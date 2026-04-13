<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        // Ambil semua data siswa dari tabel students
        $students = Student::all();

        // Kirim data ke view (halaman web)
        return view('students.index', compact('students'));
    }
}