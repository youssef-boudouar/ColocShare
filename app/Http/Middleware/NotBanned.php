<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserNotBanned
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_banned === true) {
            Auth::logout();
            return redirect('/login')->withErrors(['email' => 'Votre compte a été suspendu.']);
        }

        return $next($request);
    }
}
