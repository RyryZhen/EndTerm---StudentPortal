<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Enrollment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $students = User::where('role', 'student')->count();
        $instructors = User::where('role', 'instructor')->count();
        $schedules = Schedule::count();
        $enrollments = Enrollment::count();
        $subjects = \App\Models\Subject::with('requirement')
        ->get()
        ->groupBy(['year_level', 'semester']);
        

        return view('admin.dashboard', compact(
            'students',
            'instructors',
            'schedules',
            'enrollments',
            'subjects',
        ));
    }
}