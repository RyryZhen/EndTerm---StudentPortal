<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        // $subjects = Subject::all();
        $subjects = \App\Models\Subject::with('requirement')
        ->orderBy('year_level')
        ->orderBy('semester')
        ->get()
        ->groupBy(['year_level', 'semester']);
        return view('admin.subjects.index', compact('subjects'));
    }

public function create()
{
    // We need all subjects so the Admin can pick which one is a pre-requisite
    $subjects = Subject::orderBy('code')->get();
    return view('admin.subjects.create', compact('subjects'));
}

// app/Http/Controllers/Admin/SubjectController.php

public function store(Request $request)
{
    // 1. Validation (Tells Laravel what is required)
    $request->validate([
        'code' => 'required|unique:subjects,code',
        'name' => 'required|min:2|max:100',
        'units' => 'required|numeric',
        'year_level' => 'required|integer|min:1|max:4', 
        'semester' => 'required|integer|min:1|max:2',   
        'requirement_id' => 'nullable|exists:subjects,id',
        'requirement_type' => 'required|in:pre,co,none',
    ]);

    // 2. Creation (Actually saves it to the DB)
    Subject::create([
        'code' => strtoupper($request->code),
        'name' => $request->name,
        'units' => $request->units,
        'year_level' => $request->year_level, 
        'semester' => $request->semester,     
        'requirement_id' => $request->requirement_id,
        'requirement_type' => $request->requirement_type,
    ]);

    // 3. Redirect back to the organized list
    return redirect()->route('admin.subjects.index')->with('success', 'Subject added successfully!');
}
}