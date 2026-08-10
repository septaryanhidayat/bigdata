<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login CMS Admin | SmartEdu Digital Platform</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-md bg-white rounded-3xl border border-slate-200 shadow-2xl overflow-hidden p-8 space-y-6">
        
        <!-- Header Brand Info -->
        <div class="text-center space-y-2">
            <div class="inline-flex p-3 rounded-2xl bg-teal-50 border border-teal-100 mb-2">
                <img src="/images/smartedu_logo.png" alt="SmartEdu Logo" class="h-12 w-auto object-contain">
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Portal CMS Admin</h1>
            <p class="text-xs text-slate-500 font-medium">Masuk untuk mengelola modul fitur, branding, & pengaturan landing page SmartEdu.</p>
        </div>

        <!-- Alert Error -->
        @if ($errors->any())
        <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-800 font-medium space-y-1">
            @foreach ($errors->all() as $error)
                <p>⚠️ {{ $error }}</p>
            @endforeach
        </div>
        @endif

        @if (session('success'))
        <div class="p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-800 font-medium">
            ✓ {{ session('success') }}
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5">Username / Email Admin:</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       value="{{ old('username') }}" 
                       required 
                       placeholder="Masukkan username admin" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600 transition-all">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">Password Admin:</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       placeholder="Masukkan password admin" 
                       class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:border-teal-600 transition-all">
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-600">
                    <input type="checkbox" name="remember" checked class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    <span>Ingat Saya</span>
                </label>
                <span class="text-[11px] font-bold text-teal-700">Akses Terenkripsi</span>
            </div>

            <button type="submit" class="w-full py-3.5 px-4 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs tracking-wide uppercase shadow-md transition-all">
                Masuk ke Dashboard Admin ➔
            </button>
        </form>

        <div class="text-center pt-2 border-t border-slate-100">
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-500 hover:text-teal-700 transition-colors">
                ← Kembali ke Landing Page SmartEdu
            </a>
        </div>
    </div>

</body>
</html>
