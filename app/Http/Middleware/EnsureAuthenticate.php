<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthenticate
{
    // public function handle(Request $request, Closure $next): Response
    // {
    //     // dd('Middleware is working!');
    //     if (!Auth::guard('admin')->check() && !Auth::guard('customer')->check()) {
    //         dd('Middleware triggered: Not authenticated');
    //         // \Log::info('Middleware: User not authenticated');
    //         return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    //     }

    //     dd('Middleware : Authenticated');
    //     // \Log::info('Middleware: User authenticated');
    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah pengguna belum login di salah satu guard
        if (!Auth::guard('admin')->check() && !Auth::guard('customer')->check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika login berhasil, lanjutkan ke request berikutnya
        return $next($request);
    }
}
