<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }
        // Jika tidak sesuai, kembalikan ke halaman dashboard dengan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
    }
}