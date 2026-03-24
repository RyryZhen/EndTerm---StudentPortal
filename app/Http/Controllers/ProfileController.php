<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function enroll($scheduleId)
    {
        $user = Auth::user();

        // prevent duplicate enrollment
        $exists = Enrollment::where('user_id', $user->id)
            ->where('schedule_id', $scheduleId)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Already enrolled');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'schedule_id' => $scheduleId
        ]);

        return back()->with('success', 'Enrolled successfully');
    }
}