<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EnrollmentController extends Controller
{
    /**
     * Handle single enrollment (Quick Enroll)
     */
    public function enroll(Request $request, $scheduleId)
    {
        $user = Auth::user();
        
        // Prevent duplicate enrollment for the same subject
        $schedule = Schedule::findOrFail($scheduleId);
        $alreadyEnrolled = Enrollment::where('user_id', $user->id)
            ->whereHas('schedule', function($q) use ($schedule) {
                $q->where('subject_id', $schedule->subject_id);
            })->exists();

        if ($alreadyEnrolled) {
            return redirect()->back()->with('error', 'You are already enrolled in this subject.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'schedule_id' => $scheduleId,
            'status' => 'confirmed'
        ]);

        return redirect()->back()->with('success', 'Successfully enrolled!');
    }

    /**
     * Handle bulk enrollment from the Smart Scheduler
     */
    public function bulkStore(Request $request)
    {
        $user = Auth::user();
        $scheduleIds = $request->input('schedule_ids', []);

        if (empty($scheduleIds)) {
            return redirect()->route('student.planner')->with('error', 'No schedules selected.');
        }

        try {
            DB::transaction(function () use ($user, $scheduleIds) {
                foreach ($scheduleIds as $id) {
                    // Check if already enrolled in this specific schedule
                    $exists = Enrollment::where('user_id', $user->id)
                        ->where('schedule_id', $id)
                        ->exists();

                    if (!$exists) {
                        Enrollment::create([
                            'user_id' => $user->id,
                            'schedule_id' => $id,
                            'status' => 'confirmed'
                        ]);
                    }
                }
            });

            return redirect()->route('student.dashboard')->with('success', 'Bulk enrollment successful!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong during enrollment.');
        }
    }
}