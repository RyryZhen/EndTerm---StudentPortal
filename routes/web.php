<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Schedule;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use App\Services\ScheduleService;
use App\Services\TimetableService;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ScheduleController;

// 1. Public Routes
// 1. Public Routes
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Profile Routes (Keep these, but REMOVED the generic /dashboard)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// 3. ADMIN ROUTES
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('subjects', SubjectController::class);
    Route::resource('schedules', ScheduleController::class);
});

// 4. INSTRUCTOR ROUTES
Route::middleware(['auth'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('instructor.dashboard');
    })->name('dashboard');
});
// 5. STUDENT ROUTES
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    
    // 1. Main Dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'admin') return redirect()->route('admin.dashboard');
        if ($user->role === 'instructor') return redirect()->route('instructor.dashboard');

        $schedules = Schedule::with('subject', 'instructor')->get();
        $enrolled = Enrollment::with('schedule.subject')->where('user_id', $user->id)->get();
        $suggested = app(ScheduleService::class)->suggest($user->id);
        $timetable = app(TimetableService::class)->build(Auth::id());

        return view('student.dashboard', compact('schedules', 'enrolled', 'timetable', 'suggested'));
    })->name('dashboard');

    // 2. The Planner Page
    Route::get('/planner', function () {
        $available_subjects = \App\Models\Subject::with('schedules')->get();
        return view('student.planner', compact('available_subjects'));
    })->name('planner');
    Route::get('/planner/generate', function () {
        return redirect()->route('student.planner');
    });

    // 3. Generate Schedule (Keep only one version)
    Route::post('/planner/generate', function (Illuminate\Http\Request $request, ScheduleService $service) {
        $result = $service->generate($request->all());
        return view('student.planner-results', compact('result'));
    })->name('generate-schedule');

    // 4. THE MISSING ROUTE FIX
    // This defines student.enroll.bulk
    Route::post('/enroll/bulk', [EnrollmentController::class, 'bulkStore'])->name('enroll.bulk');
    
    // Individual enrollment
    Route::post('/enroll/{schedule}', [EnrollmentController::class, 'enroll'])->name('enroll.store');
});