<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Inertia\Inertia;

class AttendanceController extends Controller
{
    public function index()
    {
        // Show history of attendance
        return Inertia::render('Attendance/Index', [
            'attendances' => Attendance::with('user')->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now()->toTimeString();

        // Check if already clocked in today
        $attendance = Attendance::where('user_id', $user->id)
                                ->where('date', $today)
                                ->first();

        if ($attendance) {
            // If already clocked in, then CLOCK OUT
            if ($attendance->clock_out) {
                return redirect()->back()->with('error', 'You have already finished work for today.');
            }
            
            $attendance->update(['clock_out' => $now]);
            return redirect()->back()->with('success', 'Clocked Out Successfully! Good job.');
        } else {
            // If no record, CLOCK IN
            Attendance::create([
                'user_id' => $user->id,
                'date' => $today,
                'clock_in' => $now,
                'status' => 'present'
            ]);
            return redirect()->back()->with('success', 'Clocked In! Have a great shift.');
        }
    }
}