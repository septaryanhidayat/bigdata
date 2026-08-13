<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Artikel Keislaman & Edukasi | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">

    <header class="bg-slate-950 text-white py-4 px-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" class="h-9 bg-white p-1 rounded-xl">
                <div>
                    <span class="font-black text-xs block text-amber-300 uppercase">ARTIKEL KEISLAMAN & EDUKASI</span>
                    <span class="text-[10px] text-emerald-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold hover:text-amber-300">← Kembali ke Beranda</a>
        </div>
    </header>

    <main class="py-16 max-w-6xl mx-auto px-4 space-y-10">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs uppercase">LITERASI ROBBANI</span>
            <h1 class="text-3xl font-black text-slate-900">Artikel Fiqih, Ibadah & Parenting Islami</h1>
            <p class="text-slate-600 text-sm font-medium">Panduan fiqih ibadah sunnah, pembentukan karakter anak Rabbani, dan tips parenting Islami.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($articleList as $article)
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-xl transition-all space-y-4 flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="h-48 rounded-2xl bg-slate-100 overflow-hidden">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png'; this.className='w-full h-full object-contain p-4 bg-slate-900';">
                    </div>
                    <span class="px-2.5 py-1 rounded-md bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase inline-block">
                        {{ $article['category'] }}
                    </span>
                    <span class="text-xs text-slate-400 font-bold block">📅 {{ $article['date'] }} • {{ $article['author'] }}</span>
                    <h3 class="text-lg font-black text-slate-900 group-hover:text-emerald-700 leading-snug">{{ $article['title'] }}</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-medium line-clamp-3">{{ $article['excerpt'] }}</p>
                </div>
                <div class="pt-2">
                    <a href="{{ route('school.artikel.show', $article['slug']) }}" class="inline-block px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition-colors">
                        Baca Artikel Lengkap ➔
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <footer class="bg-slate-950 text-slate-400 text-xs py-8 text-center border-t border-slate-900">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
