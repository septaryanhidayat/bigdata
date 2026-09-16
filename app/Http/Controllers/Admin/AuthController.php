<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\AuditLog;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $input = trim($request->input('username'));
        $password = $request->input('password');

        // Resolve input by username or email
        $userCandidate = User::where('email', $input)->orWhere('username', $input)->first();
        if ($input === 'admin' && !$userCandidate) {
            $email = 'admin@smartedu.test';
            $userCandidate = User::where('email', $email)->first();
        } else {
            $email = $userCandidate ? $userCandidate->email : $input;
        }

        $throttleKey = Str::transliterate(Str::lower($email) . '|' . $request->ip());

        // 1. Rate Limiting Protection (Max 5 attempts per 60 seconds)
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return redirect()->back()->withInput($request->only('username'))->withErrors([
                'username' => "Terlalu banyak percobaan login gagal. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }

        // 2. Inactive User Verification
        if ($userCandidate && array_key_exists('is_active', $userCandidate->getAttributes()) && !$userCandidate->is_active) {
            RateLimiter::hit($throttleKey, 60);
            return redirect()->back()->withInput($request->only('username'))->withErrors([
                'username' => 'Akun Anda sedang dinonaktifkan oleh Administrator. Silakan hubungi manajemen sistem.',
            ]);
        }

        // 3. Attempt Authentication
        if (Auth::attempt(['email' => $email, 'password' => $password], $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            $user = Auth::user();
            try {
                $user->update(['last_login_at' => now()]);
                AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'LOGIN ADMIN',
                    'model_type' => 'User',
                    'model_id' => $user->id,
                    'ip_address' => $request->ip(),
                ]);
            } catch (\Throwable $e) {}

            return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang di CMS Admin SmartEdu!');
        }

        RateLimiter::hit($throttleKey, 60);

        return redirect()->back()->withInput($request->only('username'))->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $cookie = cookie()->forget('remember_web');

        return redirect()->route('admin.login')
            ->withCookie($cookie)
            ->with('success', 'Anda telah berhasil keluar dari sistem admin.');
    }
}
