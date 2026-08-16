<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    
    <!-- Primary SEO Meta Tags -->
    <title>{{ $news['title'] }} | {{ $settings['school_name'] ?? 'SIT Robbani Ogan Ilir' }}</title>
    <meta name="title" content="{{ $news['title'] }} | {{ $settings['school_name'] ?? 'SIT Robbani Ogan Ilir' }}">
    <meta name="description" content="{{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($news['content']))), 160) }}">
    <meta name="keywords" content="Berita SIT Robbani, {{ $news['category'] ?? 'Berita Sekolah' }}, SIT Robbani Ogan Ilir, TKIT SDIT SMPIT SMAIT Indralaya, Haflah Robbani, PPDB SIT Robbani, Sekolah Islam Unggulan Ogan Ilir">
    <meta name="author" content="{{ $news['author'] ?? 'Humas SIT Robbani' }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <!-- Open Graph / Facebook / WhatsApp SEO -->
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="SIT Robbani Ogan Ilir">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $news['title'] }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($news['content']))), 160) }}">
    <meta property="og:image" content="{{ str_starts_with($news['image'], 'http') ? $news['image'] : url($news['image']) }}">
    <meta property="og:image:alt" content="{{ $news['title'] }}">
    <meta property="og:locale" content="id_ID">
    <meta property="article:published_time" content="{{ date('c', strtotime($news['date'] ?? now())) }}">
    <meta property="article:section" content="{{ $news['category'] ?? 'Berita' }}">

    <!-- Twitter Card SEO -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="{{ $news['title'] }}">
    <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($news['content']))), 160) }}">
    <meta name="twitter:image" content="{{ str_starts_with($news['image'], 'http') ? $news['image'] : url($news['image']) }}">

    <!-- Schema.org JSON-LD Structured Data for Google Indexing -->
    <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'NewsArticle',
      'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => url()->current()
      ],
      'headline' => $news['title'],
      'image' => [
        str_starts_with($news['image'], 'http') ? $news['image'] : url($news['image'])
      ],
      'datePublished' => date('c', strtotime($news['date'] ?? now())),
      'dateModified' => date('c'),
      'author' => [
        '@type' => 'Organization',
        'name' => $news['author'] ?? 'Humas SIT Robbani',
        'url' => url('/')
      ],
      'publisher' => [
        '@type' => 'EducationalOrganization',
        'name' => 'SIT Robbani Ogan Ilir',
        'logo' => [
          '@type' => 'ImageObject',
          'url' => url('/images/logo-robbani-official.png')
        ]
      ],
      'description' => \Illuminate\Support\Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($news['content']))), 160)
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
    </script>
    
    <!-- Tailwind CSS CDN with darkMode: 'class' -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    screens: {
                        'xs': '420px',
                    },
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

        /* Typography & Clean Paragraphs in Article Content (Mobile & Desktop) */
        .prose-content {
            font-size: 0.9375rem;
            line-height: 1.85;
            word-break: break-word;
            text-align: left !important;
        }
        @media (min-width: 640px) {
            .prose-content {
                font-size: 1.0625rem;
                line-height: 1.9;
            }
        }
        .prose-content p, 
        .prose-content div:not(.wp-block-columns):not(.row) {
            margin-bottom: 1.35rem;
            line-height: 1.85;
            text-align: left !important;
        }
        .prose-content h2 {
            font-size: 1.35rem;
            font-weight: 900;
            margin-top: 2rem;
            margin-bottom: 1rem;
            line-height: 1.3;
            text-align: left !important;
        }
        .prose-content h3 {
            font-size: 1.15rem;
            font-weight: 800;
            margin-top: 1.5rem;
            margin-bottom: 0.75rem;
            text-align: left !important;
        }
        .prose-content strong {
            font-weight: 800;
        }
        .prose-content ul, .prose-content ol {
            margin-bottom: 1.35rem;
            padding-left: 1.25rem;
            text-align: left !important;
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
            text-align: left !important;
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
            max-width: 48px !important;
            max-height: 48px !important;
            width: auto !important;
            height: auto !important;
            display: inline-block !important;
            margin: 0.25rem 0.5rem !important;
            vertical-align: middle !important;
            border-radius: 0.375rem !important;
            box-shadow: none !important;
        }

        .prose-content table img,
        .prose-content li img {
            max-width: 80px !important;
            display: inline-block !important;
            margin: 0 0.25rem !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#060e07] text-slate-900 dark:text-[#f7fee7] antialiased min-h-screen pb-24 lg:pb-12 transition-colors duration-300">

    <!-- Sticky Glassmorphism Header Bar (Responsive & Clean on all Screen Sizes) -->
    <header class="sticky top-0 z-50 transition-colors duration-300 bg-white/95 dark:bg-[#07170a]/95 backdrop-blur-md border-b border-slate-200 dark:border-[#1a3d1e] shadow-xs">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 py-2.5 sm:py-3.5 flex items-center justify-between gap-2">
            
            <!-- Left Logo & Branding -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group shrink-0">
                <img x-show="!darkMode" src="{{ $settings['logo_light'] ?? '/images/logo robbani light.png' }}" class="h-8 sm:h-10 w-auto object-contain" alt="Logo SIT Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <img x-show="darkMode" x-cloak src="{{ $settings['logo_dark'] ?? '/images/logo robbani dark.png' }}" class="h-8 sm:h-10 w-auto object-contain" alt="Logo SIT Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <div class="hidden xs:block">
                    <span class="font-black text-[11px] sm:text-xs block text-emerald-700 dark:text-[#c6f634] uppercase tracking-wider group-hover:text-emerald-600 leading-tight">PORTAL BERITA</span>
                    <span class="text-[9px] sm:text-[10px] text-slate-500 dark:text-slate-400 font-bold block leading-tight">SIT ROBBANI</span>
                </div>
            </a>

            <!-- Header Action Controls (Optimized Single-Row Mobile Layout) -->
            <div class="flex items-center gap-1.5 sm:gap-2.5 shrink-0">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-[#0c2210] hover:bg-slate-200 dark:hover:bg-[#143319] text-slate-700 dark:text-slate-300 font-extrabold text-xs transition-colors border border-slate-200 dark:border-[#1a3d1e] hidden sm:inline-flex items-center gap-1.5">
                    🏠 Beranda
                </a>
                
                <a href="{{ route('school.berita') }}" class="px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-[11px] sm:text-xs shadow-xs transition-colors flex items-center gap-1">
                    <span>←</span> <span class="hidden xs:inline">Semua </span><span>Berita</span>
                </a>

                <!-- Dark Mode Toggle Button -->
                <button @click="darkMode = !darkMode" title="Ganti Mode Terang / Malam" class="p-1.5 sm:px-2.5 sm:py-2 rounded-xl bg-slate-100 dark:bg-[#0c2210] text-slate-800 dark:text-[#c6f634] hover:bg-slate-200 dark:hover:bg-[#143319] border border-slate-200 dark:border-[#1a3d1e] font-extrabold text-xs transition-all shadow-xs flex items-center justify-center">
                    <span x-show="!darkMode">🌙</span>
                    <span x-show="darkMode" x-cloak>☀️</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Container: 2-Column Desktop Layout (Left: Wide Article | Right: All Widgets) -->
    <main class="max-w-7xl mx-auto px-3 sm:px-6 py-5 sm:py-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
            
            <!-- ========================================================================= -->
            <!-- SISI KIRI (lg:col-span-8): ARTIKEL BERITA UTAMA (TAMPILAN LEBAR & ELEGAN)  -->
            <!-- ========================================================================= -->
            <article class="lg:col-span-8 space-y-5 sm:space-y-6">
                
                <!-- Breadcrumbs & Category Badge -->
                <div class="space-y-2.5 sm:space-y-3">
                    <div class="flex flex-wrap items-center gap-1.5 text-[11px] sm:text-xs font-bold text-slate-500 dark:text-slate-400">
                        <a href="{{ route('home') }}" class="hover:text-emerald-600 dark:hover:text-[#c6f634]">Beranda</a>
                        <span>/</span>
                        <a href="{{ route('school.berita') }}" class="hover:text-emerald-600 dark:hover:text-[#c6f634]">Berita</a>
                        <span>/</span>
                        <span class="text-slate-800 dark:text-slate-200 font-extrabold">{{ $news['category'] ?? 'Berita' }}</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-full text-[11px] sm:text-xs font-black text-white uppercase shadow-xs inline-block {{ ($news['category'] ?? '') == 'KB/TKIT' ? 'bg-emerald-700' : (($news['category'] ?? '') == 'SDIT' ? 'bg-orange-600' : (($news['category'] ?? '') == 'SMPIT' ? 'bg-blue-600' : (($news['category'] ?? '') == 'SMAIT' ? 'bg-purple-600' : 'bg-emerald-700'))) }}">
                            {{ $news['category'] ?? 'Berita' }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 dark:bg-[#0c2210] text-emerald-800 dark:text-[#c6f634] border border-emerald-200 dark:border-[#1a3d1e]">
                            Dokumentasi Resmi
                        </span>
                    </div>

                    <!-- Headline Title (Lebar, Jelas & Proporsional) -->
                    <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold font-headline text-slate-900 dark:text-white leading-tight tracking-tight">
                        {{ $news['title'] }}
                    </h1>

                    <!-- Author & Metadata Line (Clean Wrap on Mobile) -->
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-[11px] sm:text-xs font-bold text-slate-500 dark:text-slate-400 border-y border-slate-200 dark:border-[#1a3d1e] py-3">
                        <div class="flex items-center gap-1.5">
                            <div class="w-6 h-6 rounded-full bg-emerald-700 text-white font-black flex items-center justify-center text-[10px] shadow-xs">
                                {{ strtoupper(substr($news['author'] ?? 'H', 0, 2)) }}
                            </div>
                            <span class="text-slate-900 dark:text-slate-200 font-extrabold">{{ $news['author'] ?? 'Humas SIT Robbani' }}</span>
                        </div>
                        <span>•</span>
                        <span>🗓️ {{ $news['date'] }}</span>
                        <span>•</span>
                        <span>⏱️ 3 Menit Baca</span>
                        <span class="hidden xs:inline">•</span>
                        <span class="hidden xs:inline">📍 Ogan Ilir, Sumsel</span>
                    </div>
                </div>

                <!-- Featured Hero Image Showcase (Proporsional & Rounded) -->
                <div class="bg-white dark:bg-[#07170a] rounded-2xl sm:rounded-3xl overflow-hidden border border-slate-200 dark:border-[#1a3d1e] shadow-md">
                    <div class="relative max-h-[460px] overflow-hidden bg-slate-950 flex items-center justify-center">
                        <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full max-h-[460px] object-cover object-center" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full p-8 object-contain bg-white';">
                    </div>
                    <div class="p-3 sm:p-3.5 bg-slate-50 dark:bg-[#0a1f0e] text-[10px] sm:text-[11px] text-slate-600 dark:text-slate-300 text-center font-bold border-t border-slate-200 dark:border-[#1a3d1e] flex items-center justify-center gap-1.5">
                        <span>📷</span> Dokumentasi resmi kegiatan {{ $news['category'] ?? 'SIT Robbani' }} Ogan Ilir, Sumatera Selatan.
                    </div>
                </div>

                <!-- Main Content Text Box (High Contrast, Responsive Images, No Distortion) -->
                <div class="bg-white dark:bg-[#07170a] p-4 sm:p-8 lg:p-9 rounded-2xl sm:rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm text-slate-800 dark:text-slate-200 prose-content">
                    {!! $news['content'] !!}
                </div>

                <!-- Interactive Social Share Action Bar (Grid 3 Kolom on Mobile) -->
                <div class="p-4 sm:p-6 rounded-2xl sm:rounded-3xl bg-emerald-50/80 dark:bg-[#07170a] border border-emerald-200 dark:border-[#1a3d1e] space-y-3 sm:space-y-0 sm:flex sm:items-center sm:justify-between sm:gap-4 shadow-sm">
                    <div class="space-y-0.5 text-center sm:text-left">
                        <span class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center justify-center sm:justify-start gap-1.5">
                            <span>📢</span> Bagikan Berita Ini:
                        </span>
                        <span class="text-[10px] sm:text-[11px] text-slate-500 dark:text-slate-400 font-medium">Bantu sebarkan informasi kegiatan santri</span>
                    </div>
                    <div class="grid grid-cols-3 gap-1.5 sm:flex sm:flex-wrap sm:gap-2">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($news['title'] . ' ' . request()->fullUrl()) }}" target="_blank" class="px-2.5 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-[11px] sm:text-xs shadow-xs transition-transform hover:scale-105 flex items-center justify-center gap-1">
                            <span>💬</span> <span>WA</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="px-2.5 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-[11px] sm:text-xs shadow-xs transition-transform hover:scale-105 flex items-center justify-center gap-1">
                            <span>📘</span> <span>FB</span>
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link berita berhasil disalin ke clipboard!');" class="px-2.5 py-2 sm:px-4 sm:py-2.5 rounded-xl bg-slate-800 dark:bg-[#0c2210] hover:bg-slate-900 dark:hover:bg-[#143319] text-white dark:text-[#c6f634] border border-slate-700 dark:border-[#1a3d1e] font-extrabold text-[11px] sm:text-xs shadow-xs transition-transform hover:scale-105 flex items-center justify-center gap-1">
                            <span>🔗</span> <span>Salin</span>
                        </button>
                    </div>
                </div>

                <!-- Author Bio Card -->
                <div class="bg-white dark:bg-[#07170a] p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm flex items-start gap-3 sm:gap-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-emerald-700 text-white font-black flex items-center justify-center text-xs sm:text-sm shadow-md shrink-0">
                        {{ strtoupper(substr($news['author'] ?? 'H', 0, 2)) }}
                    </div>
                    <div class="space-y-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-1.5">
                            <h4 class="font-extrabold text-xs sm:text-sm text-slate-900 dark:text-white">{{ $news['author'] ?? 'Humas SIT Robbani' }}</h4>
                            <span class="px-2 py-0.5 rounded-md bg-emerald-100 dark:bg-[#0c2210] text-emerald-800 dark:text-[#c6f634] text-[9px] font-black uppercase">Official Publisher</span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-400 leading-relaxed font-medium">
                            Dipublikasikan oleh Tim Media &amp; Humas Resmi SIT Robbani Ogan Ilir untuk mengabarkan kegiatan akademik, tahfidz, dan prestasi santri.
                        </p>
                    </div>
                </div>

                <!-- Navigation Previous / Next Article Bar -->
                <div class="pt-3 border-t border-slate-200 dark:border-[#1a3d1e] flex flex-col sm:flex-row items-center justify-between gap-2.5">
                    <a href="{{ route('school.berita') }}" class="w-full sm:w-auto px-4 py-2.5 sm:px-5 sm:py-3 rounded-2xl bg-white dark:bg-[#07170a] border border-slate-200 dark:border-[#1a3d1e] text-slate-800 dark:text-slate-200 font-extrabold text-xs hover:border-emerald-500 hover:text-emerald-700 dark:hover:text-[#c6f634] transition-all shadow-xs flex items-center justify-center gap-1.5">
                        <span>← Lihat Semua Berita</span>
                    </a>
                    <a href="{{ route('home') }}" class="w-full sm:w-auto px-4 py-2.5 sm:px-5 sm:py-3 rounded-2xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs transition-all shadow-md flex items-center justify-center gap-1.5">
                        <span>Kembali ke Beranda Utama 🏠</span>
                    </a>
                </div>

            </article>

            <!-- ========================================================================= -->
            <!-- SISI KANAN (lg:col-span-4): SEMUA WIDGET DIGABUNG DI 1 SIDEBAR STICKY     -->
            <!-- ========================================================================= -->
            <aside class="lg:col-span-4 space-y-5 sm:space-y-6 lg:sticky lg:top-24">
                
                <!-- WIDGET 1: Berita Populer & Terkini (Proporsional Thumbnail) -->
                <div class="bg-white dark:bg-[#07170a] p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm space-y-3.5">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-[#143319] pb-2.5">
                        <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-1.5">
                            <span>🔥</span> Berita Terpopuler
                        </h4>
                        <a href="{{ route('school.berita') }}" class="text-[10px] font-black text-emerald-700 dark:text-[#c6f634] hover:underline">Lihat Semua →</a>
                    </div>

                    <div class="space-y-2.5">
                        @foreach($recentNews as $rn)
                        <a href="{{ route('school.berita.show', $rn['slug'] ?? \Illuminate\Support\Str::slug($rn['title'])) }}" class="flex items-center gap-2.5 sm:gap-3 group p-1.5 sm:p-2 rounded-2xl hover:bg-slate-50 dark:hover:bg-[#0a1f0e] border border-transparent hover:border-slate-200 dark:hover:border-[#1a3d1e] transition-all">
                            <div class="w-16 h-14 sm:w-20 sm:h-16 rounded-xl overflow-hidden bg-slate-900 shrink-0 border border-slate-200 dark:border-[#1a3d1e]">
                                <img src="{{ $rn['image'] }}" alt="{{ $rn['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-2 bg-white';">
                            </div>
                            <div class="space-y-0.5 min-w-0 flex-1">
                                <span class="text-[9px] font-black text-emerald-700 dark:text-[#c6f634] uppercase block">{{ $rn['category'] ?? 'Berita' }}</span>
                                <h5 class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-[#c6f634] line-clamp-2 leading-snug transition-colors">{{ $rn['title'] }}</h5>
                                <span class="text-[9px] text-slate-400 font-bold block">🗓️ {{ $rn['date'] }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- WIDGET 2: Kategori Jenjang & Tag Populer -->
                <div class="bg-white dark:bg-[#07170a] p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm space-y-3">
                    <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 dark:border-[#143319] pb-2.5">
                        <span>🏷️</span> Kategori &amp; Unit Sekolah
                    </h4>
                    <div class="grid grid-cols-2 gap-2 pt-1">
                        <a href="{{ route('school.unit', 'tkit') }}" class="p-2 sm:p-2.5 rounded-2xl bg-emerald-50 dark:bg-[#0a1f0e] border border-emerald-200/80 dark:border-[#1a3d1e] text-emerald-800 dark:text-emerald-300 font-extrabold text-xs hover:bg-emerald-700 hover:text-white transition-all flex items-center justify-between">
                            <span>🧸 KB/TKIT</span>
                            <span class="text-[10px]">➔</span>
                        </a>
                        <a href="{{ route('school.unit', 'sdit') }}" class="p-2 sm:p-2.5 rounded-2xl bg-orange-50 dark:bg-[#0a1f0e] border border-orange-200/80 dark:border-[#1a3d1e] text-orange-800 dark:text-orange-300 font-extrabold text-xs hover:bg-orange-600 hover:text-white transition-all flex items-center justify-between">
                            <span>🏫 SDIT</span>
                            <span class="text-[10px]">➔</span>
                        </a>
                        <a href="{{ route('school.unit', 'smpit') }}" class="p-2 sm:p-2.5 rounded-2xl bg-blue-50 dark:bg-[#0a1f0e] border border-blue-200/80 dark:border-[#1a3d1e] text-blue-800 dark:text-blue-300 font-extrabold text-xs hover:bg-blue-600 hover:text-white transition-all flex items-center justify-between">
                            <span>📚 SMPIT</span>
                            <span class="text-[10px]">➔</span>
                        </a>
                        <a href="{{ route('school.unit', 'smait') }}" class="p-2 sm:p-2.5 rounded-2xl bg-purple-50 dark:bg-[#0a1f0e] border border-purple-200/80 dark:border-[#1a3d1e] text-purple-800 dark:text-purple-300 font-extrabold text-xs hover:bg-purple-600 hover:text-white transition-all flex items-center justify-between">
                            <span>🎓 SMAIT</span>
                            <span class="text-[10px]">➔</span>
                        </a>
                    </div>
                    <div class="flex flex-wrap gap-1.5 pt-1.5">
                        <a href="{{ route('school.berita') }}" class="px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-[#0c2210] text-slate-700 dark:text-slate-300 font-bold text-[10px] hover:bg-slate-200">
                            📖 Tahfidz Al-Qur'an
                        </a>
                        <a href="{{ route('school.berita') }}" class="px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-[#0c2210] text-slate-700 dark:text-slate-300 font-bold text-[10px] hover:bg-slate-200">
                            🏆 Prestasi Santri
                        </a>
                        <a href="{{ route('school.ppdb') }}" class="px-2.5 py-1 rounded-xl bg-amber-100 dark:bg-[#0c2210] text-amber-800 dark:text-amber-300 font-extrabold text-[10px] hover:bg-amber-500 hover:text-white">
                            ✨ SPMB Online
                        </a>
                    </div>
                </div>

                <!-- WIDGET 3: Agenda & Event Kampus Terdekat -->
                <div class="bg-white dark:bg-[#07170a] p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm space-y-3">
                    <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-1.5 border-b border-slate-100 dark:border-[#143319] pb-2.5">
                        <span>📅</span> Agenda &amp; Event Terdekat
                    </h4>

                    <div class="space-y-2">
                        @foreach(array_slice($agendaList ?? [], 0, 3) as $agenda)
                        <div class="flex items-center gap-2.5 sm:gap-3 p-2 sm:p-2.5 rounded-2xl bg-slate-50 dark:bg-[#0a1f0e] border border-slate-200/80 dark:border-[#1a3d1e]">
                            <div class="flex flex-col items-center justify-center bg-emerald-700 text-white w-10 h-10 sm:w-11 sm:h-11 rounded-xl shrink-0 font-bold shadow-xs">
                                <span class="text-[11px] sm:text-xs leading-none font-black">{{ $agenda['date_day'] ?? '15' }}</span>
                                <span class="text-[8px] uppercase tracking-wider leading-none mt-0.5 font-extrabold">{{ $agenda['date_month'] ?? 'JUN' }}</span>
                            </div>
                            <div class="min-w-0 space-y-0.5 flex-1">
                                <h5 class="text-xs font-extrabold text-slate-900 dark:text-white truncate">{{ $agenda['title'] }}</h5>
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-medium block truncate">📍 {{ $agenda['location'] ?? 'Kampus Robbani' }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- WIDGET 4: Pengumuman Terkini -->
                <div class="bg-white dark:bg-[#07170a] p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm space-y-3">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-[#143319] pb-2.5">
                        <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-1.5">
                            <span>📢</span> Pengumuman Kampus
                        </h4>
                        <a href="{{ route('school.berita') }}" class="text-[10px] font-bold text-emerald-600 dark:text-[#c6f634] hover:underline">Semua</a>
                    </div>

                    <div class="space-y-2 text-xs">
                        @foreach(array_slice($announcementList ?? [], 0, 3) as $ann)
                        <div class="p-2.5 sm:p-3 rounded-2xl bg-slate-50 dark:bg-[#0a1f0e] border border-slate-200/80 dark:border-[#1a3d1e] space-y-1 hover:border-emerald-500 transition-all">
                            <span class="text-[9px] font-extrabold px-2 py-0.5 rounded bg-emerald-100 dark:bg-[#0c2210] text-emerald-800 dark:text-[#c6f634] uppercase">{{ $ann['category'] ?? 'INFO' }}</span>
                            <h5 class="font-extrabold text-slate-900 dark:text-white line-clamp-2 leading-snug">{{ $ann['title'] }}</h5>
                            <span class="text-[10px] text-slate-400 font-bold block pt-0.5">📅 {{ $ann['date'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- WIDGET 5: Kontak & Redaksi Humas -->
                <div class="bg-white dark:bg-[#07170a] p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-200 dark:border-[#1a3d1e] shadow-sm space-y-2.5">
                    <h4 class="font-black text-xs text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 dark:border-[#143319] pb-2.5">
                        <span>📞</span> Kontak Humas SIT Robbani
                    </h4>
                    <div class="space-y-1.5 text-xs font-bold text-slate-700 dark:text-slate-300">
                        <a href="https://wa.me/62811747472" target="_blank" class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 dark:bg-[#0a1f0e] hover:text-emerald-600 transition-colors">
                            <span class="text-emerald-600">💬</span> <span>0811-7474-72 (WhatsApp)</span>
                        </a>
                        <a href="mailto:info@sitrobbani.sch.id" class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 dark:bg-[#0a1f0e] hover:text-emerald-600 transition-colors truncate">
                            <span class="text-blue-600">✉️</span> <span class="truncate">info@sitrobbani.sch.id</span>
                        </a>
                        <div class="flex items-center gap-2 p-2 rounded-xl bg-slate-50 dark:bg-[#0a1f0e]">
                            <span class="text-orange-600">📍</span> <span class="truncate">Indralaya, Ogan Ilir, Sumsel</span>
                        </div>
                    </div>
                </div>

                <!-- WIDGET 6: Banner Callout SPMB Online 2026/2027 -->
                <div class="p-5 sm:p-6 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-emerald-800 via-teal-900 to-slate-950 text-white space-y-3.5 shadow-lg border border-emerald-700/50">
                    <div class="space-y-1.5">
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[9px] font-black uppercase shadow-xs">SPMB 2026/2027</span>
                        <h4 class="text-base sm:text-lg font-black font-headline tracking-tight leading-tight">Pendaftaran Santri Baru Telah Dibuka</h4>
                        <p class="text-[11px] sm:text-xs text-slate-200 font-medium leading-relaxed">
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
