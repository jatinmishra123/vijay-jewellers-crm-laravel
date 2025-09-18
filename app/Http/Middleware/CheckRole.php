<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Use default auth guard (users table)
        $user = auth()->user();

        // Debug log
        Log::info('CheckRole Middleware', [
            'user_role' => $user ? $user->getRoleName() : null,
            'allowed_roles' => $roles
        ]);

        if (!$user || !$user->role) {
            return redirect()->route('admin.login')
                ->with('error', 'Your account does not have a valid role assigned.');
        }

        // Convert roles passed as pipe-separated strings into array
        $allowedRoles = [];
        foreach ($roles as $role) {
            $allowedRoles = array_merge($allowedRoles, explode('|', $role));
        }

        if (!in_array($user->role->name, $allowedRoles)) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to access that page.');
        }

        return $next($request);
    }
}
