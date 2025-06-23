<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        if (!$user) {
            // Not authenticated
            return redirect()->route('login');
        }

        // Support comma-separated roles in a single argument
        $roles = count($roles) === 1 && str_contains($roles[0], ',')
            ? explode(',', $roles[0])
            : $roles;
        $roles = array_map('trim', $roles);

        // Assumes user model has a 'role' attribute or method
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized. You do not have the required role.');
        }

        return $next($request);
    }
}
