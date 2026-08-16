<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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

        // Resolve 'admin' or email input to database user email
        $email = $input;
        if ($input === 'admin') {
            $email = 'admin@smartedu.test';
        }

        if (Auth::attempt(['email' => $email, 'password' => $password], $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang di CMS Admin SmartEdu!');
        }

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

        return redirect()->route('login')
            ->withCookie($cookie)
            ->with('success', 'Anda telah berhasil keluar dari sistem admin.');
    }
}
