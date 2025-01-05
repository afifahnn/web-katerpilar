<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check() && !Auth::guard('customer')->check()) {
            session()->flash('error', 'Silahkan login terlebih dahulu!');
            return redirect('/login');
        }

        return $next($request);
    }
}
