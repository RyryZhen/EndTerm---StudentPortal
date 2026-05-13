<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clear existing IT schedules to prevent duplicates
        Schedule::where('section_name', 'LIKE', 'IT-%')->delete();

        $dept = Department::firstOrCreate(['code' => 'IT'], ['name' => 'College of Information Technology']);
        $instructorIds = User::where('role', 'instructor')->pluck('id')->toArray();
        $rooms = ['Lab-1', 'Lab-2', 'IT-301', 'IT-302', 'AVR-1', 'Bldg-A1'];
        
        // STRICTLY Monday to Friday
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $itCurriculum = [
            1 => [
                1 => [
                    ['code' => 'URD_CC101_IT', 'name' => 'Introduction to Computing', 'units' => 3],
                    ['code' => 'URD_CC102_IT', 'name' => 'Fundamentals of Programming', 'units' => 3],
                    ['code' => 'URD_GE5', 'name' => 'The Contemporary World', 'units' => 3],
                    ['code' => 'URD_GE6', 'name' => 'Science, Technology and Society', 'units' => 3],
                    ['code' => 'URD_GE7', 'name' => 'Mathematics in the Modern World', 'units' => 3],
                    ['code' => 'URD_NSTP1', 'name' => 'NSTP 1', 'units' => 3],
                    ['code' => 'URD_PE1', 'name' => 'Physical Activity 1', 'units' => 2],
                ],
                2 => [
                    ['code' => 'URD_CC103_IT', 'name' => 'Intermediate Programming', 'units' => 3],
                    ['code' => 'URD_GE1', 'name' => 'Understanding the Self', 'units' => 3],
                    ['code' => 'URD_GE2', 'name' => 'Readings in Philippine History', 'units' => 3],
                    ['code' => 'URD_GE3', 'name' => 'Art Appreciation', 'units' => 3],
                    ['code' => 'URD_GEE3', 'name' => 'Reading Visual Arts', 'units' => 3],
                    ['code' => 'URD_IT105', 'name' => 'Computer Organization', 'units' => 3],
                    ['code' => 'URD_MS101', 'name' => 'Discrete Mathematics', 'units' => 3],
                    ['code' => 'URD_NSTP_2', 'name' => 'NSTP 2', 'units' => 3],
                    ['code' => 'URD_PE2', 'name' => 'Physical Activity 2', 'units' => 2],
                ]
            ],
            2 => [
                1 => [
                    ['code' => 'URD_CC104_IT', 'name' => 'Data Structures and Algorithms', 'units' => 3],
                    ['code' => 'URD_GE4', 'name' => 'Purposive Communication', 'units' => 3],
                    ['code' => 'URD_GEE4', 'name' => 'Global Citizenship', 'units' => 3],
                    ['code' => 'URD_GEEL1', 'name' => 'Living in the IT era', 'units' => 3],
                    ['code' => 'URD_HCI101_IT', 'name' => 'Human Computer Interaction 1', 'units' => 3],
                    ['code' => 'URD_OOP101_IT', 'name' => 'Object Oriented Programming', 'units' => 3],
                    ['code' => 'URD_PE3', 'name' => 'Physical Activity 3', 'units' => 2],
                ],
                2 => [
                    ['code' => 'URD_CC105_IT', 'name' => 'Information Management 1', 'units' => 3],
                    ['code' => 'URD_GE8', 'name' => 'The Life and Works of Rizal', 'units' => 3],
                    ['code' => 'URD_HCI102_IT', 'name' => 'Human Computer Interaction 2', 'units' => 3],
                    ['code' => 'URD_MT101_IT', 'name' => 'Multimedia Technologies', 'units' => 3],
                    ['code' => 'URD_NET101_IT', 'name' => 'Networking 1', 'units' => 3],
                    ['code' => 'URD_PE4', 'name' => 'Physical Activity 4', 'units' => 2],
                    ['code' => 'URD_SAD101_IT', 'name' => 'System Analysis and Design', 'units' => 3],
                    ['code' => 'URD_WD101_IT', 'name' => 'Web Development', 'units' => 3],
                ]
            ],
            3 => [
                1 => [
                    ['code' => 'URD_CC106_IT', 'name' => 'App Dev and Emerging Tech', 'units' => 3],
                    ['code' => 'URD_GEEL2', 'name' => 'The Entrepreneurial Mind', 'units' => 3],
                    ['code' => 'URD_IM102_IT', 'name' => 'Information Management 2', 'units' => 3],
                    ['code' => 'URD_MD101_IT', 'name' => 'Mobile Application Dev 1', 'units' => 3],
                    ['code' => 'URD_MS102_IT', 'name' => 'Quantitative Methods', 'units' => 3],
                    ['code' => 'URD_NET102_IT', 'name' => 'Networking 2', 'units' => 3],
                    ['code' => 'URD_OS101_IT', 'name' => 'Operating System Application', 'units' => 3],
                    ['code' => 'URD_SP101_IT', 'name' => 'Social and Professional Issues', 'units' => 3],
                    ['code' => 'URD_WS101_IT', 'name' => 'Web Systems 1', 'units' => 3],
                ],
                2 => [
                    ['code' => 'URD_CAP101_IT', 'name' => 'Capstone Project 1', 'units' => 3],
                    ['code' => 'URD_ELEC1_IT', 'name' => 'Elective 1 (Web Systems 2)', 'units' => 3],
                    ['code' => 'URD_ELEC2_IT', 'name' => 'Elective 2 (Mobile Dev 2)', 'units' => 3],
                    ['code' => 'URD_GE9', 'name' => 'Ethics', 'units' => 3],
                    ['code' => 'URD_IAS101_IT', 'name' => 'Information Assurance 1', 'units' => 3],
                    ['code' => 'URD_IC1', 'name' => 'Personality Development', 'units' => 3],
                    ['code' => 'URD_IPT101_IT', 'name' => 'Integrative Programming', 'units' => 3],
                    ['code' => 'URD_TECH101_IT', 'name' => 'Technopreneurship', 'units' => 3],
                ]
            ],
            4 => [
                1 => [
                    ['code' => 'URD_CAP102_IT', 'name' => 'Capstone Project 2', 'units' => 3],
                    ['code' => 'URD_ELEC3_IT', 'name' => 'Elective 3', 'units' => 3],
                    ['code' => 'URD_ELEC4_IT', 'name' => 'Elective 4', 'units' => 3],
                    ['code' => 'URD_IAS102_IT', 'name' => 'Information Assurance 2', 'units' => 3],
                    ['code' => 'URD_SA101_IT', 'name' => 'System Admin', 'units' => 3],
                    ['code' => 'URD_SIA101_IT', 'name' => 'System Integration', 'units' => 3],
                ],
                2 => [
                    ['code' => 'URD_OJT101_IT', 'name' => 'Internship', 'units' => 6],
                ]
            ]
        ];

        foreach ($itCurriculum as $year => $semesters) {
            foreach ($semesters as $currentSem => $subjectsToSeed) {
                
                foreach (['A', 'B', 'C'] as $label) {
                    $section = Section::firstOrCreate([
                        'name' => "IT-{$year}{$label}",
                        'year_level' => $year,
                        'department_id' => $dept->id
                    ]);

                    // To avoid subjects overlapping in the same section, 
                    // we keep track of which Day-Time slots are taken
                    $takenSlots = [];

                    foreach ($subjectsToSeed as $s) {
                        
                        $subject = Subject::updateOrCreate(['code' => $s['code']], [
                            'name' => $s['name'],
                            'units' => $s['units'],
                            'year_level' => $year,
                            'semester' => $currentSem
                        ]);

                        // Logic to find a free slot
                        $assigned = false;
                        $attempts = 0;

                        while (!$assigned && $attempts < 50) {
                            $day = $days[array_rand($days)];
                            // Ensure start time + units doesn't exceed 20:00 (8 PM)
                            $maxStart = 20 - (int)$s['units'];
                            $startTimeHour = rand(7, $maxStart);
                            
                            $slotKey = "{$day}-{$startTimeHour}";

                            if (!isset($takenSlots[$slotKey])) {
                                // Mark this and subsequent hours as taken for this section
                                for ($i = 0; $i < (int)$s['units']; $i++) {
                                    $takenSlots["{$day}-" . ($startTimeHour + $i)] = true;
                                }

                                Schedule::create([
                                    'subject_id'    => $subject->id,
                                    'section_id'    => $section->id,
                                    'instructor_id' => $instructorIds[array_rand($instructorIds)],
                                    'section_name'  => $section->name,
                                    'year_level'    => $year,
                                    'semester'      => $currentSem,
                                    'day'           => $day,
                                    'start_time'    => sprintf('%02d:00', $startTimeHour),
                                    'end_time'      => sprintf('%02d:00', $startTimeHour + (int)$s['units']),
                                    'room'          => $rooms[array_rand($rooms)],
                                ]);
                                $assigned = true;
                            }
                            $attempts++;
                        }
                    }
                }
            }
        }
    }
}