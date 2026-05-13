<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\User;

class ScheduleSimulationSeeder extends Seeder
{
    public function run()
    {
        // 1. Get all instructors
        $instructors = User::where('role', 'instructor')->get();

        if ($instructors->isEmpty()) {
            return $this->command->error('Please ensure you have Instructors in the database first!');
        }

        // 2. Define the grid of possibilities
        $sections = ['A', 'B', 'C'];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        
        // Define 3 distinct time blocks to ensure options across morning and afternoon
        $timeSlots = [
            ['start' => '07:30', 'end' => '10:30'],
            ['start' => '10:30', 'end' => '13:30'],
            ['start' => '14:00', 'end' => '17:00'],
        ];

        // 3. Process every year level
        for ($year = 1; $year <= 4; $year++) {
            // Get subjects specifically for this year level
            $subjects = Subject::where('year_level', $year)->get();

            if ($subjects->isEmpty()) {
                $this->command->warn("No subjects found for Year Level $year. Skipping...");
                continue;
            }

            foreach ($sections as $secIndex => $letter) {
                $sectionName = $year . $letter; // Results in 1A, 2B, 3C, etc.

                foreach ($subjects as $subIndex => $subject) {
                    
                    // --- FLEXIBILITY LOGIC ---
                    // Shift the day based on the section so Section A/B/C have the same class on different days
                    $dayIndex = ($subIndex + $secIndex) % 6;
                    
                    // Shift the time slot so the same subject is offered at different times across sections
                    $slotIndex = ($subIndex + $secIndex) % 3;
                    $slot = $timeSlots[$slotIndex];

                    Schedule::create([
                        'subject_id'    => $subject->id,
                        'instructor_id' => $instructors->random()->id,
                        'section'       => $sectionName,
                        'year_level'    => $year,
                        'semester'      => $subject->semester ?? 1,
                        'day'           => $days[$dayIndex],
                        'start_time'    => $slot['start'],
                        'end_time'      => $slot['end'],
                        // Assign rooms based on year level to keep them somewhat organized
                        'room'          => 'IT-Room ' . ($year * 100 + $secIndex + ($subIndex % 3)),
                    ]);
                }
            }
        }

        $this->command->info('Massive scattered schedules for 1A through 4C created successfully!');
    }
}