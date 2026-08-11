<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}" x-data="{ mobileMenuOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil {{ $school->name }} | Website Resmi Unit Sekolah</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN Fallback -->
    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root, html.theme-emerald {
            --theme-gradient-primary: linear-gradient(135deg, #10b981 0%, #14b8a6 50%, #06b6d4 100%);
            --theme-accent: #10b981;
            --theme-accent-dark: #059669;
            --theme-accent-light: #d1fae5;
            --theme-text-accent: #047857;
            --theme-hero-bg: linear-gradient(135deg, #022c22 0%, #0f172a 50%, #064e3b 100%);
        }
        html.theme-ocean {
            --theme-gradient-primary: linear-gradient(135deg, #3b82f6 0%, #6366f1 50%, #8b5cf6 100%);
            --theme-accent: #3b82f6;
            --theme-accent-dark: #2563eb;
            --theme-accent-light: #dbeafe;
            --theme-text-accent: #1d4ed8;
            --theme-hero-bg: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #172554 100%);
        }
        html.theme-magenta {
            --theme-gradient-primary: linear-gradient(135deg, #ec4899 0%, #d946ef 50%, #8b5cf6 100%);
            --theme-accent: #ec4899;
            --theme-accent-dark: #db2777;
            --theme-accent-light: #fce7f3;
            --theme-text-accent: #be185d;
            --theme-hero-bg: linear-gradient(135deg, #4c0519 0%, #0f172a 50%, #3b0764 100%);
        }
        html.theme-sunset {
            --theme-gradient-primary: linear-gradient(135deg, #f43f5e 0%, #f97316 50%, #eab308 100%);
            --theme-accent: #f43f5e;
            --theme-accent-dark: #e11d48;
            --theme-accent-light: #ffe4e6;
            --theme-text-accent: #be123c;
            --theme-hero-bg: linear-gradient(135deg, #450a0a 0%, #0f172a 50%, #431407 100%);
        }
        html.theme-gold {
            --theme-gradient-primary: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            --theme-accent: #f59e0b;
            --theme-accent-dark: #d97706;
            --theme-accent-light: #fef3c7;
            --theme-text-accent: #b45309;
            --theme-hero-bg: linear-gradient(135deg, #000000 0%, #0f172a 50%, #451a03 100%);
        }

        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #0f172a; }
        .theme-btn-primary { background: var(--theme-gradient-primary) !important; color: #ffffff !important; }
        .theme-text-accent { color: var(--theme-text-accent) !important; }
        .theme-bg-badge { background-color: var(--theme-accent-light) !important; color: var(--theme-text-accent) !important; }
        
        .scroll-reveal { opacity: 0; transform: translateY(24px); transition: all 0.6s ease-out; }
        .scroll-reveal.revealed { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">

    <!-- Top Bar -->
    <div class="bg-slate-950 text-white text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="hover:text-amber-300 font-bold flex items-center gap-1">
                <span>← Kembali ke Portal Yayasan Robbani</span>
            </a>
            <div class="flex items-center gap-4 text-[11px] font-bold">
                <span>📞 {{ $school->phone ?? $settings['contact_phone'] }}</span>
                <a href="{{ route('admin.dashboard') }}" class="px-2.5 py-0.5 rounded-lg theme-btn-primary">Portal Admin ➔</a>
            </div>
        </div>
    </div>

    <!-- Header Navbar -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('school.unit', strtolower($school->code)) }}" class="flex items-center gap-3">
                <span class="px-2.5 py-1 rounded-xl text-xs font-black text-white" style="background-color: {{ $school->theme_color ?? '#059669' }}">
                    {{ $school->code }}
                </span>
                <div>
                    <h1 class="text-sm font-black text-slate-900 leading-tight">{{ $school->name }}</h1>
                    <span class="text-[10px] text-slate-500 font-bold block">NPSN: {{ $school->npsn }} • Terakreditasi A</span>
                </div>
            </a>

            <!-- Clean 1-Word Navigation Links -->
            <nav class="hidden md:flex items-center gap-5 text-xs font-bold text-slate-700">
                <a href="#profil" class="hover:theme-text-accent">Profil</a>
                <a href="#kepsek" class="hover:theme-text-accent">Kepsek</a>
                <a href="#statistik" class="hover:theme-text-accent">Statistik</a>
                <a href="#guru" class="hover:theme-text-accent">Guru</a>
                <a href="#kelas" class="hover:theme-text-accent">Kelas</a>
                <a href="#ppdb" class="px-4 py-2 rounded-xl theme-btn-primary font-black shadow">PPDB ➔</a>
            </nav>
        </div>
    </header>

    <!-- Unit Hero Section -->
    <section class="py-16 text-white relative overflow-hidden" style="background: var(--theme-hero-bg);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7 space-y-4">
                <span class="px-3 py-1 rounded-full text-xs font-black text-white inline-block" style="background-color: {{ $school->theme_color ?? '#059669' }}">
                    UNIT {{ $school->code }}
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-white leading-tight">
                    Selamat Datang di {{ $school->name }}
                </h1>
                <p class="text-sm text-slate-200 leading-relaxed">
                    Membentuk siswa unggul, berakhlak mulia, penghafal Al-Qur'an, dan menguasai ilmu pengetahuan digital berlandaskan Kurikulum Merdeka & Kekhasan JSIT.
                </p>
                <div class="pt-2 flex items-center gap-3">
                    <a href="#ppdb" class="px-6 py-3 rounded-xl bg-amber-400 text-slate-950 font-black text-xs shadow-lg hover:scale-105 transition-transform">
                        Daftar Siswa Baru ➔
                    </a>
                    <a href="#guru" class="px-6 py-3 rounded-xl bg-white/10 text-white font-bold text-xs border border-white/20">
                        Lihat Dewan Guru
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="p-3 rounded-3xl bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80" alt="Gedung Unit {{ $school->code }}" class="w-full h-64 object-cover rounded-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistik" class="py-8 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="text-3xl font-black theme-text-accent block">{{ $school->students_count }}</span>
                    <span class="text-xs text-slate-500 font-bold uppercase">Total Siswa Aktif</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="text-3xl font-black text-blue-600 block">{{ $school->employees_count }}</span>
                    <span class="text-xs text-slate-500 font-bold uppercase">Guru & Pendidik</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="text-3xl font-black text-purple-600 block">{{ $school->classrooms_count }}</span>
                    <span class="text-xs text-slate-500 font-bold uppercase">Rombel Kelas</span>
                </div>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    <span class="text-3xl font-black text-amber-500 block">A Unggul</span>
                    <span class="text-xs text-slate-500 font-bold uppercase">Akreditasi BAN-S/M</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Kepsek Profile Section -->
    <section id="kepsek" class="py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-4">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80" class="w-full h-80 object-cover rounded-2xl border-4 theme-border-accent shadow-md">
                </div>
                <div class="md:col-span-8 space-y-3">
                    <span class="px-3 py-1 rounded-full theme-bg-badge text-[10px] font-black uppercase">Kepala Sekolah Unit</span>
                    <h2 class="text-2xl font-black text-slate-900">{{ $school->principal_name }}</h2>
                    <p class="text-xs theme-text-accent font-bold">Kepala Unit {{ $school->name }}</p>
                    <p class="text-xs text-slate-600 leading-relaxed italic">
                        "Selamat datang di {{ $school->name }}. Kami berikhtiar membentuk generasi soleh berkarakter Rabbani yang tidak hanya unggul dalam hafalan Al-Qur'an dan nilai akademik, namun juga siap bersaing di era teknologi digital modern."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Teachers Section -->
    <section id="guru" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 space-y-6">
            <div class="text-center max-w-xl mx-auto space-y-2">
                <span class="px-3 py-1 rounded-full theme-bg-badge text-[10px] font-black uppercase">Tenaga Pendidik</span>
                <h2 class="text-2xl font-black text-slate-900">Dewan Guru {{ $school->code }} Robbani</h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                @forelse($teachers as $t)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($t->name) }}&background=059669&color=ffffff&bold=true" class="w-16 h-16 rounded-full mx-auto border-2 theme-border-accent">
                    <h4 class="font-extrabold text-xs text-slate-900 leading-tight">{{ $t->name }}</h4>
                    <p class="text-[10px] text-slate-500 font-bold">{{ $t->position ?? 'Guru Pengajar' }}</p>
                </div>
                @empty
                <div class="col-span-4 text-center py-6 text-xs text-slate-400">Data dewan guru sedang diperbarui.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- PPDB Unit Section -->
    <section id="ppdb" class="py-16 theme-btn-primary text-white text-center">
        <div class="max-w-4xl mx-auto px-4 space-y-4">
            <span class="px-3 py-1 rounded-full bg-amber-400 text-slate-950 font-black text-xs uppercase">PENDAFTARAN KHUSUS UNIT {{ $school->code }}</span>
            <h2 class="text-3xl font-black text-white">Daftarkan Ananda di {{ $school->name }}</h2>
            <p class="text-xs text-slate-100">Alamat Kampus: {{ $school->address }}</p>
            <div class="pt-2">
                <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20ingin%20mendaftar%20di%20{{ urlencode($school->name) }}" class="px-8 py-3.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs shadow-xl inline-block">
                    Konsultasi PPDB {{ $school->code }} via WhatsApp ➔
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 text-white py-8 text-center text-xs text-slate-400 border-t border-slate-800">
        © 2026 {{ $school->name }} • {{ $settings['school_name'] }}. All rights reserved.
    </footer>

</body>
</html>
