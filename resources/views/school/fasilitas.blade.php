<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fasilitas Sekolah | {{ $settings['school_name'] }}</title>
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
                    <span class="font-black text-xs block text-amber-300 uppercase">FASILITAS SEKOLAH</span>
                    <span class="text-[10px] text-emerald-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold hover:text-amber-300">← Kembali ke Beranda</a>
        </div>
    </header>

    <main class="py-16 max-w-7xl mx-auto px-4 space-y-12">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs uppercase">SARANA & PRASARANA UNGGULAN</span>
            <h1 class="text-3xl font-black text-slate-900">Fasilitas Pembelajaran Kondusif & Modern</h1>
            <p class="text-slate-600 text-sm font-medium">SIT Robbani Ogan Ilir dilengkapi sarana penunjang akademik, keagamaan, olahraga, dan keamanan peserta didik.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($facilityList as $fac)
            <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm hover:shadow-xl transition-all space-y-4 group">
                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl font-bold group-hover:scale-110 transition-transform">
                    {{ $fac['icon'] }}
                </div>
                <h3 class="text-xl font-black text-slate-900 group-hover:text-emerald-700 transition-colors">{{ $fac['title'] }}</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">{{ $fac['desc'] }}</p>
                <div class="pt-4 border-t border-slate-100 text-[11px] font-bold text-emerald-700 flex items-center gap-1">
                    <span>✓ Siap Digunakan Pembelajaran</span>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Banner Sewa Fasilitas -->
        <div class="p-8 rounded-3xl bg-emerald-950 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="space-y-2">
                <h3 class="text-xl font-black text-amber-300">Ingin Menyewa Fasilitas Sekolah Kami?</h3>
                <p class="text-xs text-slate-300">Aula pertemuan, lapangan olahraga, dan sarana sekolah dapat disewa untuk kegiatan resmi institusi/masyarakat.</p>
            </div>
            <a href="{{ route('school.layanan.sewa') }}" class="px-6 py-3.5 rounded-2xl bg-amber-400 text-slate-950 font-black text-xs shadow-lg hover:scale-105 transition-transform whitespace-nowrap">
                Permohonan Sewa Fasilitas ➔
            </a>
        </div>
    </main>

    <footer class="bg-slate-950 text-slate-400 text-xs py-8 text-center border-t border-slate-900">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
