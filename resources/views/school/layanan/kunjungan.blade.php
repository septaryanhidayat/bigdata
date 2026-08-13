<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin Kunjungan Sekolah | {{ $settings['school_name'] }}</title>
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
                    <span class="font-black text-xs block text-amber-300 uppercase">IZIN KUNJUNGAN SEKOLAH</span>
                    <span class="text-[10px] text-emerald-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold hover:text-amber-300">← Kembali ke Beranda</a>
        </div>
    </header>

    <main class="py-12 max-w-3xl mx-auto px-4 space-y-8">
        
        <div class="text-center space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs uppercase">LAYANAN HUMAS & KUNJUNGAN</span>
            <h1 class="text-3xl font-black text-slate-900">Form Permohonan Izin Kunjungan Sekolah</h1>
            <p class="text-slate-600 text-sm font-medium">Pengajuan izin kunjungan studi banding, silaturahmi instansi, atau observasi ke SIT Robbani Ogan Ilir.</p>
        </div>

        @if(session('success'))
        <div class="p-5 rounded-2xl bg-emerald-100 border border-emerald-300 text-emerald-900 font-extrabold text-sm space-y-1 shadow-md">
            <p class="flex items-center gap-2 text-base"><span>✅</span> {{ session('success') }}</p>
        </div>
        @endif

        <form action="{{ route('school.layanan.kunjungan.store') }}" method="POST" class="p-8 rounded-3xl bg-white border border-slate-200 shadow-xl space-y-5">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-xs font-black text-slate-800 uppercase">Nama Instansi / Sekolah / Lembaga *</label>
                <input type="text" name="instansi" required placeholder="Contoh: SDIT Nurul Islam / Dinas Pendidikan" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-800 uppercase">Nama Lengkap Penanggung Jawab *</label>
                    <input type="text" name="nama_pemohon" required placeholder="Nama lengkap & gelar" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-800 uppercase">No. WhatsApp / HP *</label>
                    <input type="text" name="no_hp" required placeholder="081234567890" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-800 uppercase">Email Aktif *</label>
                    <input type="email" name="email" required placeholder="email@instansi.com" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-800 uppercase">Rencana Tanggal Kunjungan *</label>
                    <input type="date" name="tgl_kunjungan" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black text-slate-800 uppercase">Estimasi Jumlah Peserta *</label>
                <input type="number" name="jumlah_peserta" min="1" required placeholder="Contoh: 15" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black text-slate-800 uppercase">Maksud & Tujuan Kunjungan *</label>
                <textarea name="tujuan" rows="4" required placeholder="Jelaskan agenda dan topik studi banding / silaturahmi..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600"></textarea>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl theme-btn-primary font-black text-xs uppercase shadow-xl hover:scale-[1.01] transition-transform">
                Kirim Permohonan Izin Kunjungan ➔
            </button>
        </form>

    </main>

    <footer class="bg-slate-950 text-slate-400 text-xs py-8 text-center border-t border-slate-900">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
