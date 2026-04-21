<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

        // Cegah kalau bukan guru
        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        $assignments = Assignment::with(['class', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->get();

        $classes = SchoolClass::all();
        $subjects = Subject::all();

        return view('guru.tugas', compact('assignments', 'classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;

        // Cegah kalau bukan guru
        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|in:tugas,ujian,materi',
            'due_date' => 'nullable|date',
            'file' => 'nullable|file|max:5120',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        Assignment::create([
            'teacher_id' => $teacher->id, // ✅ FIX DI SINI
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'file' => $filePath,
            'due_date' => $request->due_date,
        ]);

        return back()->with('success', 'Tugas berhasil dibuat');
    }

    public function destroy($id)
    {
        $teacher = Auth::user()->teacher;

        // Cegah kalau bukan guru
        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        $assignment = Assignment::findOrFail($id);

        // Pastikan hanya guru pemilik yang bisa hapus
        if ($assignment->teacher_id != $teacher->id) {
            abort(403);
        }

        $assignment->delete();

        return back()->with('success', 'Tugas dihapus');
    }
}