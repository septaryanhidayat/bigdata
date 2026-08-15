<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news['title'] }} | {{ $settings['school_name'] }}</title>
    
    <!-- Tailwind CSS CDN with darkMode: 'class' -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        theme: {
                            emerald: '#059669',
                            teal: '#0d9488',
                            orange: '#ea580c',
                            blue: '#2563eb',
                            purple: '#9333ea',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts & Alpine.js -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s, color 0.3s; }
        .glass-header-light { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(12px); }
        .glass-header-dark { background: rgba(15, 23, 42, 0.9); backdrop-filter: blur(12px); }
        .prose-content p { margin-bottom: 1.25rem; line-height: 1.8; }
        .prose-content strong { font-weight: 800; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 antialiased min-h-screen pb-24 lg:pb-12">

    <!-- Sticky Glassmorphism Header Bar -->
    <header class="sticky top-0 z-50 transition-colors duration-300 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img x-show="!darkMode" src="{{ $settings['logo_light'] ?? '/images/logo robbani light.png' }}" class="h-10 w-auto object-contain" alt="Logo SIT Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <img x-show="darkMode" x-cloak src="{{ $settings['logo_dark'] ?? '/images/logo robbani dark.png' }}" class="h-10 w-auto object-contain" alt="Logo SIT Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <div>
                    <span class="font-black text-xs block text-emerald-700 dark:text-emerald-400 uppercase tracking-wider group-hover:text-emerald-600">PORTAL BERITA RESMI</span>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>

            <!-- Header Action Controls (Navigation & Dark Mode Toggle) -->
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-extrabold text-xs transition-colors border border-slate-200 dark:border-slate-700 hidden sm:inline-flex items-center gap-1.5">
                    🏠 Beranda
                </a>
                
                <a href="{{ route('school.berita') }}" class="px-3.5 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-sm transition-colors flex items-center gap-1">
                    ← Semua Berita
                </a>

                <!-- Dark Mode Toggle Button (Default: Light Mode) -->
                <button @click="darkMode = !darkMode" title="Ganti Mode Terang / Malam" class="p-2 sm:px-3 sm:py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-amber-300 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 font-extrabold text-xs transition-all shadow-xs flex items-center gap-1.5">
                    <span x-show="!darkMode" class="flex items-center gap-1">🌙 <span class="hidden md:inline">Mode Malam</span></span>
                    <span x-show="darkMode" x-cloak class="flex items-center gap-1">☀️ <span class="hidden md:inline">Mode Terang</span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Container: Rich 3-Column Layout for News Readers -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- ========================================== -->
            <!-- LEFT SIDEBAR (col-span-3): REDAKSI & AKSES -->
            <!-- ========================================== -->
            <aside class="lg:col-span-3 space-y-6 order-2 lg:order-1">
                
                <!-- Card 1: Redaksi & Humas SIT Robbani -->
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 border-b border-slate-100 dark:border-slate-800 pb-3">
                        <div class="w-12 h-12 rounded-full bg-emerald-700 text-white font-black flex items-center justify-center text-sm shadow-md shrink-0">
                            {{ strtoupper(substr($news['author'] ?? 'H', 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <h4 class="font-extrabold text-sm text-slate-900 dark:text-white truncate">{{ $news['author'] ?? 'Humas SIT Robbani' }}</h4>
                            <span class="text-[10px] text-emerald-700 dark:text-emerald-400 font-black uppercase block">Tim Publikasi Resmi</span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                        Portal resmi berita &amp; liputan kegiatan belajar santri KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani Ogan Ilir.
                    </p>
                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800 space-y-2 text-xs font-bold text-slate-700 dark:text-slate-300">
                        <div class="flex items-center gap-2">
                            <span>📞</span> <a href="https://wa.me/62811747472" target="_blank" class="hover:text-emerald-600">0811-7474-72</a>
                        </div>
                        <div class="flex items-center gap-2">
                            <span>✉️</span> <a href="mailto:info@sitrobbani.sch.id" class="hover:text-emerald-600 truncate">info@sitrobbani.sch.id</a>
                        </div>
                        <div class="flex items-center gap-2">
                            <span>📍</span> <span class="truncate">Indralaya, Ogan Ilir</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Kategori Jenjang & Tag Populer -->
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                    <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-2">
                        <span>🏷️</span> Kategori &amp; Jenjang Sekolah
                    </h4>
                    <div class="flex flex-wrap gap-2 pt-1">
                        <a href="{{ route('home') }}" class="px-3 py-1 rounded-xl bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 font-extrabold text-[11px] hover:bg-emerald-700 hover:text-white transition-colors">
                            🧸 KB/TKIT
                        </a>
                        <a href="{{ route('home') }}" class="px-3 py-1 rounded-xl bg-orange-100 dark:bg-orange-950 text-orange-800 dark:text-orange-300 font-extrabold text-[11px] hover:bg-orange-600 hover:text-white transition-colors">
                            🏫 SDIT
                        </a>
                        <a href="{{ route('home') }}" class="px-3 py-1 rounded-xl bg-blue-100 dark:bg-blue-950 text-blue-800 dark:text-blue-300 font-extrabold text-[11px] hover:bg-blue-600 hover:text-white transition-colors">
                            📚 SMPIT
                        </a>
                        <a href="{{ route('home') }}" class="px-3 py-1 rounded-xl bg-purple-100 dark:bg-purple-950 text-purple-800 dark:text-purple-300 font-extrabold text-[11px] hover:bg-purple-600 hover:text-white transition-colors">
                            🎓 SMAIT
                        </a>
                        <a href="{{ route('school.berita') }}" class="px-3 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-[11px] hover:bg-slate-200">
                            📖 Tahfidz Al-Qur'an
                        </a>
                        <a href="{{ route('school.berita') }}" class="px-3 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-[11px] hover:bg-slate-200">
                            🏆 Prestasi Santri
                        </a>
                        <a href="{{ route('school.ppdb') }}" class="px-3 py-1 rounded-xl bg-amber-100 dark:bg-amber-950 text-amber-800 dark:text-amber-300 font-extrabold text-[11px] hover:bg-amber-500 hover:text-white">
                            ✨ PPDB Online
                        </a>
                    </div>
                </div>

                <!-- Card 3: Pengumuman Resmi Terbaru -->
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-1.5">
                            <span>📢</span> Pengumuman Terkini
                        </h4>
                        <a href="{{ route('school.berita') }}" class="text-[10px] font-bold text-emerald-600 hover:underline">Semua</a>
                    </div>

                    <div class="space-y-3 text-xs">
                        @foreach(array_slice($announcementList ?? [], 0, 3) as $ann)
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-800 space-y-1 hover:border-emerald-500 transition-all">
                            <span class="text-[9px] font-extrabold px-2 py-0.5 rounded bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 uppercase">{{ $ann['category'] ?? 'INFO' }}</span>
                            <h5 class="font-extrabold text-slate-900 dark:text-white line-clamp-2 leading-snug">{{ $ann['title'] }}</h5>
                            <span class="text-[10px] text-slate-400 font-bold block pt-1">📅 {{ $ann['date'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </aside>

            <!-- ========================================== -->
            <!-- CENTER COLUMN (col-span-6): ARTIKEL UTAMA  -->
            <!-- ========================================== -->
            <article class="lg:col-span-6 space-y-6 order-1 lg:order-2">
                
                <!-- Breadcrumb & Unit Category Badge -->
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400">
                        <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
                        <span>/</span>
                        <a href="{{ route('school.berita') }}" class="hover:text-emerald-600">Berita</a>
                        <span>/</span>
                        <span class="text-slate-800 dark:text-slate-200 font-extrabold">{{ $news['category'] ?? 'Berita' }}</span>
                    </div>

                    <span class="px-3.5 py-1 rounded-full text-xs font-black text-white uppercase shadow-sm inline-block {{ ($news['category'] ?? '') == 'KB/TKIT' ? 'bg-emerald-700' : (($news['category'] ?? '') == 'SDIT' ? 'bg-orange-600' : (($news['category'] ?? '') == 'SMPIT' ? 'bg-blue-600' : (($news['category'] ?? '') == 'SMAIT' ? 'bg-purple-600' : 'bg-emerald-700'))) }}">
                        {{ $news['category'] ?? 'Berita' }}
                    </span>

                    <!-- Headline Title -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold font-headline text-slate-900 dark:text-white leading-tight tracking-tight">
                        {{ $news['title'] }}
                    </h1>

                    <!-- Author & Metadata Line -->
                    <div class="flex flex-wrap items-center gap-3 text-xs font-bold text-slate-500 dark:text-slate-400 border-y border-slate-200 dark:border-slate-800 py-3">
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-emerald-700 text-white font-black flex items-center justify-center text-[10px]">
                                {{ strtoupper(substr($news['author'] ?? 'Humas', 0, 1)) }}
                            </span>
                            <span class="text-slate-900 dark:text-slate-200 font-extrabold">{{ $news['author'] ?? 'Humas SIT Robbani' }}</span>
                        </div>
                        <span>•</span>
                        <span>🗓️ {{ $news['date'] }}</span>
                        <span>•</span>
                        <span>⏱️ 3 Menit Baca</span>
                        <span>•</span>
                        <span>📍 Ogan Ilir, Sumsel</span>
                    </div>
                </div>

                <!-- Featured Image Showcase -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-md">
                    <div class="relative max-h-[420px] overflow-hidden bg-slate-900 flex items-center justify-center">
                        <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full p-8 object-contain bg-white';">
                    </div>
                    <div class="p-3 bg-slate-100 dark:bg-slate-800/80 text-[11px] text-slate-600 dark:text-slate-400 text-center font-bold border-t border-slate-200 dark:border-slate-800">
                        📷 Dokumentasi resmi kegiatan {{ $news['category'] ?? 'SIT Robbani' }} Ogan Ilir, Sumatera Selatan.
                    </div>
                </div>

                <!-- Main Content Text Box (High Contrast & Legibility) -->
                <div class="bg-white dark:bg-slate-900 p-6 sm:p-8 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm text-slate-800 dark:text-slate-200 text-sm sm:text-base leading-relaxed font-medium prose-content space-y-4">
                    {!! $news['content'] !!}
                </div>

                <!-- Interactive Social Share Action Bar -->
                <div class="p-5 rounded-3xl bg-emerald-50 dark:bg-slate-900 border border-emerald-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                    <span class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <span>📢</span> Bagikan Berita Ini:
                    </span>
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($news['title'] . ' ' . request()->fullUrl()) }}" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-xs transition-colors flex items-center gap-1.5">
                            <span>🟢 WhatsApp</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-xs transition-colors flex items-center gap-1.5">
                            <span>🔵 Facebook</span>
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link berita berhasil disalin ke clipboard!');" class="px-4 py-2 rounded-xl bg-slate-800 dark:bg-slate-700 hover:bg-slate-900 text-white font-black text-xs shadow-xs transition-colors flex items-center gap-1.5">
                            <span>🔗 Salin Link</span>
                        </button>
                    </div>
                </div>

                <!-- Navigation Previous / Next Article Bar -->
                <div class="pt-4 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between gap-4">
                    <a href="{{ route('school.berita') }}" class="px-4 py-2.5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-800 dark:text-slate-200 font-extrabold text-xs hover:border-emerald-500 transition-all shadow-xs flex items-center gap-1.5">
                        <span>← Berita Lainnya</span>
                    </a>
                    <a href="{{ route('home') }}" class="px-4 py-2.5 rounded-2xl bg-emerald-700 text-white font-black text-xs hover:bg-emerald-800 transition-all shadow-sm flex items-center gap-1.5">
                        <span>Kembali ke Beranda 🏠</span>
                    </a>
                </div>

            </article>

            <!-- ========================================== -->
            <!-- RIGHT SIDEBAR (col-span-3): POPULER & PPDB -->
            <!-- ========================================== -->
            <aside class="lg:col-span-3 space-y-6 order-3">
                
                <!-- Card 1: Berita Populer & Terkini (4 Items Grid List) -->
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-1.5">
                            <span>🔥</span> Berita Terpopuler
                        </h4>
                        <a href="{{ route('school.berita') }}" class="text-[10px] font-bold text-emerald-600 hover:underline">Semua</a>
                    </div>

                    <div class="space-y-3">
                        @foreach($recentNews as $rn)
                        <a href="{{ route('school.berita.show', $rn['slug'] ?? \Illuminate\Support\Str::slug($rn['title'])) }}" class="flex items-center gap-3 group p-2 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/60 transition-all">
                            <div class="w-16 h-14 rounded-xl overflow-hidden bg-slate-900 shrink-0 border border-slate-200 dark:border-slate-800">
                                <img src="{{ $rn['image'] }}" alt="{{ $rn['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-2 bg-white';">
                            </div>
                            <div class="space-y-1 min-w-0">
                                <span class="text-[9px] font-extrabold text-emerald-700 dark:text-emerald-400 uppercase block">{{ $rn['category'] ?? 'Berita' }}</span>
                                <h5 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 line-clamp-2 leading-snug transition-colors">{{ $rn['title'] }}</h5>
                                <span class="text-[9px] text-slate-400 font-bold block">🗓️ {{ $rn['date'] }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Card 2: Agenda & Event Kampus Terdekat -->
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-3">
                    <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-1.5 border-b border-slate-100 dark:border-slate-800 pb-2">
                        <span>📅</span> Agenda &amp; Event Terdekat
                    </h4>

                    <div class="space-y-2.5">
                        @foreach(array_slice($agendaList ?? [], 0, 3) as $agenda)
                        <div class="flex items-center gap-3 p-2.5 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-800">
                            <div class="flex flex-col items-center justify-center bg-emerald-700 text-white w-10 h-10 rounded-xl shrink-0 font-bold shadow-xs">
                                <span class="text-xs leading-none">{{ $agenda['date_day'] ?? '15' }}</span>
                                <span class="text-[8px] uppercase tracking-wider leading-none mt-0.5">{{ $agenda['date_month'] ?? 'JUN' }}</span>
                            </div>
                            <div class="min-w-0 space-y-0.5">
                                <h5 class="text-xs font-extrabold text-slate-900 dark:text-white truncate">{{ $agenda['title'] }}</h5>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium block truncate">📍 {{ $agenda['location'] ?? 'Kampus Robbani' }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Card 3: Banner Call-To-Action PPDB Online 2026/2027 -->
                <div class="p-6 rounded-3xl bg-gradient-to-br from-emerald-800 via-teal-900 to-slate-900 text-white space-y-4 shadow-lg border border-emerald-700/50">
                    <div class="space-y-1">
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[9px] font-black uppercase shadow-xs">PPDB 2026/2027</span>
                        <h4 class="text-lg font-black font-headline tracking-tight">Pendaftaran Peserta Didik Baru</h4>
                        <p class="text-xs text-slate-200 font-medium leading-relaxed">
                            Mari bergabung bersama SIT Robbani Ogan Ilir jenjang KB/TKIT, SDIT, SMPIT, &amp; SMAIT.
                        </p>
                    </div>
                    <a href="{{ route('school.ppdb') }}" class="w-full py-3 rounded-2xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs text-center shadow-md block transition-all hover:scale-[1.02]">
                        Daftar PPDB Online ➔
                    </a>
                </div>

            </aside>

        </div>

    </main>

    <!-- Footer Bar -->
    <footer class="bg-white dark:bg-slate-950 text-slate-600 dark:text-slate-400 text-xs py-8 text-center border-t border-slate-200 dark:border-slate-800 transition-colors">
        <div class="max-w-7xl mx-auto px-4 space-y-2">
            <p class="font-bold">© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
            <p class="text-[11px] text-slate-400">Pendidikan Berkarakter Qur'ani &amp; Berprestasi Digital • Terakreditasi Unggul</p>
        </div>
    </footer>

</body>
</html>
