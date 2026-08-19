<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('admin.login');
        }

        // Super Admin always bypasses all checks
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check if user's role is in the allowed roles
        if (!empty($roles) && in_array($user->role, $roles, true)) {
            return $next($request);
        }

        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => false,
                'message' => "Akses Ditolak: Peran akun Anda ({$user->role_name_label}) tidak memiliki izin untuk mengakses fitur ini.",
            ], 403);
        }

        return redirect()->route('admin.dashboard')->with('error', "⛔ Akses Ditolak: Peran akun Anda ({$user->role_name_label}) tidak memiliki izin untuk mengakses halaman tersebut.");
    }
}
