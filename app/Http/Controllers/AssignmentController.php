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

        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        // AUTO-COMPLETE TUGAS YANG MELEWATI DEADLINE
        $now = Carbon::now();
        
        $overdueAssignments = Assignment::where('teacher_id', $teacher->id)
            ->where('is_completed', false)
            ->whereNotNull('due_date')
            ->where('due_date', '<', $now)
            ->get();
        
        foreach ($overdueAssignments as $assignment) {
            $assignment->is_completed = true;
            $assignment->completed_at = $assignment->due_date;
            $assignment->save();
        }
        
        $assignments = Assignment::with(['class', 'subject'])
            ->where('teacher_id', $teacher->id)
            ->latest()
            ->paginate(10);

        // ✅ AMBIL SEMUA KELAS DAN MATA PELAJARAN UNTUK FORM
        $classes = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('guru.tugas', compact('assignments', 'classes', 'subjects'));
    }

    /**
     * Show form untuk membuat tugas baru.
     */
    public function create()
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, 'User bukan guru');
        }
        
        // AMBIL SEMUA KELAS (tidak hanya yang ada di schedules)
        $classes = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        
        return view('guru.tugas-create', compact('classes', 'subjects'));
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

        $dueDate = null;
        if ($request->filled('due_date')) {
            $dueDate = Carbon::parse($request->input('due_date'));
        }
        
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
            'due_date' => $request->input('due_date'),
            'is_completed' => $isCompleted,
            'completed_at' => $completedAt,
        ]);

        $message = $isCompleted ? 'Tugas berhasil dibuat (Deadline sudah lewat, otomatis ditandai selesai)!' : 'Tugas berhasil dibuat!';
        
        return redirect()->route('guru.tugas')->with('success', $message);
    }

    /**
     * Show form untuk edit tugas.
     */
    public function edit($id)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        $assignment = Assignment::where('teacher_id', $teacher->id)
            ->where('id', $id)
            ->firstOrFail();
        
        // AMBIL SEMUA KELAS (tidak hanya yang ada di schedules)
        $classes = SchoolClass::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        
        return view('guru.tugas-edit', compact('assignment', 'classes', 'subjects'));
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

        $assignment = Assignment::where('teacher_id', $teacher->id)
            ->where('id', $id)
            ->firstOrFail();

        // Jika request untuk toggle complete
        if ($request->has('toggle_complete')) {
            $assignment->is_completed = !$assignment->is_completed;
            
            if ($assignment->is_completed) {
                $assignment->completed_at = now();
            } else {
                $assignment->completed_at = null;
            }
            
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

        $dueDate = null;
        if ($request->filled('due_date')) {
            $dueDate = Carbon::parse($request->input('due_date'));
        }
        
        $isCompleted = $assignment->is_completed;
        $completedAt = $assignment->completed_at;
        
        if (!$isCompleted && $dueDate && $dueDate->isPast() && !$dueDate->isToday()) {
            $isCompleted = true;
            $completedAt = $dueDate;
        }

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'type' => $request->type,
            'due_date' => $request->input('due_date'),
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

        $assignment = Assignment::where('teacher_id', $teacher->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($assignment->file && Storage::disk('public')->exists($assignment->file)) {
            Storage::disk('public')->delete($assignment->file);
        }

        $assignment->delete();

        return redirect()->route('guru.tugas')->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * Toggle complete status (API endpoint)
     */
    public function toggleComplete($id)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $assignment = Assignment::where('teacher_id', $teacher->id)
            ->where('id', $id)
            ->firstOrFail();

        $assignment->is_completed = !$assignment->is_completed;
        
        if ($assignment->is_completed) {
            $assignment->completed_at = now();
        } else {
            $assignment->completed_at = null;
        }
        
        $assignment->save();

        return response()->json([
            'success' => true,
            'is_completed' => $assignment->is_completed
        ]);
    }

    /**
     * Get assignments for student (SISWA)
     */
    public function getStudentAssignments()
    {
        $studentId = Auth::id();
        $now = Carbon::now();
        
        $assignments = Assignment::whereHas('class.students', function($query) use ($studentId) {
            $query->where('students.id', $studentId);
        })
        ->with(['subject', 'submissions' => function($query) use ($studentId) {
            $query->where('student_id', $studentId);
        }])
        ->orderBy('due_date', 'asc')
        ->get();
        
        foreach ($assignments as $assignment) {
            $submission = $assignment->submissions->first();
            
            if ($submission && $submission->status == 'submitted') {
                $assignment->status = 'submitted';
                $assignment->is_late = false;
            } 
            else if ($assignment->due_date && Carbon::parse($assignment->due_date)->isPast()) {
                $assignment->status = 'late';
                $assignment->is_late = true;
            } 
            else {
                $assignment->status = 'pending';
                $assignment->is_late = false;
            }
        }
        
        return $assignments;
    }
    
    /**
     * Auto-mark overdue assignments as completed
     */
    public function autoCompleteOverdueAssignments()
    {
        $teacher = Auth::user()->teacher;
        
        if (!$teacher) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $now = Carbon::now();
        
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
            'message' => "{$updatedCount} tugas telah otomatis ditandai selesai"
        ]);
    }
}