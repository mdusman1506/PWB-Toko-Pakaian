<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user adalah ADMIN
        if (auth()->check() && auth()->user()->role !== 'admin') {
            // Jika bukan admin, tolak akses (Error 403 Forbidden)
            abort(403, 'AKSES DITOLAK: Halaman ini khusus Admin!');
        }

        return $next($request);
    }
}