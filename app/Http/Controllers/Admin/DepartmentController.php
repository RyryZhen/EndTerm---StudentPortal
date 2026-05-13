<?php

namespace App\Http\Controllers\Admin; // <-- Added \Admin
use App\Models\User; // Make sure this is at the top
use Illuminate\Support\Str;
use App\Http\Controllers\Controller; // <-- Import the base Controller
use App\Models\Department;           // <-- Import the Model
use Illuminate\Http\Request;
class DepartmentController extends Controller
{

public function destroy(\App\Models\Department $department)
{
    // Optional: Prevent deletion if there are subjects/users attached
    if ($department->subjects()->count() > 0 || $department->users()->count() > 1) {
        return redirect()->back()->with('error', 'Cannot delete department: It still has active subjects or personnel.');
    }

    $department->delete();

    return redirect()->route('admin.departments.index')
        ->with('success', 'Department and associated access removed successfully.');
}

// ... inside DepartmentController class

/**
 * Display the specific department (Curriculum View)
 */
public function show(Department $department)
{
    // Load subjects related to this department so we can show the curriculum
    $department->load('subjects'); 
    
    return view('admin.departments.show', compact('department'));
}

/**
 * Show the form for editing the department
 */
public function edit(Department $department)
{
    return view('admin.departments.edit', compact('department'));
}

/**
 * Update the department in storage
 */
public function update(Request $request, Department $department)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:10|unique:departments,code,' . $department->id,
    ]);

    $department->update($request->all());

    return redirect()->route('admin.departments.index')
                     ->with('success', 'Department updated successfully!');
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 2. This will now work because of the import above
        $departments = Department::withCount(['users', 'subjects'])->get();
        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'code' => 'required|string|max:10|unique:departments',
    ]);

    // Clean the code (remove spaces)
    $cleanCode = str_replace(' ', '', strtolower($request->code));

    $department = Department::create([
        'name' => $request->name,
        'code' => strtoupper($request->code),
    ]);

    $email = $cleanCode . '@portal.com';
    $password = $cleanCode . 'pass123';

    User::create([
        'name' => $department->name . ' Administrator',
        'email' => $email,
        'password' => bcrypt($password), // This is correct!
        'role' => 'admin',
        'department_id' => $department->id,
    ]);

    return redirect()->route('admin.departments.index')
        ->with('success', "Department created! Login: {$email} | Password: {$password}");
}

    // ... keep the other empty methods (show, edit, update, destroy) below
}