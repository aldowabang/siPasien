<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Method 1: Using Auth facade (most reliable)
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Method 2: Check user status dengan cara yang lebih flexible
        if ($this->userIsInactive($user)) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Akun Anda tidak aktif.');
        }

        // Check role
        if (!$this->userHasRole($user, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }

    /**
     * Check if user is inactive
     */
    private function userIsInactive($user): bool
    {
        // Cek multiple possible status fields
        if (isset($user->is_active)) {
            return !$user->is_active;
        }
        
        if (isset($user->status)) {
            return $user->status !== 'active';
        }
        
        if (method_exists($user, 'isActive')) {
            return !$user->isActive();
        }
        
        return false; // Default to active if no status check available
    }

    /**
     * Check if user has required role
     */
    private function userHasRole($user, array $roles): bool
    {
        if (!isset($user->role)) {
            return false;
        }
        
        return in_array($user->role, $roles);
    }
}