<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna sudah login
        if (!Auth::check()) {
            // Arahkan ke halaman login jika belum login
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Lanjutkan ke request berikutnya jika sudah login
        return $next($request);
    }
}
