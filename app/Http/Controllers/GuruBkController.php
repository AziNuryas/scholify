<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Chat;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class GuruBkController extends Controller
{
    private function getGuruBk()
    {
        // Mengambil profil guru BK yang sedang login
        if (auth()->check() && auth()->user()->role === 'guru_bk') {
            return \App\Models\Teacher::where('user_id', auth()->id())->first();
        }
        return \App\Models\Teacher::where('user_id', \App\Models\User::where('role', 'guru_bk')->first()->id ?? 0)->first();
    }

    public function index()
    {
        $guruData = $this->getGuruBk();
        $guru = collect($guruData ? $guruData->toArray() : [
            'name' => 'Guru BK',
            'role' => 'Bimbingan Konseling',
            'avatar' => null
        ]);

        // Statistik Nyata dari Database
        $stats = [
            'total_students' => DB::table('students')->count(),
            'active_cases' => DB::table('chats')->where('receiver_id', auth()->id())->distinct('sender_id')->count(),
            'unread_messages' => DB::table('chats')->where('receiver_id', auth()->id())->where('is_read', false)->count(),
            'appointments_today' => 0
        ];

        return view('gurubk.dashboard', compact('guru', 'stats'));
    }

    public function chats(Request $request)
    {
        $guruData = $this->getGuruBk();
        $guru = collect($guruData ? $guruData->toArray() : [
            'name' => 'Guru BK',
            'role' => 'Bimbingan Konseling',
            'avatar' => null
        ]);

        // Cari daftar ID Siswa yang pernah ngobrol dengan Guru BK (bisa sebagai pengirim atau penerima)
        $studentIds = Chat::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->get()
            ->map(function($chat) {
                return $chat->sender_id == auth()->id() ? $chat->receiver_id : $chat->sender_id;
            })
            ->unique()
            ->values();

        // Ambil profil siswa dan pesan terakhirnya
        $inbox = User::with(['student.schoolClass'])
            ->whereIn('id', $studentIds)
            ->get()
            ->map(function($user) {
                // Cari pesan terakhir antara BK ini dan Siswa ini
                $lastMsg = Chat::where(function($q) use ($user) {
                    $q->where('sender_id', $user->id)->where('receiver_id', auth()->id());
                })->orWhere(function($q) use ($user) {
                    $q->where('sender_id', auth()->id())->where('receiver_id', $user->id);
                })->orderBy('created_at', 'desc')->first();

                // Hitung pesan yang belum dibaca dari siswa ini
                $unread = Chat::where('sender_id', $user->id)
                    ->where('receiver_id', auth()->id())
                    ->where('is_read', false)->count();

                return (object)[
                    'sender_id' => $user->id,
                    'student_name' => $user->name,
                    'avatar' => $user->student->avatar ?? null,
                    'class' => $user->student->schoolClass->name ?? '-',
                    'last_message' => $lastMsg->message ?? '',
                    'is_read' => $unread === 0,
                    'created_at' => $lastMsg->created_at ?? now(),
                    'time' => $lastMsg ? $lastMsg->created_at->diffForHumans() : ''
                ];
            })
            ->sortByDesc('created_at')
            ->values();

        // Jika ada siswa yang dipilih, ambil riwayat percakapannya
        $selectedStudentId = $request->input('student_id') ?? ($inbox->first()->sender_id ?? null);
        $selectedStudent = null;
        $messages = collect([]);

        if ($selectedStudentId) {
            $selectedStudent = User::with('student.schoolClass')->find($selectedStudentId);
            $messages = Chat::where(function($q) use ($selectedStudentId) {
                    $q->where('sender_id', $selectedStudentId)->where('receiver_id', auth()->id());
                })
                ->orWhere(function($q) use ($selectedStudentId) {
                    $q->where('sender_id', auth()->id())->where('receiver_id', $selectedStudentId);
                })
                ->orderBy('created_at', 'asc')
                ->get();
            
            // Mark as read
            Chat::where('sender_id', $selectedStudentId)->where('receiver_id', auth()->id())->update(['is_read' => true]);
        }

        return view('gurubk.chats', compact('guru', 'inbox', 'selectedStudent', 'messages'));
    }

    public function reply(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'student_id' => 'required'
        ]);

        \App\Models\Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->student_id,
            'message' => $request->message,
            'is_read' => false
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function profile()
    {
        $guruData = $this->getGuruBk();
        $guru = collect($guruData ? $guruData->toArray() : []);
        
        return view('gurubk.profile', compact('guru', 'guruData'));
    }

    public function updateProfile(Request $request)
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();
        
        if (!$teacher) {
            return back()->with('error', 'Data guru tidak ditemukan untuk akun ini.');
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $teacher->avatar = '/storage/' . $path;
        }

        $teacher->name = $request->input('name') ?? $teacher->name;
        $teacher->nip = $request->input('nip');
        $teacher->phone = $request->input('phone');
        $teacher->birth_place = $request->input('birth_place');
        $teacher->address = $request->input('address');
        $teacher->save();

        return back()->with('success', 'Profil Guru BK berhasil diperbarui!');
    }

    public function appointments()
    {
        $guruData = $this->getGuruBk();
        $guru = collect($guruData ? $guruData->toArray() : []);

        $appointments = \App\Models\Appointment::with(['student.schoolClass'])
            ->where('teacher_id', auth()->id())
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
            if ($appointment->teacher_id == auth()->id()) {
                $appointment->update(['status' => $request->status]);
                return back()->with('success', 'Status jadwal temu diperbarui.');
            }
        } catch (\Exception $e) {}
        return back()->with('error', 'Gagal memperbarui status jadwal temu.');
    }

    public function discipline()
    {
        $guruData = $this->getGuruBk();
        $guru = collect($guruData ? $guruData->toArray() : []);

        $records = \App\Models\DisciplinaryRecord::with(['student.schoolClass'])
            ->orderBy('created_at', 'desc')
            ->get();
        $students = \App\Models\Student::with('schoolClass')->get();

        return view('gurubk.discipline', compact('guru', 'records', 'students'));
    }

    public function storeDiscipline(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'violation_type' => 'required|string',
            'description' => 'required|string',
            'points' => 'required|integer|min:0'
        ]);

        try {
            \App\Models\DisciplinaryRecord::create([
                'student_id' => $request->student_id,
                'teacher_id' => auth()->id(),
                'date' => $request->date,
                'violation_type' => $request->violation_type,
                'description' => $request->description,
                'points' => $request->points
            ]);
            return back()->with('success', 'Catatan disiplin berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan catatan disiplin.');
        }
    }
}
