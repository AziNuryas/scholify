<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Store a newly created appointment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'notes' => 'nullable|string|max:500'
        ]);

        $appointment = Appointment::create([
            'student_id' => Auth::user()->student->id,
            'teacher_id' => $request->teacher_id,
            'date' => $request->date,
            'time' => $request->time,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Jadwal temu berhasil diajukan! Menunggu konfirmasi dari Guru BK.');
    }

    /**
     * Get appointments for student.
     */
    public function index()
    {
        $appointments = Appointment::where('student_id', Auth::user()->student->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('student.appointments', compact('appointments'));
    }
}