<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // --- 1. SUPERADMIN ---
        // Access to everything, department_id is null
        User::updateOrCreate(
            ['email' => 'admin@portal.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'department_id' => null,
            ]
        );

        // Ensure the Department exists before linking Admins/Students
        $cit = Department::firstOrCreate(
            ['code' => 'CIT'],
            ['name' => 'College of Information Technology']
        );

        // --- 2. DEPARTMENTAL ADMIN (Personnel) ---
        // Limited to CIT department
        User::updateOrCreate(
            ['email' => 'cit@portal.com'],
            [
                'name' => 'CIT Department Head',
                'password' => Hash::make('citpass123'),
                'role' => 'admin', 
                'department_id' => $cit->id,
            ]
        );

        // --- 3. STUDENT ---
        // Linked to CIT, role is 'student'
        User::updateOrCreate(
            ['email' => 'student@portal.com'],
            [
                'name' => 'Juan Dela Cruz',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'department_id' => $cit->id,
            ]
        );
    }
}