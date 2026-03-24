<?php
namespace App\Services;

use App\Models\Enrollment;
use App\Models\Schedule;

class EnrollmentService
{
    public function hasConflict($userId, Schedule $newSchedule)
    {
        $enrollments = Enrollment::where('user_id', $userId)
            ->with('schedule')
            ->get();

        foreach ($enrollments as $enrollment) {
            $existing = $enrollment->schedule;

            if ($existing->day !== $newSchedule->day) {
                continue;
            }

            // TIME OVERLAP CHECK
            if (
                $newSchedule->start_time < $existing->end_time &&
                $newSchedule->end_time > $existing->start_time
            ) {
                return true;
            }
        }

        return false;
    }
}