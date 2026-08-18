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
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s, color 0.3s; }
        [x-cloak] { display: none !important; }

        /* Typography & Clean Justified Paragraphs in Article Content */
        .prose-content {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            font-size: 1.05rem;
            line-height: 1.95;
            word-break: break-word;
            text-align: justify !important;
            text-justify: inter-word;
            letter-spacing: -0.011em;
        }
        @media (min-width: 640px) {
            .prose-content {
                font-size: 1.125rem;
                line-height: 2.0;
            }
        }
        .prose-content p, 
        .prose-content div:not(.wp-block-columns):not(.row) {
            margin-bottom: 1.5rem;
            line-height: 1.95;
            text-align: justify !important;
            text-justify: inter-word;
        }
        .prose-content h2 {
            font-size: 1.45rem;
            font-weight: 900;
            margin-top: 2.25rem;
            margin-bottom: 1rem;
            line-height: 1.35;
            text-align: left !important;
            color: #0f172a;
        }
        .dark .prose-content h2 { color: #f8fafc; }
        .prose-content h3 {
            font-size: 1.25rem;
            font-weight: 800;
            margin-top: 1.75rem;
            margin-bottom: 0.85rem;
            text-align: left !important;
            color: #1e293b;
        }
        .dark .prose-content h3 { color: #f1f5f9; }
        .prose-content strong {
            font-weight: 800;
            color: #0f172a;
        }
        .dark .prose-content strong { color: #ffffff; }
        .prose-content ul, .prose-content ol {
            margin-bottom: 1.5rem;
            padding-left: 1.35rem;
            text-align: justify !important;
        }
        .prose-content ul { list-style-type: disc; }
        .prose-content ol { list-style-type: decimal; }
        .prose-content li { margin-bottom: 0.6rem; line-height: 1.8; }
        .prose-content blockquote {
            border-left: 4px solid #059669;
            padding: 1rem 1.35rem;
            margin: 1.75rem 0;
            background: rgba(5, 150, 105, 0.07);
            border-radius: 0 1.25rem 1.25rem 0;
            font-style: italic;
            font-family: 'Lora', Georgia, serif;
            font-size: 1.1rem;
            text-align: justify !important;
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

                <!-- Interactive Compact Social Share Action Bar (WA, FB, IG, Telegram, TikTok, Threads, X, Copy Link) -->
                <div class="p-3 sm:p-4 rounded-2xl bg-slate-50 dark:bg-[#07170a] border border-slate-200 dark:border-[#1a3d1e] flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xs">
                    <div class="space-y-0.5 text-center sm:text-left">
                        <span class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center justify-center sm:justify-start gap-1.5">
                            <span>🚀</span> <span>Bagikan Berita Ini:</span>
                        </span>
                        <span class="text-[10px] sm:text-[11px] text-slate-500 dark:text-slate-400 font-medium block">Sebarkan informasi kegiatan positif SIT Robbani ke media sosial</span>
                    </div>
                    
                    <!-- Icon Social Buttons (Compact Single Row Fit) -->
                    <div class="flex items-center justify-center gap-1.5 shrink-0">
                        <!-- WhatsApp -->
                        <a href="https://api.whatsapp.com/send?text={{ urlencode($news['title'] . ' ' . request()->fullUrl()) }}" target="_blank" title="Bagikan ke WhatsApp" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-[#25D366] hover:bg-[#1fa951] text-white flex items-center justify-center shadow-xs hover:scale-110 transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.157 4.228 4.278-1.121z"/></svg>
                        </a>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" title="Bagikan ke Facebook" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-[#1877F2] hover:bg-[#145dbb] text-white flex items-center justify-center shadow-xs hover:scale-110 transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>

                        <!-- Instagram -->
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link disalin! Buka Instagram dan tempel di Story / Bio Anda.');" title="Bagikan ke Instagram" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center shadow-xs hover:scale-110 transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </button>

                        <!-- Telegram -->
                        <a href="https://t.me/share/url?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news['title']) }}" target="_blank" title="Bagikan ke Telegram" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-[#229ED9] hover:bg-[#1c80b0] text-white flex items-center justify-center shadow-xs hover:scale-110 transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.16.16-.295.295-.605.295l.213-3.053 5.56-5.023c.242-.213-.054-.333-.373-.121l-6.871 4.326-2.962-.924c-.643-.204-.657-.643.136-.953l11.57-4.461c.537-.196 1.006.128.832.941z"/></svg>
                        </a>

                        <!-- TikTok -->
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link disalin! Buka TikTok dan bagikan ke teman Anda.');" title="Bagikan ke TikTok" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-[#000000] hover:bg-slate-900 text-white flex items-center justify-center shadow-xs hover:scale-110 transition-all border border-slate-800">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.67 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.82.57-1.31 1.56-1.3 2.56.02 1.03.58 1.98 1.46 2.47.88.5 2 .48 2.85-.02.77-.47 1.25-1.35 1.26-2.25.02-4.8.01-9.6.01-14.4z"/></svg>
                        </button>

                        <!-- Threads -->
                        <a href="https://www.threads.net/intent/post?text={{ urlencode($news['title'] . ' ' . request()->fullUrl()) }}" target="_blank" title="Bagikan ke Threads" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-[#000000] hover:bg-slate-900 text-white flex items-center justify-center shadow-xs hover:scale-110 transition-all border border-slate-800">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.186 24h-.007c-3.582-.024-6.333-1.254-8.176-3.657C2.295 18.2 1.5 15.244 1.5 11.83 1.5 8.397 2.292 5.43 3.988 3.321 5.82 1.034 8.57 0 12.18 0c3.55 0 6.275 1.01 8.098 3.003 1.706 1.865 2.522 4.478 2.522 7.842v1.272c0 2.27-.584 4.093-1.737 5.418-1.127 1.295-2.73 1.986-4.762 1.986-1.748 0-3.178-.54-4.25-1.605-1.074-1.066-1.62-2.527-1.62-4.342 0-1.808.544-3.267 1.616-4.337 1.07-1.068 2.497-1.61 4.24-1.61 1.294 0 2.428.32 3.37.952.126-1.716-.277-3.012-1.198-3.854-.925-.845-2.355-1.273-4.25-1.273-2.617 0-4.526.688-5.674 2.046-1.07 1.266-1.583 3.19-1.583 5.717 0 2.54.512 4.47 1.583 5.736 1.15 1.358 3.057 2.046 5.674 2.046 1.702 0 3.177-.32 4.382-.952.164 1.344.02 2.378-.426 3.076-.59.92-1.652 1.386-3.16 1.386-1.505 0-2.564-.466-3.15-1.386-.184-.288-.337-.645-.457-1.07l-2.072.563c.204.815.516 1.5.934 2.054 1.026 1.36 2.68 2.05 4.917 2.05 2.235 0 3.89-.69 4.918-2.05.772-.888 1.168-2.18 1.168-3.84v-1.27c0-2.774-.63-4.887-1.874-6.28C17.387 2.87 15.116 2.04 12.18 2.04c-2.935 0-5.206.83-6.748 2.467-1.42 1.507-2.13 3.738-2.13 6.63 0 2.893.71 5.124 2.13 6.63 1.542 1.637 3.813 2.467 6.748 2.467 1.688 0 3.167-.325 4.394-.966.19 1.378.026 2.443-.492 3.166-.69 1.07-1.92 1.614-3.656 1.614-1.737 0-2.966-.544-3.656-1.614-.23-.357-.403-.787-.517-1.29l-2.07.562c.204.872.548 1.603 1.032 2.193z"/></svg>
                        </a>

                        <!-- X / Twitter -->
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($news['title']) }}&url={{ urlencode(request()->fullUrl()) }}" target="_blank" title="Bagikan ke X (Twitter)" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-[#000000] hover:bg-slate-900 text-white flex items-center justify-center shadow-xs hover:scale-110 transition-all border border-slate-800">
                            <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>

                        <!-- Copy Direct Link (Pure SVG Icon) -->
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berita berhasil disalin ke clipboard!');" title="Salin Tautan" class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-slate-700 hover:bg-slate-800 text-white flex items-center justify-center shadow-xs hover:scale-110 transition-all">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M16 1H8C6.9 1 6 1.9 6 3v1H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-1h2c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-2V3c0-1.1-.9-2-2-2zm-6 2h4v2h-4V3zm6 17H4V6h2v12h10v2zm2-3H8V6h10v11z"/></svg>
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
                            Dipublikasikan oleh Tim Media &amp; Humas Resmi SIT Robbani Ogan Ilir untuk mengabarkan kegiatan akademik, tahfidz, dan prestasi siswa.
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
                            🏆 Prestasi Siswa
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
                        <h4 class="text-base sm:text-lg font-black font-headline tracking-tight leading-tight">Pendaftaran Siswa Baru Telah Dibuka</h4>
                        <p class="text-[11px] sm:text-xs text-slate-200 font-medium leading-relaxed">
                            Penerimaan siswa baru KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani Ogan Ilir tahun ajaran 2026/2027.
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
