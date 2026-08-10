<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin CMS') - SmartEdu Dashboard</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen flex flex-col md:flex-row">

    <!-- Admin Sidebar -->
    <aside class="w-full md:w-64 bg-slate-900 text-white shrink-0 p-6 flex flex-col justify-between">
        <div class="space-y-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center font-bold text-xl text-white">⚙️</div>
                <div>
                    <h2 class="font-extrabold text-base tracking-tight leading-none text-white">SmartEdu CMS</h2>
                    <p class="text-[11px] text-slate-400 font-medium mt-1">Admin Landing Manager</p>
                </div>
            </div>

            <nav class="space-y-1.5 pt-4 border-t border-slate-800 text-xs font-bold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-600 text-white' : 'text-slate-300' }}">
                    <span>📊</span> <span>Dashboard Overview</span>
                </a>
                <a href="{{ route('admin.modules.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.modules.*') ? 'bg-teal-600 text-white' : 'text-slate-300' }}">
                    <span>🧩</span> <span>Kelola 21 Modul Fitur</span>
                </a>
                <a href="{{ route('admin.settings') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.settings') ? 'bg-teal-600 text-white' : 'text-slate-300' }}">
                    <span>⚙️</span> <span>Branding & Header</span>
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 transition-colors {{ request()->routeIs('admin.faqs.*') ? 'bg-teal-600 text-white' : 'text-slate-300' }}">
                    <span>❓</span> <span>Kelola FAQ</span>
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-slate-800 space-y-3">
            <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700 text-xs">
                <p class="text-[10px] text-slate-400 font-medium">User Login:</p>
                <p class="font-extrabold text-white truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
            </div>

            <a href="{{ route('home') }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-slate-800 text-teal-400 hover:bg-slate-700 font-bold text-xs flex items-center justify-center gap-2">
                <span>🌐 Lihat Landing Page</span>
                <span>↗</span>
            </a>

            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-rose-950/80 text-rose-300 hover:bg-rose-900 border border-rose-800/50 font-bold text-xs flex items-center justify-center gap-2 transition-colors">
                    <span>🚪 Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-6 md:p-10 overflow-y-auto">
        <!-- Flash Alert -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-100 border border-emerald-300 text-emerald-900 font-bold text-xs flex items-center gap-2 shadow-sm">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
