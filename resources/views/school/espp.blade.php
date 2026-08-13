<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SPP & Portal ARSI Mobile | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .theme-btn-primary { background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important; color: #ffffff !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">

    <header class="bg-slate-950 text-white py-4 px-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" class="h-9 bg-white p-1 rounded-xl">
                <div>
                    <span class="font-black text-xs block text-amber-300 uppercase">PORTAL E-SPP & ARSI MOBILE</span>
                    <span class="text-[10px] text-emerald-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold hover:text-amber-300">← Kembali ke Beranda</a>
        </div>
    </header>

    <main class="py-12 max-w-4xl mx-auto px-4 space-y-8">
        
        <div class="text-center space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs uppercase">ROBBANI STUDENT INFORMATION</span>
            <h1 class="text-3xl font-black text-slate-900">Cek Tagihan & Informasi SPP Realtime</h1>
            <p class="text-slate-600 text-sm font-medium">Masukkan NISN atau Nomor Induk Siswa untuk mengecek rincian tagihan SPP dan riwayat pembayaran.</p>
        </div>

        <form action="{{ route('school.espp') }}" method="GET" class="p-8 rounded-3xl bg-white border border-slate-200 shadow-xl space-y-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="nisn" value="{{ request('nisn') }}" required placeholder="Masukkan NIS / NISN Siswa..." class="flex-1 px-4 py-3.5 rounded-xl border border-slate-300 text-xs font-bold focus:outline-none focus:border-emerald-600">
                <button type="submit" class="px-6 py-3.5 rounded-xl theme-btn-primary font-black text-xs uppercase shadow-md hover:scale-105 transition-transform">
                    Cek Status SPP ➔
                </button>
            </div>
        </form>

        @if(request()->has('nisn'))
            @if($student)
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b pb-3 border-slate-100">
                    <div>
                        <h3 class="font-black text-base text-slate-900">{{ $student->name }}</h3>
                        <span class="text-xs text-slate-500 font-bold">NISN: {{ $student->nisn }} • Unit: {{ $student->school->code ?? 'SIT Robbani' }}</span>
                    </div>
                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 font-black text-xs rounded-full">SISWA AKTIF</span>
                </div>

                <div class="space-y-3">
                    <h4 class="text-xs font-black text-slate-900 uppercase">Rincian Tagihan SPP:</h4>
                    @if($bills->count() > 0)
                        <div class="space-y-2">
                            @foreach($bills as $bill)
                            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                                <div>
                                    <span class="block text-xs font-bold text-slate-900">{{ $bill->month }} {{ $bill->year }}</span>
                                    <span class="text-[11px] text-slate-500 font-medium">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase {{ $bill->status == 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $bill->status }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-500 italic">Tidak ada rincian tagihan SPP terpisah. Seluruh pembayaran terdata lunas.</p>
                    @endif
                </div>
            </div>
            @else
            <div class="p-6 rounded-3xl bg-amber-50 border border-amber-200 text-amber-900 text-xs font-bold text-center space-y-1">
                <p>Data siswa dengan NISN / NIS "{{ request('nisn') }}" tidak ditemukan.</p>
                <p class="text-[11px] font-normal text-amber-800">Silakan hubungi Tata Usaha atau WhatsApp Hotline 0811747472.</p>
            </div>
            @endif
        @endif

    </main>

    <footer class="bg-slate-950 text-slate-400 text-xs py-8 text-center border-t border-slate-900">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
