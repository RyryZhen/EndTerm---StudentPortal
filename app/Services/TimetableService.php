<?php

namespace App\Services;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class TimetableService
{
    public function build($userId)
    {
        $enrollments = Enrollment::with('schedule.subject', 'schedule.instructor')
            ->where('user_id', $userId)
            ->get();

        $timetable = [];

        foreach ($enrollments as $en) {
            $schedule = $en->schedule;

            $timetable[$schedule->day][] = [
                'subject' => $schedule->subject->name,
                'start' => $schedule->start_time,
                'end' => $schedule->end_time,
                'instructor' => $schedule->instructor->name,
                'room' => $schedule->room
            ];
        }

        return $timetable;
    }
}