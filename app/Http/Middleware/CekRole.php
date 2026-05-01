<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CekRole
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('user_id')) {
            return redirect('/');
        }

        if (session('role') !== 'admin') {
            abort(403, 'Akses khusus admin');
        }

        return $next($request);
    }
}
