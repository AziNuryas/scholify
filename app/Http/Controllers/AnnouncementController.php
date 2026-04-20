<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\SchoolClass; // ✅ TAMBAH INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    /**
     * 📌 Halaman guru (list + form)
     */
    public function guruIndex()
    {
        $announcements = Announcement::where('teacher_id', Auth::id())
            ->latest()
            ->get();

        // ✅ ambil semua kelas
        $classes = SchoolClass::orderBy('name')->get();

        return view('guru.pengumuman', compact('announcements', 'classes'));
    }

    /**
     * 📌 Simpan pengumuman dari guru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target' => 'required|in:all_classes,single_class',
            'class_id' => 'nullable|required_if:target,single_class|exists:school_classes,id',
            'file' => 'nullable|file|max:5120', // max 5MB
        ]);

        $filePath = null;

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('announcements', 'public');
        }

        // Simpan ke database
        Announcement::create([
            'teacher_id' => Auth::id(),
            'title'      => $request->title,
            'content'    => $request->content,
            'target'     => $request->target === 'all_classes' ? 'all' : 'class',
            'class_id'   => $request->target === 'single_class' ? $request->class_id : null,
            'file'       => $filePath,
            'status'     => 'terkirim',
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil dikirim');
    }

    /**
     * 📌 Halaman siswa
     */
    public function studentIndex()
    {
        $user = Auth::user();

        $announcements = Announcement::where('target', 'all')
            ->orWhere(function ($query) use ($user) {
                $query->where('target', 'class')
                      ->where('class_id', $user->class_id);
            })
            ->latest()
            ->get();

        return view('student.announcements', compact('announcements'));
    }

    /**
     * 📌 Hapus pengumuman
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);

        if ($announcement->teacher_id != Auth::id()) {
            abort(403);
        }

        // hapus file kalau ada
        if ($announcement->file && \Storage::disk('public')->exists($announcement->file)) {
            \Storage::disk('public')->delete($announcement->file);
        }

        $announcement->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus');
    }
}