<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Cek apakah user memiliki role yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Jika role tidak sesuai, redirect ke dashboard masing-masing
            return $this->redirectBasedOnRole($user);
        }

        return $next($request);
    }

    /**
     * Redirect user berdasarkan role
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectBasedOnRole($user)
    {
        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'siswa' => redirect()->route('student.dashboard'),
            'guru_bk' => redirect()->route('gurubk.dashboard'),
            'guru' => redirect()->route('guru.dashboard'),
            default => redirect()->route('login')->with('error', 'Role tidak dikenali.'),
        };
    }
}