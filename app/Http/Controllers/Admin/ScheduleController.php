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

    // 1. GET ALL SCHEDULES FIRST
    // We get the full collection so we can reliably extract section names
    $allSchedules = Schedule::with(['subject', 'instructor'])->get();

    // 2. EXTRACT UNIQUE SECTIONS FOR THE DROPDOWN
    // This pulls every 'section' value, removes nulls, removes duplicates, and sorts them
    $sections = $allSchedules->pluck('section')
        ->filter()
        ->unique()
        ->sort()
        ->values();

    // 3. APPLY FILTERING AND GROUPING FOR THE VIEW
    // If a section is selected, we filter the collection we already fetched
    $filteredSchedules = $allSchedules;
    if ($selectedSection) {
        $filteredSchedules = $allSchedules->where('section', $selectedSection);
    }

    // Sort by Day and then Time
    $schedules = $filteredSchedules->sortBy([
        [fn ($a, $b) => $this->dayOrder($a->day) <=> $this->dayOrder($b->day)],
        ['start_time', 'asc']
    ])->groupBy(['section', 'day']);

    return view('admin.schedules.index', compact('schedules', 'sections', 'selectedSection'));
}

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
        // Changed 'instructors' to 'users' to match your User model
        'instructor_id' => 'required|exists:users,id', 
        'section'       => 'required|string|max:10',
        'year_level'    => 'required|integer',
        'semester'      => 'required|integer',
        'day'           => 'required|string',
        'start_time'    => 'required',
        'end_time'      => 'required',
        'room'          => 'nullable|string',
    ]);

    Schedule::create($validated);

    return redirect()->route('admin.schedules.index')
                     ->with('success', 'Schedule added to Section ' . $request->section);
}
}