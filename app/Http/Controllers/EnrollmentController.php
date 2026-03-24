<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Schedule;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EnrollmentController;

class EnrollmentController extends Controller
{
    public function enroll($scheduleId, EnrollmentService $service)
    {
        $schedule = Schedule::findOrFail($scheduleId);

        $user = Auth::user();

        // CHECK CONFLICT
        if ($service->hasConflict($user->id, $schedule)) {
            return back()->with('error', 'Schedule conflict detected!');
        }

        // ENROLL
        Enrollment::create([
            'user_id' => $user->id,
            'schedule_id' => $schedule->id,
        ]);

        return back()->with('success', 'Enrolled successfully!');
    }
    public function bulkStore(Request $request)
{
    // Validate that we received IDs
    $request->validate([
        'schedule_ids' => 'required|array',
        'schedule_ids.*' => 'exists:schedules,id'
    ]);

    $studentId = auth()->id();

    foreach ($request->schedule_ids as $scheduleId) {
        // Prevent duplicate enrollments
        Enrollment::firstOrCreate([
            'user_id' => $studentId,
            'schedule_id' => $scheduleId
        ]);
    }

    return redirect()->route('student.dashboard')
        ->with('success', 'Successfully enrolled in your generated schedule!');
}
}
