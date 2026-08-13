<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $article['title'] }} | {{ $settings['school_name'] }}</title>
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
                <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" class="h-9 bg-[#14220c] p-1 rounded-xl border border-[#264218]">
                <div>
                    <span class="font-black text-xs block text-[#a8f52c] uppercase">ARTIKEL KEISLAMAN</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('school.artikel') }}" class="text-xs font-bold text-slate-300 hover:text-[#a8f52c]">← Kembali ke Artikel</a>
        </div>
    </header>

    <main class="py-12 max-w-4xl mx-auto px-4 space-y-8">
        <div class="space-y-4">
            <span class="px-3 py-1 rounded-full bg-[#14220c] border border-[#264218] text-[#a8f52c] font-black text-xs uppercase inline-block">
                {{ $article['category'] }}
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight">
                {{ $article['title'] }}
            </h1>
            <div class="flex items-center gap-4 text-xs font-bold text-slate-400 border-b border-[#264218] pb-4">
                <span>📅 {{ $article['date'] }}</span>
                <span>✍️ {{ $article['author'] }}</span>
                <span>📍 SIT Robbani Ogan Ilir</span>
            </div>
        </div>

        <div class="rounded-3xl overflow-hidden bg-[#070c04] border border-[#264218]">
            <img src="{{ $article['image'] }}" alt="{{ $article['title'] }}" class="w-full max-h-[450px] object-cover" onerror="this.src='https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png'; this.className='w-full p-8 object-contain bg-[#070c04]';">
        </div>

        <div class="p-8 rounded-[2rem] card-dark-surface text-slate-200 text-sm sm:text-base leading-relaxed space-y-4 font-medium">
            {!! $article['content'] !!}
        </div>
    </main>

    <footer class="bg-[#070c04] text-slate-400 text-xs py-8 text-center border-t border-[#1c3011]">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
