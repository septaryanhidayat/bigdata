<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita & Pengumuman | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .theme-btn-primary { background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important; color: #ffffff !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">

    <!-- Header Navbar -->
    <header class="bg-slate-950 text-white py-4 px-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" class="h-9 bg-white p-1 rounded-xl">
                <div>
                    <span class="font-black text-xs block text-amber-300 uppercase">BERITA & PENGUMUMAN</span>
                    <span class="text-[10px] text-emerald-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold hover:text-amber-300">← Kembali ke Beranda</a>
        </div>
    </header>

    <!-- Content -->
    <main class="py-16 max-w-7xl mx-auto px-4 space-y-10">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs uppercase">KABAR KAMPUS & ROBBANI NEWS</span>
            <h1 class="text-3xl font-black text-slate-900">Berita, Kegiatan & Pengumuman Terbaru</h1>
            <p class="text-slate-600 text-sm font-medium">Seputar prestasi siswa, agenda Haflah wisuda, qurban, dan pengumuman resmi SIT Robbani Ogan Ilir.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($newsList as $news)
            <div class="rounded-3xl bg-white border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl transition-all flex flex-col justify-between group">
                <div>
                    <div class="relative h-48 bg-slate-200 overflow-hidden">
                        <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png'; this.className='w-full h-full object-contain p-4 bg-slate-900';">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-black text-[10px] uppercase shadow-md">
                            {{ $news['category'] }}
                        </span>
                    </div>
                    <div class="p-5 space-y-3">
                        <span class="text-[11px] font-bold text-slate-400 block">📅 {{ $news['date'] }} • {{ $news['author'] ?? 'Humas' }}</span>
                        <h3 class="text-sm font-black text-slate-900 line-clamp-2 group-hover:text-emerald-700 transition-colors leading-snug">
                            {{ $news['title'] }}
                        </h3>
                        <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed font-medium">
                            {{ $news['excerpt'] }}
                        </p>
                    </div>
                </div>
                <div class="p-5 pt-0">
                    <a href="{{ route('school.berita.show', $news['slug'] ?? \Illuminate\Support\Str::slug($news['title'])) }}" class="inline-flex items-center gap-1 text-xs font-black text-emerald-700 hover:underline">
                        <span>Baca Berita Selengkapnya</span>
                        <span>➔</span>
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
