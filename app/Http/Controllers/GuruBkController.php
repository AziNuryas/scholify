<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\LaporanGuru;
use App\Models\AsesmenSiswa;
use App\Models\DeteksiDiniSiswa;
use App\Services\DeteksiDiniService;
use Illuminate\Support\Facades\DB;

class GuruBkController extends Controller
{
    private function getGuruBk()
    {
        if (auth()->check() && auth()->user()->role === 'guru_bk') {
            return \App\Models\Teacher::where('user_id', auth()->id())->first();
        }
        return \App\Models\Teacher::where('user_id', \App\Models\User::where('role', 'guru_bk')->first()->id ?? 0)->first();
    }

    public function index()
    {
        $guruData = $this->getGuruBk();
        $guru = collect($guruData ? $guruData->toArray() : [
            'name'   => 'Guru BK',
            'role'   => 'Bimbingan Konseling',
            'avatar' => null,
        ]);

        $stats = [
            'total_students'     => DB::table('students')->count(),
            'active_cases'       => DB::table('chats')->where('receiver_id', auth()->id())->distinct('sender_id')->count(),
            'unread_messages'    => DB::table('chats')->where('receiver_id', auth()->id())->where('is_read', false)->count(),
            'appointments_today' => \App\Models\Appointment::whereDate('date', today())->count(),
        ];

        $filter = request('agenda_filter', 'today');

        $appointmentsQuery = \App\Models\Appointment::with(['student.schoolClass'])
            ->whereIn('status', ['pending', 'approved']);

        if ($filter === 'week') {
            $appointmentsQuery->whereBetween('date', [today(), today()->endOfWeek()]);
        } else {
            $appointmentsQuery->whereDate('date', today());
        }

        $appointments = $appointmentsQuery->orderBy('date', 'asc')->orderBy('time', 'asc')->get()->map(function ($appt) {
            return [
                'name'  => $appt->student->name ?? '-',
                'class' => $appt->student->schoolClass->name ?? '-',
                'topic' => $appt->notes ?: 'Konseling',
                'time'  => \Carbon\Carbon::parse($appt->time)->format('H:i') . ' WIB',
                'date'  => \Carbon\Carbon::parse($appt->date)->format('d M'),
                'type'  => $appt->status === 'pending' ? 'alert' : 'normal',
            ];
        });

        return view('gurubk.dashboard', compact('guru', 'stats', 'appointments', 'filter'));
    }

    public function profile()
    {
        $guruData = $this->getGuruBk();
        $guru     = collect($guruData ? $guruData->toArray() : []);

        return view('gurubk.profile', compact('guru', 'guruData'));
    }

    public function updateProfile(Request $request)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();

        if (!$teacher) {
            return back()->with('error', 'Data guru tidak ditemukan untuk akun ini.');
        }

        if ($request->hasFile('avatar')) {
            $path            = $request->file('avatar')->store('avatars', 'public');
            $teacher->avatar = '/storage/' . $path;
        }

        $teacher->name        = $request->input('name') ?? $teacher->name;
        $teacher->nip         = $request->input('nip');
        $teacher->phone       = $request->input('phone');
        $teacher->birth_place = $request->input('birth_place');
        $teacher->address     = $request->input('address');
        $teacher->save();

