<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleTenagaMedis
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role !== 'tenaga_medis') {
            return redirect('/login')->with('error', 'Anda tidak memiliki akses.');
        }
        return $next($request);
    }
}
