<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    User::create([
        'name' => 'Admin User',
        'email' => 'admin@portal.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    User::create([
        'name' => 'Instructor User',
        'email' => 'instructor@portal.com',
        'password' => Hash::make('password'),
        'role' => 'instructor',
    ]);

    User::create([
        'name' => 'Student User',
        'email' => 'student@portal.com',
        'password' => Hash::make('password'),
        'role' => 'student',
    ]);
}
}
