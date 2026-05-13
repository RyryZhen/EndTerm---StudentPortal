<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
// database/seeders/DatabaseSeeder.php
public function run(): void
{
    $this->call([
        DepartmentSeeder::class, // MUST BE FIRST
        UserSeeder::class,
        SubjectSeeder::class,
        CurriculumSeeder::class,
        ArchitectureSubjectSeeder::class,
        ArchitectureScheduleSeeder::class,
    ]);
}
}
