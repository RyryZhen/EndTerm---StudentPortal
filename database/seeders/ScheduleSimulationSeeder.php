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
        // 1. Get the Subjects you already created (1st Year, 1st Sem)
        //$subjects = Subject::where('year_level', 1)->where('semester', 1)->get();
        $subjects = Subject::all();
        // 2. Get some Instructors
        $instructors = User::where('role', 'instructor')->get();

        if ($subjects->isEmpty() || $instructors->isEmpty()) {
            return $this->command->error('Please ensure you have 1st Year subjects and Instructors in the database first!');
        }

        $sections = ['1A', '1B', '1C'];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        foreach ($sections as $index => $section) {
            foreach ($subjects as $subIndex => $subject) {
                // We offset the day and time based on the section so they aren't identical
                $day = $days[($subIndex + $index) % 5]; 
                $startHour = 8 + ($subIndex % 4); // Spreads classes between 8AM and 12PM
                
                Schedule::create([
                    'subject_id'    => $subject->id,
                    'instructor_id' => $instructors->random()->id,
                    'section'       => $section,
                    'year_level'    => 1,
                    'semester'      => 1,
                    'day'           => $day,
                    'start_time'    => sprintf('%02d:00', $startHour),
                    'end_time'      => sprintf('%02d:00', $startHour + 3), // 3-hour sessions
                    'room'          => 'Room ' . (101 + $index),
                ]);
            }
        }

        $this->command->info('Simulated schedules for 1A, 1B, and 1C created successfully!');
    }
}