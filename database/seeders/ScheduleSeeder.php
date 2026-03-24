<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $subject = Subject::where('code', 'URD_CC101_IT')->first();
    $instructor = User::where('role', 'instructor')->first();

    if ($subject && $instructor) {
        // Class 1: Monday (Should be picked by scheduler)
        Schedule::create([
            'subject_id' => $subject->id,
            'instructor_id' => $instructor->id,
            'day' => 'Monday',
            'start_time' => '08:00:00',
            'end_time' => '11:00:00',
            'room' => 'Lab 1'
        ]);

        // Class 2: Friday (Should be HIDDEN by scheduler)
        Schedule::create([
            'subject_id' => $subject->id,
            'instructor_id' => $instructor->id,
            'day' => 'Friday',
            'start_time' => '13:00:00',
            'end_time' => '16:00:00',
            'room' => 'Lab 2'
        ]);
    }
}
}
