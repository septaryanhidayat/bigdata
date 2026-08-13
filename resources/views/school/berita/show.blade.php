<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news['title'] }} | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">

    <!-- Header Navbar -->
    <header class="bg-slate-950 text-white py-4 px-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" class="h-9 bg-white p-1 rounded-xl">
                <div>
                    <span class="font-black text-xs block text-amber-300 uppercase">PORTAL BERITA RESMI</span>
                    <span class="text-[10px] text-emerald-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <div class="flex items-center gap-4 text-xs font-bold">
                <a href="{{ route('school.berita') }}" class="hover:text-amber-300">← Kembali ke Berita</a>
            </div>
        </div>
    </header>

    <!-- Main Article -->
    <main class="py-12 max-w-4xl mx-auto px-4 space-y-8">
        
        <div class="space-y-4">
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs uppercase inline-block">
                {{ $news['category'] }}
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 leading-tight">
                {{ $news['title'] }}
            </h1>
            <div class="flex items-center gap-4 text-xs font-bold text-slate-500 border-b border-slate-200 pb-4">
                <span>📅 {{ $news['date'] }}</span>
                <span>✍️ {{ $news['author'] ?? 'Humas SIT Robbani' }}</span>
                <span>📍 Ogan Ilir, Sumsel</span>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="rounded-3xl overflow-hidden bg-slate-900 shadow-xl border border-slate-200">
            <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full max-h-[450px] object-cover" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png'; this.className='w-full p-8 object-contain bg-slate-950';">
        </div>

        <!-- Content Body -->
        <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm text-slate-700 text-sm sm:text-base leading-relaxed space-y-4 font-medium">
            {!! $news['content'] !!}
        </div>

        <!-- Recent News Sidebar -->
        <div class="pt-8 border-t border-slate-200 space-y-4">
            <h3 class="text-lg font-black text-slate-900">Berita Lainnya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($recentNews as $rn)
                <a href="{{ route('school.berita.show', $rn['slug'] ?? \Illuminate\Support\Str::slug($rn['title'])) }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-emerald-500 transition-all block group">
                    <span class="text-[10px] font-bold text-slate-400 block mb-1">📅 {{ $rn['date'] }}</span>
                    <h4 class="text-xs font-black text-slate-900 group-hover:text-emerald-700 line-clamp-2 leading-snug">{{ $rn['title'] }}</h4>
                </a>
                @endforeach
            </div>
        </div>

    </main>

    <footer class="bg-slate-950 text-slate-400 text-xs py-8 text-center border-t border-slate-900">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
