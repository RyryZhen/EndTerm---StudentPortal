<?php

namespace App\Services;

use App\Models\Schedule;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class ScheduleService
{

public function generate($data)
{
    $selectedSubjectIds = $data['subjects'] ?? [];
    $priorityIds = $data['priority'] ?? [];
    $preferredDays = $data['preferred_days'] ?? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    $startTimeLimit = $data['start_limit'] ?? '07:30';
    $endTimeLimit = $data['end_limit'] ?? '18:00';

    // Fetch selected subjects
    $selectedSubjects = \App\Models\Subject::whereIn('id', $selectedSubjectIds)->get()->keyBy('id');

    // 1. Fetch schedules
    $allSchedules = Schedule::with(['subject', 'instructor'])
        ->whereIn('subject_id', $selectedSubjectIds)
        ->get()
        ->groupBy('subject_id');

    $finalSelection = [];
    $warnings = [];
    $isPerfect = true;

    // --- THE CRITICAL FIX: SORT BY PRIORITY ---
    // This moves priority IDs to the front of the loop
    $sortedSubjectIds = collect($selectedSubjectIds)->sortByDesc(function ($id) use ($priorityIds) {
        return in_array($id, $priorityIds) ? 1 : 0;
    });

    // 2. Loop through sorted subjects
    foreach ($sortedSubjectIds as $subjectId) {
        $subject = $selectedSubjects->get($subjectId);
        $schedulesForSubject = $allSchedules->get($subjectId);

        if (!$schedulesForSubject) {
            $warnings[] = "No classes found for {$subject->name}";
            $finalSelection[] = ['subject' => $subject, 'schedule' => null];
            continue;
        }

        $bestMatch = null;
        $lowestPenalty = 999999;

        foreach ($schedulesForSubject as $option) {
            $penalty = 0;

            // Priority Logic: If it's a priority subject, we treat day/time mismatches as heavy penalties
            $isPriority = in_array($subjectId, $priorityIds);

            // Penalty: Day Mismatch
            if (!in_array($option->day, $preferredDays)) {
                $penalty += $isPriority ? 10000 : 1000; 
            }

            // Penalty: Time Mismatch
            if ($option->start_time < $startTimeLimit || $option->end_time > $endTimeLimit) {
                $penalty += $isPriority ? 5000 : 500;
            }

            // Penalty: Conflict (The "Dealbreaker")
            if ($this->hasConflict($option, collect($finalSelection)->pluck('schedule')->filter()->all())) {
                $penalty += 20000; // Extremely high to avoid overlapping
            }

            if ($penalty < $lowestPenalty) {
                $lowestPenalty = $penalty;
                $bestMatch = $option;
            }
        }

        if ($bestMatch && $lowestPenalty < 20000) {
            $finalSelection[] = ['subject' => $subject, 'schedule' => $bestMatch];
            if ($lowestPenalty > 0) {
                $isPerfect = false;
                if ($lowestPenalty >= 1000) $warnings[] = "{$subject->name} had to be placed on a non-preferred day to fit.";
            }
        } else {
            $isPerfect = false;
            $warnings[] = "Could not fit {$subject->name} due to scheduling conflicts.";
            $finalSelection[] = ['subject' => $subject, 'schedule' => null];
        }
    }

    return [
        'schedule' => $finalSelection,
        'warnings' => $warnings,
        'is_perfect' => $isPerfect
    ];
}
    private function hasConflict($newSched, $existingSelection)
    {
        foreach ($existingSelection as $existing) {
            if ($newSched->day === $existing->day) {
                // Check if times overlap
                if ($newSched->start_time < $existing->end_time && $newSched->end_time > $existing->start_time) {
                    return true;
                }
            }
        }
        return false;
    }

    public function suggest($userId)
    {
        $enrolledSubjectIds = Enrollment::where('user_id', $userId)
            ->join('schedules', 'enrollments.schedule_id', '=', 'schedules.id')
            ->pluck('schedules.subject_id');

        return Schedule::with(['subject', 'instructor'])
            ->whereNotIn('subject_id', $enrolledSubjectIds)
            ->limit(3)
            ->get()
            ->map(fn($s) => ['schedule' => $s, 'score' => 85]);
    }
}