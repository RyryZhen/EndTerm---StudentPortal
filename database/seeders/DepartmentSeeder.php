<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    \App\Models\Department::updateOrCreate(
        ['code' => 'CIT'],
        ['name' => 'College of Information Technology']
    );

    \App\Models\Department::updateOrCreate(
        ['code' => 'COA'],
        ['name' => 'College of Architecture']
    );
    
    // Add any others you need (CAS, CBA, etc.)
}
}
