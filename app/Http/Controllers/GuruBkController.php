<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Appointment;
use App\Models\CatatanKonseling;
use App\Models\LaporanGuru;
use App\Models\AsesmenSiswa;
use App\Models\Chat;
use App\Models\User;
use App\Models\DisciplinaryRecord;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GuruBkController extends Controller
{
    /**
     * Index method - Memanggil dashboard
     */
    public function index()
    {
        return $this->dashboard();
    }

    /**
     * Dashboard Guru BK - Menampilkan semua statistik BK
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Cek apakah user adalah guru BK
        if ($user->role !== 'guru_bk') {
            abort(403, 'User bukan Guru BK');
        }

        // Data guru untuk welcome banner
        $guru = [
            'name' => $user->name,
            'role' => $user->role,
        ];

        // =========================
        // 1. STATISTIK BK
        // =========================
        $stats = [
            'total_students' => Student::count(),
            'active_cases' => LaporanGuru::where('status', 'baru')->count(),
            'appointments_today' => Appointment::whereDate('date', Carbon::today())->count(),
        ];

        // Total konseling / chat
        $totalKonseling = Chat::count();

        // Pesan konseling belum dibalas
        $konselingBelumDibalas = Chat::where('is_replied', false)->count();

        // Total catatan konseling
        $totalCatatanKonseling = CatatanKonseling::count();

        // Agenda/Janji Temu Hari Ini
        $appointments = Appointment::with('student')
            ->whereDate('date', Carbon::today())
            ->orderBy('time', 'asc')
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'name' => $appointment->student->name ?? 'Siswa',
                    'class' => $appointment->student->schoolClass->name ?? '-',
                    'topic' => $appointment->notes ?? 'Konseling',
                    'time' => Carbon::parse($appointment->time)->format('H:i') . ' WIB',
                    'type' => $appointment->status === 'pending' ? 'alert' : 'normal',
                    'status' => $appointment->status,
                ];
            });

        // Pesan konseling terbaru
        $pesanTerbaru = Chat::with('student')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Siswa dengan asesmen selesai
        $siswaRisikoTinggi = AsesmenSiswa::where('status', 'selesai')
            ->with('siswa')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($asesmen) {
                $skor = 0;
                if (isset($asesmen->hasil_analisis['skor'])) {
                    $skor = is_array($asesmen->hasil_analisis['skor'])
                        ? array_sum($asesmen->hasil_analisis['skor'])
                        : $asesmen->hasil_analisis['skor'];
                }

                return (object)[
                    'student' => $asesmen->siswa,
                    'skor_akhir' => $skor,
                    'jenis' => $asesmen->getLabelJenisAttribute(),
                ];
            });

        // Laporan siswa baru
        $laporanPending = LaporanGuru::with('siswa')
            ->where('status', 'baru')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('gurubk.dashboard', compact(
            'guru',
            'stats',
            'totalKonseling',
            'konselingBelumDibalas',
            'totalCatatanKonseling',
            'appointments',
            'pesanTerbaru',
            'siswaRisikoTinggi',
            'laporanPending'
        ));
    }

    /**
     * Halaman Janji Temu
     */
    public function appointments()
    {
        $appointments = Appointment::with('student')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'asc')
            ->paginate(20);

        return view('gurubk.appointments', compact('appointments'));
    }

    /**
     * Update Status Janji Temu
     */
    public function updateAppointmentStatus($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        return redirect()->back()->with('success', 'Status janji temu berhasil diupdate');
    }

    /**
     * Halaman Catatan Konseling
     */
    public function catatanKonselingIndex()
    {
        $catatan = CatatanKonseling::with(['student', 'bk'])
            ->orderBy('session_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $siswa = Student::orderBy('name')->get();

        return view('gurubk.catatan-konseling', compact('catatan', 'siswa'));
    }

    /**
     * Store Catatan Konseling
     */
    public function catatanKonselingStore(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'topic' => 'required|string|max:255',
            'notes' => 'required|string',
            'recommendation' => 'nullable|string',
        ]);

        CatatanKonseling::create([
            'student_id' => $request->student_id,
            'bk_id' => Auth::id(),
            'session_date' => Carbon::today(),
            'topic' => $request->topic,
            'notes' => $request->notes,
            'recommendation' => $request->recommendation,
        ]);

        return redirect()->back()->with('success', 'Catatan konseling berhasil disimpan');
    }

    /**
     * Edit Catatan Konseling
     */
    public function catatanKonselingEdit($id)
    {
        $catatan = CatatanKonseling::findOrFail($id);
        $siswa = Student::orderBy('name')->get();

        return view('gurubk.catatan-konseling-edit', compact('catatan', 'siswa'));
    }

    /**
     * Update Catatan Konseling
     */
    public function catatanKonselingUpdate(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'topic' => 'required|string|max:255',
            'notes' => 'required|string',
            'recommendation' => 'nullable|string',
        ]);

        $catatan = CatatanKonseling::findOrFail($id);
        
        $catatan->fill([
            'student_id' => $request->student_id,
            'topic' => $request->topic,
            'notes' => $request->notes,
            'recommendation' => $request->recommendation,
        ]);
        $catatan->save();

        return redirect()->route('gurubk.catatan-konseling.index')
            ->with('success', 'Catatan konseling berhasil diupdate');
    }

    /**
     * Delete Catatan Konseling
     */
    public function catatanKonselingDestroy($id)
    {
        $catatan = CatatanKonseling::findOrFail($id);
        $catatan->delete();

        return redirect()->back()->with('success', 'Catatan konseling berhasil dihapus');
    }

    /**
     * Halaman Laporan Siswa (Index dengan filter)
     */
    public function laporanIndex(Request $request)
    {
        $query = LaporanGuru::with(['siswa', 'guru']);
        
        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter urgensi
        if ($request->filled('urgensi')) {
            $query->where('tingkat_urgensi', $request->urgensi);
        }
        
        $laporan = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('gurubk.laporan', compact('laporan'));
    }

    /**
     * Detail Laporan Siswa
     */
    public function laporanShow($id)
    {
        $laporan = LaporanGuru::with(['siswa', 'guru'])->findOrFail($id);
        return view('gurubk.laporan-show', compact('laporan'));
    }

    /**
     * Proses Laporan (Update status dan catatan)
     */
    public function laporanProses(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:baru,diproses,selesai,ditutup',
            'tindak_lanjut' => 'nullable|string',
        ]);
        
        $laporan = LaporanGuru::findOrFail($id);
        
        $laporan->status = $request->status;
        $laporan->tindak_lanjut = $request->tindak_lanjut;
        
        if ($request->status === 'diproses' && !$laporan->ditangani_at) {
            $laporan->ditangani_at = Carbon::now();
            $laporan->ditangani_oleh = Auth::id();
        }
        
        if ($request->status === 'selesai' && !$laporan->ditangani_at) {
            $laporan->ditangani_at = Carbon::now();
            $laporan->ditangani_oleh = Auth::id();
        }
        
        $laporan->save();
        
        return redirect()->back()->with('success', 'Tindak lanjut berhasil disimpan');
    }

    /**
     * Halaman Profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('gurubk.profile', compact('user'));
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profile berhasil diupdate');
    }

    /**
     * Halaman Deteksi Asesmen
     */
    public function deteksiAsesmen(Request $request)
    {
        $tahunAjaran = '2024/2025';
        $semester = 'ganjil';

        // ========== 1. ASESMEN LIST ==========
        $asesmenQuery = AsesmenSiswa::with('siswa')->where('status', 'selesai');

        if ($request->filled('jenis')) {
            $asesmenQuery->where('jenis_asesmen', $request->jenis);
        }

        if ($request->filled('cari')) {
            $asesmenQuery->whereHas('siswa', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->cari . '%');
            });
        }

        $asesmenList = $asesmenQuery->orderBy('created_at', 'desc')->paginate(10);

        foreach ($asesmenList as $item) {
            $item->label_jenis = match ($item->jenis_asesmen) {
                'gaya_belajar' => '📚 Gaya Belajar',
                'minat_bakat' => '⭐ Minat & Bakat',
                'kesehatan_mental' => '💚 Kesehatan Mental',
                'masalah_umum' => '📋 Daftar Cek Masalah',
                'sosiometri' => '🤝 Sosiometri',
                default => $item->jenis_asesmen,
            };
        }

        // ========== 2. SISWA BERISIKO ==========
        $laporanGrouped = LaporanGuru::with('siswa')
            ->where('status', 'baru')
            ->select('siswa_id', DB::raw('COUNT(*) as total_laporan_guru'))
            ->groupBy('siswa_id')
            ->get();

        $siswaBerisiko = $laporanGrouped->map(function ($item) {
            $total = $item->total_laporan_guru;
            $siswa = $item->siswa;
            
            if ($total >= 5) {
                $kategori = 'kritis';
                $skor = min(100, $total * 15);
            } elseif ($total >= 3) {
                $kategori = 'berisiko';
                $skor = min(100, $total * 10);
            } else {
                $kategori = 'perhatian';
                $skor = min(100, $total * 5);
            }
            
            $asesmenSelesai = AsesmenSiswa::where('siswa_id', $siswa?->id)
                ->where('status', 'selesai')
                ->exists();
            
            return (object) [
                'siswa' => $siswa,
                'total_laporan_guru' => $total,
                'kategori_risiko' => $kategori,
                'skor_risiko' => $skor,
                'asesmen_selesai' => $asesmenSelesai,
            ];
        })->filter(function ($item) {
            return !is_null($item->siswa);
        });

        // ========== 3. LAPORAN BARU ==========
        $laporanBaru = LaporanGuru::with(['siswa', 'guru'])
            ->where('status', 'baru')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ========== 4. STATISTIK ==========
        $siswaKritis = LaporanGuru::where('status', 'baru')
            ->select('siswa_id', DB::raw('COUNT(*) as total'))
            ->groupBy('siswa_id')
            ->havingRaw('COUNT(*) >= 5')
            ->get()
            ->count();

        $siswaBerisikoCount = LaporanGuru::where('status', 'baru')
            ->select('siswa_id', DB::raw('COUNT(*) as total'))
            ->groupBy('siswa_id')
            ->havingRaw('COUNT(*) >= 3 AND COUNT(*) < 5')
            ->get()
            ->count();

        $siswaPerhatian = LaporanGuru::where('status', 'baru')
            ->select('siswa_id', DB::raw('COUNT(*) as total'))
            ->groupBy('siswa_id')
            ->havingRaw('COUNT(*) >= 1 AND COUNT(*) < 3')
            ->get()
            ->count();

        $statistik = [
            'kritis' => $siswaKritis,
            'berisiko' => $siswaBerisikoCount,
            'perhatian' => $siswaPerhatian,
            'asesmen_selesai' => AsesmenSiswa::where('status', 'selesai')->count(),
            'laporan_baru' => LaporanGuru::where('status', 'baru')->count(),
        ];

        return view('gurubk.deteksi_asesmen.index', compact(
            'tahunAjaran',
            'semester',
            'statistik',
            'asesmenList',
            'siswaBerisiko',
            'laporanBaru'
        ));
    }

    /**
     * Detail Deteksi Asesmen
     */
    public function deteksiAsesmenShow($id)
    {
        $asesmen = AsesmenSiswa::with('siswa')->findOrFail($id);
        
        $asesmen->label_jenis = match ($asesmen->jenis_asesmen) {
            'gaya_belajar' => '📚 Gaya Belajar',
            'minat_bakat' => '⭐ Minat & Bakat',
            'kesehatan_mental' => '💚 Kesehatan Mental',
            'masalah_umum' => '📋 Daftar Cek Masalah',
            'sosiometri' => '🤝 Sosiometri',
            default => $asesmen->jenis_asesmen,
        };

        return view('gurubk.deteksi_asesmen.show', compact('asesmen'));
    }

    /**
     * Simpan Catatan Asesmen
     */
    public function catatanAsesmen(Request $request, $id)
    {
        $request->validate([
            'catatan_bk' => 'nullable|string',
        ]);

        $asesmen = AsesmenSiswa::findOrFail($id);
        
        $asesmen->catatan_bk = $request->catatan_bk;
        $asesmen->ditinjau_oleh = Auth::id();
        $asesmen->save();

        return redirect()->back()->with('success', 'Catatan asesmen berhasil disimpan');
    }

    /**
     * Halaman Chat Konseling
     */
    public function chats()
    {
        $chats = Chat::with('student')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('gurubk.chats', compact('chats'));
    }

    /**
     * Balas Chat Konseling
     */
    public function replyChat(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'reply' => 'required|string|min:3'
        ]);

        $chat = Chat::findOrFail($request->chat_id);
        
        $chat->reply = $request->reply;
        $chat->is_replied = true;
        $chat->replied_at = Carbon::now();
        $chat->replied_by = Auth::id();
        $chat->save();

        return redirect()->back()->with('success', 'Pesan berhasil dibalas');
    }

    /**
     * Halaman Disiplin / Pelanggaran
     */
    public function discipline()
    {
        $records = DisciplinaryRecord::with('student')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $siswa = Student::orderBy('name')->get();

        return view('gurubk.discipline', compact('records', 'siswa'));
    }

    /**
     * Simpan Data Disiplin
     */
    public function storeDiscipline(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|string',
            'description' => 'required|string',
            'action_taken' => 'nullable|string'
        ]);

        DisciplinaryRecord::create($request->all());

        return redirect()->back()->with('success', 'Data pelanggaran berhasil disimpan');
    }
}