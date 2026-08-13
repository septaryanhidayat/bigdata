<!DOCTYPE html>
<html lang="id" class="scroll-smooth {{ $settings['website_theme'] ?? 'theme-emerald' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Resmi | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .theme-btn-primary { background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important; color: #ffffff !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">

    <!-- Navbar -->
    <header class="bg-slate-950 text-white py-4 px-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" class="h-9 bg-white p-1 rounded-xl">
                <div>
                    <span class="font-black text-xs block text-amber-300 uppercase">YAYASAN GENERASI ROBBANI</span>
                    <span class="text-[10px] text-emerald-400 font-bold block">SUMATERA SELATAN</span>
                </div>
            </a>
            <div class="flex items-center gap-4 text-xs font-bold">
                <a href="{{ route('home') }}" class="hover:text-amber-300">← Kembali ke Beranda</a>
                <a href="{{ route('school.ppdb') }}" class="px-3 py-1.5 rounded-xl theme-btn-primary">Daftar PPDB ➔</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-16 max-w-5xl mx-auto px-4 space-y-12">
        
        <!-- Header Title -->
        <div class="text-center space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs tracking-wider uppercase">PROFIL ORGANISASI & YAYASAN</span>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900">Yayasan Generasi Robbani Sumatera Selatan</h1>
            <p class="text-slate-600 text-sm font-medium">SIT Robbani Ogan Ilir (KB/TKIT, SDIT, SMPIT, SMAIT)</p>
        </div>

        <!-- Profil Overview -->
        <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-xl space-y-6">
            <h2 class="text-xl font-black text-slate-900 border-b pb-3 border-slate-100">Tentang Yayasan</h2>
            <p class="text-slate-600 text-sm leading-relaxed font-medium">
                Yayasan Generasi Robbani Sumatera Selatan adalah lembaga pendidikan dan sosial keislaman yang berpusat di Kabupaten Ogan Ilir, Sumatera Selatan. Yayasan membawahi empat unit pendidikan terpadu unggulan: **KB/TKIT Robbani**, **SDIT Robbani**, **SMPIT Robbani**, dan **SMAIT Robbani**.
            </p>
            <p class="text-slate-600 text-sm leading-relaxed font-medium">
                Dengan mengusung komitmen *Pendidikan Karakter Islami & Keunggulan Akademik Digital*, SIT Robbani menyinergikan Kurikulum Merdeka, Kekhasan Jaringan Sekolah Islam Terpadu (JSIT), Program Tahfidz Al-Qur'an, Bina Pribadi Islami (BPI), serta Ekosistem Digital Terpadu.
            </p>
        </div>

        <!-- Visi & Misi Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="p-8 rounded-3xl bg-emerald-950 text-white space-y-4 shadow-xl">
                <span class="text-3xl">🎯</span>
                <h3 class="text-xl font-black text-amber-300">Visi Yayasan</h3>
                <p class="text-xs text-slate-200 leading-relaxed font-medium">
                    "Menjadi Lembaga Pendidikan Islam Terpadu Pilihan Utama di Sumatera Selatan yang Mencetak Generasi Rabbani Beriman, Hafidz Al-Qur'an, Berakhlak Karimah, Unggul Akademik, dan Siap Memimpin di Era Digital."
                </p>
            </div>

            <div class="p-8 rounded-3xl bg-white border border-slate-200 space-y-4 shadow-xl">
                <span class="text-3xl">🚀</span>
                <h3 class="text-xl font-black text-slate-900">Misi Utama</h3>
                <ul class="space-y-2 text-xs text-slate-600 font-medium">
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-600 font-bold">1.</span> Menyediakan pendidikan terpadu berstandar JSIT dari jenjang usia dini hingga menengah atas.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-600 font-bold">2.</span> Membina kecintaan siswa terhadap Al-Qur'an melalui target hafalan dan pemahaman adab.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-600 font-bold">3.</span> Mengembangkan kecerdasan digital, kepemimpinan, dan kemandirian berprestasi.
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-emerald-600 font-bold">4.</span> Menjalin kemitraan erat bersama wali murid, masyarakat, dan pemerintah daerah.
                    </li>
                </ul>
            </div>
        </div>

        <!-- 4 Unit Schools List -->
        <div class="space-y-6">
            <h2 class="text-2xl font-black text-slate-900">Unit Pendidikan Under Yayasan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($schools as $sc)
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm space-y-3">
                    <span class="px-2.5 py-1 rounded-lg text-xs font-black text-white inline-block" style="background-color: {{ $sc->theme_color }}">
                        {{ $sc->code }}
                    </span>
                    <h4 class="font-black text-sm text-slate-900">{{ $sc->name }}</h4>
                    <p class="text-xs text-slate-500 font-medium">Kepsek: {{ $sc->principal_name }}</p>
                    <a href="{{ route('school.unit', strtolower($sc->code)) }}" class="text-xs font-black text-emerald-700 hover:underline block pt-2">Lihat Profil Unit ➔</a>
                </div>
                @endforeach
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 text-slate-400 text-xs py-8 text-center border-t border-slate-900">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

</body>
</html>
