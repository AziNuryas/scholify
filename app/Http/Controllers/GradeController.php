<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use App\Models\SchoolClass; // ⬅️ sesuaikan nama model
use App\Models\Subject;

class GradeController extends Controller
{
    // tampil halaman nilai
    public function index()
    {
        $students = Student::all();

        // 🔥 TAMBAHAN WAJIB
        $classes = SchoolClass::all(); 
        $subjects = Subject::all();

        return view('guru.nilai', compact('students', 'classes', 'subjects'));
    }

    // simpan nilai
    public function store(Request $request)
    {
        foreach ($request->grades as $studentId => $data) {

            Grade::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id ?? 1, // 🔥 dinamis
                    'type' => $request->type ?? 'UTS',
                    'semester' => 'Ganjil',
                    'academic_year' => '2026',
                ],
                [
                    'score' => $data['score'] ?? null,
                ]
            );
        }

        return back()->with('success', 'Nilai berhasil disimpan');
    }
}