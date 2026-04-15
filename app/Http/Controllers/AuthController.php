<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        if (auth()->check()) {
            return $this->redirectBasedOnRole(auth()->user());
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole(auth()->user());
        }

        return back()->with('error', 'Email atau password salah');
    }

    /**
     * Redirect berdasarkan role
     */
    private function redirectBasedOnRole($user)
    {
        // SISWA
        if ($user->role === 'siswa') {
            return redirect()->route('student.dashboard');
        }

        // GURU BK
        if ($user->role === 'guru_bk') {
            return redirect()->route('gurubk.dashboard');
        }

        // GURU (FIX DI SINI 🔥)
        if ($user->role === 'guru') {
            return redirect()->route('guru.dashboard'); // ✅ SUDAH BENAR
        }

        // ADMIN
        if ($user->role === 'admin') {
            return redirect()->route('dashboard');
        }

        return redirect()->route('login');
    }

    /**
     * Dashboard universal
     */
    public function dashboard()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return $this->redirectBasedOnRole(auth()->user());
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}