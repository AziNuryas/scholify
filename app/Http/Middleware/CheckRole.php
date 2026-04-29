<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Cek apakah user memiliki role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika role tidak sesuai, redirect ke dashboard masing-masing
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'siswa':
                return redirect()->route('student.dashboard');
            case 'guru_bk':
                return redirect()->route('gurubk.dashboard');
            default:
                abort(403, 'Unauthorized access.');
        }
    }
}