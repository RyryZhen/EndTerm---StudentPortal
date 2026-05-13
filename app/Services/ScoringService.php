<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;

class ScoringService
{
    /**
     * Calculate scores for schedules based on user preferences.
     */
public function calculate(array $preferredDays, array $subjectIds)
{
    $subjects = \App\Models\Subject::whereIn('id', $subjectIds)->get();
    
    // Get the current user to check their department/year
    $user = Auth::user();

    return $subjects->map(function ($subject) use ($preferredDays, $user) {
        // Find schedules for this subject
        $query = \App\Models\Schedule::with('instructor')
            ->where('subject_id', $subject->id);

        // OPTIONAL: Filter by the student's department/year to ensure they see the right sections
        $query->whereHas('section', function($q) use ($user) {
            $q->where('department_id', $user->department_id)
              ->where('year_level', $user->year_level);
        });

        // Get all possible schedules for this subject
        $allSchedules = $query->get();

        // Try to find one that matches the preferred days
        // We use case-insensitive matching just in case
        $matchingSchedule = $allSchedules->filter(function($s) use ($preferredDays) {
            return in_array(trim($s->day), $preferredDays);
        })->first();

        // If no match on preferred days, take the first available one anyway 
        // but we will flag it as a "Non-Preferred Day" match
        $finalSchedule = $matchingSchedule ?? $allSchedules->first();

        return [
            'subject' => $subject,
            'schedule' => $finalSchedule,
            'is_preferred_day' => $matchingSchedule ? true : false,
            'score' => $finalSchedule ? $this->computeScore($finalSchedule) : 0,
        ];
    })
    ->sortByDesc('score')
    ->values()
    ->all();
}
    /**
     * The logic that decides which schedule is "better"
     */
    private function computeScore($schedule)
    {
        $score = 50; // Base score

        // RULE 1: Friday-Free Priority
        // If the student wants a chill Friday, we boost classes that aren't on Friday
        // or prioritize earlier Friday classes.
        if ($schedule->day === 'Fri') {
            $score -= 10; // Slightly lower score for Friday classes
        } else {
            $score += 15; // Bonus for Mid-week classes
        }

        // RULE 2: Morning Person? (Optional)
        // You can add more logic here, like $score += 5 if start_time is before 12:00
        
        return $score;
    }

    public function getSelectedSchedules(array $ids)
{
    return Schedule::with(['subject', 'instructor'])
        ->whereIn('id', $ids)
        ->get()
        ->map(function ($s) {
            return [
                'subject' => $s->subject,
                'schedule' => $s,
            ];
        });
}
}