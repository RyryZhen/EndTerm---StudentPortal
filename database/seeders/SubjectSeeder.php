<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create ALL subjects first (without worrying about links yet)
        $subjects = [
            ['code' => 'URD_CC101_IT', 'name' => 'Introduction to Computing', 'units' => 3.00],
            ['code' => 'URD_CC102_IT', 'name' => 'Fundamentals of Programming', 'units' => 3.00],
            ['code' => 'URD_CC103_IT', 'name' => 'Intermediate Programming', 'units' => 3.00],
            ['code' => 'URD_IT105',    'name' => 'Computer Organization', 'units' => 3.00],
            ['code' => 'URD_GE7',      'name' => 'Math in the Modern World', 'units' => 3.00],
            ['code' => 'URD_MS101',    'name' => 'Discrete Mathematics', 'units' => 3.00],
            ['code' => 'URD_CC104_IT', 'name' => 'Data Structures and Algorithms', 'units' => 3.00],
            ['code' => 'URD_CC105_IT', 'name' => 'Information Management 1', 'units' => 3.00],
            ['code' => 'URD_SAD101_IT', 'name' => 'System Analysis and Design', 'units' => 3.00],
            ['code' => 'URD_CC106_IT', 'name' => 'App Dev and Emerging Tech', 'units' => 3.00],
            // Add more as needed...
        ];

        foreach ($subjects as $s) {
            Subject::updateOrCreate(['code' => $s['code']], $s);
        }

        // 2. Link the Requirements into your NEW pivot table
        // This is the logic your Auto-Scheduler will read.
        
        $this->link('URD_CC103_IT', 'URD_CC102_IT'); // Int. Prog needs Fund. Prog
        $this->link('URD_IT105', 'URD_CC101_IT');    // Comp Org needs Intro
        $this->link('URD_MS101', 'URD_GE7');         // Discrete Math needs Math Modern World
        
        // Example of MULTIPLE pre-requisites for CC106
        $this->link('URD_CC106_IT', 'URD_CC105_IT');
        $this->link('URD_CC106_IT', 'URD_SAD101_IT');
    }

    /**
     * Helper function to link subjects in the subject_requirements table
     */
    private function link($targetCode, $requiredCode)
    {
        $subject = Subject::where('code', $targetCode)->first();
        $required = Subject::where('code', $requiredCode)->first();

        if ($subject && $required) {
            DB::table('subject_requirements')->insertOrIgnore([
                'subject_id' => $subject->id,
                'required_subject_id' => $required->id,
                'type' => 'pre',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}