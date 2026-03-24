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

        // 1. Fetch all possible schedules for selected subjects (1A, 1B, 1C etc)
        $allSchedules = Schedule::with(['subject', 'instructor'])
            ->whereIn('subject_id', $selectedSubjectIds)
            ->get()
            ->groupBy('subject_id');

        $finalSelection = [];
        $warnings = [];
        $isPerfect = true;

        // 2. Loop through each subject the user wants
        foreach ($selectedSubjectIds as $subjectId) {
            $schedulesForSubject = $allSchedules->get($subjectId);

            if (!$schedulesForSubject) {
                $warnings[] = "No classes found for Subject ID: $subjectId";
                continue;
            }

            $bestMatch = null;
            $lowestPenalty = 999999;

            foreach ($schedulesForSubject as $option) {
                $penalty = 0;

                // Penalty: Wrong Day
                if (!in_array($option->day, $preferredDays)) {
                    $penalty += 1000;
                }

                // Penalty: Outside preferred hours
                if ($option->start_time < $startTimeLimit || $option->end_time > $endTimeLimit) {
                    $penalty += 500;
                }

                // Penalty: Time Conflict with already picked subjects
                if ($this->hasConflict($option, $finalSelection)) {
                    $penalty += 5000;
                }

                if ($penalty < $lowestPenalty) {
                    $lowestPenalty = $penalty;
                    $bestMatch = $option;
                }
            }

            if ($bestMatch) {
                $finalSelection[] = $bestMatch;
                if ($lowestPenalty > 0) {
                    $isPerfect = false;
                    if ($lowestPenalty >= 5000) $warnings[] = "Conflict detected for {$bestMatch->subject->name}.";
                    elseif ($lowestPenalty >= 1000) $warnings[] = "{$bestMatch->subject->name} falls on a non-preferred day ({$bestMatch->day}).";
                }
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