<?php
namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\Enrollment;
use App\Services\ScheduleService;
use App\Services\TimetableService;
use App\Services\ScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{

public function store(Request $request, $scheduleId)
{
    $user = Auth::user();
    $schedule = Schedule::with('subject')->findOrFail($scheduleId);

    // RULE 1: Strict Department Validation
    // Check if the subject's department matches the student's department
    if ($schedule->subject->department_id !== $user->department_id) {
        return redirect()->back()->with('error', 'Unauthorized: This subject does not belong to your department curriculum.');
    }

    // RULE 2: Prevent Duplicate Enrollment
    $alreadyEnrolled = Enrollment::where('user_id', $user->id)
        ->whereHas('schedule', function($q) use ($schedule) {
            $q->where('subject_id', $schedule->subject_id);
        })->exists();

    if ($alreadyEnrolled) {
        return redirect()->back()->with('error', 'You are already enrolled in this subject.');
    }

    // Proceed with enrollment
    Enrollment::create([
        'user_id' => $user->id,
        'schedule_id' => $scheduleId,
        'status' => 'confirmed'
    ]);

    return redirect()->back()->with('success', 'Successfully enrolled in ' . $schedule->subject->name);
}
// public function index()
// {
//     // Fetch only the student's confirmed enrollments
//   $enrolled = Enrollment::with(['schedule.subject', 'schedule.instructor'])
     //           ->where('student_id', \Illuminate\Support\Facades\Auth::id())
      //          ->get();

//     // Group them by Day for the Timetable
//     $timetable = [];
//     foreach ($enrolled as $enrollment) {
//         $sch = $enrollment->schedule;
//         $timetable[$sch->day][] = [
//             'subject' => $sch->subject->name,
//             'start' => $sch->start_time,
//             'end' => $sch->end_time,
//             'instructor' => $sch->instructor->name,
//             'color' => 'indigo' // You can vary this if you like
//         ];
//     }

//     return view('student.dashboard', compact('enrolled', 'timetable'));
// }

public function index()
{
    $user = Auth::user();

    if ($user->role === 'admin') return redirect()->route('admin.dashboard');
    if ($user->role === 'instructor') return redirect()->route('instructor.dashboard');

    // Fetch enrollments
    $enrolled = Enrollment::with(['schedule.subject', 'schedule.instructor'])
                ->where('user_id', $user->id)
                ->get();

    // If you only want to show the FIRST 9 subjects for testing:
    // $enrolled = $enrolled->take(9); 

    $timetable = [];
    foreach ($enrolled as $enrollment) {
        $sch = $enrollment->schedule;
        if ($sch) {
            // Grouping by day, then by schedule ID
            $timetable[$sch->day][$sch->id] = [
                'subject' => $sch->subject->name,
                'start' => $sch->start_time,
                'end' => $sch->end_time,
                'instructor' => $sch->instructor->name ?? 'TBA',
            ];
        }
    }

    return view('student.dashboard', compact('enrolled', 'timetable'));
}
// public function index()
// {
//     $user = Auth::user();
    
//     // Role Protection
//     if ($user->role === 'admin') return redirect()->route('admin.dashboard');
//     if ($user->role === 'instructor') return redirect()->route('instructor.dashboard');

//     // ONLY fetch what the student has actually enrolled in
//     $enrolled = Enrollment::with(['schedule.subject', 'schedule.instructor'])
//                 ->where('user_id', $user->id)
//                 ->get();

//     // Grouping logic for the visual timetable
//     $timetable = [];
//     foreach ($enrolled as $enrollment) {
//         $sch = $enrollment->schedule;
//         if ($sch) {
//             $timetable[$sch->day][] = [
//                 'subject' => $sch->subject->name,
//                 'start' => $sch->start_time,
//                 'end' => $sch->end_time,
//                 'instructor' => $sch->instructor->name,
//             ];
//         }
//     }

//     // Notice: We are NOT fetching $available_subjects or $schedules anymore.
//     // This prevents the "expanding" or "cluttered" feeling.
//     return view('student.dashboard', compact('enrolled', 'timetable'));
// }





// StudentDashboardController.php

public function planner()
    {
        $user = Auth::user();

        // 1. Identify all subjects for the student's current year and Semester 1
        $sem1SubjectIds = Subject::where('department_id', $user->department_id)
            ->where('year_level', $user->year_level)
            ->where('semester', 1)
            ->pluck('id');

        // 2. Count how many of those specific subjects have a confirmed enrollment
        // Note: Using 'confirmed' as status based on your store() method
        $passedCount = Enrollment::where('user_id', $user->id)
            ->whereHas('schedule', function($query) use ($sem1SubjectIds) {
                $query->whereIn('subject_id', $sem1SubjectIds);
            })
            ->where('status', 'confirmed') 
            ->count();

        // 3. Automation Logic: If they passed all Sem 1 subjects, show Sem 2
        $targetSemester = ($passedCount >= $sem1SubjectIds->count() && $sem1SubjectIds->count() > 0) ? 2 : 1;

        // 4. Load the subjects including their schedules for the JS Live Preview
        // We filter by the target semester detected above
        $available_subjects = Subject::with(['schedules'])
            ->where('department_id', $user->department_id)
            ->where('year_level', $user->year_level)
            ->where('semester', $targetSemester)
            ->get();

        // 5. Fetch Full Curriculum grouped by Year and Semester (for UI reference)
        $curriculum = Subject::where('department_id', $user->department_id)
            ->orderBy('year_level')
            ->orderBy('semester')
            ->get()
            ->groupBy(['year_level', 'semester']);

        // 6. Fetch Sections for the Mega Helper
        $sections = Section::where('department_id', $user->department_id)
            ->where('year_level', $user->year_level)
            ->with('schedules')
            ->get()
            ->map(function($section) {
                return [
                    'id' => $section->id,
                    'name' => $section->name,
                    // Map which subjects belong to this section based on schedules
                    'subject_ids' => $section->schedules->pluck('subject_id')->unique()->values()->toArray()
                ];
            });

        return view('student.planner', compact('available_subjects', 'sections', 'curriculum', 'targetSemester'));
    }


    public function generate(Request $request)
{
    // 1. Get the specific IDs captured by your JavaScript
    $ids = $request->input('schedule_ids', []);
    $preferredDays = $request->input('preferred_days', []);
    $selectedSubjectIds = $request->input('subjects', []);

    // 2. Logic: If the student has customized their timetable, use those specific IDs
    if (!empty($ids)) {
        // Fetch only the specific schedules the student picked
        $schedules = \App\Models\Schedule::with(['subject', 'instructor'])
            ->whereIn('id', $ids)
            ->get();

        $suggestions = $schedules->map(function ($sch) {
            return [
                'schedule' => $sch,
                'subject' => $sch->subject,
                'score' => 100 // Give it a perfect score because it's hand-picked
            ];
        });
    } else {
        // 3. Fallback: If no specific slots picked, use the ScoringService suggestions
        if (empty($preferredDays) || empty($selectedSubjectIds)) {
            return redirect()->back()->with('error', 'Please select both preferred days and subjects.');
        }

        $scoringService = app(\App\Services\ScoringService::class);
        $suggestions = $scoringService->calculate($preferredDays, $selectedSubjectIds);
    }

    $resultData = [
        'is_perfect' => true,
        'warnings' => empty($ids) ? [] : ["Displaying your customized timetable selection."],
        'matches' => $suggestions
    ];

    return view('student.planner-results', [
        'result' => $resultData,
        'preferredDays' => $preferredDays
    ]);
}

/**
 * Process the selected subjects and generate possible schedule combinations.
 */
// public function generate(Request $request)
// {
//     $ids = $request->input('schedule_ids', []); // I
//     $preferredDays = $request->input('preferred_days', []);
//     $selectedSubjectIds = $request->input('subjects', []); // Get the user's selected subjects

//     if (empty($preferredDays) || empty($selectedSubjectIds)) {
//         return redirect()->back()->with('error', 'Please select both preferred days and subjects.');
//     }

//     $scoringService = app(\App\Services\ScoringService::class);
    
//     // Pass both the days and the selected subjects to the service
//     $suggestions = $scoringService->calculate($preferredDays, $selectedSubjectIds);

//     $resultData = [
//         'is_perfect' => true,
//         'warnings' => [],
//         'matches' => $suggestions
//     ];

//     return view('student.planner-results', [
//         'result' => $resultData,
//         'preferredDays' => $preferredDays
//     ]);
// }
public function bulkStore(Request $request)
{
    
   $user = Auth::user();
    $scheduleIds = $request->input('schedule_ids', []);

    if (empty($scheduleIds)) {
        return redirect()->route('student.planner')->with('error', 'No valid schedules were selected for enrollment.');
    }

    $enrolledCount = 0;

    foreach ($scheduleIds as $id) {
        // You can reuse your existing logic or keep it simple for bulk:
        // 1. Check if already enrolled to avoid duplicates
        $exists = Enrollment::where('user_id', $user->id)
            ->where('schedule_id', $id)
            ->exists();

        if (!$exists) {
            Enrollment::create([
                'user_id' => $user->id,
                'schedule_id' => $id,
                'status' => 'confirmed'
            ]);
            $enrolledCount++;
        }
    }

    return redirect()->route('student.dashboard')->with('success', "Successfully enrolled in $enrolledCount subjects!");
}
}


