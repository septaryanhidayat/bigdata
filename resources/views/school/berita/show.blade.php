<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news['title'] }} | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0f172a; color: #f8fafc; }
        .glass-header { background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(12px); }
        .article-card { background-color: #1e293b; border: 1px solid #334155; }
        .prose-custom p { margin-bottom: 1.25rem; line-height: 1.8; color: #cbd5e1; }
        .prose-custom strong { color: #f8fafc; font-weight: 800; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 antialiased min-h-screen pb-24 lg:pb-12">

    <!-- Sticky Glassmorphism Header Bar -->
    <header class="glass-header py-4 px-4 sm:px-6 sticky top-0 z-50 border-b border-slate-800 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="/images/logo robbani dark.png" class="h-9 w-auto object-contain" alt="Logo SIT Robbani" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                <div>
                    <span class="font-black text-xs block text-emerald-400 uppercase tracking-wider">PORTAL BERITA RESMI</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-extrabold text-xs transition-colors border border-slate-700 hidden sm:inline-flex items-center gap-1">
                    🏠 Beranda
                </a>
                <a href="{{ route('school.berita') }}" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-sm transition-colors flex items-center gap-1">
                    ← Semua Berita
                </a>
            </div>
        </div>
    </header>

    <main class="py-8 sm:py-12 max-w-4xl mx-auto px-4 space-y-8">
        
        <!-- Breadcrumb & Category Badge -->
        <div class="space-y-4">
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('home') }}" class="text-xs font-bold text-slate-400 hover:text-emerald-400">Beranda</a>
                <span class="text-slate-600">•</span>
                <a href="{{ route('school.berita') }}" class="text-xs font-bold text-slate-400 hover:text-emerald-400">Berita</a>
                <span class="text-slate-600">•</span>
                <span class="px-3 py-1 rounded-full text-xs font-black text-white uppercase shadow-sm {{ ($news['category'] ?? '') == 'KB/TKIT' ? 'bg-emerald-600' : (($news['category'] ?? '') == 'SDIT' ? 'bg-orange-600' : (($news['category'] ?? '') == 'SMPIT' ? 'bg-blue-600' : (($news['category'] ?? '') == 'SMAIT' ? 'bg-purple-600' : 'bg-emerald-700'))) }}">
                    {{ $news['category'] ?? 'Berita' }}
                </span>
            </div>

            <!-- News Title -->
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white leading-tight tracking-tight">
                {{ $news['title'] }}
            </h1>

            <!-- Author & Metadata Row -->
            <div class="flex flex-wrap items-center gap-4 text-xs font-bold text-slate-400 border-y border-slate-800 py-3.5">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-emerald-600 text-white font-black flex items-center justify-center text-[10px] shadow-xs">
                        {{ strtoupper(substr($news['author'] ?? 'Humas', 0, 2)) }}
                    </div>
                    <span class="text-slate-200">{{ $news['author'] ?? 'Humas SIT Robbani' }}</span>
                </div>
                <span>•</span>
                <span>🗓️ {{ $news['date'] }}</span>
                <span>•</span>
                <span>⏱️ 3 Menit Baca</span>
                <span>•</span>
                <span>📍 Ogan Ilir, Sumsel</span>
            </div>
        </div>

        <!-- Featured Image Frame -->
        <div class="rounded-3xl overflow-hidden article-card shadow-lg relative">
            <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full max-h-[480px] object-cover" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full p-8 object-contain bg-white';">
            <div class="p-3 bg-slate-950/80 border-t border-slate-800 text-[11px] text-slate-400 text-center font-medium">
                📷 Dokumentasi resmi kegiatan {{ $news['category'] ?? 'SIT Robbani' }} Ogan Ilir.
            </div>
        </div>

        <!-- Article Content Box -->
        <article class="p-6 sm:p-10 rounded-3xl article-card text-slate-200 text-sm sm:text-base leading-relaxed space-y-4 font-medium prose-custom shadow-md">
            {!! $news['content'] !!}
        </article>

        <!-- Social Share Bar -->
        <div class="p-5 rounded-2xl bg-slate-800/80 border border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-xs font-black text-white uppercase tracking-wider flex items-center gap-2">
                <span>📢</span> Bagikan Berita Ini:
            </span>
            <div class="flex items-center gap-2">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($news['title'] . ' ' . request()->fullUrl()) }}" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-colors flex items-center gap-1">
                    <span>🟢 WhatsApp</span>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-sm transition-colors flex items-center gap-1">
                    <span>🔵 Facebook</span>
                </a>
                <button onclick="navigator.clipboard.writeText(window.location.href); alert('Link berita berhasil disalin!');" class="px-4 py-2 rounded-xl bg-slate-700 hover:bg-slate-600 text-white font-bold text-xs shadow-sm transition-colors flex items-center gap-1">
                    <span>🔗 Salin Link</span>
                </button>
            </div>
        </div>

        <!-- Related News Grid -->
        <div class="pt-6 border-t border-slate-800 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-black text-white flex items-center gap-2">
                    <span>📰</span> Berita &amp; Kegiatan Lainnya
                </h3>
                <a href="{{ route('school.berita') }}" class="text-xs font-bold text-emerald-400 hover:underline">Lihat Semua ➔</a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($recentNews as $rn)
                <a href="{{ route('school.berita.show', $rn['slug'] ?? \Illuminate\Support\Str::slug($rn['title'])) }}" class="p-4 rounded-2xl article-card hover:border-emerald-500 transition-all block group space-y-3 shadow-sm">
                    <div class="relative h-32 rounded-xl overflow-hidden bg-slate-900">
                        <img src="{{ $rn['image'] }}" alt="{{ $rn['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full h-full object-contain p-3 bg-white';">
                        <span class="absolute top-2 left-2 bg-emerald-700 text-white px-2 py-0.5 rounded text-[9px] font-black uppercase">{{ $rn['category'] ?? 'Berita' }}</span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 block">🗓️ {{ $rn['date'] }}</span>
                        <h4 class="text-xs font-black text-white group-hover:text-emerald-400 line-clamp-2 leading-snug">{{ $rn['title'] }}</h4>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-8 text-center border-t border-slate-800">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
