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
        dd('Middleware is working!');
        // if (!Auth::guard('admin')->check() && !Auth::guard('customer')->check()) {
        //     dd('Middleware triggered: Not authenticated');
        //     \Log::info('Middleware: User not authenticated');
        //     return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        // }

        // dd('Middleware : Authenticated');
        // \Log::info('Middleware: User authenticated');
        // return $next($request);
    }
}
