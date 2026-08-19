<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#004532">
    <title>Portal Masuk Admin &amp; Guru | SmartEdu SIT Robbani</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=10">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v=10">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CDN with Forms Plugin -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        robbani: {
                            dark: '#004532',
                            primary: '#065f46',
                            emerald: '#059669',
                            light: '#10b981',
                            accent: '#fd761a',
                            orange: '#f97316',
                            lime: '#c6f634'
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #061107;
        }

        /* Ambient Glow Animations */
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.35; transform: scale(1); }
            50% { opacity: 0.65; transform: scale(1.08); }
        }
        @keyframes float-gentle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }

        .glow-orb-1 {
            animation: pulse-slow 8s ease-in-out infinite alternate;
        }
        .glow-orb-2 {
            animation: pulse-slow 10s ease-in-out infinite alternate-reverse;
        }
        .float-card {
            animation: float-gentle 6s ease-in-out infinite;
        }

        /* Pattern Background Overlay */
        .islamic-pattern {
            background-image: radial-gradient(rgba(198, 246, 52, 0.08) 1px, transparent 1px), radial-gradient(rgba(16, 185, 129, 0.08) 1px, transparent 1px);
            background-size: 32px 32px;
            background-position: 0 0, 16px 16px;
        }

        /* Glassmorphic Effects */
        .glass-card {
            background: linear-gradient(135deg, rgba(13, 30, 15, 0.88) 0%, rgba(6, 17, 7, 0.94) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .glass-inner {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="h-full antialiased text-slate-100 flex flex-col justify-between selection:bg-emerald-500 selection:text-white relative overflow-x-hidden min-h-screen"
      x-data="{ 
          showPassword: false, 
          isSubmitting: false,
          timeString: '',
          dateString: '',
          initClock() {
              const update = () => {
                  const now = new Date();
                  const options = { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric' };
                  this.dateString = now.toLocaleDateString('id-ID', options);
                  this.timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' }) + ' WIB';
              };
              update();
              setInterval(update, 1000);
          }
      }"
      x-init="initClock()">

    <!-- 1. BACKGROUND LAYER WITH REAL SCHOOL CAMPUS & DUAL-TONE GRADIENT -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <!-- Campus High-Res Image -->
        <img src="https://lh3.googleusercontent.com/aida/AP1WRLuf5i7pWfq9dzqqqjNB6dJ3JNiFjsv6Iv0erwSW9QTXek-Ur1VI-e_ULP2zi3qLQIbKln9GGYMrKRcDMpgsk8uELhhqxDf4J0N_tZ3ObFRa1UmfynfH5wzEfpsoQwZd8ofmDXnfj0-gwTaJjxlH2Gt_qt3XIBHF0DtXovfyqeC4E7-y7dd3rgARHyA57tjdlEywmGuLbJ1q3jagkMiPIv2sK3XpKR-CEw_Kr3hiDZtYNpxD6JtANagJSWCU" 
             alt="Kampus SIT Robbani" 
             class="w-full h-full object-cover object-center filter blur-[1px] scale-105 transform opacity-30 transition-transform duration-1000"
             onerror="this.src='{{ asset('images/facilities/gedung_smpit.jpg') }}'; this.onerror=null;">

        <!-- Gradient Vignette Overlay -->
        <div class="absolute inset-0 bg-gradient-to-br from-[#061107]/95 via-[#004532]/90 to-[#022c22]/95 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-radial-vignette opacity-80"></div>
        
        <!-- Texture Grid Pattern -->
        <div class="absolute inset-0 islamic-pattern"></div>

        <!-- Ambient Glow Orbs -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl glow-orb-1"></div>
        <div class="absolute -bottom-32 -right-32 w-[32rem] h-[32rem] bg-[#c6f634]/15 rounded-full blur-3xl glow-orb-2"></div>
        <div class="absolute top-1/2 left-1/3 w-72 h-72 bg-teal-500/15 rounded-full blur-2xl glow-orb-1"></div>
    </div>

    <!-- 2. TOP HEADER BRAND BAR -->
    <header class="relative z-10 w-full px-4 sm:px-8 py-4 sm:py-6 flex items-center justify-between">
        <a href="{{ route('home') }}" class="group flex items-center gap-3 transition-transform hover:scale-[1.02]">
            <div class="p-2 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-md flex items-center justify-center">
                <img src="{{ asset('images/logo-robbani-official.png') }}" alt="Logo SIT Robbani" class="h-8 sm:h-10 w-auto object-contain drop-shadow" onerror="this.src='{{ asset('images/logo robbani light.png') }}'">
            </div>
            <div>
                <span class="block text-xs sm:text-sm font-black text-white tracking-wide uppercase group-hover:text-[#c6f634] transition-colors">SIT ROBBANI</span>
                <span class="block text-[10px] text-emerald-300/80 font-semibold tracking-wider">Ogan Ilir, Sumatera Selatan</span>
            </div>
        </a>

        <!-- Live Clock & Status Badge -->
        <div class="hidden md:flex items-center gap-4">
            <div class="glass-inner px-4 py-2 rounded-2xl flex items-center gap-3 text-xs">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <div class="text-right leading-tight">
                    <div class="font-extrabold text-white" x-text="timeString || 'WIB'"></div>
                    <div class="text-[10px] text-slate-300 font-medium" x-text="dateString"></div>
                </div>
            </div>

            <a href="{{ route('home') }}" class="glass-inner px-4 py-2.5 rounded-2xl text-xs font-bold text-slate-200 hover:text-white hover:bg-white/10 hover:border-emerald-400/40 transition-all flex items-center gap-2">
                <span>🌐 Website Utama</span>
                <span class="text-xs">↗</span>
            </a>
        </div>
    </header>

    <!-- 3. MAIN LOGIN CONTAINER (SPLIT DUAL PANEL) -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 sm:px-6 py-6 sm:py-10">
        <div class="w-full max-w-5xl glass-card rounded-3xl sm:rounded-[2.5rem] shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 border border-emerald-500/25">
            
            <!-- LEFT PANEL: School Identity & Integrated Ecosystem Highlights -->
            <div class="lg:col-span-5 p-6 sm:p-10 bg-gradient-to-b from-white/[0.06] to-transparent border-b lg:border-b-0 lg:border-r border-white/10 flex flex-col justify-between relative overflow-hidden">
                
                <!-- Background Campus Glow Accent -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-2xl"></div>

                <div class="space-y-6 relative z-10">
                    <!-- Top Pill Tag -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-xs font-extrabold shadow-sm">
                        <span>✨</span>
                        <span>SMARTEDU ECOSYSTEM 2026</span>
                    </div>

                    <!-- Main Headline -->
                    <div class="space-y-2">
                        <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight leading-snug">
                            Portal Terpadu <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#c6f634] via-emerald-300 to-teal-200">
                                SIT Robbani
                            </span>
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300/90 leading-relaxed font-medium">
                            Satu gerbang masuk manajemen data, absensi RFID, keuangan SPP, CBT, e-Rapor, dan publikasi website untuk seluruh unit.
                        </p>
                    </div>

                    <!-- 4 Unit Integrated Badges -->
                    <div class="space-y-2 pt-2">
                        <span class="text-[10px] uppercase tracking-wider font-extrabold text-slate-400 block">Unit Pendidikan Terpadu:</span>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="glass-inner p-2.5 rounded-xl flex items-center gap-2 text-slate-200">
                                <span class="text-base">🧸</span>
                                <div>
                                    <div class="font-extrabold text-[11px] text-white">KB / TKIT</div>
                                    <div class="text-[9px] text-slate-400">Pendidikan Usia Dini</div>
                                </div>
                            </div>
                            <div class="glass-inner p-2.5 rounded-xl flex items-center gap-2 text-slate-200">
                                <span class="text-base">🎒</span>
                                <div>
                                    <div class="font-extrabold text-[11px] text-white">SDIT Robbani</div>
                                    <div class="text-[9px] text-slate-400">Sekolah Dasar Islam</div>
                                </div>
                            </div>
                            <div class="glass-inner p-2.5 rounded-xl flex items-center gap-2 text-slate-200">
                                <span class="text-base">📖</span>
                                <div>
                                    <div class="font-extrabold text-[11px] text-white">SMPIT Robbani</div>
                                    <div class="text-[9px] text-slate-400">Boarding &amp; Reguler</div>
                                </div>
                            </div>
                            <div class="glass-inner p-2.5 rounded-xl flex items-center gap-2 text-slate-200">
                                <span class="text-base">🎓</span>
                                <div>
                                    <div class="font-extrabold text-[11px] text-white">SMAIT Robbani</div>
                                    <div class="text-[9px] text-slate-400">Kader Pemimpin Umat</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security & Protection Pill -->
                    <div class="p-3.5 rounded-2xl bg-emerald-950/40 border border-emerald-500/20 space-y-1.5">
                        <div class="flex items-center gap-2 text-xs font-bold text-emerald-300">
                            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span>Keamanan Terenkripsi SSL 256-bit</span>
                        </div>
                        <p class="text-[10px] text-slate-400 leading-normal">
                            Hak akses dibatasi otomatis sesuai role jabatan (Ketua Yayasan, Humas, Kepala Unit, Dewan Guru, &amp; Staf).
                        </p>
                    </div>
                </div>

                <!-- Bottom Footer Info -->
                <div class="pt-6 mt-6 border-t border-white/10 flex items-center justify-between text-[11px] text-slate-400">
                    <span>Yayasan SIT Robbani</span>
                    <span class="font-bold text-emerald-400">Indralaya, Ogan Ilir</span>
                </div>
            </div>

            <!-- RIGHT PANEL: Interactive Modern Login Form -->
            <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-center space-y-6 bg-slate-950/40">
                
                <!-- Form Header -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="inline-flex p-2.5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-inner">
                            <img src="{{ asset('images/logo robbani light.png') }}" alt="Logo SIT Robbani" class="h-10 sm:h-12 w-auto object-contain">
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/10 text-emerald-300 border border-emerald-500/30">
                            🔒 Autentikasi Resmi
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight pt-2">
                        Masuk ke Akun Anda
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-400">
                        Gunakan email resmi atau username yang telah didaftarkan oleh administrator.
                    </p>
                </div>

                <!-- Flash Alert Message: Error -->
                @if ($errors->any())
                <div class="p-4 bg-rose-500/15 border border-rose-500/40 rounded-2xl text-xs text-rose-200 space-y-1.5 shadow-lg backdrop-blur-md animate-fade-in">
                    <div class="flex items-center gap-2 font-bold text-rose-300">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Gagal Masuk:</span>
                    </div>
                    @foreach ($errors->all() as $error)
                        <p class="pl-6 text-[11px] font-medium text-rose-200/90">• {{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <!-- Flash Alert Message: Success -->
                @if (session('success'))
                <div class="p-4 bg-emerald-500/15 border border-emerald-500/40 rounded-2xl text-xs text-emerald-200 space-y-1 shadow-lg backdrop-blur-md">
                    <div class="flex items-center gap-2 font-bold text-emerald-300">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                <!-- Login Form -->
                <form action="{{ route('admin.login.store') }}" 
                      method="POST" 
                      class="space-y-5"
                      @submit="isSubmitting = true">
                    @csrf

                    <!-- Username / Email Field -->
                    <div class="space-y-1.5">
                        <label for="username" class="block text-xs font-bold text-slate-200">
                            Username / Email Pengguna:
                        </label>
                        <div class="relative rounded-2xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   required 
                                   autofocus
                                   placeholder="Contoh: humas@sitrobbani.sch.id / sd@sitrobbani.sch.id" 
                                   class="w-full pl-11 pr-4 py-3.5 rounded-2xl bg-white/[0.07] border border-white/15 text-white text-xs sm:text-sm font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#c6f634] focus:border-transparent focus:bg-white/[0.12] transition-all">
                        </div>
                    </div>

                    <!-- Password Field with Show/Hide Toggle -->
                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-bold text-slate-200">
                                Password Akun:
                            </label>
                        </div>
                        <div class="relative rounded-2xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input :type="showPassword ? 'text' : 'password'" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   placeholder="Masukkan password Anda" 
                                   class="w-full pl-11 pr-12 py-3.5 rounded-2xl bg-white/[0.07] border border-white/15 text-white text-xs sm:text-sm font-medium placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#c6f634] focus:border-transparent focus:bg-white/[0.12] transition-all">
                            
                            <!-- Toggle Visibility Button -->
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-white transition-colors cursor-pointer"
                                    title="Tampilkan / Sembunyikan Password">
                                <!-- Eye Open Icon -->
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <!-- Eye Closed Icon -->
                                <svg x-show="showPassword" x-cloak class="w-5 h-5 text-[#c6f634]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Encrypted Badge -->
                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center gap-2.5 cursor-pointer font-medium text-slate-300 hover:text-white transition-colors select-none">
                            <input type="checkbox" 
                                   name="remember" 
                                   checked 
                                   class="w-4 h-4 rounded-lg bg-white/10 border-white/20 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-slate-900 cursor-pointer">
                            <span>Ingat Saya di Perangkat Ini</span>
                        </label>
                        <span class="text-[11px] font-bold text-emerald-300/80 flex items-center gap-1">
                            <span>🔒</span> SSO Terintegrasi
                        </span>
                    </div>

                    <!-- Submit Button with Gradient & Glow -->
                    <button type="submit" 
                            :disabled="isSubmitting"
                            class="w-full py-4 px-6 rounded-2xl bg-gradient-to-r from-emerald-500 via-teal-500 to-emerald-600 hover:from-emerald-400 hover:to-teal-400 text-slate-950 font-black text-xs sm:text-sm tracking-wider uppercase shadow-xl shadow-emerald-950/60 hover:shadow-emerald-500/25 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-75 disabled:cursor-not-allowed">
                        <span x-show="!isSubmitting" class="flex items-center gap-2">
                            <span>MASUK KE DASHBOARD ADMIN</span>
                            <span class="text-base font-bold">➔</span>
                        </span>
                        <span x-show="isSubmitting" x-cloak class="flex items-center gap-2 text-slate-900">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-slate-900" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>MEMVERIFIKASI AKUN...</span>
                        </span>
                    </button>
                </form>

                <!-- Navigation Quick Links -->
                <div class="pt-4 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
                    <a href="{{ route('home') }}" class="font-bold text-slate-400 hover:text-[#c6f634] transition-colors flex items-center gap-1.5">
                        <span>←</span>
                        <span>Kembali ke Website Utama</span>
                    </a>
                    <a href="{{ route('school.ppdb') }}" class="font-bold text-emerald-400 hover:text-[#c6f634] transition-colors flex items-center gap-1.5">
                        <span>Portal PPDB Online</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- 4. BOTTOM COPYRIGHT & VERSION FOOTER -->
    <footer class="relative z-10 w-full px-4 py-4 text-center text-[11px] text-slate-400/80 font-medium">
        <p>© 2026 Yayasan Sekolah Islam Terpadu (SIT) Robbani Ogan Ilir • SmartEdu Management System v4.2</p>
    </footer>

</body>
</html>
