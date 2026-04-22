<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the assignments (untuk Guru).
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        // Cegah kalau bukan guru
        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        // ✅ AUTO-COMPLETE TUGAS YANG MELEWATI DEADLINE
        $now = Carbon::now();
        
        // Ambil semua tugas yang belum selesai dan melewati deadline
        $overdueAssignments = Assignment::where('teacher_id', $teacher->id)
            ->where('is_completed', false)
            ->whereNotNull('due_date')
            ->where('due_date', '<', $now)
            ->get();
        
        foreach ($overdueAssignments as $assignment) {
            $assignment->is_completed = true;
            $assignment->completed_at = $assignment->due_date; // tandai selesai di tanggal deadline
            $assignment->save();
        }
        
        // Ambil tugas dengan data terbaru
        $assignments = Assignment::with(['class', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->get();

        $classes = SchoolClass::all();
        $subjects = Subject::all();

        return view('guru.tugas', compact('assignments', 'classes', 'subjects'));
    }

    /**
     * Store a newly created assignment in storage.
     */
    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|in:tugas,ujian,materi',
            'due_date' => 'nullable|date',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments', 'public');
        }

        // Cek apakah deadline sudah lewat
        $dueDate = $request->due_date ? Carbon::parse($request->due_date) : null;
        $isCompleted = false;
        $completedAt = null;
        
        if ($dueDate && $dueDate->isPast() && !$dueDate->isToday()) {
            $isCompleted = true;
            $completedAt = $dueDate;
        }

        Assignment::create([
            'teacher_id' => $teacher->id,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'file' => $filePath,
            'due_date' => $request->due_date,
            'is_completed' => $isCompleted,
            'completed_at' => $completedAt,
        ]);

        $message = $isCompleted ? 'Tugas berhasil dibuat (Deadline sudah lewat, otomatis ditandai selesai)!' : 'Tugas berhasil dibuat!';
        
        return redirect()->route('guru.tugas')->with('success', $message);
    }

    /**
     * Update the specified assignment in storage.
     */
    public function update(Request $request, $id)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        $assignment = Assignment::findOrFail($id);

        if ($assignment->teacher_id != $teacher->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah tugas ini');
        }

        // Jika request untuk toggle complete (tandai selesai/belum selesai)
        if ($request->has('toggle_complete')) {
            $assignment->is_completed = !$assignment->is_completed;
            $assignment->completed_at = $assignment->is_completed ? now() : null;
            $assignment->save();

            $message = $assignment->is_completed 
                ? 'Tugas berhasil ditandai selesai ✓' 
                : 'Tugas berhasil ditandai belum selesai';
            
            return redirect()->route('guru.tugas')->with('success', $message);
        }

        // Update data tugas biasa
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|in:tugas,ujian,materi',
            'due_date' => 'nullable|date',
        ]);

        // Cek deadline baru apakah sudah lewat
        $dueDate = $request->due_date ? Carbon::parse($request->due_date) : null;
        $isCompleted = $assignment->is_completed;
        
        if (!$isCompleted && $dueDate && $dueDate->isPast() && !$dueDate->isToday()) {
            $isCompleted = true;
            $completedAt = $dueDate;
        } else {
            $completedAt = $assignment->completed_at;
        }

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'type' => $request->type,
            'due_date' => $request->due_date,
            'is_completed' => $isCompleted,
            'completed_at' => $completedAt,
        ]);

        return redirect()->route('guru.tugas')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified assignment from storage.
     */
    public function destroy($id)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        $assignment = Assignment::findOrFail($id);

        if ($assignment->teacher_id != $teacher->id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus tugas ini');
        }

        if ($assignment->file && Storage::disk('public')->exists($assignment->file)) {
            Storage::disk('public')->delete($assignment->file);
        }

        $assignment->delete();

        return redirect()->route('guru.tugas')->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * Get assignments with proper status for student (SISWA)
     * ✅ Auto-mark tugas yang melewati deadline sebagai LATE
     */
    public function getStudentAssignments()
    {
        $studentId = Auth::id();
        $now = Carbon::now();
        
        // Ambil semua tugas berdasarkan kelas siswa
        $assignments = Assignment::whereHas('class.students', function($query) use ($studentId) {
            $query->where('students.id', $studentId);
        })
        ->with(['subject', 'submissions' => function($query) use ($studentId) {
            $query->where('student_id', $studentId);
        }])
        ->orderBy('due_date', 'asc')
        ->get();
        
        // Proses setiap tugas untuk menentukan status yang benar
        foreach ($assignments as $assignment) {
            $submission = $assignment->submissions->first();
            
            // ✅ Jika sudah submit
            if ($submission && $submission->status == 'submitted') {
                $assignment->status = 'submitted';
                $assignment->is_late = false;
            } 
            // ✅ Jika belum submit dan melewati deadline
            else if ($assignment->due_date && Carbon::parse($assignment->due_date)->isPast()) {
                $assignment->status = 'late';
                $assignment->is_late = true;
                
                // ✅ OTOMATIS TANDAI TUGAS SEBAGAI TERLAMBAT (TIDAK SELESAI)
                // Untuk sisi guru, tugas tetap belum selesai, tapi untuk siswa statusnya late
            } 
            // ✅ Status pending (belum dikerjakan, deadline masih ada)
            else {
                $assignment->status = 'pending';
                $assignment->is_late = false;
            }
        }
        
        return $assignments;
    }
    
    /**
     * ✅ METHOD BARU: Auto-mark overdue assignments as completed (untuk GURU)
     * Bisa dipanggil via cron job atau setiap kali load halaman
     */
    public function autoCompleteOverdueAssignments()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $now = Carbon::now();
        
        // Tugas yang belum selesai dan melewati deadline
        $overdueAssignments = Assignment::where('teacher_id', $teacher->id)
            ->where('is_completed', false)
            ->whereNotNull('due_date')
            ->where('due_date', '<', $now)
            ->get();
        
        $updatedCount = 0;
        
        foreach ($overdueAssignments as $assignment) {
            $assignment->is_completed = true;
            $assignment->completed_at = $assignment->due_date;
            $assignment->save();
            $updatedCount++;
        }
        
        return response()->json([
            'success' => true,
            'updated_count' => $updatedCount,
            'message' => "{$updatedCount} tugas telah otomatis ditandai selesai karena melewati deadline"
        ]);
    }
}