<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB Online 2026/2027 | {{ $settings['school_name'] }}</title>
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
                    <span class="font-black text-xs block text-[#a8f52c] uppercase">PORTAL SPMB / PPDB ONLINE</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-300 hover:text-[#a8f52c]">← Beranda</a>
        </div>
    </header>

    <main class="py-12 max-w-4xl mx-auto px-4 space-y-8">
        
        <div class="text-center space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-[#14220c] border border-[#264218] text-[#a8f52c] font-black text-xs uppercase">PENERIMAAN PESERTA DIDIK BARU</span>
            <h1 class="text-3xl font-black text-white">Formulir Pendaftaran PPDB T.A 2026/2027</h1>
            <p class="text-slate-400 text-sm font-medium">Ayo menjadi bagian dari SIT Robbani Ogan Ilir untuk jenjang KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani.</p>
        </div>

        @if(session('success'))
        <div class="p-6 rounded-[2rem] bg-[#a8f52c] text-[#070c04] space-y-2 shadow-2xl">
            <span class="px-3 py-1 bg-[#070c04] text-[#a8f52c] font-black text-xs rounded-full inline-block">PENDAFTARAN BERHASIL</span>
            <p class="text-sm font-bold leading-relaxed">{{ session('success') }}</p>
        </div>
        @endif

        <form action="{{ route('school.ppdb.store') }}" method="POST" class="p-8 rounded-[2rem] card-dark-surface space-y-6">
            @csrf
            
            <div class="p-5 rounded-2xl bg-[#070c04] border border-[#264218] space-y-2">
                <span class="text-xs font-black text-[#a8f52c] block uppercase">📌 Pilihan Jenjang Unit Sekolah *</span>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                    @foreach($schools as $sc)
                    <label class="p-3 rounded-xl bg-[#14220c] border border-[#264218] hover:border-[#a8f52c] cursor-pointer flex items-center gap-2">
                        <input type="radio" name="school_code" value="{{ strtolower($sc->code) }}" required class="accent-[#a8f52c]">
                        <span class="text-xs font-black text-white">{{ $sc->code }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-sm font-black text-[#a8f52c] border-b pb-2 border-[#264218]">1. Data Ananda (Calon Siswa)</h3>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-300 uppercase">Nama Lengkap Ananda *</label>
                    <input type="text" name="nama_lengkap" required placeholder="Nama sesuai akta kelahiran" class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-300 uppercase">Jenis Kelamin *</label>
                        <select name="jenis_kelamin" required class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-300 uppercase">Tempat Lahir *</label>
                        <input type="text" name="tempat_lahir" required placeholder="Kota lahir" class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-300 uppercase">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" required class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                    </div>
                </div>
            </div>

            <div class="space-y-4 pt-4 border-t border-[#264218]">
                <h3 class="text-sm font-black text-[#a8f52c] border-b pb-2 border-[#264218]">2. Data Orang Tua / Wali</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-300 uppercase">Nama Lengkap Orang Tua / Wali *</label>
                        <input type="text" name="nama_ortu" required placeholder="Nama Ayah / Ibu" class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-300 uppercase">No. WhatsApp Orang Tua *</label>
                        <input type="text" name="no_hp_ortu" required placeholder="081234567890" class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-300 uppercase">Alamat Domisili Lengkap *</label>
                    <textarea name="alamat" rows="3" required placeholder="Kecamatan, Kabupaten Ogan Ilir, Sumatera Selatan..." class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]"></textarea>
                </div>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl btn-lime-primary font-black text-xs uppercase tracking-wider shadow-xl hover:scale-[1.01] transition-transform">
                Submit Formulir PPDB Online ➔
            </button>
        </form>

    </main>

    <footer class="bg-[#070c04] text-slate-400 text-xs py-8 text-center border-t border-[#1c3011]">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
