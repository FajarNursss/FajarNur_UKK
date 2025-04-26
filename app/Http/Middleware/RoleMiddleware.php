<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan pengguna sudah terautentikasi
        if (auth()->check()) {
            // Cek apakah role pengguna ada dalam list role yang diberikan
            if (!in_array(auth()->user()->role, $roles)) {
                // Jika tidak sesuai, tampilkan pesan Akses Ditolak
                abort(403, 'Akses ditolak.');
            }
        } else {
            // Jika pengguna belum terautentikasi, redirect ke login
            return redirect()->route('login');
        }

        return $next($request);
    }
}

