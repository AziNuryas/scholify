<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Classes;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    /**
     * Dashboard - Overview statistik
     */
    public function index()
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

    /**
     * Menampilkan daftar siswa
     */
    public function students()
    {
        $students = Student::with(['user', 'schoolClass'])->latest()->paginate(15);
        return view('admin.students', compact('students'));
    }

    /**
     * Form tambah siswa
     */
    public function createStudent()
    {
        $classes = Classes::orderBy('grade_level')->orderBy('name')->get();
        return view('admin.students-create', compact('classes'));
    }

    /**
     * Simpan siswa baru - OTOMATIS ROLE SISWA
     */
    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'nisn' => 'nullable|string|unique:students,nisn',
            'nis' => 'nullable|string|unique:students,nis',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
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
            'first_name' => $validated['first_name'] ?? null,
            'last_name' => $validated['last_name'] ?? null,
            'birth_place' => $validated['birth_place'] ?? null,
            'birth_date' => $validated['birth_date'] ?? null,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
        ]);

        return redirect()->route('admin.students')
            ->with('success', '🎓 Siswa berhasil ditambahkan!');
    }

    /**
     * Form edit siswa
     */
    public function editStudent($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $classes = Classes::orderBy('grade_level')->orderBy('name')->get();
        return view('admin.students-edit', compact('student', 'classes'));
    }

    /**
     * Update siswa
     */
    public function updateStudent(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);
        $user = $student->user;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'nisn' => 'nullable|string|unique:students,nisn,' . $id,
            'nis' => 'nullable|string|unique:students,nis,' . $id,
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
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
            'first_name' => $validated['first_name'] ?? $student->first_name,
            'last_name' => $validated['last_name'] ?? $student->last_name,
            'birth_place' => $validated['birth_place'] ?? $student->birth_place,
            'birth_date' => $validated['birth_date'] ?? $student->birth_date,
            'address' => $validated['address'] ?? $student->address,
            'phone' => $validated['phone'] ?? $student->phone,
        ]);

        return redirect()->route('admin.students')
            ->with('success', '✏️ Siswa berhasil diperbarui!');
    }

    /**
     * Hapus siswa
     */
    public function deleteStudent($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $user = $student->user;
        
        $student->delete();
        
        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.students')
            ->with('success', '🗑️ Siswa berhasil dihapus!');
    }

    // ==================== TEACHER MANAGEMENT ====================

    /**
     * Menampilkan daftar semua guru (BK + Mapel)
     */
    public function teachers()
    {
        $teachers = User::whereIn('role', ['guru', 'guru_bk'])
            ->with('homeroomClass')
            ->paginate(15);
        return view('admin.teachers', compact('teachers'));
    }

    /**
     * Form tambah guru
     */
    public function createTeacher()
    {
        return view('admin.teachers-create');
    }

    /**
     * Simpan guru baru (BK atau Mapel)
     */
    public function storeTeacher(Request $request)
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
            'religion' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'subject' => 'nullable|required_if:role,guru|string|max:100',
            'education_level' => 'nullable|string|max:10',
            'major' => 'nullable|string|max:100',
            'university' => 'nullable|string|max:100',
            'graduation_year' => 'nullable|integer|min:1970|max:2030',
            'employment_status' => 'nullable|string|max:50',
            'start_year' => 'nullable|integer|min:1970|max:2030',
            'certification' => 'nullable|string',
        ]);

        $userData = [
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
            'subject' => $validated['subject'] ?? null,
        ];

        if (Schema::hasColumn('users', 'religion')) {
            $userData['religion'] = $validated['religion'] ?? null;
        }
        if (Schema::hasColumn('users', 'education_level')) {
            $userData['education_level'] = $validated['education_level'] ?? null;
        }
        if (Schema::hasColumn('users', 'major')) {
            $userData['major'] = $validated['major'] ?? null;
        }
        if (Schema::hasColumn('users', 'university')) {
            $userData['university'] = $validated['university'] ?? null;
        }
        if (Schema::hasColumn('users', 'graduation_year')) {
            $userData['graduation_year'] = $validated['graduation_year'] ?? null;
        }
        if (Schema::hasColumn('users', 'employment_status')) {
            $userData['employment_status'] = $validated['employment_status'] ?? null;
        }
        if (Schema::hasColumn('users', 'start_year')) {
            $userData['start_year'] = $validated['start_year'] ?? null;
        }
        if (Schema::hasColumn('users', 'certification')) {
            $userData['certification'] = $validated['certification'] ?? null;
        }

        User::create($userData);

        $roleLabel = $validated['role'] === 'guru_bk' ? 'Guru BK' : 'Guru Mapel';
        
        return redirect()->route('admin.teachers')
            ->with('success', '👩‍🏫 ' . $roleLabel . ' berhasil ditambahkan!');
    }

    /**
     * Form edit guru
     */
    public function editTeacher($id)
    {
        $teacher = User::whereIn('role', ['guru', 'guru_bk'])->findOrFail($id);
        return view('admin.teachers-edit', compact('teacher'));
    }

    /**
     * Update guru
     */
    public function updateTeacher(Request $request, $id)
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
            'religion' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'subject' => 'nullable|required_if:role,guru|string|max:100',
            'education_level' => 'nullable|string|max:10',
            'major' => 'nullable|string|max:100',
            'university' => 'nullable|string|max:100',
            'graduation_year' => 'nullable|integer|min:1970|max:2030',
            'employment_status' => 'nullable|string|max:50',
            'start_year' => 'nullable|integer|min:1970|max:2030',
            'certification' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $validated['password'] = Hash::make($request->password);
        }

        $updateData = array_filter($validated, function($key) {
            return Schema::hasColumn('users', $key) || in_array($key, ['password']);
        }, ARRAY_FILTER_USE_KEY);

        $teacher->update($updateData);

        $roleLabel = $validated['role'] === 'guru_bk' ? 'Guru BK' : 'Guru Mapel';
        
        return redirect()->route('admin.teachers')
            ->with('success', '✏️ ' . $roleLabel . ' berhasil diperbarui!');
    }

    /**
     * Hapus guru
     */
    public function deleteTeacher($id)
    {
        $teacher = User::whereIn('role', ['guru', 'guru_bk'])->findOrFail($id);
        $teacher->delete();

        return redirect()->route('admin.teachers')
            ->with('success', '🗑️ Guru berhasil dihapus!');
    }

    // ==================== CLASS MANAGEMENT ====================

    /**
     * Menampilkan daftar kelas
     */
    public function classes()
    {
        $classes = Classes::with('homeroomTeacher')->get();
        
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

    /**
     * Form tambah kelas
     */
    public function createClass()
    {
        $grades = ['X', 'XI', 'XII'];
        $teachers = Teacher::orderBy('name')->get();
        return view('classes.create', compact('grades', 'teachers'));
    }

    /**
     * Simpan kelas baru
     */
    public function storeClass(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:10',
                Rule::unique('classes')->where(function ($query) use ($request) {
                    return $query->where('grade_level', $request->grade);
                }),
            ],
            'grade' => 'required|in:X,XI,XII',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        ], [
            'name.unique' => 'Kelas dengan nama tersebut sudah ada di tingkat yang sama.',
        ]);

        Classes::create([
            'name' => $validated['name'],
            'grade_level' => $validated['grade'],
            'homeroom_teacher_id' => $validated['homeroom_teacher_id'] ?? null,
        ]);

        return redirect()->route('admin.classes')
            ->with('success', '🌟 Kelas "' . $validated['name'] . '" berhasil ditambahkan!');
    }

    /**
     * Form edit kelas
     */
    public function editClass($id)
    {
        $class = Classes::with(['homeroomTeacher', 'students.user'])->findOrFail($id);
        $grades = ['X', 'XI', 'XII'];
        $teachers = Teacher::orderBy('name')->get();
        
        // Siswa yang sudah di kelas ini
        $classStudents = $class->students;
        
        // Siswa yang belum memiliki kelas (tersedia untuk ditambahkan)
        $availableStudents = Student::whereNull('class_id')
            ->orWhere('class_id', '!=', $id)
            ->orderBy('name')
            ->get();
        
        return view('classes.edite', compact('class', 'grades', 'teachers', 'classStudents', 'availableStudents'));
    }

    /**
     * Update kelas
     */
    public function updateClass(Request $request, $id)
    {
        /** @var \App\Models\Classes $class */
        $class = Classes::findOrFail($id);
        
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:10',
                Rule::unique('classes')
                    ->where(function ($query) use ($request) {
                        return $query->where('grade_level', $request->grade);
                    })
                    ->ignore($id),
            ],
            'grade' => 'required|in:X,XI,XII',
            'homeroom_teacher_id' => 'nullable|exists:teachers,id',
        ], [
            'name.unique' => 'Kelas dengan nama tersebut sudah ada di tingkat yang sama.',
        ]);

        $class->update([
            'name' => $validated['name'],
            'grade_level' => $validated['grade'],
            'homeroom_teacher_id' => $validated['homeroom_teacher_id'] ?? null,
        ]);

        return redirect()->route('admin.classes')
            ->with('success', '✨ Kelas "' . $validated['name'] . '" berhasil diperbarui!');
    }

    /**
     * Hapus kelas
     */
    public function deleteClass($id)
    {
        $class = Classes::findOrFail($id);
        $className = $class->name;
        $class->delete();

        return redirect()->route('admin.classes')
            ->with('success', '🗑️ Kelas "' . $className . '" berhasil dihapus!');
    }

    /**
     * Menambahkan siswa ke kelas
     */
    public function addStudentToClass(Request $request, $classId)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);
        
        $student = Student::findOrFail($request->student_id);
        $student->update(['class_id' => $classId]);
        
        if ($student->user) {
            $student->user->update(['class_id' => $classId]);
        }
        
        $class = Classes::find($classId);
        
        return redirect()->route('admin.classes.edit', $classId)
            ->with('success', '🎓 ' . $student->name . ' berhasil ditambahkan ke kelas ' . $class->name . '!');
    }

    /**
     * Menghapus siswa dari kelas
     */
    public function removeStudentFromClass($classId, $studentId)
    {
        $student = Student::findOrFail($studentId);
        $student->update(['class_id' => null]);
        
        if ($student->user) {
            $student->user->update(['class_id' => null]);
        }
        
        $class = Classes::find($classId);
        
        return redirect()->route('admin.classes.edit', $classId)
            ->with('success', '🗑️ ' . $student->name . ' berhasil dikeluarkan dari kelas ' . $class->name . '!');
    }

    // ==================== REPORTS ====================

    /**
     * Laporan & Statistik
     */
    public function reports()
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

    // ==================== SETTINGS ====================

    /**
     * Pengaturan
     */
    public function settings()
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

    /**
     * Update pengaturan
     */
    public function updateSettings(Request $request)
    {
        return redirect()->route('admin.settings')
            ->with('success', '⚙️ Pengaturan berhasil diupdate!');
    }

    // ==================== PROFILE ====================

    /**
     * Profil Admin
     */
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }

    /**
     * Update Profil Admin
     */
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $admin */
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

        return back()->with('success', '👤 Profil berhasil diupdate!');
    }
}