<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-SPP & Portal ARSI Mobile | {{ $settings['school_name'] }}</title>
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
                <img src="/images/logo robbani dark.png" class="h-9 w-auto object-contain" alt="Logo SIT Robbani">
                <div>
                    <span class="font-black text-xs block text-[#a8f52c] uppercase">PORTAL E-SPP & ARSI MOBILE</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-300 hover:text-[#a8f52c]">← Beranda</a>
        </div>
    </header>

    <main class="py-12 max-w-4xl mx-auto px-4 space-y-8">
        
        <div class="text-center space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-[#14220c] border border-[#264218] text-[#a8f52c] font-black text-xs uppercase">ROBBANI STUDENT INFORMATION</span>
            <h1 class="text-3xl font-black text-white">Cek Tagihan & Informasi SPP Realtime</h1>
            <p class="text-slate-400 text-sm font-medium">Masukkan NISN atau Nomor Induk Siswa untuk mengecek rincian tagihan SPP dan riwayat pembayaran.</p>
        </div>

        <form action="{{ route('school.espp') }}" method="GET" class="p-8 rounded-[2rem] card-dark-surface space-y-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="nisn" value="{{ request('nisn') }}" required placeholder="Masukkan NIS / NISN Siswa..." class="flex-1 px-4 py-3.5 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-bold text-white focus:outline-none focus:border-[#a8f52c]">
                <button type="submit" class="px-6 py-3.5 rounded-xl btn-lime-primary font-black text-xs uppercase tracking-wider shadow-md hover:scale-105 transition-transform">
                    Cek Status SPP ➔
                </button>
            </div>
        </form>

        @if(request()->has('nisn'))
            @if($student)
            <div class="p-6 rounded-[2rem] card-dark-surface space-y-4">
                <div class="flex items-center justify-between border-b pb-3 border-[#264218]">
                    <div>
                        <h3 class="font-black text-base text-white">{{ $student->name }}</h3>
                        <span class="text-xs text-slate-400 font-bold">NISN: {{ $student->nisn }} • Unit: {{ $student->school->code ?? 'SIT Robbani' }}</span>
                    </div>
                    <span class="px-3 py-1 bg-[#a8f52c] text-[#070c04] font-black text-xs rounded-full">SISWA AKTIF</span>
                </div>

                <div class="space-y-3">
                    <h4 class="text-xs font-black text-[#a8f52c] uppercase">Rincian Tagihan SPP:</h4>
                    @if($bills->count() > 0)
                        <div class="space-y-2">
                            @foreach($bills as $bill)
                            <div class="p-4 rounded-xl bg-[#070c04] border border-[#264218] flex items-center justify-between">
                                <div>
                                    <span class="block text-xs font-bold text-white">{{ $bill->month }} {{ $bill->year }}</span>
                                    <span class="text-[11px] text-slate-400 font-medium">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                                </div>
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-black uppercase {{ $bill->status == 'lunas' ? 'bg-[#a8f52c] text-[#070c04]' : 'bg-red-500 text-white' }}">
                                    {{ $bill->status }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-slate-400 italic">Tidak ada rincian tagihan SPP terpisah. Seluruh pembayaran terdata lunas.</p>
                    @endif
                </div>
            </div>
            @else
            <div class="p-6 rounded-[2rem] bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs font-bold text-center space-y-1">
                <p>Data siswa dengan NISN / NIS "{{ request('nisn') }}" tidak ditemukan.</p>
                <p class="text-[11px] font-normal text-amber-200">Silakan hubungi Tata Usaha atau WhatsApp Hotline 0811747472.</p>
            </div>
            @endif
        @endif

    </main>

    <footer class="bg-[#070c04] text-slate-400 text-xs py-8 text-center border-t border-[#1c3011]">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
