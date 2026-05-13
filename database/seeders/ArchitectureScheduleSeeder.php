<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Department;
use Carbon\Carbon;

class ArchitectureScheduleSeeder extends Seeder
{
    public function run(): void
    {

    // This deletes ONLY the schedules for Architecture. 
// Everything else (IT, Engineering, Users, etc.) stays exactly as it is.
Schedule::where('section_name', 'LIKE', 'ARCH-%')->delete();
        // 1. Setup Department
        $dept = Department::firstOrCreate(['code' => 'ARCH'], ['name' => 'College of Architecture']);

        // 2. Instructor Pool: Famous Scientists and Mathematicians
        $instructors = [
            'Isaac Newton', 'Albert Einstein', 'Nikola Tesla', 'Marie Curie', 
            'Galileo Galilei', 'Pythagoras', 'Euclid', 'Ada Lovelace', 
            'Alan Turing', 'Charles Darwin', 'Stephen Hawking', 'Carl Friedrich Gauss'
        ];
        
        $instructorIds = [];
        foreach ($instructors as $name) {
            $user = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $name)) . '@psu.edu.ph'],
                ['name' => $name, 'password' => bcrypt('password'), 'role' => 'instructor']
            );
            $instructorIds[] = $user->id;
        }

        // 3. Room Pool: Archi-11 to Archi-36
        $rooms = [];
        for ($floor = 1; $floor <= 3; $floor++) {
            for ($rm = 1; $rm <= 6; $rm++) {
                $rooms[] = "Archi-{$floor}{$rm}";
            }
        }

        // 4. Curriculum Data from Evaluation Report
        $curriculum = [
            // Year => [Sem => [Subjects]]
            1 => [
                1 => [
                    ['code' => 'URD_AD1_ARCH', 'name' => 'Architectural Design 01', 'units' => 2.00],
                    ['code' => 'URD_AVG1_ARC', 'name' => 'Architectural Visual 1', 'units' => 3.00],
                    ['code' => 'URD_AVT1_ARC', 'name' => 'Architectural Visual 2', 'units' => 2.00],
                    ['code' => 'URD_GE1', 'name' => 'Understanding the Self', 'units' => 3.00],
                    ['code' => 'URD_GE7', 'name' => 'Mathematics in the Modern World', 'units' => 3.00],
                    ['code' => 'URD_HOA111_ARCH', 'name' => 'History of Architecture 1', 'units' => 2.00],
                    ['code' => 'URD_NSTP1', 'name' => 'NSTP 1', 'units' => 3.00],
                    ['code' => 'URD_PE1', 'name' => 'Physical Activity 1', 'units' => 2.00],
                    ['code' => 'URD_TOA1_ARC', 'name' => 'Theory of Architecture 1', 'units' => 2.00],
                ],
                2 => [
                    ['code' => 'URD_AD122', 'name' => 'Architectural Design 2', 'units' => 2.00],
                    ['code' => 'URD_AI121', 'name' => 'Architectural Interior', 'units' => 2.00],
                    ['code' => 'URD_AVG123', 'name' => 'Architectural Visual 3', 'units' => 3.00],
                    ['code' => 'URD_AVT124', 'name' => 'Architectural Visual 4', 'units' => 2.00],
                    ['code' => 'URD_BT122_ARCH', 'name' => 'Building Technology 1', 'units' => 3.00],
                    ['code' => 'URD_GE2', 'name' => 'Readings in Philippine History', 'units' => 3.00],
                    ['code' => 'URD_NSTP_2', 'name' => 'NSTP 2', 'units' => 3.00],
                    ['code' => 'URD_PE2', 'name' => 'Physical Activity 2', 'units' => 2.00],
                    ['code' => 'URD_TCSM12_ARCH', 'name' => 'Solid Mensuration', 'units' => 2.00],
                    ['code' => 'URD_TOA_122', 'name' => 'Theory of Architecture 2', 'units' => 2.00],
                ]
            ],
            2 => [
                1 => [
                    ['code' => 'URD_AD_113', 'name' => 'Architectural Design 3', 'units' => 3.00],
                    ['code' => 'URD_AVT_115', 'name' => 'Architectural Visual 5', 'units' => 2.00],
                    ['code' => 'URD_BU_111', 'name' => 'Building Utilities 1', 'units' => 3.00],
                    ['code' => 'URD_GE4', 'name' => 'Purposive Communication', 'units' => 3.00],
                    ['code' => 'URD_GE6', 'name' => 'Science, Technology and Society', 'units' => 3.00],
                    ['code' => 'URD_HOA_112', 'name' => 'History of Architecture 2', 'units' => 2.00],
                    ['code' => 'URD_PE3', 'name' => 'Physical Activity 3', 'units' => 2.00],
                    ['code' => 'URD_TCC_112', 'name' => 'Calculus', 'units' => 3.00],
                    ['code' => 'URD_TD_11', 'name' => 'Tropical Design', 'units' => 2.00],
                ],
                2 => [
                    ['code' => 'URD_AD_124', 'name' => 'Architectural Design 4', 'units' => 3.00],
                    ['code' => 'URD_BES12', 'name' => 'Surveying', 'units' => 3.00],
                    ['code' => 'URD_BESR123', 'name' => 'Statics of Rigid Bodies', 'units' => 3.00],
                    ['code' => 'URD_BT_122', 'name' => 'Building Technology 2', 'units' => 3.00],
                    ['code' => 'URD_GE5', 'name' => 'The Contemporary World', 'units' => 3.00],
                    ['code' => 'URD_GE9', 'name' => 'Ethics', 'units' => 3.00],
                    ['code' => 'URD_HOA_123', 'name' => 'History of Architecture 3', 'units' => 2.00],
                    ['code' => 'URD_PE4', 'name' => 'Physical Activity 4', 'units' => 2.00],
                ]
            ],
            3 => [
                1 => [
                    ['code' => 'URD_AD_115', 'name' => 'Architectural Design 5', 'units' => 4.00],
                    ['code' => 'URD_BESM_114', 'name' => 'Strength of Materials', 'units' => 3.00],
                    ['code' => 'URD_BT_113', 'name' => 'Building Technology 3', 'units' => 3.00],
                    ['code' => 'URD_BU_112', 'name' => 'Building Utilities 2', 'units' => 3.00],
                    ['code' => 'URD_CAD_111', 'name' => 'CADD 1', 'units' => 2.00],
                    ['code' => 'URD_GE3', 'name' => 'Art Appreciation', 'units' => 3.00],
                    ['code' => 'URD_GE9_BC', 'name' => 'Rizal', 'units' => 3.00],
                    ['code' => 'URD_HOA_114', 'name' => 'History of Architecture 4', 'units' => 2.00],
                ],
                2 => [
                    ['code' => 'URD_AD126', 'name' => 'Architectural Design 6', 'units' => 4.00],
                    ['code' => 'URD_AP121', 'name' => 'Planning 1', 'units' => 3.00],
                    ['code' => 'URD_BETS125', 'name' => 'Theory of Structure', 'units' => 3.00],
                    ['code' => 'URD_BT124', 'name' => 'Building Technology 4', 'units' => 3.00],
                    ['code' => 'URD_BU123', 'name' => 'Building Utilities 3', 'units' => 3.00],
                    ['code' => 'URD_CAD122_ARC', 'name' => 'CADD 2', 'units' => 2.00],
                    ['code' => 'URD_PP121', 'name' => 'Professional Practice 1', 'units' => 3.00],
                ]
            ],
            4 => [
                1 => [
                    ['code' => 'URD_AD_117', 'name' => 'Architectural Design 7', 'units' => 5.00],
                    ['code' => 'URD_APL_112', 'name' => 'Planning 2', 'units' => 3.00],
                    ['code' => 'URD_BEST_115', 'name' => 'Steel and Timber Design', 'units' => 3.00],
                    ['code' => 'URD_BT_115', 'name' => 'Building Technology 5', 'units' => 3.00],
                    ['code' => 'URD_PP_112', 'name' => 'Professional Practice 2', 'units' => 3.00],
                    ['code' => 'URD_RMA_111', 'name' => 'Research Methods', 'units' => 3.00],
                ],
                2 => [
                    ['code' => 'URD_AD128', 'name' => 'Architectural Design 8', 'units' => 5.00],
                    ['code' => 'URD_APL123', 'name' => 'Planning 3', 'units' => 3.00],
                    ['code' => 'URD_GEE3', 'name' => 'Reading Visual Arts', 'units' => 3.00],
                    ['code' => 'URD_GEEL1', 'name' => 'Living in the IT Era', 'units' => 3.00],
                    ['code' => 'URD_PP123', 'name' => 'Professional Practice 3', 'units' => 3.00],
                    ['code' => 'URD_SPC121', 'name' => 'Specialization 1 (Urban Design)', 'units' => 3.00],
                ]
            ],
            5 => [
                1 => [
                    ['code' => 'URD_AD119', 'name' => 'Architectural Design 9 (Thesis)', 'units' => 5.00],
                    ['code' => 'URD_BEAS116', 'name' => 'Architectural Structure', 'units' => 3.00],
                    ['code' => 'URD_BMA111', 'name' => 'Business Mgmt 1', 'units' => 3.00],
                    ['code' => 'URD_GEE2_ARCHI', 'name' => 'Indigenous Communities', 'units' => 3.00],
                    ['code' => 'URD_HS11', 'name' => 'Housing', 'units' => 2.00],
                    ['code' => 'URD_SPC112', 'name' => 'Specialization 2 (Urban Planning)', 'units' => 3.00],
                ],
                2 => [
                    ['code' => 'URD_AD120', 'name' => 'Architectural Design 10', 'units' => 5.00],
                    ['code' => 'URD_BMA122', 'name' => 'Business Mgmt 2', 'units' => 3.00],
                    ['code' => 'URD_GEE4', 'name' => 'Global Citizenship', 'units' => 3.00],
                    ['code' => 'URD_SPC123', 'name' => 'Specialization 3 (Envi Planning)', 'units' => 3.00],
                ]
            ]
        ];

       $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    foreach ($curriculum as $year => $semesters) {
        foreach (['A', 'B', 'C'] as $sectionLabel) {
            
            $section = Section::firstOrCreate([
                'name' => "ARCH-{$year}{$sectionLabel}",
                'year_level' => $year,
                'department_id' => $dept->id
            ]);

            foreach ($semesters as $sem => $subjects) {
                foreach ($subjects as $index => $subData) {
                    
                    $subject = Subject::firstOrCreate(['code' => $subData['code']], [
                        'name' => $subData['name'],
                        'units' => $subData['units'],
                        'year_level' => $year,
                        'semester' => $sem
                    ]);

                    // Smart Time Calculation
                    // 2 units = 2 hours | 3 units = 3 hours
                    $duration = ($subData['units'] >= 3) ? 3 : 2;
                    
                    // Scatter logic: Offset the start hour based on section and index
                    // Starting from 7:00 AM, skipping based on index to avoid overlaps within the same section
                    $startHour = 7 + (($index * 2) % 8); 
                    if ($sectionLabel == 'B') $startHour += 1;
                    if ($sectionLabel == 'C') $startHour += 2;

                    $startTime = sprintf('%02d:00', $startHour);
                    $endTime = sprintf('%02d:00', $startHour + $duration);

                    Schedule::create([
                        'subject_id'    => $subject->id,
                        'section_id'    => $section->id,
                        'instructor_id' => $instructorIds[array_rand($instructorIds)],
                        'section_name'  => $section->name,
                        'year_level'    => $year,
                        'semester'      => $sem,
                        'day'           => $days[($index + ord($sectionLabel)) % 6],
                        'start_time'    => $startTime,
                        'end_time'      => $endTime,
                        'room'          => $rooms[array_rand($rooms)],
                    ]);
                }
            }
        }
    }
    }
}