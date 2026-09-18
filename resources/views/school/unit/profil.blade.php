@extends('school.unit.layouts.master')

@section('title', 'Profil Sekolah - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Mengenal visi, misi, rekam jejak, fasilitas, dewan guru, dan program unggulan di ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $unitUrl = url('/unit/' . $codeLower);
@endphp

@section('content')
{{-- SUBPAGE HERO HEADER --}}
<div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} border-b border-indigo-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-indigo-200 mb-3 flex items-center space-x-2">
            <a href="{{ $unitUrl }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Tentang Kami</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Profil {{ $info['name'] }}</h1>
        <p class="text-sm text-indigo-100 mt-2 font-light max-w-2xl">
            Mengenal lebih dekat visi, nilai pendidikan Qur'ani, fasilitas, dan keunggulan civitas akademika.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-16">

    {{-- SEKSI 1: TEASER SAMBUTAN KEPALA SEKOLAH --}}
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-4 flex justify-center">
                <div class="w-56 h-72 sm:w-64 sm:h-80 rounded-2xl overflow-hidden shadow-xl border-4 border-white ring-4 ring-indigo-100 bg-indigo-50 relative group">
                    <img src="{{ asset($info['principal_photo'] ?: '/uploads/dewan/kepala-sekolah.webp') }}" 
                         alt="{{ $info['principal_name'] }}" 
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500"
                         onerror="this.src='/uploads/dewan/kepala-sekolah.webp'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-3 left-3 text-white">
                        <span class="block text-sm font-extrabold">{{ $info['principal_name'] }}</span>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-8 space-y-4 text-left">
                <div class="inline-flex items-center space-x-2 bg-indigo-100 text-indigo-800 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-user-tie text-indigo-600"></i>
                    <span>Sambutan Pimpinan</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Mendidik Generasi Qur'ani Berprestasi
                </h2>
                <div class="w-16 h-1 bg-indigo-600 rounded-full"></div>
                <div class="text-xs sm:text-sm text-gray-600 space-y-3 leading-relaxed">
                    <p class="text-justify">
                        Assalamu'alaikum Warahmatullahi Wabarakatuh. Selamat datang di {{ $info['name'] }}. Kami berdiri dengan tekad kuat melahirkan pendidikan menengah pertama yang seimbang antara kematangan spiritual, kemuliaan akhlak, dan keunggulan sains teknologi.
                    </p>
                    <p class="text-justify">
                        Sebagai lembaga pendidikan Islam terpadu, kami mendampingi ananda dalam menuntaskan hafalan Al-Qur'an, penanaman karakter mandiri, serta penguasaan wawasan global.
                    </p>
                </div>
                <div class="pt-2">
                    <a href="{{ url('/unit/' . $codeLower . '/sambutan') }}" 
                       class="inline-flex items-center space-x-2 px-6 py-3 rounded-full text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-md hover:shadow-indigo-500/20 transition">
                        <span>Baca Sambutan Lengkap</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 2: TEASER SEJARAH SEKOLAH --}}
    <section class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up delay-1">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-7 space-y-4 text-left order-2 lg:order-1">
                <div class="inline-flex items-center space-x-2 bg-orange-100 text-orange-800 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-landmark text-orange-600"></i>
                    <span>Jejak Sejarah</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    Sejarah Berdirinya {{ $info['name'] }}
                </h2>
                <p class="text-xs sm:text-sm font-semibold text-orange-600">
                    Komitmen membangun pendidikan berkualitas
                </p>
                <div class="w-16 h-1 bg-orange-500 rounded-full"></div>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed text-justify">
                    {{ $info['history']['paragraphs'][0] ?? ($info['name'] . ' didirikan sebagai wujud kepedulian terhadap pentingnya pendidikan generasi muda Islam yang seimbang antara ilmu pengetahuan umum dan pemahaman agama yang mendalam.') }}
                </p>
                <div class="pt-2">
                    <a href="{{ url('/unit/' . $codeLower . '/sejarah') }}" 
                       class="inline-flex items-center space-x-2 px-6 py-3 rounded-full text-xs font-bold bg-slate-900 hover:bg-slate-800 text-white shadow-md transition">
                        <span>Baca Sejarah Lengkap</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
            <div class="lg:col-span-5 order-1 lg:order-2">
                <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-gray-50 max-h-72">
                    <img src="{{ asset($info['history']['image'] ?? '/uploads/campus-smpit-ishum.webp') }}" 
                         alt="Gedung Kampus {{ $info['name'] }}" 
                         class="w-full h-full object-cover"
                         onerror="this.src='/uploads/campus-smpit-ishum.webp'">
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 3: 3 KARTU FITUR PILAR --}}
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 reveal-fade-up delay-2">
        {{-- Card 1: Fasilitas --}}
        <div class="bg-white rounded-3xl p-7 shadow-xl border border-gray-100 space-y-4 hover:border-indigo-300 transition">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-indigo-600 block">Sarana Terbaik</span>
                <h3 class="text-base font-extrabold text-gray-900 mt-0.5">Fasilitas &amp; Laboratorium</h3>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed">
                Sarana laboratorium sains, ruang kelas ber-AC, perpustakaan, dan area olahraga representatif.
            </p>
            <div>
                <a href="{{ $unitUrl }}#fasilitas" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition flex items-center gap-1">
                    <span>Lihat Sarana &amp; Fasilitas</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- Card 2: Agenda Akademik --}}
        <div class="bg-white rounded-3xl p-7 shadow-xl border border-gray-100 space-y-4 hover:border-orange-300 transition">
            <div class="w-12 h-12 rounded-2xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-orange-600 block">Kalender Pendidikan</span>
                <h3 class="text-base font-extrabold text-gray-900 mt-0.5">Agenda Akademik</h3>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed">
                Jadwal ujian, munaqosah tahfidz, class meeting, dan agenda tahunan terstruktur rapi.
            </p>
            <div>
                <a href="{{ $unitUrl }}#agenda" class="text-xs font-bold text-orange-600 hover:text-orange-800 transition flex items-center gap-1">
                    <span>Lihat Semua Agenda</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        {{-- Card 3: Dewan Guru & GTK --}}
        <div class="bg-white rounded-3xl p-7 shadow-xl border border-gray-100 space-y-4 hover:border-cyan-300 transition">
            <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-xl shadow-inner">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-cyan-600 block">Tenaga Pendidik</span>
                <h3 class="text-base font-extrabold text-gray-900 mt-0.5">Dewan Guru &amp; GTK</h3>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed">
                Para asatidz dan asatidzah berdedikasi tinggi, tersertifikasi, dan berjiwa pembimbing santri.
            </p>
            <div>
                <a href="{{ $unitUrl }}#guru" class="text-xs font-bold text-cyan-600 hover:text-cyan-800 transition flex items-center gap-1">
                    <span>Lihat Profil Guru &amp; GTK</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- SEKSI 4: VISI & MISI DUA KOLOM --}}
    <section class="space-y-6 reveal-fade-up">
        <div class="text-center space-y-2">
            <span class="inline-block bg-indigo-100 text-indigo-800 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full">
                Pedoman Pendidikan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Visi dan Misi {{ $info['name'] }}
            </h2>
            <div class="w-16 h-1 bg-indigo-600 rounded-full mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Kartu Visi --}}
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg shadow-inner">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900">Visi Sekolah</h3>
                </div>
                <div class="bg-gradient-to-r from-indigo-50/70 to-white p-5 rounded-2xl border-l-4 border-indigo-600">
                    <p class="text-sm font-semibold text-gray-900 leading-relaxed font-serif italic">
                        “{{ $info['vision'] }}”
                    </p>
                </div>
                <div>
                    <a href="{{ url('/unit/' . $codeLower . '/visi-misi') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition flex items-center gap-1">
                        <span>Baca Visi &amp; Misi Lengkap</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            {{-- Kartu Misi Utama --}}
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-gray-100 space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-lg shadow-inner">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <h3 class="text-lg font-extrabold text-gray-900">Misi Utama</h3>
                </div>
                <ul class="text-xs text-gray-600 space-y-2.5">
                    @foreach(array_slice($info['missions'] ?? [], 0, 4) as $idx => $m)
                        <li class="flex items-start space-x-2">
                            <i class="fa-solid fa-circle-check text-indigo-600 text-xs mt-0.5 shrink-0"></i>
                            <span>{{ is_array($m) ? ($m['title'] . ' - ' . $m['desc']) : $m }}</span>
                        </li>
                    @endforeach
                </ul>
                <div>
                    <a href="{{ url('/unit/' . $codeLower . '/visi-misi') }}" class="text-xs font-bold text-orange-600 hover:text-orange-800 transition flex items-center gap-1">
                        <span>Lihat Seluruh Misi Program</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- SEKSI 5: KOMENTAR ALUMNI & ORANG TUA --}}
    <section class="space-y-6 reveal-fade-up">
        <div class="text-center space-y-2">
            <span class="inline-block bg-amber-100 text-amber-800 text-[10px] font-black uppercase tracking-wider px-3 py-1 rounded-full">
                Apresiasi &amp; Testimoni
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Komentar Alumni &amp; Orang Tua
            </h2>
            <p class="text-xs text-gray-500 font-light">
                Pengalaman mendampingi belajar dan bersekolah di {{ $info['name'] }}.
            </p>
            <div class="w-16 h-1 bg-amber-500 rounded-full mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $testimonials = !empty($info['alumni']) ? $info['alumni'] : [
                    ['name' => 'Wali Santri Angkatan 2025', 'title' => 'Orang Tua Murid', 'text' => 'Pendidikan adab dan hafalan Qur\'an di sekolah ini luar biasa mendampingi perkembangan ananda di rumah.', 'avatar' => '/uploads/dewan/kepala-sekolah.webp'],
                    ['name' => 'Ahmad Faiz', 'title' => 'Alumni Prestasi', 'text' => 'Fasilitas belajar modern dan bimbingan para guru sangat mendukung minat saya di bidang sains dan tahfidz.', 'avatar' => '/uploads/dewan/kepala-sekolah.webp'],
                    ['name' => 'Bunda Siti', 'title' => 'Wali Murid', 'text' => 'Suasana sekolah ramah anak dan asri, komunikasi ustadz/ustadzah kepada kami orang tua sangat terbuka.', 'avatar' => '/uploads/dewan/kepala-sekolah.webp']
                ];
            @endphp

            @foreach(array_slice($testimonials, 0, 3) as $testi)
                <div class="bg-white rounded-3xl p-7 shadow-xl border border-gray-100 space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <i class="fa-solid fa-quote-left text-2xl text-emerald-500"></i>
                        <p class="text-xs text-gray-600 leading-relaxed italic">
                            “{{ $testi['text'] }}”
                        </p>
                    </div>
                    <div class="flex items-center space-x-3 pt-3 border-t border-gray-100">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 shrink-0 border border-gray-200">
                            <img src="{{ asset($testi['avatar'] ?? '/uploads/dewan/kepala-sekolah.webp') }}" 
                                 alt="{{ $testi['name'] }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.src='/uploads/logo-ishum-square.png'">
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-gray-900">{{ $testi['name'] }}</span>
                            <span class="block text-[10px] text-gray-500">{{ $testi['title'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center pt-2">
            <a href="{{ $unitUrl }}#testimoni" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                Lihat Semua Testimoni &rarr;
            </a>
        </div>
    </section>

    {{-- SEKSI 6: ALAMAT & GOOGLE MAPS --}}
    <section class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 space-y-6 reveal-fade-up">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <span class="text-[10px] font-black uppercase tracking-wider text-indigo-600 block">
                    Lokasi &amp; Kontak
                </span>
                <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                    Alamat {{ $info['name'] }}
                </h3>
                <p class="text-xs text-gray-500">
                    {{ $info['address'] ?? 'Jalan Sadewa No. 45 RT 01 RW 04 Kelurahan Karang Raja, Prabumulih' }}
                </p>
            </div>
            <a href="https://maps.google.com/?q={{ urlencode($info['address'] ?? $info['name']) }}" 
               target="_blank" 
               rel="noopener noreferrer"
               class="px-5 py-2.5 rounded-full text-xs font-bold bg-indigo-600 hover:bg-indigo-700 text-white shadow-md transition flex items-center space-x-1.5 shrink-0 self-start sm:self-auto">
                <i class="fa-solid fa-location-arrow text-[11px]"></i>
                <span>Buka di Google Maps</span>
            </a>
        </div>

        <div class="rounded-2xl overflow-hidden shadow-inner border border-gray-200 h-80 sm:h-96">
            <iframe 
                src="https://maps.google.com/maps?q={{ urlencode($info['address'] ?? ($info['name'] . ' Sumatera Selatan')) }}&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                class="w-full h-full border-0" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                title="Peta Lokasi {{ $info['name'] }}">
            </iframe>
        </div>
    </section>

</div>
@endsection
