<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news['title'] }} | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0b1206; color: #f7fee7; }
        .card-dark-surface { background-color: #14220c !important; border: 1px solid #264218 !important; }
    </style>
</head>
<body class="bg-[#0b1206] text-lime-50 antialiased min-h-screen pb-24 lg:pb-0">

    <header class="bg-[#070c04] py-4 px-6 sticky top-0 z-50 border-b border-[#1c3011]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="/images/logo robbani dark.png" class="h-9 w-auto object-contain" alt="Logo SIT Robbani">
                <div>
                    <span class="font-black text-xs block text-[#a8f52c] uppercase">PORTAL BERITA RESMI</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('school.berita') }}" class="text-xs font-bold text-slate-300 hover:text-[#a8f52c]">← Kembali ke Berita</a>
        </div>
    </header>

    <main class="py-12 max-w-4xl mx-auto px-4 space-y-8">
        <div class="space-y-4">
            <span class="px-3 py-1 rounded-full bg-[#14220c] border border-[#264218] text-[#a8f52c] font-black text-xs uppercase inline-block">
                {{ $news['category'] }}
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight">
                {{ $news['title'] }}
            </h1>
            <div class="flex items-center gap-4 text-xs font-bold text-slate-400 border-b border-[#264218] pb-4">
                <span>📅 {{ $news['date'] }}</span>
                <span>✍️ {{ $news['author'] ?? 'Humas SIT Robbani' }}</span>
                <span>📍 Ogan Ilir, Sumsel</span>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden card-dark-surface">
            <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}" class="w-full max-h-[450px] object-cover" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png'; this.className='w-full p-8 object-contain bg-white';">
        </div>

        <div class="p-8 rounded-[2rem] card-dark-surface text-slate-200 text-sm sm:text-base leading-relaxed space-y-4 font-medium">
            {!! $news['content'] !!}
        </div>

        <div class="pt-8 border-t border-[#264218] space-y-4">
            <h3 class="text-lg font-black text-white">Berita Lainnya</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                @foreach($recentNews as $rn)
                <a href="{{ route('school.berita.show', $rn['slug'] ?? \Illuminate\Support\Str::slug($rn['title'])) }}" class="p-4 rounded-2xl card-dark-surface hover:border-[#a8f52c] transition-all block group">
                    <span class="text-[10px] font-bold text-slate-400 block mb-1">📅 {{ $rn['date'] }}</span>
                    <h4 class="text-xs font-black text-white group-hover:text-[#a8f52c] line-clamp-2 leading-snug">{{ $rn['title'] }}</h4>
                </a>
                @endforeach
            </div>
        </div>
    </main>

    <footer class="bg-[#070c04] text-slate-400 text-xs py-8 text-center border-t border-[#1c3011]">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
