<?php

namespace App\Http\Middleware;

use Closure;

class Guru
{
    public function handle($request, Closure $next)
    {
        if ($request->user()->role !== 'guru') {
            return redirect('/');
        }

        return $next($request);
    }
}
