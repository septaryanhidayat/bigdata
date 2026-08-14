<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sambutan Ketua Yayasan &amp; Profil Resmi | {{ $settings['school_name'] }}</title>
    <meta name="description" content="Profil Resmi dan Sambutan Lengkap Ketua Yayasan Generasi Robbani Sumatera Selatan. Penyelenggara KB/TKIT, SDIT, SMPIT, &amp; SMAIT Robbani Ogan Ilir.">

    <!-- Favicon & Social Sharing Meta Tags -->
    <link rel="icon" type="image/png" href="{{ !empty($settings['website_favicon']) ? $settings['website_favicon'] : '/favicon.png' }}?v=2">
    <link rel="apple-touch-icon" href="{{ !empty($settings['website_favicon']) ? $settings['website_favicon'] : '/favicon.png' }}?v=2">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sambutan Pimpinan &amp; Profil Yayasan Generasi Robbani">
    <meta property="og:description" content="Profil Resmi dan Sambutan Lengkap Ketua Yayasan Generasi Robbani Sumatera Selatan.">
    <meta property="og:image" content="{{ !empty($settings['social_share_image']) ? $settings['social_share_image'] : '/images/logo robbani light.png' }}">

    <!-- Tailwind CSS CDN with Explicit darkMode: "class" Config -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            fontFamily: {
              body: ["Plus Jakarta Sans", "sans-serif"],
              headline: ["Plus Jakarta Sans", "sans-serif"]
            }
          }
        }
      }
    </script>

    <!-- Google Fonts & Alpine.js -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#050d06] text-slate-900 dark:text-[#f0fdf4] antialiased min-h-screen flex flex-col justify-between transition-colors duration-300">

    <!-- Full-Width Navigation Header -->
    <header class="bg-white/95 dark:bg-[#050d06]/95 backdrop-blur-xl py-4 px-4 sm:px-8 lg:px-12 sticky top-0 z-50 border-b border-slate-200/90 dark:border-[#163619] shadow-sm transition-colors">
        <div class="w-full max-w-[1400px] mx-auto flex items-center justify-between gap-4">
            
            <!-- Logo Header -->
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group shrink-0" title="Kembali ke Beranda SIT Robbani">
                <img src="{{ !empty($settings['logo_light']) ? $settings['logo_light'] : '/images/logo robbani light.png' }}" class="h-10 sm:h-12 w-auto object-contain dark:hidden" alt="Logo SIT Robbani" onerror="this.src='/images/logo robbani light.png';">
                <img src="{{ !empty($settings['logo_dark']) ? $settings['logo_dark'] : '/images/logo robbani dark.png' }}" class="h-10 sm:h-12 w-auto object-contain hidden dark:block" alt="Logo SIT Robbani" onerror="this.src='/images/logo robbani dark.png';">
                <div>
                    <span class="font-black text-xs sm:text-sm block text-emerald-800 dark:text-[#a3e635] uppercase tracking-wider">PROFIL YAYASAN</span>
                    <span class="text-[10px] sm:text-xs text-slate-600 dark:text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>

            <!-- Right Header Controls -->
            <div class="flex items-center gap-3 sm:gap-4 text-xs font-extrabold">
                
                <!-- Dark Mode Toggle Button (Alpine JS) -->
                <button @click="darkMode = !darkMode" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-[#142c17] text-slate-800 dark:text-[#a3e635] border border-slate-200/90 dark:border-[#224d26] transition-all hover:scale-105 flex items-center gap-2 cursor-pointer shadow-sm">
                    <span x-show="!darkMode">🌙 Mode Gelap</span>
                    <span x-show="darkMode" x-cloak>☀️ Mode Terang</span>
                </button>
                
                <a href="{{ route('home') }}" class="text-slate-700 dark:text-slate-200 hover:text-emerald-800 dark:hover:text-[#a3e635] transition-colors hidden sm:inline-block">← Beranda</a>
                <a href="{{ route('school.ppdb') }}" class="px-4 py-2 rounded-xl bg-[#004532] dark:bg-[#a3e635] text-white dark:text-[#050d06] font-black text-xs shadow-md hover:scale-105 transition-transform">Daftar PPDB ➔</a>
            </div>
        </div>
    </header>

    <!-- Full-Width Responsive Main Container -->
    <main class="py-10 sm:py-14 w-full max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 sm:space-y-16 flex-1">
        
        <!-- Header Title Banner -->
        <div class="text-center space-y-3 max-w-4xl mx-auto">
            <span class="px-4 py-1.5 rounded-full bg-emerald-100 dark:bg-[#a3e635] text-emerald-950 dark:text-[#050d06] font-black text-xs uppercase tracking-widest inline-block border border-emerald-300 dark:border-[#a3e635] shadow-sm">
                ✨ SAMBUTAN PIMPINAN &amp; PROFIL RESMI
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
                Yayasan Generasi Robbani Sumatera Selatan
            </h1>
            <p class="text-xs sm:text-base text-slate-600 dark:text-[#a3e635] font-semibold max-w-2xl mx-auto">
                Penyelenggara Pendidikan Islam Terpadu (KB/TKIT, SDIT, SMPIT, &amp; SMAIT Robbani) Berpusat di Kecamatan Indralaya Utara, Kabupaten Ogan Ilir.
            </p>
        </div>

        <!-- 1. Sambutan Lengkap Ketua Yayasan Full-Width Box -->
        <div class="bg-white dark:bg-[#0c1a0e] rounded-3xl p-6 sm:p-10 lg:p-12 border border-slate-200/90 dark:border-[#1b3d1f] shadow-xl space-y-8 transition-colors">
            <div class="flex flex-col lg:flex-row gap-8 items-center lg:items-start border-b border-slate-200 dark:border-[#1b3d1f] pb-8">
                
                <!-- Foto Ketua Yayasan -->
                <div class="shrink-0 flex flex-col items-center text-center">
                    <div class="w-40 h-40 sm:w-48 sm:h-48 rounded-full border-4 border-emerald-600 dark:border-[#a3e635] p-1 shadow-2xl bg-white overflow-hidden relative">
                        <img src="{{ !empty($settings['principal_photo']) ? $settings['principal_photo'] : '/images/logo robbani light.png' }}" alt="{{ $settings['principal_name'] }}" class="w-full h-full object-cover rounded-full" onerror="this.src='/images/logo robbani light.png';">
                    </div>
                    <span class="mt-4 px-3.5 py-1 rounded-full bg-emerald-100 dark:bg-[#a3e635] text-emerald-950 dark:text-[#050d06] text-[10px] font-black uppercase tracking-wider shadow-sm">
                        KETUA YAYASAN
                    </span>
                    <h3 class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-2">{{ $settings['principal_name'] }}</h3>
                    <p class="text-xs text-emerald-800 dark:text-[#a3e635] font-bold max-w-[220px]">{{ $settings['principal_title'] }}</p>
                </div>

                <!-- Isi Teks Sambutan Lengkap -->
                <div class="space-y-4 text-xs sm:text-sm text-slate-700 dark:text-slate-200 leading-relaxed font-medium flex-1">
                    <h2 class="text-xl sm:text-2xl font-black text-emerald-800 dark:text-[#a3e635] border-b border-emerald-500/20 pb-2">
                        Assalamu'alaikum Warahmatullahi Wabarakatuh
                    </h2>

                    <p>
                        Alhamdulillah, puji dan syukur senantiasa kita panjatkan ke hadirat Allah SWT yang telah melimpahkan rahmat, hidayah, dan inayah-Nya kepada kita semua. Sholawat beserta salam semoga senantiasa tercurah kepada junjungan kita Nabi Besar Muhammad SAW, keluarga, sahabat, dan para pengikutnya hingga akhir zaman.
                    </p>

                    <p>
                        Selamat datang di portal resmi **Yayasan Generasi Robbani Sumatera Selatan**. Kami menyadari betul bahwa dunia pendidikan hari ini dihadapkan pada tantangan yang sangat dinamis. Era digitalisasi membawa kemajuan pesat, namun di sisi lain menuntut benteng moral dan karakter yang semakin kokoh bagi anak-anak kita.
                    </p>

                    <p>
                        Oleh karena itu, Yayasan Generasi Robbani hadir di Kabupaten Ogan Ilir membawa visi besar: **membentuk generasi rabbani yang tidak hanya cerdas secara akademik dan menguasai teknologi digital, tetapi juga kokoh aqidahnya, hafidz Al-Qur'an, dan berakhlak mulia.**
                    </p>

                    <!-- 5 Pilar Pendidikan Box -->
                    <div class="bg-emerald-50 dark:bg-[#142c17] p-5 sm:p-6 rounded-2xl border border-emerald-200 dark:border-[#224d26] space-y-3 my-4">
                        <h4 class="font-black text-emerald-950 dark:text-[#a3e635] text-xs sm:text-sm uppercase tracking-wider flex items-center gap-2">
                            <span>🏛️</span> <span>5 PILAR UTAMA KURIKULUM &amp; PENDIDIKAN SIT ROBBANI:</span>
                        </h4>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-2.5 text-xs font-bold text-slate-800 dark:text-slate-200">
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-700 dark:text-[#a3e635] font-black">✔</span> <span>1. Pembiasaan &amp; Tahfidz Al-Qur'an (Juz 30 &amp; Juz 1-5)</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-700 dark:text-[#a3e635] font-black">✔</span> <span>2. Bina Pribadi Islami (BPI) &amp; Penanaman Adab</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-700 dark:text-[#a3e635] font-black">✔</span> <span>3. Integration Kurikulum Merdeka &amp; Standar JSIT</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-emerald-700 dark:text-[#a3e635] font-black">✔</span> <span>4. Ekosistem Digital SmartEdu (RFID Gate &amp; Cashless)</span>
                            </li>
                            <li class="flex items-center gap-2 md:col-span-2">
                                <span class="text-emerald-700 dark:text-[#a3e635] font-black">✔</span> <span>5. Sinergi Komunikasi Erat Antara Sekolah &amp; Orang Tua</span>
                            </li>
                        </ul>
                    </div>

                    <p>
                        Melalui pengelolaan empat unit pendidikan terpadu dari **KB/TKIT, SDIT, SMPIT, hingga SMAIT Robbani**, kami berkomitmen memberikan pengasuhan yang hangat, profesional, dan menyenangkan (*Because, Every Child is Unique*). Semoga Allah SWT meridhoi niat tulus kita bersama.
                    </p>

                    <div class="pt-3 text-right border-t border-slate-100 dark:border-[#1b3d1f]">
                        <p class="font-bold text-slate-900 dark:text-white">Wassalamu'alaikum Warahmatullahi Wabarakatuh,</p>
                        <p class="font-black text-emerald-800 dark:text-[#a3e635] text-sm sm:text-base mt-1">{{ $settings['principal_name'] }}</p>
                        <p class="text-xs text-slate-600 dark:text-slate-300 font-semibold">{{ $settings['principal_title'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Visi, Misi, & Nilai Utama -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 pt-4">
                
                <!-- Visi Card -->
                <div class="bg-gradient-to-br from-[#004532] via-[#065f46] to-[#0f172a] text-white p-6 sm:p-8 rounded-3xl space-y-4 shadow-xl border border-emerald-700/50">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-2xl shadow-inner">🎯</div>
                    <h3 class="text-lg sm:text-xl font-black text-amber-300 dark:text-[#a3e635]">Visi Utama Yayasan</h3>
                    <p class="text-xs sm:text-sm leading-relaxed font-semibold text-emerald-50">
                        "Menjadi Lembaga Pendidikan Islam Terpadu Pilihan Utama di Sumatera Selatan yang Mencetak Generasi Rabbani Beriman, Hafidz Al-Qur'an, Berakhlak Karimah, Unggul Akademik, dan Siap Memimpin di Era Digital."
                    </p>
                </div>

                <!-- Misi Card -->
                <div class="bg-slate-50 dark:bg-[#122615] border border-slate-200 dark:border-[#204724] p-6 sm:p-8 rounded-3xl space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-[#142c17] flex items-center justify-center text-2xl shadow-inner">🚀</div>
                    <h3 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">Misi Strategis</h3>
                    <ul class="space-y-3 text-xs sm:text-sm font-medium text-slate-700 dark:text-slate-200">
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-700 dark:bg-[#a3e635] text-white dark:text-[#050d06] font-black text-[10px] flex items-center justify-center shrink-0 mt-0.5">1</span>
                            <span>Menyediakan pendidikan terpadu berstandar JSIT dari usia dini (TK) hingga jenjang menengah atas (SMA).</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-700 dark:bg-[#a3e635] text-white dark:text-[#050d06] font-black text-[10px] flex items-center justify-center shrink-0 mt-0.5">2</span>
                            <span>Membina kecintaan terhadap Al-Qur'an melalui target hafalan bertahap dan pendampingan adab islami.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <span class="w-5 h-5 rounded-full bg-emerald-700 dark:bg-[#a3e635] text-white dark:text-[#050d06] font-black text-[10px] flex items-center justify-center shrink-0 mt-0.5">3</span>
                            <span>Mengembangkan kecerdasan digital, kepemimpinan, dan kemandirian berprestasi secara berkelanjutan.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 2. Unit Sekolah Under Yayasan (4 Unit Full Width) -->
        <div class="space-y-6">
            <div class="text-center space-y-2 max-w-2xl mx-auto">
                <span class="text-emerald-800 dark:text-[#a3e635] font-black text-xs uppercase tracking-widest">UNIT PENDIDIKAN INTEGRASI</span>
                <h2 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white">4 Unit Sekolah Unggulan SIT Robbani</h2>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 font-medium">Layanan pendidikan terpadu berjenjang dari usia dini hingga jenjang menengah atas di Kabupaten Ogan Ilir.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($schools as $sc)
                <div class="bg-white dark:bg-[#0c1a0e] border border-slate-200 dark:border-[#1b3d1f] p-6 rounded-3xl space-y-3 shadow-md hover:shadow-xl transition-all flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-lg bg-[#004532] dark:bg-[#a3e635] text-white dark:text-[#050d06] text-xs font-black">
                                {{ $sc->code }}
                            </span>
                            <span class="text-[10px] text-slate-400 font-bold">OGAN ILIR</span>
                        </div>
                        <h4 class="font-black text-lg text-slate-900 dark:text-white leading-snug">{{ $sc->name }}</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-300 font-medium">Kepsek: <span class="font-bold text-emerald-800 dark:text-[#a3e635]">{{ $sc->principal_name }}</span></p>
                    </div>
                    <a href="{{ route('school.unit', strtolower($sc->code)) }}" class="inline-flex items-center gap-1.5 text-xs font-black text-emerald-800 dark:text-[#a3e635] hover:underline pt-4">
                        <span>Lihat Profil Unit</span> <span>➔</span>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- 3. Informasi Sekretariat Pusat -->
        <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-10 border border-slate-800 space-y-6 shadow-2xl">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-slate-800 pb-6">
                <div>
                    <span class="text-[10px] text-[#a3e635] font-black uppercase tracking-widest block">SEKRETARIAT PUSAT</span>
                    <h3 class="text-xl sm:text-2xl font-black text-white">Yayasan Generasi Robbani Sumatera Selatan</h3>
                    <p class="text-xs text-slate-400 font-semibold mt-1">Pusat Administrasi &amp; Kampus Pendidikan SIT Robbani Ogan Ilir</p>
                </div>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['contact_phone']) }}" target="_blank" class="px-5 py-3 rounded-xl bg-[#a3e635] text-[#050d06] font-black text-xs hover:scale-105 transition-transform shadow-lg shrink-0">
                    💬 Hubungi WhatsApp Sekretariat ➔
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-xs sm:text-sm font-medium">
                <div class="space-y-1">
                    <span class="text-slate-400 font-bold block text-[10px] uppercase">📌 Kantor Pusat:</span>
                    <p class="text-slate-200 leading-relaxed font-semibold">Kecamatan Indralaya Utara, Kabupaten Ogan Ilir, Sumatera Selatan</p>
                </div>
                <div class="space-y-1">
                    <span class="text-slate-400 font-bold block text-[10px] uppercase">📞 Layanan Telepon / WA:</span>
                    <p class="text-slate-200 font-semibold">{{ $settings['contact_phone'] }}</p>
                </div>
                <div class="space-y-1">
                    <span class="text-slate-400 font-bold block text-[10px] uppercase">✉️ Email Resmi:</span>
                    <p class="text-slate-200 font-semibold">{{ $settings['contact_email'] }}</p>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 text-xs py-8 transition-colors">
        <div class="w-full max-w-[1400px] mx-auto px-4 text-center space-y-3">
            <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
            <a href="https://berandadigital.net" target="_blank" class="text-emerald-400 dark:text-[#a3e635] hover:underline inline-flex items-center gap-1 font-bold">
                <span>Powered by Beranda Teknologi Digital</span>
                <span>➔</span>
            </a>
        </div>
    </footer>

</body>
</html>
