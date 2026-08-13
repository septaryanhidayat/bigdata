<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ mobileMenuOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil {{ $school->name }} | Website Resmi Unit Sekolah</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="https://sitrobbani.sch.id/wp-content/uploads/2022/01/cropped-favicon-32x32.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0b1206; color: #f7fee7; }
        .btn-lime-primary { background-color: #a8f52c !important; color: #070c04 !important; }
        .card-dark-surface { background-color: #14220c !important; border: 1px solid #264218 !important; }
    </style>
</head>
<body class="bg-[#0b1206] text-lime-50 antialiased min-h-screen pb-24 lg:pb-0">

    <!-- Top Bar -->
    <div class="bg-[#070c04] text-white text-xs py-2 px-4 border-b border-[#1c3011]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="hover:text-[#a8f52c] font-bold flex items-center gap-1">
                <span>← Kembali ke Portal Yayasan Robbani</span>
            </a>
            <div class="flex items-center gap-4 text-[11px] font-bold">
                <span>📞 {{ $school->phone ?? $settings['contact_phone'] }}</span>
                <a href="{{ route('admin.dashboard') }}" class="px-2.5 py-0.5 rounded-lg btn-lime-primary">Portal Admin ➔</a>
            </div>
        </div>
    </div>

    <!-- Header Navbar -->
    <header class="sticky top-0 z-50 bg-[#0b1206]/95 backdrop-blur-xl border-b border-[#1c3011]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('school.unit', strtolower($school->code)) }}" class="flex items-center gap-3">
                <span class="px-2.5 py-1 rounded-xl text-xs font-black text-[#070c04] bg-[#a8f52c]">
                    {{ $school->code }}
                </span>
                <div>
                    <h1 class="text-sm font-black text-white leading-tight">{{ $school->name }}</h1>
                    <span class="text-[10px] text-slate-400 font-bold block">NPSN: {{ $school->npsn }} • Terakreditasi A</span>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center gap-5 text-xs font-bold text-slate-300">
                <a href="#profil" class="hover:text-[#a8f52c]">Profil</a>
                <a href="#kepsek" class="hover:text-[#a8f52c]">Kepsek</a>
                <a href="#statistik" class="hover:text-[#a8f52c]">Statistik</a>
                <a href="#guru" class="hover:text-[#a8f52c]">Guru</a>
                <a href="#kelas" class="hover:text-[#a8f52c]">Kelas</a>
                <a href="{{ route('school.ppdb') }}" class="px-4 py-2 rounded-xl btn-lime-primary font-black shadow">PPDB ➔</a>
            </nav>
        </div>
    </header>

    <!-- Unit Hero Section -->
    <section class="py-12 px-4 sm:px-6 max-w-7xl mx-auto space-y-8">
        
        <div class="p-8 rounded-[2.5rem] bg-[#a8f52c] text-[#070c04] shadow-2xl relative overflow-hidden space-y-6">
            <div class="space-y-3">
                <span class="px-3 py-1 rounded-full bg-[#070c04] text-[#a8f52c] font-black text-xs inline-block uppercase">
                    UNIT {{ $school->code }} ROBBANI
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-[#070c04] leading-tight">
                    {{ $school->name }}
                </h1>
                <p class="text-xs sm:text-sm font-semibold text-[#0f1d08] max-w-2xl leading-relaxed">
                    {{ $school->description ?? 'Mewujudkan generasi Rabbani unggul dalam keimanan, ketaqwaan, dan keilmuan digital.' }}
                </p>
            </div>

            <div class="flex flex-wrap gap-4 pt-2">
                <a href="{{ route('school.ppdb') }}" class="px-6 py-3 rounded-2xl bg-[#070c04] text-[#a8f52c] font-black text-xs shadow-lg hover:scale-105 transition-transform">
                    Daftar SPMB / PPDB Online ➔
                </a>
                <a href="https://api.whatsapp.com/send?phone=62811747472" target="_blank" class="px-6 py-3 rounded-2xl bg-[#14220c] text-white font-bold text-xs">
                    Hubungi WhatsApp Unit
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div id="profil" class="lg:col-span-8 space-y-6">
                <div class="p-8 rounded-[2rem] card-dark-surface space-y-4">
                    <h2 class="text-xl font-black text-[#a8f52c] border-b pb-3 border-[#264218]">Profil & Keunggulan Unit</h2>
                    <p class="text-xs text-slate-300 leading-relaxed font-medium">
                        Unit {{ $school->name }} berkomitmen memberikan layanan pendidikan Islam Terpadu berlandaskan Al-Qur'an dan As-Sunnah. Pembelajaran diintegrasikan dengan Kurikulum Nasional, Kurikulum Merdeka, dan Pembinaan Karakter JSIT.
                    </p>
                </div>

                <div id="kepsek" class="p-8 rounded-[2rem] card-dark-surface space-y-4">
                    <span class="text-xs font-black text-[#a8f52c] uppercase tracking-wider block">KEPALA SEKOLAH</span>
                    <h3 class="text-lg font-black text-white">{{ $school->principal_name }}</h3>
                    <p class="text-xs text-slate-300 italic font-medium leading-relaxed">
                        "Selamat datang di portal resmi {{ $school->name }}. Kami berikhtiar mendidik para siswa menjadi pribadi beriman, hafidz Al-Qur'an, berakhlak mulia, dan siap memimpin masa depan."
                    </p>
                </div>
            </div>

            <div id="statistik" class="lg:col-span-4 space-y-4">
                <div class="p-6 rounded-[2rem] card-dark-surface text-center space-y-2">
                    <span class="text-3xl font-black text-[#a8f52c] block">{{ $school->students_count ?? count($students) }}</span>
                    <span class="text-xs font-bold text-slate-300 uppercase">Siswa Aktif</span>
                </div>
                <div class="p-6 rounded-[2rem] card-dark-surface text-center space-y-2">
                    <span class="text-3xl font-black text-[#a8f52c] block">{{ $school->employees_count ?? count($teachers) }}</span>
                    <span class="text-xs font-bold text-slate-300 uppercase">Guru & Tenaga Pendidik</span>
                </div>
                <div class="p-6 rounded-[2rem] card-dark-surface text-center space-y-2">
                    <span class="text-3xl font-black text-[#a8f52c] block">{{ $school->classrooms_count ?? count($classrooms) }}</span>
                    <span class="text-xs font-bold text-slate-300 uppercase">Rombongan Belajar / Kelas</span>
                </div>
            </div>

        </div>

    </section>

    <footer class="bg-[#070c04] text-slate-400 text-xs py-8 text-center border-t border-[#1c3011]">
        <p>© {{ date('Y') }} {{ $school->name }} (Yayasan Generasi Robbani Sumatera Selatan).</p>
    </footer>

</body>
</html>
