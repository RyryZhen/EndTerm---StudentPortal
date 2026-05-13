<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{

public function index()
{
    $user = Auth::user();
    $query = Subject::with('requirement');

    // 1. Role-Based Filtering
    // If the user is an admin (Department Head), show only their department's subjects.
    // If the user is a superadmin, $query stays empty and shows ALL subjects.
    if ($user->role === 'admin' && $user->department_id) {
        $query->where('department_id', $user->department_id);
    }

    // 2. Execute and Group
    $subjects = $query->orderBy('year_level')
        ->orderBy('semester')
        ->orderBy('code')
        ->get()
        ->groupBy(fn($item) => (int)$item->year_level)
        ->map(fn($year) => $year->groupBy(fn($item) => (int)$item->semester));

    return view('admin.subjects.index', compact('subjects'));
}
    public function store(Request $request)
    {
        // Always validate first!
        $request->validate([
            'code' => 'required|unique:subjects,code',
            'name' => 'required|min:2|max:100',
            'units' => 'required|numeric',
            'year_level' => 'required|integer|min:1|max:5',
            'semester' => 'required|integer|min:1|max:2',
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($request->code);

        // Assign department automatically if the admin belongs to one
        $user = Auth::user();
        if ($user && isset($user->department_id)) {
            $data['department_id'] = $user->department_id;
        }

        Subject::create($data);

        return redirect()->route('admin.subjects.index')->with('success', 'Subject added successfully!');
    }

    public function create()
    {
        $subjects = Subject::orderBy('code')->get();
        return view('admin.subjects.create', compact('subjects'));
    }
}