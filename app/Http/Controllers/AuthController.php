<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            return $this->redirectBasedOnRole(auth()->user());
        }

        return view('auth.login');
    }

    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'siswa') {
            return redirect()->route('student.dashboard');
        }
        if ($user->role === 'guru_bk') {
            return redirect()->route('gurubk.dashboard');
        }
        return redirect()->route('dashboard');
    }

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

    public function dashboard()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return $this->redirectBasedOnRole(auth()->user());
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}