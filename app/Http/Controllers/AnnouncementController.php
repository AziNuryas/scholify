<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        // ambil semua kelas
        $classes = SchoolClass::orderBy('name')->get();

        return view('guru.pengumuman', compact('announcements', 'classes'));
    }

    /**
     * 📌 Simpan pengumuman dari guru
     */
    public function store(Request $request)
    {
        // Validasi - sudah sinkron dengan blade
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target' => 'required|in:all,single_class', // ✅ Sesuai dengan value di blade
            'class_id' => 'nullable|required_if:target,single_class|exists:school_classes,id',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // max 5MB
        ]);

        $filePath = null;

        // Upload file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('announcements', 'public');
        }

        // Simpan ke database
        $announcement = Announcement::create([
            'teacher_id' => Auth::id(),
            'title'      => $request->title,
            'content'    => $request->content,
            'target'     => $request->target === 'all' ? 'all' : 'class',
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

        // Cek kepemilikan
        if ($announcement->teacher_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus file kalau ada
        if ($announcement->file && Storage::disk('public')->exists($announcement->file)) {
            Storage::disk('public')->delete($announcement->file);
        }

        $announcement->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus');
    }

    /**
     * 📌 Download lampiran
     */
    public function download($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Cek izin akses
        if (Auth::user()->role === 'guru' && $announcement->teacher_id != Auth::id()) {
            abort(403);
        }
        
        if (Auth::user()->role === 'siswa' && $announcement->target === 'class') {
            if ($announcement->class_id != Auth::user()->class_id) {
                abort(403);
            }
        }

        if ($announcement->file && Storage::disk('public')->exists($announcement->file)) {
            return Storage::disk('public')->download($announcement->file);
        }

        return back()->with('error', 'File tidak ditemukan');
    }
}