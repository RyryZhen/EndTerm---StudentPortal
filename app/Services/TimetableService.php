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

    // Map short names to full names if your DB uses "Mon", "Tue", etc.
    $dayMapping = [
        'Mon' => 'Monday',
        'Tue' => 'Tuesday',
        'Wed' => 'Wednesday',
        'Thu' => 'Thursday',
        'Fri' => 'Friday',
        'Sat' => 'Saturday',
        'Sun' => 'Sunday',
    ];

    foreach ($enrollments as $en) {
        $schedule = $en->schedule;
        
        // Use the mapping if it exists, otherwise use the raw value
        $dayKey = $dayMapping[$schedule->day] ?? $schedule->day;

        $timetable[$dayKey][] = [
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