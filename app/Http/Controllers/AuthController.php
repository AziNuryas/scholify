<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('user')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Dummy login
        if ($request->email === 'admin@school.com' && $request->password === 'admin123') {
            
            session([
                'user' => $request->email
            ]);

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function dashboard()
    {
        if (!session('user')) {
            return redirect()->route('login');
        }

        return view('admin.dashboard');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}