        return back()->with('success', 'Profil Guru BK berhasil diperbarui!');
    }

    public function appointments()
    {
        $guruData = $this->getGuruBk();
        $guru     = collect($guruData ? $guruData->toArray() : []);

        $appointments = \App\Models\Appointment::with(['student.schoolClass'])
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('gurubk.appointments', compact('guru', 'appointments'));
    }

    public function updateAppointmentStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:approved,rejected,completed']);

        try {
            $appointment = \App\Models\Appointment::findOrFail($id);
            $appointment->update(['status' => $request->status]);
            return back()->with('success', 'Status jadwal temu diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui status jadwal temu.');
        }
    }

    public function discipline()
    {
        $guruData = $this->getGuruBk();
        $guru     = collect($guruData ? $guruData->toArray() : []);

        $records  = \App\Models\DisciplinaryRecord::with(['student.schoolClass'])
            ->orderBy('created_at', 'desc')
            ->get();

        $siswa = \App\Models\Student::with('schoolClass')->get();

        return view('gurubk.discipline', compact('guru', 'records', 'siswa'));
    }

    public function storeDiscipline(Request $request)
    {
        $request->validate([
            'student_id'     => 'required|exists:students,id',
            'date'           => 'required|date',
            'violation_type' => 'required|string',
            'description'    => 'required|string',
            'points'         => 'required|integer|min:0',
        ]);

        try {
            \App\Models\DisciplinaryRecord::create([
                'student_id'     => $request->student_id,
                'teacher_id'     => auth()->id(),
                'date'           => $request->date,
                'violation_type' => $request->violation_type,
                'description'    => $request->description,
                'points'         => $request->points,
            ]);
            return back()->with('success', 'Catatan disiplin berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan catatan disiplin.');
        }
    }

    public function deteksiAsesmen(Request $request)
    {
        $tahunAjaran = config('bk.tahun_ajaran_aktif');
        $semester    = config('bk.semester_aktif');

        $statistik = [
            'total_siswa'     => User::where('role', 'siswa')->count(),
            'kritis'          => DeteksiDiniSiswa::where('kategori_risiko', 'kritis')->count(),
            'berisiko'        => DeteksiDiniSiswa::where('kategori_risiko', 'berisiko')->count(),
            'perhatian'       => DeteksiDiniSiswa::where('kategori_risiko', 'perhatian')->count(),
            'laporan_baru'    => LaporanGuru::where('status', 'baru')->count(),
            'asesmen_selesai' => AsesmenSiswa::where('status', 'selesai')
                                    ->where('tahun_ajaran', $tahunAjaran)
                                    ->where('semester', $semester)
                                    ->distinct('siswa_id')
                                    ->count(),
        ];

        $siswaBerisiko = DeteksiDiniSiswa::with('siswa')
            ->whereIn('kategori_risiko', ['kritis', 'berisiko'])
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->orderByDesc('skor_risiko')
            ->paginate(10, ['*'], 'berisiko_page');

        $laporanBaru = LaporanGuru::with(['guru', 'siswa.schoolClass'])
            ->where('status', 'baru')
            ->latest()
            ->take(10)
            ->get();

        $asesmenQuery = AsesmenSiswa::with('siswa')
            ->where('status', 'selesai')
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester);

        if ($request->filled('jenis')) {
            $asesmenQuery->where('jenis_asesmen', $request->jenis);
        }
        if ($request->filled('cari')) {
            $asesmenQuery->whereHas('siswa', fn($q) => $q->where('name', 'like', "%{$request->cari}%"));
        }

        $asesmenList = $asesmenQuery->latest()->paginate(20, ['*'], 'asesmen_page')->withQueryString();

        return view('gurubk.deteksi_asesmen.index', compact(
            'statistik', 'siswaBerisiko', 'laporanBaru', 'tahunAjaran', 'semester', 'asesmenList'
        ));
    }

    public function laporanIndex(Request $request)
    {
        $query = LaporanGuru::with(['siswa.schoolClass', 'guru'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('urgensi')) {
            $query->where('tingkat_urgensi', $request->urgensi);
        }

        $laporan = $query->paginate(20)->withQueryString();

        return view('gurubk.laporan', compact('laporan'));
    }

    public function laporanProses(Request $request, LaporanGuru $laporan)
    {
        $request->validate([
            'status'        => 'required|in:baru,diproses,selesai,ditutup',
            'tindak_lanjut' => 'required|string|min:5',
        ]);

        $laporan->update([
            'status'         => $request->status,
            'tindak_lanjut'  => $request->tindak_lanjut,
            'ditangani_oleh' => auth()->id(),
            'ditangani_at'   => now(),
        ]);

        $student = Student::find($laporan->siswa_id);
        if ($student && $student->user_id) {
            (new DeteksiDiniService)->hitungSkorRisiko(
                $student->user_id,
                config('bk.tahun_ajaran_aktif'),
                config('bk.semester_aktif')
            );
        }

        return back()->with('success', 'Tindak lanjut berhasil disimpan.');
    }
}