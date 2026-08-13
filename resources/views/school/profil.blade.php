<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Resmi | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s, color 0.3s; }
        .btn-dark-lime { background-color: #a8f52c !important; color: #070c04 !important; }
        .btn-light-emerald { background-color: #059669 !important; color: #ffffff !important; }
    </style>
</head>
<body :class="darkMode ? 'bg-[#0b1206] text-lime-50' : 'bg-slate-50 text-slate-900'" class="antialiased min-h-screen pb-24 lg:pb-0">

    <header :class="darkMode ? 'bg-[#070c04] border-[#1c3011]' : 'bg-white border-slate-200'" class="py-4 px-6 sticky top-0 z-50 border-b shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png" class="h-9 bg-slate-900 p-1 rounded-xl">
                <div>
                    <span :class="darkMode ? 'text-[#a8f52c]' : 'text-[#059669]'" class="font-black text-xs block uppercase">PROFIL YAYASAN</span>
                    <span :class="darkMode ? 'text-slate-300' : 'text-slate-500'" class="text-[10px] font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <div class="flex items-center gap-4 text-xs font-bold">
                <button @click="darkMode = !darkMode" class="px-3 py-1 rounded-xl bg-slate-200 dark:bg-white/10 text-xs">
                    <span x-show="!darkMode">🌙 Mode Gelap</span>
                    <span x-show="darkMode" x-cloak>☀️ Mode Terang</span>
                </button>
                <a href="{{ route('home') }}" class="hover:text-[#059669] dark:hover:text-[#a8f52c]">← Beranda</a>
                <a href="{{ route('school.ppdb') }}" :class="darkMode ? 'btn-dark-lime' : 'btn-light-emerald'" class="px-3.5 py-1.5 rounded-xl font-black">Daftar PPDB ➔</a>
            </div>
        </div>
    </header>

    <main class="py-12 max-w-5xl mx-auto px-4 space-y-10">
        <div class="text-center space-y-3">
            <span :class="darkMode ? 'bg-[#14220c] border-[#264218] text-[#a8f52c]' : 'bg-emerald-100 border-emerald-200 text-[#059669]'" class="px-3.5 py-1 rounded-full border font-black text-xs uppercase">ORGANISASI & YAYASAN</span>
            <h1 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-3xl sm:text-4xl font-black">Yayasan Generasi Robbani Sumatera Selatan</h1>
            <p :class="darkMode ? 'text-slate-400' : 'text-slate-600'" class="text-sm font-medium">KB/TKIT, SDIT, SMPIT, dan SMAIT Robbani Ogan Ilir</p>
        </div>

        <div :class="darkMode ? 'bg-[#14220c] border-[#264218]' : 'bg-white border-slate-200 shadow-sm'" class="p-8 rounded-[2rem] border space-y-6">
            <h2 :class="darkMode ? 'text-[#a8f52c]' : 'text-[#059669]'" class="text-xl font-black border-b pb-3 border-slate-200/20">Tentang Yayasan</h2>
            <p :class="darkMode ? 'text-slate-300' : 'text-slate-700'" class="text-sm leading-relaxed font-medium">
                Yayasan Generasi Robbani Sumatera Selatan adalah lembaga pendidikan dan sosial keislaman terpadu yang berpusat di Kabupaten Ogan Ilir, Sumatera Selatan. Yayasan membawahi empat unit pendidikan unggulan: **KB/TKIT Robbani**, **SDIT Robbani**, **SMPIT Robbani**, dan **SMAIT Robbani**.
            </p>
            <p :class="darkMode ? 'text-slate-300' : 'text-slate-700'" class="text-sm leading-relaxed font-medium">
                SIT Robbani Ogan Ilir menyinergikan Kurikulum Merdeka, Kekhasan Jaringan Sekolah Islam Terpadu (JSIT), Program Tahfidz Al-Qur'an, Bina Pribadi Islami (BPI), serta Ekosistem Digital Terpadu.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div :class="darkMode ? 'bg-[#a8f52c] text-[#070c04]' : 'bg-[#059669] text-white'" class="p-8 rounded-[2rem] space-y-4 shadow-xl">
                <span class="text-3xl">🎯</span>
                <h3 class="text-xl font-black">Visi Yayasan</h3>
                <p class="text-xs leading-relaxed font-semibold">
                    "Menjadi Lembaga Pendidikan Islam Terpadu Pilihan Utama di Sumatera Selatan yang Mencetak Generasi Rabbani Beriman, Hafidz Al-Qur'an, Berakhlak Karimah, Unggul Akademik, dan Siap Memimpin di Era Digital."
                </p>
            </div>

            <div :class="darkMode ? 'bg-[#14220c] border-[#264218]' : 'bg-white border-slate-200 shadow-sm'" class="p-8 rounded-[2rem] border space-y-4">
                <span class="text-3xl">🚀</span>
                <h3 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-xl font-black">Misi Utama</h3>
                <ul :class="darkMode ? 'text-slate-300' : 'text-slate-700'" class="space-y-2 text-xs font-medium">
                    <li class="flex items-start gap-2">
                        <span :class="darkMode ? 'text-[#a8f52c]' : 'text-[#059669]'" class="font-bold">1.</span> Menyediakan pendidikan terpadu berstandar JSIT dari jenjang usia dini hingga menengah atas.
                    </li>
                    <li class="flex items-start gap-2">
                        <span :class="darkMode ? 'text-[#a8f52c]' : 'text-[#059669]'" class="font-bold">2.</span> Membina kecintaan siswa terhadap Al-Qur'an melalui target hafalan dan pemahaman adab.
                    </li>
                    <li class="flex items-start gap-2">
                        <span :class="darkMode ? 'text-[#a8f52c]' : 'text-[#059669]'" class="font-bold">3.</span> Mengembangkan kecerdasan digital, kepemimpinan, dan kemandirian berprestasi.
                    </li>
                </ul>
            </div>
        </div>

        <div class="space-y-6">
            <h2 :class="darkMode ? 'text-white' : 'text-slate-900'" class="text-2xl font-black">Unit Sekolah Under Yayasan</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($schools as $sc)
                <div :class="darkMode ? 'bg-[#14220c] border-[#264218]' : 'bg-white border-slate-200 shadow-sm'" class="p-5 rounded-3xl border space-y-3">
                    <span :class="darkMode ? 'bg-[#a8f52c] text-[#070c04]' : 'bg-[#059669] text-white'" class="px-2.5 py-1 rounded-lg text-xs font-black inline-block">
                        {{ $sc->code }}
                    </span>
                    <h4 :class="darkMode ? 'text-white' : 'text-slate-900'" class="font-black text-sm">{{ $sc->name }}</h4>
                    <p :class="darkMode ? 'text-slate-400' : 'text-slate-500'" class="text-xs font-medium">Kepsek: {{ $sc->principal_name }}</p>
                    <a href="{{ route('school.unit', strtolower($sc->code)) }}" :class="darkMode ? 'text-[#a8f52c]' : 'text-[#059669]'" class="text-xs font-black hover:underline block pt-2">Lihat Profil Unit ➔</a>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <footer :class="darkMode ? 'bg-[#070c04] border-[#1c3011] text-slate-400' : 'bg-slate-900 text-slate-300 border-slate-800'" class="text-xs py-8 border-t">
        <div class="max-w-5xl mx-auto px-4 text-center space-y-3">
            <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
            <a href="https://berandadigital.net" target="_blank" :class="darkMode ? 'text-[#a8f52c]' : 'text-emerald-400'" class="hover:underline flex items-center justify-center gap-1 font-bold">
                <span>Powered by Beranda Teknologi Digital</span>
                <span>➔</span>
            </a>
        </div>
    </footer>

</body>
</html>
