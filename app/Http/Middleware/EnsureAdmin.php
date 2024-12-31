<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna adalah admin
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Redirect jika bukan admin
        return redirect()->route('login')->withErrors('Access denied.');
    }
}
