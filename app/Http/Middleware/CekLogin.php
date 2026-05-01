<?php

namespace App\Http\Middleware;

use Closure;

class CekLogin
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }
        return $next($request);
    }
}
