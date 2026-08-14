<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Artikel Keislaman & Edukasi | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #071208; color: #f7fee7; }
        .btn-lime-primary { background-color: #c6f634 !important; color: #071208 !important; font-weight: 900 !important; }
        .card-dark-surface { background-color: #112413 !important; border: 1px solid #1e3c20 !important; }
    </style>
</head>
<body class="bg-[#071208] text-[#f7fee7] antialiased min-h-screen pb-24 lg:pb-0">

    <header class="bg-[#070c04] py-4 px-6 sticky top-0 z-50 border-b border-[#1c3011]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" class="h-9 bg-[#14220c] p-1 rounded-xl border border-[#264218]">
                <div>
                    <span class="font-black text-xs block text-[#a8f52c] uppercase">ARTIKEL KEISLAMAN & EDUKASI</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-300 hover:text-[#a8f52c]">← Beranda</a>
        </div>
    </header>

    <main class="py-12 max-w-6xl mx-auto px-4 space-y-8">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-[#14220c] border border-[#264218] text-[#a8f52c] font-black text-xs uppercase">LITERASI ROBBANI</span>
            <h1 class="text-3xl font-black text-white">Artikel Fiqih, Ibadah & Parenting Islami</h1>
            <p class="text-slate-400 text-sm font-medium">Panduan fiqih ibadah sunnah dan pembentukan karakter generasi Rabbani.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($articleList as $article)
            <div class="p-6 rounded-3xl card-dark-surface space-y-4 flex flex-col justify-between group">
                <div class="space-y-3">
                    <div class="h-48 rounded-2xl bg-[#070c04] overflow-hidden">
                        <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png'; this.className='w-full h-full object-contain p-4 bg-[#070c04]';">
                    </div>
                    <span class="px-2.5 py-1 rounded-md bg-[#a8f52c] text-[#070c04] font-black text-[10px] uppercase inline-block">
                        {{ $article['category'] }}
                    </span>
                    <span class="text-xs text-slate-400 font-bold block">📅 {{ $article['date'] }} • {{ $article['author'] }}</span>
                    <h3 class="text-lg font-black text-white group-hover:text-[#a8f52c] leading-snug">{{ $article['title'] }}</h3>
                    <p class="text-xs text-slate-300 leading-relaxed font-medium line-clamp-3">{{ $article['excerpt'] }}</p>
                </div>
                <div class="pt-2">
                    <a href="{{ route('school.artikel.show', $article['slug']) }}" class="inline-block px-4 py-2.5 rounded-xl btn-lime-primary font-black text-xs">
                        Baca Artikel Lengkap ➔
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
