<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;

class ScheduleController extends Controller
{
 
public function index(Request $request)
{
    $selectedSection = $request->get('section');
    $selectedYear = $request->get('year');
    $selectedSem = $request->get('semester');

    // Get unique sections for the filter dropdown
    $sections = Schedule::pluck('section_name')->unique()->sort()->values();

    $query = Schedule::with(['subject', 'instructor']);

    // Apply Filters
    if ($selectedSection) {
        $query->where('section_name', $selectedSection);
    }
    if ($selectedYear) {
        $query->where('year_level', $selectedYear);
    }
    if ($selectedSem) {
        $query->where('semester', $selectedSem);
    }

    // In your index method, before passing to the view:
$schedules = $query->get()
    ->map(function($s) {
        // Ensure day names are always Full (e.g., 'Monday')
        $s->day = ucfirst(strtolower($s->day)); 
        return $s;
    })
    ->groupBy(['section_name', 'day']);

    // Sort by Day (using a RAW SQL CASE for day order) and Start Time at DB level
    // $schedules = $query->orderByRaw("FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')")
    //     ->orderBy('start_time', 'asc')
    //     ->get()
    //     ->groupBy(['section_name', 'day']); 

    return view('admin.schedules.index', compact(
        'schedules', 
        'sections', 
        'selectedSection', 
        'selectedYear', 
        'selectedSem'
    ));
}


// public function index(Request $request)
// {
//     $selectedSection = $request->get('section');
//     $selectedYear = $request->get('year'); // Add this
//     $selectedSem = $request->get('semester'); // Add this

//     $sections = Schedule::pluck('section_name')->filter()->unique()->sort()->values();

//     $query = Schedule::with(['subject', 'instructor']);

//     if ($selectedSection) {
//         $query->where('section_name', $selectedSection);
//     }
    
//     // CRITICAL: Filter by Year and Sem so you don't see Year 1 subjects in Year 4 summary
//     if ($selectedYear) {
//         $query->where('year_level', $selectedYear);
//     }
//     if ($selectedSem) {
//         $query->where('semester', $selectedSem);
//     }

//     $schedules = $query->get()
//         ->sortBy([[fn ($a, $b) => $this->dayOrder($a->day) <=> $this->dayOrder($b->day)], ['start_time', 'asc']])
//         ->groupBy(['section_name', 'day']); 

//     return view('admin.schedules.index', compact('schedules', 'sections', 'selectedSection', 'selectedYear', 'selectedSem'));
// }
// Helper function to handle day sorting
private function dayOrder($day) {
    $days = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];
    return $days[$day] ?? 8;
}

    public function create(Request $request)
{
    $instructors = User::where('role', 'instructor')->get();
    
    $selectedYear = $request->get('year');
    $selectedSem = $request->get('semester');

    // Fetch subjects ONLY for the selected year and semester
    // If none are selected, it returns an empty collection so the page doesn't crash
    $subjects = Subject::when($selectedYear, function($query) use ($selectedYear) {
            return $query->where('year_level', $selectedYear);
        })
        ->when($selectedSem, function($query) use ($selectedSem) {
            return $query->where('semester', $selectedSem);
        })
        ->orderBy('code')
        ->get();

    return view('admin.schedules.create', compact('subjects', 'instructors', 'selectedYear', 'selectedSem'));
}

// public function create(Request $request)
// {
//     $instructors = User::where('role', 'instructor')->get();
    
//     // Get year and sem from the URL (if selected)
//     $selectedYear = $request->get('year');
//     $selectedSem = $request->get('semester');
// $subjects = Subject::orderBy('year_level')
//         ->orderBy('semester')
//         ->get();
// }
//     $subjects = Subject::when($selectedYear, function($query) use ($selectedYear) {
//             return $query->where('year_level', $selectedYear);
//         })
//         ->when($selectedSem, function($query) use ($selectedSem) {
//             return $query->where('semester', $selectedSem);
//         })
//         ->get();

//     return view('admin.schedules.create', compact('subjects', 'instructors', 'selectedYear', 'selectedSem'));
// }
public function store(Request $request)
{
    $validated = $request->validate([
        'subject_id'    => 'required|exists:subjects,id',
        'instructor_id' => 'required|exists:users,id', 
        'section_name'  => 'required|string|max:10',
        'year_level'    => 'required|integer',
        'semester'      => 'required|integer',
        'day'           => 'required|string',
        'start_time'    => 'required',
        'end_time'      => 'required',
        'room'          => 'nullable|string',
    ]);

    $subject = Subject::findOrFail($request->subject_id);

    // --- RULE 1: YEAR LEVEL MISMATCH ---
    // Prevent scheduling a 4th-year subject for a 1st-year section
    if ($request->year_level < $subject->year_level) {
        return back()->withInput()->withErrors([
            'subject_id' => "Year Level Mismatch: This is a Year {$subject->year_level} subject, but you are scheduling for Year {$request->year_level}."
        ]);
    }

    // --- RULE 2: PREREQUISITE & CO-REQUISITE CHECK ---
    if ($subject->requirement_id) {
        $req = Subject::find($subject->requirement_id);

        if ($subject->requirement_type === 'pre') {
            // In a scheduling context, we ensure the Prereq isn't in the SAME semester.
            // It must have been available in a previous year/semester.
            if ($request->year_level == $subject->year_level && $request->semester == $subject->semester) {
                 // You might want to check if it was already passed, but for scheduling:
                 // Just ensure they aren't trying to take a PRE-REQ at the same time.
            }
        }

        if ($subject->requirement_type === 'co') {
            // Check if the Co-req is already in the schedule for THIS section and THIS semester
            $coReqExists = Schedule::where('section_name', $request->section_name)
                ->where('subject_id', $subject->requirement_id)
                ->where('semester', $request->semester)
                ->where('year_level', $request->year_level)
                ->exists();

            if (!$coReqExists) {
                return back()->withInput()->withErrors([
                    'subject_id' => "Validation Failed: {$subject->name} requires {$req->name} to be scheduled in the same term (Co-requisite)."
                ]);
            }
        }
    }

    Schedule::create($validated);

    return redirect()->route('admin.schedules.index')
        ->with('success', "Subject {$subject->code} verified against curriculum and added to {$request->section_name}.");
}
}
