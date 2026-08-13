<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Online 2026/2027 | {{ $settings['school_name'] }}</title>
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
                    <span class="font-black text-xs block text-amber-300 uppercase">PORTAL SPMB / PPDB ONLINE</span>
                    <span class="text-[10px] text-emerald-400 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold hover:text-amber-300">← Kembali ke Beranda</a>
        </div>
    </header>

    <main class="py-12 max-w-4xl mx-auto px-4 space-y-8">
        
        <div class="text-center space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs uppercase">PENERIMAAN PESERTA DIDIK BARU</span>
            <h1 class="text-3xl font-black text-slate-900">Formulir Pendaftaran PPDB T.A 2026/2027</h1>
            <p class="text-slate-600 text-sm font-medium">Ayo menjadi bagian dari SIT Robbani Ogan Ilir untuk jenjang KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani.</p>
        </div>

        @if(session('success'))
        <div class="p-6 rounded-3xl bg-emerald-950 text-white border border-emerald-800 space-y-2 shadow-2xl">
            <span class="px-3 py-1 bg-emerald-500 text-slate-950 font-black text-xs rounded-full inline-block">PENDAFTARAN BERHASIL</span>
            <p class="text-sm text-slate-200 leading-relaxed font-medium">{{ session('success') }}</p>
        </div>
        @endif

        <form action="{{ route('school.ppdb.store') }}" method="POST" class="p-8 rounded-3xl bg-white border border-slate-200 shadow-xl space-y-6">
            @csrf
            
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 space-y-1">
                <span class="text-xs font-black text-emerald-900 block">📌 Pilihan Jenjang Unit Sekolah *</span>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                    @foreach($schools as $sc)
                    <label class="p-3 rounded-xl bg-white border border-slate-200 hover:border-emerald-500 cursor-pointer flex items-center gap-2">
                        <input type="radio" name="school_code" value="{{ strtolower($sc->code) }}" required class="accent-emerald-600">
                        <span class="text-xs font-black text-slate-900">{{ $sc->code }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-sm font-black text-slate-900 border-b pb-2 border-slate-200">1. Data Ananda (Calon Siswa)</h3>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-800 uppercase">Nama Lengkap Ananda *</label>
                    <input type="text" name="nama_lengkap" required placeholder="Nama sesuai akta kelahiran" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-800 uppercase">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-800 uppercase">Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" required placeholder="Kota lahir" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-800 uppercase">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-slate-200">
                <h3 class="text-sm font-black text-slate-900 border-b pb-2 border-slate-200">2. Data Orang Tua / Wali</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-800 uppercase">Nama Lengkap Orang Tua / Wali *</label>
                        <input type="text" name="nama_ortu" required placeholder="Nama Ayah / Ibu" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-800 uppercase">No. WhatsApp Orang Tua *</label>
                        <input type="text" name="no_hp_ortu" required placeholder="081234567890" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-800 uppercase">Alamat Domisili Lengkap *</label>
                    <textarea name="alamat" rows="3" required placeholder="Kecamatan, Kabupaten Ogan Ilir, Sumatera Selatan..." class="w-full px-4 py-3 rounded-xl border border-slate-300 text-xs font-semibold focus:outline-none focus:border-emerald-600"></textarea>
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl theme-btn-primary font-black text-xs uppercase shadow-xl hover:scale-[1.01] transition-transform">
                Submit Formulir PPDB Online ➔
            </button>
        </form>

    </main>

    <footer class="bg-slate-950 text-slate-400 text-xs py-8 text-center border-t border-slate-900">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
