<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use App\Models\Department;

class ArchitectureSubjectSeeder extends Seeder
{
    public function run()
    {
        $coa = Department::where('code', 'COA')->first();
        
        if (!$coa) {
            $this->command->error('COA Department not found! Please seed departments first.');
            return;
        }

        $subjects = [
            // --- FIRST YEAR: 1st Semester ---
            ['code' => 'URD_AD1_ARCH', 'name' => 'Architectural Design 01 (Intro to Design)', 'units' => 2, 'year_level' => 1, 'semester' => 1],
            ['code' => 'URD_AVG1_ARC', 'name' => 'Architectural Visual (Communication 1- Graphics 1)', 'units' => 3, 'year_level' => 1, 'semester' => 1],
            ['code' => 'URD_AVT1_ARC', 'name' => 'Architectural Visual (Communication 2 - Visual Tech 1)', 'units' => 2, 'year_level' => 1, 'semester' => 1],
            ['code' => 'URD_GE1', 'name' => 'Understanding the Self', 'units' => 3, 'year_level' => 1, 'semester' => 1],
            ['code' => 'URD_GE7', 'name' => 'Mathematics in the Modern World', 'units' => 3, 'year_level' => 1, 'semester' => 1],
            ['code' => 'URD_HOA111_ARCH', 'name' => 'History of Architecture 1', 'units' => 2, 'year_level' => 1, 'semester' => 1],
            ['code' => 'URD_NSTP1', 'name' => 'National Service Training Program I', 'units' => 3, 'year_level' => 1, 'semester' => 1],
            ['code' => 'URD_PE1', 'name' => 'Physical Activity Towards Health and Fitness 1', 'units' => 2, 'year_level' => 1, 'semester' => 1],
            ['code' => 'URD_TOA1_ARC', 'name' => 'Theory of Architecture 1', 'units' => 2, 'year_level' => 1, 'semester' => 1],

            // --- FIRST YEAR: 2nd Semester ---
            ['code' => 'URD_AD122', 'name' => 'Architectural Design 2 Creative Design and Fundamentals', 'units' => 2, 'year_level' => 1, 'semester' => 2],
            ['code' => 'URD_AI121', 'name' => 'Architectural Interior', 'units' => 2, 'year_level' => 1, 'semester' => 2],
            ['code' => 'URD_AVG123', 'name' => 'Architectural Visual Communications 3 Graphics 2', 'units' => 3, 'year_level' => 1, 'semester' => 2],
            ['code' => 'URD_AVT124', 'name' => 'Architectural Visual (Communications 4- Visual Techniques 2)', 'units' => 2, 'year_level' => 1, 'semester' => 2],
            ['code' => 'URD_BT122_ARCH', 'name' => 'Building Technology 1 Building Materials', 'units' => 3, 'year_level' => 1, 'semester' => 2],
            ['code' => 'URD_GE2', 'name' => 'Readings in Philippine History', 'units' => 3, 'year_level' => 1, 'semester' => 2],
            ['code' => 'URD_NSTP_2', 'name' => 'ROTC/CWTS/LTS 2', 'units' => 3, 'year_level' => 1, 'semester' => 2],
            ['code' => 'URD_PE2', 'name' => 'Physical Activity Towards Health and Fitness 2', 'units' => 2, 'year_level' => 1, 'semester' => 2],
            ['code' => 'URD_TCSM12_ARCH', 'name' => 'Solid Mensuration', 'units' => 2, 'year_level' => 1, 'semester' => 2],
            ['code' => 'URD_TOA_122', 'name' => 'Theory of Architecture 2', 'units' => 2, 'year_level' => 1, 'semester' => 2],

            // --- SECOND YEAR: 1st Semester ---
            ['code' => 'URD_AD_113', 'name' => 'Architectural Design 3 Creative Design in Architectural Interiors', 'units' => 3, 'year_level' => 2, 'semester' => 1],
            ['code' => 'URD_AVT_115', 'name' => 'Architectural Visual Communication 5-Visual Techniques 3', 'units' => 2, 'year_level' => 2, 'semester' => 1],
            ['code' => 'URD_BU_111', 'name' => 'Building Utilities 1- Plumbing and Sanitary System', 'units' => 3, 'year_level' => 2, 'semester' => 1],
            ['code' => 'URD_GE4', 'name' => 'Purposive Communication', 'units' => 3, 'year_level' => 2, 'semester' => 1],
            ['code' => 'URD_GE6', 'name' => 'Science, Technology and Society', 'units' => 3, 'year_level' => 2, 'semester' => 1],
            ['code' => 'URD_HOA_112', 'name' => 'History of Architecture 2', 'units' => 2, 'year_level' => 2, 'semester' => 1],
            ['code' => 'URD_PE3', 'name' => 'Physical Activity Towards Health and Fitness 3', 'units' => 2, 'year_level' => 2, 'semester' => 1],
            ['code' => 'URD_TCC_112', 'name' => 'Differential and Integral Calculus', 'units' => 3, 'year_level' => 2, 'semester' => 1],
            ['code' => 'URD_TD_11', 'name' => 'Tropical Design', 'units' => 2, 'year_level' => 2, 'semester' => 1],

            // --- SECOND YEAR: 2nd Semester ---
            ['code' => 'URD_AD_124', 'name' => 'Architectural Design 4- Space Planning', 'units' => 3, 'year_level' => 2, 'semester' => 2],
            ['code' => 'URD_BES12', 'name' => 'Surveying', 'units' => 3, 'year_level' => 2, 'semester' => 2],
            ['code' => 'URD_BESR123', 'name' => 'Statics of Rigid Bodies', 'units' => 3, 'year_level' => 2, 'semester' => 2],
            ['code' => 'URD_BT_122', 'name' => 'Building Technology 2- Construction Drawings', 'units' => 3, 'year_level' => 2, 'semester' => 2],
            ['code' => 'URD_GE5', 'name' => 'The Contemporary World', 'units' => 3, 'year_level' => 2, 'semester' => 2],
            ['code' => 'URD_GE9', 'name' => 'Ethics', 'units' => 3, 'year_level' => 2, 'semester' => 2],
            ['code' => 'URD_HOA_123', 'name' => 'History of Architecture 3', 'units' => 2, 'year_level' => 2, 'semester' => 2],
            ['code' => 'URD_PE4', 'name' => 'Physical Activity Towards Health and Fitness 4', 'units' => 2, 'year_level' => 2, 'semester' => 2],

            // --- THIRD YEAR: 1st Semester ---
            ['code' => 'URD_AD_115', 'name' => 'Architectural Design 5- Space Planning 2', 'units' => 4, 'year_level' => 3, 'semester' => 1],
            ['code' => 'URD_BESM_114', 'name' => 'Strength of Materials', 'units' => 3, 'year_level' => 3, 'semester' => 1],
            ['code' => 'URD_BT_113', 'name' => 'Building Technology 3 Construction Drawing', 'units' => 3, 'year_level' => 3, 'semester' => 1],
            ['code' => 'URD_BU_112', 'name' => 'Building Utilities 2- Electrical Systems', 'units' => 3, 'year_level' => 3, 'semester' => 1],
            ['code' => 'URD_CAD_111', 'name' => 'CADD for Architecture 1', 'units' => 2, 'year_level' => 3, 'semester' => 1],
            ['code' => 'URD_GE3', 'name' => 'Art Appreciation', 'units' => 3, 'year_level' => 3, 'semester' => 1],
            ['code' => 'URD_GE9_BC', 'name' => 'The Life and Works of Rizal', 'units' => 3, 'year_level' => 3, 'semester' => 1],
            ['code' => 'URD_HOA_114', 'name' => 'History of Architecture 4', 'units' => 2, 'year_level' => 3, 'semester' => 1],

            // --- FOURTH YEAR: 1st Semester ---
            ['code' => 'URD_AD_117', 'name' => 'Architectural Design 7 Community Architecture', 'units' => 5, 'year_level' => 4, 'semester' => 1],
            ['code' => 'URD_APL_112', 'name' => 'Planning 2- Fundamentals of Urban Design', 'units' => 3, 'year_level' => 4, 'semester' => 1],
            ['code' => 'URD_BEST_115', 'name' => 'Steel and Timber Design', 'units' => 3, 'year_level' => 4, 'semester' => 1],
            ['code' => 'URD_BT_115', 'name' => 'Building Technology 5 Alternative Systems', 'units' => 3, 'year_level' => 4, 'semester' => 1],
            ['code' => 'URD_PP_112', 'name' => 'Professional Practice 2', 'units' => 3, 'year_level' => 4, 'semester' => 1],
            ['code' => 'URD_RMA_111', 'name' => 'Research Methods for Architecture', 'units' => 3, 'year_level' => 4, 'semester' => 1],

            // --- FIFTH YEAR: 1st Semester (Thesis) ---
            ['code' => 'URD_AD119', 'name' => 'Architectural Design 9- Thesis Research', 'units' => 5, 'year_level' => 5, 'semester' => 1],
            ['code' => 'URD_BEAS116', 'name' => 'Architectural Structure', 'units' => 3, 'year_level' => 5, 'semester' => 1],
            ['code' => 'URD_BMA111', 'name' => 'Business Managements 1', 'units' => 3, 'year_level' => 5, 'semester' => 1],
            ['code' => 'URD_HS11', 'name' => 'Housing', 'units' => 2, 'year_level' => 5, 'semester' => 1],
            ['code' => 'URD_SPC112', 'name' => 'Specialization 2 (Urban Planning)', 'units' => 3, 'year_level' => 5, 'semester' => 1],
        ];

        foreach ($subjects as $data) {
            Subject::updateOrCreate(
                ['code' => $data['code']], 
                array_merge($data, ['department_id' => $coa->id])
            );
        }

        $this->command->info('Architecture curriculum seeded for all year levels!');
    }
}