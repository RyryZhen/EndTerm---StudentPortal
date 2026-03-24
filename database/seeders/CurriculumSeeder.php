<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class CurriculumSeeder extends Seeder
{
    public function run()
    {
        $curriculum = [
            // FIRST YEAR - 1ST SEM
            ['code' => 'URD_CC101_IT', 'name' => 'Introduction to Computing', 'units' => 3.0, 'year' => 1, 'sem' => 1, 'pre' => null],
            ['code' => 'URD_CC102_IT', 'name' => 'Fundamentals of Programming', 'units' => 3.0, 'year' => 1, 'sem' => 1, 'pre' => null],
            ['code' => 'URD_GE5', 'name' => 'The Contemporary World', 'units' => 3.0, 'year' => 1, 'sem' => 1, 'pre' => null],
            ['code' => 'URD_GE6', 'name' => 'Science, Technology and Society', 'units' => 3.0, 'year' => 1, 'sem' => 1, 'pre' => null],
            ['code' => 'URD_GE7', 'name' => 'Mathematics in the Modern World', 'units' => 3.0, 'year' => 1, 'sem' => 1, 'pre' => null],
            ['code' => 'URD_NSTP1', 'name' => 'NSTP 1', 'units' => 3.0, 'year' => 1, 'sem' => 1, 'pre' => null],
            ['code' => 'URD_PE1', 'name' => 'PATH-FIT 1', 'units' => 2.0, 'year' => 1, 'sem' => 1, 'pre' => null],

            // FIRST YEAR - 2ND SEM
            ['code' => 'URD_CC103_IT', 'name' => 'Intermediate Programming', 'units' => 3.0, 'year' => 1, 'sem' => 2, 'pre' => 'URD_CC102_IT'],
            ['code' => 'URD_GE1', 'name' => 'Understanding the Self', 'units' => 3.0, 'year' => 1, 'sem' => 2, 'pre' => null],
            ['code' => 'URD_GE2', 'name' => 'Readings in Philippine History', 'units' => 3.0, 'year' => 1, 'sem' => 2, 'pre' => null],
            ['code' => 'URD_GE3', 'name' => 'Art Appreciation', 'units' => 3.0, 'year' => 1, 'sem' => 2, 'pre' => null],
            ['code' => 'URD_GEE3', 'name' => 'Reading Visual Arts', 'units' => 3.0, 'year' => 1, 'sem' => 2, 'pre' => null],
            ['code' => 'URD_IT 105', 'name' => 'Computer Organization', 'units' => 3.0, 'year' => 1, 'sem' => 2, 'pre' => 'URD_CC101_IT'],
            ['code' => 'URD_MS101', 'name' => 'Discrete Mathematics', 'units' => 3.0, 'year' => 1, 'sem' => 2, 'pre' => 'URD_GE7'],
            ['code' => 'URD_NSTP_2', 'name' => 'NSTP 2', 'units' => 3.0, 'year' => 1, 'sem' => 2, 'pre' => 'URD_NSTP1'],
            ['code' => 'URD_PE2', 'name' => 'PATH-FIT 2', 'units' => 2.0, 'year' => 1, 'sem' => 2, 'pre' => 'URD_PE1'],

            // SECOND YEAR - 1ST SEM
            ['code' => 'URD_CC104_IT', 'name' => 'Data Structures and Algorithms', 'units' => 3.0, 'year' => 2, 'sem' => 1, 'pre' => 'URD_CC103_IT'],
            ['code' => 'URD_GE4', 'name' => 'Purposive Communication', 'units' => 3.0, 'year' => 2, 'sem' => 1, 'pre' => null],
            ['code' => 'URD_GEE4', 'name' => 'Global Citizenship', 'units' => 3.0, 'year' => 2, 'sem' => 1, 'pre' => null],
            ['code' => 'URD_GEEL1', 'name' => 'Living in the IT era', 'units' => 3.0, 'year' => 2, 'sem' => 1, 'pre' => null],
            ['code' => 'URD_HCI101_IT', 'name' => 'Human Computer Interaction 1', 'units' => 3.0, 'year' => 2, 'sem' => 1, 'pre' => 'URD_CC103_IT'],
            ['code' => 'URD_OOP101_IT', 'name' => 'Object Oriented Programming', 'units' => 3.0, 'year' => 2, 'sem' => 1, 'pre' => 'URD_CC103_IT'],
            ['code' => 'URD_PE3', 'name' => 'PATH-FIT 3', 'units' => 2.0, 'year' => 2, 'sem' => 1, 'pre' => 'URD_PE2'],

            // SECOND YEAR - 2ND SEM
            ['code' => 'URD_CC105_IT', 'name' => 'Information Management 1', 'units' => 3.0, 'year' => 2, 'sem' => 2, 'pre' => 'URD_CC104_IT'],
            ['code' => 'URD_GE8', 'name' => 'The Life and Works of Rizal', 'units' => 3.0, 'year' => 2, 'sem' => 2, 'pre' => null],
            ['code' => 'URD_HCI102_IT', 'name' => 'Human Computer Interaction 2', 'units' => 3.0, 'year' => 2, 'sem' => 2, 'pre' => 'URD_HCI101_IT'],
            ['code' => 'URD_MT101_IT', 'name' => 'Multimedia Technologies', 'units' => 3.0, 'year' => 2, 'sem' => 2, 'pre' => 'URD_CC104_IT'],
            ['code' => 'URD_NET101_IT', 'name' => 'Networking 1', 'units' => 3.0, 'year' => 2, 'sem' => 2, 'pre' => 'URD_IT 105'],
            ['code' => 'URD_SAD101_IT', 'name' => 'System Analysis and Design', 'units' => 3.0, 'year' => 2, 'sem' => 2, 'pre' => 'URD_OOP101_IT'],
            ['code' => 'URD_WD101_IT', 'name' => 'Web Development', 'units' => 3.0, 'year' => 2, 'sem' => 2, 'pre' => 'URD_CC104_IT'],
            ['code' => 'URD_PE4', 'name' => 'PATH-FIT 4', 'units' => 2.0, 'year' => 2, 'sem' => 2, 'pre' => 'URD_PE3'],

            // THIRD YEAR - 1ST SEM
            ['code' => 'URD_CC106_IT', 'name' => 'App Dev and Emerging Tech', 'units' => 3.0, 'year' => 3, 'sem' => 1, 'pre' => 'URD_CC105_IT'],
            ['code' => 'URD_IM102_IT', 'name' => 'Information Management 2', 'units' => 3.0, 'year' => 3, 'sem' => 1, 'pre' => 'URD_CC105_IT'],
            ['code' => 'URD_MD101_IT', 'name' => 'Mobile App Dev 1', 'units' => 3.0, 'year' => 3, 'sem' => 1, 'pre' => 'URD_WD101_IT'],
            ['code' => 'URD_NET102_IT', 'name' => 'Networking 2', 'units' => 3.0, 'year' => 3, 'sem' => 1, 'pre' => 'URD_NET101_IT'],
            ['code' => 'URD_OS101_IT', 'name' => 'Operating System Application', 'units' => 3.0, 'year' => 3, 'sem' => 1, 'pre' => 'URD_IT 105'],
            ['code' => 'URD_WS101_IT', 'name' => 'Web Systems 1', 'units' => 3.0, 'year' => 3, 'sem' => 1, 'pre' => 'URD_WD101_IT'],

            // THIRD YEAR - 2ND SEM
            ['code' => 'URD_CAP101_IT', 'name' => 'Capstone Project 1', 'units' => 3.0, 'year' => 3, 'sem' => 2, 'pre' => 'URD_CC106_IT'],
            ['code' => 'URD_ELEC1_IT', 'name' => 'Elective 1 (Web Systems 2)', 'units' => 3.0, 'year' => 3, 'sem' => 2, 'pre' => 'URD_WS101_IT'],
            ['code' => 'URD_ELEC2_IT', 'name' => 'Elective 2 (Mobile App 2)', 'units' => 3.0, 'year' => 3, 'sem' => 2, 'pre' => 'URD_MD101_IT'],
            ['code' => 'URD_IAS101_IT', 'name' => 'Info Assurance and Security 1', 'units' => 3.0, 'year' => 3, 'sem' => 2, 'pre' => 'URD_CC106_IT'],
            ['code' => 'URD_IPT101_IT', 'name' => 'Integrative Programming', 'units' => 3.0, 'year' => 3, 'sem' => 2, 'pre' => 'URD_CC106_IT'],

            // FOURTH YEAR - 1ST SEM
            ['code' => 'URD_CAP102_IT', 'name' => 'Capstone Project 2', 'units' => 3.0, 'year' => 4, 'sem' => 1, 'pre' => 'URD_CAP101_IT'],
            ['code' => 'URD_ELEC3_IT', 'name' => 'Elective 3', 'units' => 3.0, 'year' => 4, 'sem' => 1, 'pre' => 'URD_ELEC1_IT'],
            ['code' => 'URD_IAS102_IT', 'name' => 'Info Assurance and Security 2', 'units' => 3.0, 'year' => 4, 'sem' => 1, 'pre' => 'URD_IAS101_IT'],
            ['code' => 'URD_SIA101_IT', 'name' => 'System Integration and Architecture', 'units' => 3.0, 'year' => 4, 'sem' => 1, 'pre' => 'URD_IPT101_IT'],

            // FOURTH YEAR - 2ND SEM
            ['code' => 'URD_OJT101_IT', 'name' => 'Internship', 'units' => 6.0, 'year' => 4, 'sem' => 2, 'pre' => null],
        ];

        foreach ($curriculum as $sub) {
            Subject::updateOrCreate(
                ['code' => $sub['code']],
                [
                    'name' => $sub['name'],
                    'units' => $sub['units'],
                    'year_level' => $sub['year'],
                    'semester' => $sub['sem'],
                    'pre_req_code' => $sub['pre']
                ]
            );
        }
    }
}