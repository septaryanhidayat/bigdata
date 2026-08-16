<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article['title'] }} | {{ $settings['school_name'] }}</title>
    
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
        [x-cloak] { display: none !important; }

        /* Typography & Spacing in Article Content */
        .prose-content {
            font-size: 1rem;
            line-height: 1.85;
            word-break: break-word;
        }
        .prose-content p {
            margin-bottom: 1.35rem;
            line-height: 1.85;
        }
        .prose-content h2 {
            font-size: 1.35rem;
            font-weight: 900;
            margin-top: 2rem;
            margin-bottom: 1rem;
            line-height: 1.3;
        }
        .prose-content h3 {
            font-size: 1.15rem;
            font-weight: 800;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
        }
        .prose-content strong {
            font-weight: 800;
        }
        .prose-content ul, .prose-content ol {
            margin-bottom: 1.35rem;
            padding-left: 1.5rem;
        }
        .prose-content ul { list-style-type: disc; }
        .prose-content ol { list-style-type: decimal; }
        .prose-content li { margin-bottom: 0.5rem; }
        .prose-content blockquote {
            border-left: 4px solid #059669;
            padding: 0.75rem 1.25rem;
            margin: 1.5rem 0;
            background: rgba(5, 150, 105, 0.06);
            border-radius: 0 1rem 1rem 0;
            font-style: italic;
        }

        /* Responsive Article Images Fix */
        .prose-content img {
            max-width: 100%;
            height: auto !important;
            border-radius: 1rem;
            margin: 1.5rem auto;
            display: block;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            object-fit: cover;
        }

        /* Fix for WordPress Icons / Cliparts / Smilies / Small Icons that shouldn't stretch */
        .prose-content img.inline-icon-img,
        .prose-content img[src*="icon"],
        .prose-content img[src*="emoji"],
        .prose-content img[src*="smiley"],
        .prose-content img[src*="pin"],
        .prose-content img[src*="globe"],
        .prose-content img[src*="phone"],
        .prose-content img[src*="book"],
        .prose-content img[src*="clipart"],
        .prose-content img.wp-smiley,
        .prose-content img.emoji {
            max-width: 52px !important;
            max-height: 52px !important;
            width: auto !important;
            height: auto !important;
            display: inline-block !important;
            margin: 0.25rem 0.5rem !important;
            vertical-align: middle !important;
            border-radius: 0.375rem !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#060e07] text-slate-900 dark:text-[#f7fee7] antialiased min-h-screen pb-24 lg:pb-12 transition-colors duration-300">

    <!-- Sticky Glassmorphism Header Bar -->
    <header class="sticky top-0 z-50 transition-colors duration-300 bg-white/90 dark:bg-[#07170a]/90 backdrop-blur-md border-b border-slate-200 dark:border-[#1a3d1e] shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3.5 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img x-show="!darkMode" src="{{ $settings['logo_light'] ?? '/images/logo robbani light.png' }}" class="h-10 w-auto object-contain" alt="Logo SIT Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <img x-show="darkMode" x-cloak src="{{ $settings['logo_dark'] ?? '/images/logo robbani dark.png' }}" class="h-10 w-auto object-contain" alt="Logo SIT Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <div>
                    <span class="font-black text-xs block text-emerald-700 dark:text-[#c6f634] uppercase tracking-wider group-hover:text-emerald-600">ARTIKEL KEISLAMAN</span>
                    <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>

            <!-- Header Action Controls -->
            <div class="flex items-center gap-2 sm:gap-3">
                <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-[#0c2210] hover:bg-slate-200 dark:hover:bg-[#143319] text-slate-700 dark:text-slate-300 font-extrabold text-xs transition-colors border border-slate-200 dark:border-[#1a3d1e] hidden sm:inline-flex items-center gap-1.5">
                    🏠 Beranda
                </a>
                
                <a href="{{ route('school.artikel') }}" class="px-3.5 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-sm transition-colors flex items-center gap-1">
                    ← Semua Artikel
                </a>

                <!-- Dark Mode Toggle Button -->
                <button @click="darkMode = !darkMode" title="Ganti Mode Terang / Malam" class="p-2 sm:px-3 sm:py-2 rounded-xl bg-slate-100 dark:bg-[#0c2210] text-slate-800 dark:text-[#c6f634] hover:bg-slate-200 dark:hover:bg-[#143319] border border-slate-200 dark:border-[#1a3d1e] font-extrabold text-xs transition-all shadow-xs flex items-center gap-1.5">
                    <span x-show="!darkMode" class="flex items-center gap-1">🌙 <span class="hidden md:inline">Mode Malam</span></span>
                    <span x-show="darkMode" x-cloak class="flex items-center gap-1">☀️ <span class="hidden md:inline">Mode Terang</span></span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Container: 2-Column Desktop Layout -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- SISI KIRI (lg:col-span-8): ARTIKEL UTAMA -->
            <article class="lg:col-span-8 space-y-6">
                
                <!-- Breadcrumbs & Category Badge -->
                <div class="space-y-3">
                    <div class="flex flex-wrap items-center gap-2 text-xs font-bold text-slate-500 dark:text-slate-400">
                        <a href="{{ route('home') }}" class="hover:text-emerald-600 dark:hover:text-[#c6f634]">Beranda</a>
                        <span>/</span>
                        <a href="{{ route('school.artikel') }}" class="hover:text-emerald-600 dark:hover:text-[#c6f634]">Artikel</a>
                        <span>/</span>
                        <span class="text-slate-800 dark:text-slate-200 font-extrabold">{{ $article['category'] ?? 'Edukasi Islam' }}</span>
                    </div>

                    <span class="px-3.5 py-1 rounded-full text-xs font-black text-white uppercase shadow-sm bg-emerald-700 inline-block">
                        {{ $article['category'] ?? 'Artikel' }}
                    </span>

                    <!-- Headline Title -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold font-headline text-slate-900 dark:text-white leading-tight tracking-tight">
                        {{ $article['title'] }}
                    </h1>

                    <!-- Author & Metadata Line -->
                    <div class="flex flex-wrap items-center gap-3 text-xs font-bold text-slate-500 dark:text-slate-400 border-y border-slate-200 dark:border-[#1a3d1e] py-3.5">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-full bg-emerald-700 text-white font-black flex items-center justify-center text-[10px] shadow-xs">
                                {{ strtoupper(substr($article['author'] ?? 'U', 0, 2)) }}
                            </div>
                            <span class="text-slate-900 dark:text-slate-200 font-extrabold">{{ $article['author'] ?? 'Ustadz Pembina SIT Robbani' }}</span>
                        </div>
                        <span>•</span>
                        <span>🗓️ {{ $article['date'] }}</span>
                        <span>•</span>
                        <span>⏱️ 4 Menit Baca</span>
                        <span>•</span>
                        <span>📖 Rubrik Edukasi &amp; Karakter</span>
                    </div>
                </div>

                <!-- Featured Hero Image -->
                <div class="bg-white dark:bg-[#07170a] rounded-3xl overflow-hidden border border-slate-200 dark:border-[#1a3d1e] shadow-md">
                    <div class="relative max-h-[460px] overflow-hidden bg-slate-950 flex items-center justify-center">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-full max-h-[460px] object-cover object-center" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full p-8 object-contain bg-white';">
                    </div>
                </div>

                <!-- Main Content Text Box -->
                <div class="bg-white dark:bg-[#07170a] p-6 sm:p-9 rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm text-slate-800 dark:text-slate-200 prose-content">
                    {!! $article['content'] !!}
                </div>

                <!-- Social Share Bar -->
                <div class="p-5 sm:p-6 rounded-3xl bg-emerald-50/80 dark:bg-[#07170a] border border-emerald-200 dark:border-[#1a3d1e] flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm">
                    <div class="space-y-0.5 text-center sm:text-left">
                        <span class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center justify-center sm:justify-start gap-1.5">
                            <span>📢</span> Bagikan Artikel Ini:
                        </span>
                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">Tebarkan ilmu yang bermanfaat untuk sesama</span>
                    </div>
                    <div class="flex flex-wrap items-center justify-center gap-2">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($article['title'] . ' ' . request()->fullUrl()) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-xs transition-transform hover:scale-105 flex items-center gap-1.5">
                            <span>💬 WhatsApp</span>
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link artikel berhasil disalin ke clipboard!');" class="px-4 py-2.5 rounded-xl bg-slate-800 dark:bg-[#0c2210] hover:bg-slate-900 dark:hover:bg-[#143319] text-white dark:text-[#c6f634] border border-slate-700 dark:border-[#1a3d1e] font-extrabold text-xs shadow-xs transition-transform hover:scale-105 flex items-center gap-1.5">
                            <span>🔗 Salin Link</span>
                        </button>
                    </div>
                </div>

                <!-- Navigation Previous / Next Article Bar -->
                <div class="pt-4 border-t border-slate-200 dark:border-[#1a3d1e] flex flex-col sm:flex-row items-center justify-between gap-3">
                    <a href="{{ route('school.artikel') }}" class="w-full sm:w-auto px-5 py-3 rounded-2xl bg-white dark:bg-[#07170a] border border-slate-200 dark:border-[#1a3d1e] text-slate-800 dark:text-slate-200 font-extrabold text-xs hover:border-emerald-500 hover:text-emerald-700 dark:hover:text-[#c6f634] transition-all shadow-xs flex items-center justify-center gap-2">
                        <span>← Lihat Artikel Lainnya</span>
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto px-5 py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs transition-all shadow-md flex items-center justify-center gap-2">
                        <span>Kembali ke Beranda Utama 🏠</span>
                    </a>
                </div>

            </article>

            <!-- SISI KANAN (lg:col-span-4): SIDEBAR WIDGETS -->
            <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">
                
                <!-- WIDGET 1: Artikel Terkait Lainnya -->
                <div class="bg-white dark:bg-[#07170a] p-5 rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-[#143319] pb-3">
                        <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-1.5">
                            <span>📖</span> Artikel Pilihan Lainnya
                        </h4>
                        <a href="{{ route('school.artikel') }}" class="text-[10px] font-black text-emerald-700 dark:text-[#c6f634] hover:underline">Semua →</a>
                    </div>

                    <div class="space-y-3">
                        @foreach($recentArticles ?? [] as $ra)
                        <a href="{{ route('school.artikel.show', $ra['slug'] ?? \Illuminate\Support\Str::slug($ra['title'])) }}" class="flex items-center gap-3 group p-2 rounded-2xl hover:bg-slate-50 dark:hover:bg-[#0a1f0e] border border-transparent hover:border-slate-200 dark:hover:border-[#1a3d1e] transition-all">
                            <div class="w-20 h-16 rounded-xl overflow-hidden bg-slate-900 shrink-0 border border-slate-200 dark:border-[#1a3d1e]">
                                <img src="{{ $ra['image'] }}" alt="{{ $ra['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-2 bg-white';">
                            </div>
                            <div class="space-y-1 min-w-0 flex-1">
                                <span class="text-[9px] font-black text-emerald-700 dark:text-[#c6f634] uppercase block">{{ $ra['category'] ?? 'Edukasi' }}</span>
                                <h5 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-[#c6f634] line-clamp-2 leading-snug transition-colors">{{ $ra['title'] }}</h5>
                                <span class="text-[9px] text-slate-400 font-bold block">🗓️ {{ $ra['date'] }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- WIDGET 2: Akses Unit Sekolah -->
                <div class="bg-white dark:bg-[#07170a] p-5 rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm space-y-3">
                    <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 dark:border-[#143319] pb-3">
                        <span>🏷️</span> Profil Unit Sekolah
                    </h4>
                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <a href="{{ route('school.unit', 'tkit') }}" class="p-2.5 rounded-2xl bg-emerald-50 dark:bg-[#0a1f0e] border border-emerald-200/80 dark:border-[#1a3d1e] text-emerald-800 dark:text-emerald-300 font-extrabold text-xs hover:bg-emerald-700 hover:text-white transition-all flex items-center justify-between">
                            <span>🧸 KB/TKIT</span>
                            <span class="text-[10px]">➔</span>
                        </a>
                        <a href="{{ route('school.unit', 'sdit') }}" class="p-2.5 rounded-2xl bg-orange-50 dark:bg-[#0a1f0e] border border-orange-200/80 dark:border-[#1a3d1e] text-orange-800 dark:text-orange-300 font-extrabold text-xs hover:bg-orange-600 hover:text-white transition-all flex items-center justify-between">
                            <span>🏫 SDIT</span>
                            <span class="text-[10px]">➔</span>
                        </a>
                        <a href="{{ route('school.unit', 'smpit') }}" class="p-2.5 rounded-2xl bg-blue-50 dark:bg-[#0a1f0e] border border-blue-200/80 dark:border-[#1a3d1e] text-blue-800 dark:text-blue-300 font-extrabold text-xs hover:bg-blue-600 hover:text-white transition-all flex items-center justify-between">
                            <span>📚 SMPIT</span>
                            <span class="text-[10px]">➔</span>
                        </a>
                        <a href="{{ route('school.unit', 'smait') }}" class="p-2.5 rounded-2xl bg-purple-50 dark:bg-[#0a1f0e] border border-purple-200/80 dark:border-[#1a3d1e] text-purple-800 dark:text-purple-300 font-extrabold text-xs hover:bg-purple-600 hover:text-white transition-all flex items-center justify-between">
                            <span>🎓 SMAIT</span>
                            <span class="text-[10px]">➔</span>
                        </a>
                    </div>
                </div>

                <!-- WIDGET 3: Banner Callout SPMB Online 2026/2027 -->
                <div class="p-6 rounded-3xl bg-gradient-to-br from-emerald-800 via-teal-900 to-slate-950 text-white space-y-4 shadow-lg border border-emerald-700/50">
                    <div class="space-y-1.5">
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[9px] font-black uppercase shadow-xs">SPMB 2026/2027</span>
                        <h4 class="text-lg font-black font-headline tracking-tight">Pendaftaran Santri Baru Telah Dibuka</h4>
                        <p class="text-xs text-slate-200 font-medium leading-relaxed">
                            Penerimaan santri baru KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani Ogan Ilir tahun ajaran 2026/2027.
                        </p>
                    </div>
                    <a href="{{ route('school.ppdb') }}" class="w-full py-3 rounded-2xl bg-gradient-to-r from-amber-400 to-orange-500 hover:from-amber-300 hover:to-orange-400 text-slate-950 font-black text-xs text-center shadow-md block transition-all hover:scale-[1.02]">
                        Daftar SPMB Online ➔
                    </a>
                </div>

            </aside>

        </div>

    </main>

    <!-- Auto-Constraint Small WordPress Inline Icons Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const proseImages = document.querySelectorAll('.prose-content img');
            proseImages.forEach(function(img) {
                if ((img.naturalWidth > 0 && img.naturalWidth <= 128) || (img.naturalHeight > 0 && img.naturalHeight <= 128)) {
                    img.classList.add('inline-icon-img');
                }
                img.addEventListener('load', function() {
                    if (img.naturalWidth <= 128 || img.naturalHeight <= 128) {
                        img.classList.add('inline-icon-img');
                    }
                });
            });
        });
    </script>

    <!-- Footer Bar -->
    <footer class="bg-white dark:bg-[#040c05] text-slate-600 dark:text-slate-400 text-xs py-8 text-center border-t border-slate-200 dark:border-[#1a3d1e] transition-colors">
        <div class="max-w-7xl mx-auto px-4 space-y-2">
            <p class="font-bold">© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
            <p class="text-[11px] text-slate-400 dark:text-slate-500">Pendidikan Berkarakter Qur'ani &amp; Berprestasi Digital • Terakreditasi Unggul</p>
        </div>
    </footer>

</body>
</html>
