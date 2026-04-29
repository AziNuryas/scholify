<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;
        
        // Cek apakah role user sesuai dengan yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Redirect berdasarkan role jika tidak sesuai
        if ($userRole === 'siswa') {
            return redirect()->route('student.dashboard')
                ->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        } 
        
        if ($userRole === 'guru_bk') {
            return redirect()->route('gurubk.dashboard')
                ->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        } 
        
        if ($userRole === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk mengakses halaman tersebut.');
        }

        // Jika role tidak dikenal
        abort(403, 'Unauthorized access.');
    }
}