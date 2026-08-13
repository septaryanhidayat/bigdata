<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita & Pengumuman | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0b1206; color: #f7fee7; }
        .btn-lime-primary { background-color: #a8f52c !important; color: #070c04 !important; }
        .card-dark-surface { background-color: #14220c !important; border: 1px solid #264218 !important; }
    </style>
</head>
<body class="bg-[#0b1206] text-lime-50 antialiased min-h-screen pb-24 lg:pb-0">

    <header class="bg-[#070c04] py-4 px-6 sticky top-0 z-50 border-b border-[#1c3011]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" class="h-9 bg-[#14220c] p-1 rounded-xl border border-[#264218]">
                <div>
                    <span class="font-black text-xs block text-[#a8f52c] uppercase">BERITA & PENGUMUMAN</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-300 hover:text-[#a8f52c]">← Beranda</a>
        </div>
    </header>

    <main class="py-12 max-w-7xl mx-auto px-4 space-y-8">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-[#14220c] border border-[#264218] text-[#a8f52c] font-black text-xs uppercase">KABAR KAMPUS ROBBANI</span>
            <h1 class="text-3xl font-black text-white">Berita, Kegiatan & Pengumuman</h1>
            <p class="text-slate-400 text-sm font-medium">Informasi resmi seputar Haflah, Wisuda Tahfidz, Qurban, dan prestasi SIT Robbani Ogan Ilir.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($newsList as $news)
            <div class="rounded-3xl card-dark-surface overflow-hidden flex flex-col justify-between group">
                <div>
                    <div class="relative h-48 bg-[#070c04] overflow-hidden">
                        <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png'; this.className='w-full h-full object-contain p-4 bg-[#070c04]';">
                        <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-[#a8f52c] text-[#070c04] font-black text-[10px] uppercase shadow-md">
                            {{ $news['category'] }}
                        </span>
                    </div>
                    <div class="p-5 space-y-3">
                        <span class="text-[11px] font-bold text-slate-400 block">📅 {{ $news['date'] }}</span>
                        <h3 class="text-sm font-black text-white line-clamp-2 group-hover:text-[#a8f52c] transition-colors leading-snug">
                            {{ $news['title'] }}
                        </h3>
                        <p class="text-xs text-slate-300 line-clamp-3 leading-relaxed font-medium">
                            {{ $news['excerpt'] }}
                        </p>
                    </div>
                </div>
                <div class="p-5 pt-0">
                    <a href="{{ route('school.berita.show', $news['slug'] ?? \Illuminate\Support\Str::slug($news['title'])) }}" class="inline-flex items-center gap-1 text-xs font-black text-[#a8f52c] hover:underline">
                        <span>Baca Berita Selengkapnya</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <footer class="bg-[#070c04] text-slate-400 text-xs py-8 text-center border-t border-[#1c3011]">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
