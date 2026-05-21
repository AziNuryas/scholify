<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Subject;

class GradeController extends Controller
{
    // tampil halaman nilai
    public function index()
    {
        $students = Student::all();

        // TAMBAHAN WAJIB
        $classes = SchoolClass::all(); 
        $subjects = Subject::all();

        return view('guru.nilai', compact('students', 'classes', 'subjects'));
    }

    // simpan nilai
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'grades' => 'required|array',
            'grades.*.score' => 'nullable|numeric|min:0|max:100',
        ]);

        $savedCount = 0;

        foreach ($request->grades as $studentId => $data) {
            // 🔥 PERBAIKAN: Hanya simpan jika score tidak null
            if (isset($data['score']) && $data['score'] !== '' && $data['score'] !== null) {
                
                Grade::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'subject_id' => $request->subject_id ?? 1,
                        'type' => $request->type ?? 'UTS',
                        'semester' => 'Ganjil',
                        'academic_year' => '2026',
                    ],
                    [
                        'score' => $data['score'],
                    ]
                );
                $savedCount++;
            }
        }

        if ($savedCount == 0) {
            return back()->with('warning', 'Tidak ada nilai yang diisi!');
        }

        return back()->with('success', "{$savedCount} nilai berhasil disimpan");
    }
}