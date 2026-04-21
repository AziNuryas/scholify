<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the assignments.
     */
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

    /**
     * Store a newly created assignment in storage.
     */
    public function store(Request $request)
    {
        $teacher = Auth::user()->teacher;

        // Cegah kalau bukan guru
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

        Assignment::create([
            'teacher_id' => $teacher->id,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'file' => $filePath,
            'due_date' => $request->due_date,
            'is_completed' => false,
            'completed_at' => null,
        ]);

        return redirect()->route('guru.tugas')->with('success', 'Tugas berhasil dibuat!');
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

        // Pastikan hanya guru pemilik yang bisa update
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

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'type' => $request->type,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('guru.tugas')->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Remove the specified assignment from storage.
     */
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
            abort(403, 'Anda tidak memiliki izin untuk menghapus tugas ini');
        }

        // Hapus file jika ada
        if ($assignment->file && Storage::disk('public')->exists($assignment->file)) {
            Storage::disk('public')->delete($assignment->file);
        }

        $assignment->delete();

        return redirect()->route('guru.tugas')->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * Toggle assignment completion status (AJAX version).
     */
    public function toggleComplete($id)
    {
        try {
            $teacher = Auth::user()->teacher;

            if (!$teacher) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $assignment = Assignment::findOrFail($id);

            if ($assignment->teacher_id != $teacher->id) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            $assignment->is_completed = !$assignment->is_completed;
            $assignment->completed_at = $assignment->is_completed ? now() : null;
            $assignment->save();

            return response()->json([
                'success' => true,
                'is_completed' => $assignment->is_completed,
                'completed_at' => $assignment->completed_at,
                'message' => $assignment->is_completed ? 'Tugas ditandai selesai' : 'Tugas ditandai belum selesai'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Bulk delete assignments.
     */
    public function bulkDestroy(Request $request)
    {
        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, 'User bukan guru');
        }

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:assignments,id'
        ]);

        $assignments = Assignment::whereIn('id', $request->ids)
            ->where('teacher_id', $teacher->id)
            ->get();

        foreach ($assignments as $assignment) {
            if ($assignment->file && Storage::disk('public')->exists($assignment->file)) {
                Storage::disk('public')->delete($assignment->file);
            }
            $assignment->delete();
        }

        return redirect()->route('guru.tugas')->with('success', count($assignments) . ' tugas berhasil dihapus!');
    }
}