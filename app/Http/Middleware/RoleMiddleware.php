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
     * Check user role based on position relationship.
     * Accepts role parameter as position name (admin, dokter, apoteker).
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        // 1. Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Load position if not already loaded
        if (!$user->relationLoaded('position')) {
            $user->load('position');
        }

        // 2. Check if user has a position assigned
        if (!$user->position) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'No role assigned to your account.');
        }

        // 3. Check if user's role matches the required role
        $userRole = strtolower($user->position->position); // 'Admin' -> 'admin'

        if ($userRole === $role) {
            return $next($request);
        }

        // 4. If role doesn't match, logout and redirect
        Auth::logout();
        return redirect()->route('login')->with('error', 'Unauthorized access. Session terminated.');
    }
}
