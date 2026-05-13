<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        // Only show students belonging to the logged-in Admin's department
        $students = User::where('role', 'student')
            ->where('department_id', Auth::user()->department_id)
            ->get();

        return view('admin.students.index', compact('students'));
    }
public function store(Request $request)
{
    $admin = Auth::user();

    // 1. Add the new academic fields to validation
    $request->validate([
        'name' => 'required|string|max:255',
        'year_level' => 'required|integer|between:1,4', // Assuming 4-year courses
        'max_units' => 'required|integer|min:1|max:30',
        'status' => 'required|in:Regular,Irregular,Returnee',
    ]);

    // 2. ID Generation Logic (Existing)
    $yearPrefix = date('y'); 
    $latestStudent = User::where('role', 'student')
        ->where('student_id_number', 'LIKE', $yearPrefix . '-UR-%')
        ->orderBy('student_id_number', 'desc')
        ->first();

    if ($latestStudent) {
        $lastNumber = explode('-', $latestStudent->student_id_number)[2];
        $newNumber = str_pad((int)$lastNumber + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '0001';
    }

    $sid = "$yearPrefix-UR-$newNumber";

    // 3. Automation Logic for Credentials (Existing)
    $cleanId = strtolower(str_replace('-', '', $sid));
    $email = $cleanId . "@portal.com";
    $password = $newNumber . "pass123";

    // 4. Create the Student with Academic Constraints
    User::create([
        'name' => $request->name,
        'email' => $email,
        'student_id_number' => $sid,
        'password' => Hash::make($password),
        'role' => 'student',
        'department_id' => $admin->department_id,
        'year_level' => $request->year_level,    // New Field
        'max_units' => $request->max_units,      // New Field
        'status' => $request->status,            // New Field
    ]);

    return redirect()->back()->with('success', "Student Account Created! ID: $sid | Email: $email | Pass: $password");
}
}