<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas Sekolah | {{ $settings['school_name'] }}</title>
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
                    <span class="font-black text-xs block text-[#a8f52c] uppercase">FASILITAS SEKOLAH</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-300 hover:text-[#a8f52c]">← Beranda</a>
        </div>
    </header>

    <main class="py-16 max-w-7xl mx-auto px-4 space-y-12">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-[#14220c] border border-[#264218] text-[#a8f52c] font-black text-xs uppercase">SARANA & PRASARANA UNGGULAN</span>
            <h1 class="text-3xl font-black text-white">Fasilitas Pembelajaran Modern & Kondusif</h1>
            <p class="text-slate-400 text-sm font-medium">SIT Robbani Ogan Ilir dilengkapi sarana penunjang akademik, keagamaan, olahraga, dan keamanan 24 jam.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($facilityList as $fac)
            <div class="p-8 rounded-3xl card-dark-surface space-y-4 group">
                <div class="w-16 h-16 rounded-2xl bg-[#070c04] text-[#a8f52c] border border-[#264218] flex items-center justify-center text-3xl font-bold group-hover:scale-110 transition-transform">
                    {{ $fac['icon'] }}
                </div>
                <h3 class="text-xl font-black text-white group-hover:text-[#a8f52c] transition-colors">{{ $fac['title'] }}</h3>
                <p class="text-xs text-slate-300 leading-relaxed font-medium">{{ $fac['desc'] }}</p>
                <div class="pt-4 border-t border-[#264218] text-[11px] font-bold text-[#a8f52c] flex items-center gap-1">
                    <span>✓ Siap Digunakan Pembelajaran</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Banner Sewa Fasilitas -->
        <div class="p-8 rounded-[2rem] bg-[#a8f52c] text-[#070c04] flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="space-y-2">
                <h3 class="text-xl font-black text-[#070c04]">Ingin Menyewa Fasilitas Sekolah Kami?</h3>
                <p class="text-xs text-[#0f1d08] font-semibold">Aula pertemuan, lapangan olahraga, dan sarana sekolah dapat disewa untuk kegiatan resmi institusi/masyarakat.</p>
            </div>
            <a href="{{ route('school.layanan.sewa') }}" class="px-6 py-3.5 rounded-2xl bg-[#070c04] text-[#a8f52c] font-black text-xs shadow-lg hover:scale-105 transition-transform whitespace-nowrap">
                Permohonan Sewa Fasilitas ➔
            </a>
        </div>
    </main>

    <footer class="bg-[#070c04] text-slate-400 text-xs py-8 text-center border-t border-[#1c3011]">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
