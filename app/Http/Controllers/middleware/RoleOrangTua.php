<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleOrangTua
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role !== 'orang_tua') {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses.');
        }
        return $next($request);
    }
}
