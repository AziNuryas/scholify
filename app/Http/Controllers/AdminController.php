<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Kkm;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    /**
     * Dashboard - Overview statistik
     */
    public function index(): View
    {
        $data = [
            'totalStudents' => Student::count(),
            'totalTeachers' => User::whereIn('role', ['guru', 'guru_bk'])->count(),
            'totalClasses' => Classes::count(),
            'totalAdmins' => User::where('role', 'admin')->count(),
            'recentStudents' => Student::with('user')->latest()->take(5)->get(),
            'recentTeachers' => User::whereIn('role', ['guru', 'guru_bk'])->latest()->take(5)->get(),
        ];
        
        return view('admin.dashboard', compact('data'));
    }

    // ==================== STUDENT MANAGEMENT ====================

    public function students(Request $request): View
    {
        $query = Student::with(['user', 'schoolClass']);
        
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }
        
        if ($request->filled('gender')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $students = $query->latest()->paginate(15)->appends($request->query());
        
        return view('admin.students', compact('students'));
    }

    public function showStudent(int $id): View
    {
        $student = Student::with(['user', 'schoolClass'])->findOrFail($id);
        $kkmData = Kkm::with('subject')->get();
        
        return view('admin.indexstudent', compact('student', 'kkmData'));
    }

    public function createStudent(): View
    {
        $classes = Classes::orderBy('grade_level')->orderBy('name')->get();
        return view('admin.students-create', compact('classes'));
    }

    public function storeStudent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nisn' => 'nullable|string|unique:students,nisn',
            'nis' => 'nullable|string|unique:students,nis',
            'gender' => 'nullable|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa',
            'gender' => $validated['gender'] ?? null,
            'birth_place' => $validated['birth_place'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'class_id' => $validated['class_id'] ?? null,
        ]);

        Student::create([
            'user_id' => $user->id,
            'class_id' => $validated['class_id'] ?? null,
            'nisn' => $validated['nisn'] ?? null,
            'nis' => $validated['nis'] ?? null,
            'name' => $validated['name'],
            'birth_place' => $validated['birth_place'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()->route('admin.students')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function editStudent(int $id): View
    {
        $student = Student::with('user')->findOrFail($id);
        $classes = Classes::orderBy('grade_level')->orderBy('name')->get();
        return view('admin.students-edit', compact('student', 'classes'));
    }

    public function updateStudent(Request $request, int $id): RedirectResponse
    {
        $student = Student::with('user')->findOrFail($id);
        $user = $student->user;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nisn' => 'nullable|string|unique:students,nisn,' . $id,
            'nis' => 'nullable|string|unique:students,nis,' . $id,
            'gender' => 'nullable|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'gender' => $validated['gender'] ?? $user->gender,
            'birth_place' => $validated['birth_place'] ?? $user->birth_place,
            'birth_date' => $validated['birth_date'] ?? $user->birth_date,
            'phone' => $validated['phone'] ?? $user->phone,
            'address' => $validated['address'] ?? $user->address,
            'class_id' => $validated['class_id'] ?? $user->class_id,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $user->update(['password' => Hash::make($request->password)]);
        }

        $student->update([
            'class_id' => $validated['class_id'] ?? $student->class_id,
            'nisn' => $validated['nisn'] ?? $student->nisn,
            'nis' => $validated['nis'] ?? $student->nis,
            'name' => $validated['name'],
            'birth_place' => $validated['birth_place'] ?? $student->birth_place,
            'birth_date' => $validated['birth_date'] ?? $student->birth_date,
            'address' => $validated['address'] ?? $student->address,
            'phone' => $validated['phone'] ?? $student->phone,
        ]);

        return redirect()->route('admin.students')
            ->with('success', 'Siswa berhasil diperbarui!');
    }

    public function deleteStudent(int $id): RedirectResponse
    {
        $student = Student::with('user')->findOrFail($id);
        $user = $student->user;
        $student->delete();
        if ($user) { $user->delete(); }

        return redirect()->route('admin.students')
            ->with('success', 'Siswa berhasil dihapus!');
    }

    // ==================== TEACHER MANAGEMENT ====================

    public function teachers(Request $request): View
    {
        $query = User::whereIn('role', ['guru', 'guru_bk'])->with('homeroomClass');
        
        if ($request->filled('role')) { $query->where('role', $request->role); }
        if ($request->filled('gender')) { $query->where('gender', $request->gender); }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        $teachers = $query->latest()->paginate(10)->appends($request->query());
        return view('admin.teachers', compact('teachers'));
    }

    public function createTeacher(): View
    {
        return view('admin.teachers-create');
    }

    public function storeTeacher(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:guru,guru_bk',
            'nip' => 'nullable|string|unique:users,nip',
            'gender' => 'nullable|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'nip' => $validated['nip'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'birth_place' => $validated['birth_place'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        $roleLabel = $validated['role'] === 'guru_bk' ? 'Guru BK' : 'Guru Mapel';
        return redirect()->route('admin.teachers')
            ->with('success', $roleLabel . ' berhasil ditambahkan!');
    }

    public function editTeacher(int $id): View
    {
        $teacher = User::whereIn('role', ['guru', 'guru_bk'])->findOrFail($id);
        return view('admin.teachers-edit', compact('teacher'));
    }

    public function updateTeacher(Request $request, int $id): RedirectResponse
    {
        $teacher = User::whereIn('role', ['guru', 'guru_bk'])->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:guru,guru_bk',
            'nip' => 'nullable|string|unique:users,nip,' . $id,
            'gender' => 'nullable|in:L,P',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $teacher->update(['password' => Hash::make($request->password)]);
        }

        $teacher->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'nip' => $validated['nip'] ?? $teacher->nip,
            'gender' => $validated['gender'] ?? $teacher->gender,
            'birth_place' => $validated['birth_place'] ?? $teacher->birth_place,
            'birth_date' => $validated['birth_date'] ?? $teacher->birth_date,
            'phone' => $validated['phone'] ?? $teacher->phone,
            'address' => $validated['address'] ?? $teacher->address,
        ]);

        $roleLabel = $validated['role'] === 'guru_bk' ? 'Guru BK' : 'Guru Mapel';
        return redirect()->route('admin.teachers')
            ->with('success', $roleLabel . ' berhasil diperbarui!');
    }

    public function deleteTeacher(int $id): RedirectResponse
    {
        $teacher = User::whereIn('role', ['guru', 'guru_bk'])->findOrFail($id);
        $teacher->delete();
        return redirect()->route('admin.teachers')
            ->with('success', 'Guru berhasil dihapus!');
    }

    // ==================== CLASS MANAGEMENT ====================

    public function classes(): View
    {
        $classes = Classes::with(['homeroomTeacher', 'students'])->get();
        
        $classesByGrade = [
            'X' => $classes->where('grade_level', 'X'),
            'XI' => $classes->where('grade_level', 'XI'),
            'XII' => $classes->where('grade_level', 'XII'),
        ];
        
        $stats = [
            'total' => $classes->count(),
            'gradeX' => $classes->where('grade_level', 'X')->count(),
            'gradeXI' => $classes->where('grade_level', 'XI')->count(),
            'gradeXII' => $classes->where('grade_level', 'XII')->count(),
        ];
        
        return view('admin.classes', compact('classes', 'classesByGrade', 'stats'));
    }

    public function createClass(): View
    {
        $grades = ['X', 'XI', 'XII'];
        $teachers = User::whereIn('role', ['guru', 'guru_bk'])->orderBy('name')->get();
        return view('classes.create', compact('grades', 'teachers'));
    }

    public function storeClass(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:10',
                Rule::unique('classes')->where(function ($query) use ($request) {
                    return $query->where('grade_level', $request->grade);
                }),
            ],
            'grade' => 'required|in:X,XI,XII',
            'homeroom_teacher_id' => 'nullable|exists:users,id',
        ], ['name.unique' => 'Kelas dengan nama tersebut sudah ada di tingkat yang sama.']);

        Classes::create([
            'name' => $validated['name'],
            'grade_level' => $validated['grade'],
            'homeroom_teacher_id' => $validated['homeroom_teacher_id'] ?? null,
        ]);

        return redirect()->route('admin.classes')
            ->with('success', 'Kelas "' . $validated['name'] . '" berhasil ditambahkan!');
    }

    public function editClass(int $id): View
    {
        $class = Classes::with(['homeroomTeacher', 'students.user'])->findOrFail($id);
        $grades = ['X', 'XI', 'XII'];
        $teachers = User::whereIn('role', ['guru', 'guru_bk'])->orderBy('name')->get();
        $classStudents = $class->students;
        $availableStudents = Student::whereNull('class_id')
            ->orWhere('class_id', '!=', $id)
            ->orderBy('name')->get();
        
        return view('classes.edite', compact('class', 'grades', 'teachers', 'classStudents', 'availableStudents'));
    }

    public function updateClass(Request $request, int $id): RedirectResponse
    {
        $class = Classes::findOrFail($id);
        
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:10',
                Rule::unique('classes')->where(function ($query) use ($request) {
                    return $query->where('grade_level', $request->grade);
                })->ignore($id),
            ],
            'grade' => 'required|in:X,XI,XII',
            'homeroom_teacher_id' => 'nullable|exists:users,id',
        ], ['name.unique' => 'Kelas dengan nama tersebut sudah ada di tingkat yang sama.']);

        $class->update([
            'name' => $validated['name'],
            'grade_level' => $validated['grade'],
            'homeroom_teacher_id' => $validated['homeroom_teacher_id'] ?? null,
        ]);

        return redirect()->route('admin.classes')
            ->with('success', 'Kelas "' . $validated['name'] . '" berhasil diperbarui!');
    }

    public function deleteClass(int $id): RedirectResponse
    {
        $class = Classes::findOrFail($id);
        $className = $class->name;
        $class->delete();
        return redirect()->route('admin.classes')
            ->with('success', 'Kelas "' . $className . '" berhasil dihapus!');
    }

    public function addStudentToClass(Request $request, int $classId): RedirectResponse
    {
        $request->validate(['student_id' => 'required|exists:students,id']);
        $student = Student::findOrFail($request->student_id);
        $student->update(['class_id' => $classId]);
        if ($student->user) { $student->user->update(['class_id' => $classId]); }
        $class = Classes::find($classId);
        return redirect()->route('admin.classes.edit', $classId)
            ->with('success', $student->name . ' berhasil ditambahkan ke kelas ' . $class->name);
    }

    public function removeStudentFromClass(int $classId, int $studentId): RedirectResponse
    {
        $student = Student::findOrFail($studentId);
        $student->update(['class_id' => null]);
        if ($student->user) { $student->user->update(['class_id' => null]); }
        $class = Classes::find($classId);
        return redirect()->route('admin.classes.edit', $classId)
            ->with('success', $student->name . ' berhasil dikeluarkan dari kelas ' . $class->name);
    }

    // ==================== REPORTS ====================

    public function reports(): View
    {
        $data = [
            'totalConsultations' => 456,
            'completedConsultations' => 234,
            'pendingConsultations' => 12,
            'disciplineRecords' => 24,
            'appointments' => 89,
            'approvedAppointments' => 67,
            'attendanceRate' => 94,
        ];
        return view('admin.reports', compact('data'));
    }

    public function exportPdf()
    {
        $data = [
            'totalStudents' => Student::count(),
            'totalTeachers' => User::whereIn('role', ['guru', 'guru_bk'])->count(),
            'totalClasses' => Classes::count(),
            'totalConsultations' => 456,
            'completedConsultations' => 234,
            'pendingConsultations' => 12,
            'disciplineRecords' => 24,
            'appointments' => 89,
            'approvedAppointments' => 67,
            'attendanceRate' => 94,
            'recentStudents' => Student::with(['user', 'schoolClass'])->latest()->take(10)->get(),
            'recentTeachers' => User::whereIn('role', ['guru', 'guru_bk'])->latest()->take(10)->get(),
            'generatedAt' => now()->isoFormat('dddd, D MMMM YYYY - HH:mm'),
        ];

        $pdf = Pdf::loadView('admin.reports-pdf', $data);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'defaultFont' => 'sans-serif']);
        return $pdf->download('laporan-schoolify-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportExcel()
    {
        $data = [
            'totalStudents' => Student::count(),
            'totalTeachers' => User::whereIn('role', ['guru', 'guru_bk'])->count(),
            'totalClasses' => Classes::count(),
            'totalConsultations' => 456,
            'completedConsultations' => 234,
            'pendingConsultations' => 12,
            'disciplineRecords' => 24,
            'appointments' => 89,
            'approvedAppointments' => 67,
            'attendanceRate' => 94,
        ];

        $filename = 'laporan-schoolify-' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv; charset=UTF-8', 'Content-Disposition' => 'attachment; filename="' . $filename . '"'];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, ['Laporan Schoolify']);
            fputcsv($file, ['Tanggal', now()->format('d F Y')]);
            fputcsv($file, ['']);
            fputcsv($file, ['Metrik', 'Nilai']);
            fputcsv($file, ['Total Siswa', $data['totalStudents']]);
            fputcsv($file, ['Total Guru', $data['totalTeachers']]);
            fputcsv($file, ['Total Kelas', $data['totalClasses']]);
            fputcsv($file, ['Total Konsultasi', $data['totalConsultations']]);
            fputcsv($file, ['Konsultasi Selesai', $data['completedConsultations']]);
            fputcsv($file, ['Konsultasi Pending', $data['pendingConsultations']]);
            fputcsv($file, ['Catatan Disiplin', $data['disciplineRecords']]);
            fputcsv($file, ['Jadwal Temu', $data['appointments']]);
            fputcsv($file, ['Jadwal Temu Dikonfirmasi', $data['approvedAppointments']]);
            fputcsv($file, ['Tingkat Kehadiran', $data['attendanceRate'] . '%']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ==================== SETTINGS ====================

    public function settings(): View
    {
        $settings = [
            'school_name' => 'SMA Negeri 1 Bandung',
            'school_address' => 'Jl. Pendidikan No. 123, Bandung',
            'school_email' => 'sekolah@example.com',
            'school_phone' => '+62-274-512345',
            'academic_year' => '2024/2025',
        ];
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil diupdate!');
    }

    // ==================== PROFILE ====================

    public function profile(): View
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $admin = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'current_password' => 'required|current_password',
                'password' => 'required|min:6|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $admin->update($validated);
        return back()->with('success', 'Profil berhasil diupdate!');
    }
}