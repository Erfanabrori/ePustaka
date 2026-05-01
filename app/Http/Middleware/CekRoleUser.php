<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRoleUser
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }

        if (session('role') === 'admin') {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
