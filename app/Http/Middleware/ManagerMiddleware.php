<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && (auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Manager'))) {
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}