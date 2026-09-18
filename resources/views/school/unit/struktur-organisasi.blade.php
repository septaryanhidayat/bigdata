@extends('school.unit.layouts.master')

@section('title', 'Struktur Organisasi - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Struktur Organisasi dan Manajemen Kelembagaan ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Tata kelola profesional, amanah, dan terintegrasi.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
@endphp

@section('content')
{{-- SUBPAGE HERO HEADER --}}
<div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} border-b border-indigo-950 text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-indigo-200 mb-2.5 sm:mb-3 flex items-center space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">
            <a href="{{ url('/unit/' . $codeLower) }}" class="hover:text-white transition shrink-0">Beranda</a>
            <span>/</span>
            <span class="shrink-0">Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold shrink-0">Struktur Organisasi</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Struktur Manajemen &amp; Organisasi</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Tata kelola kelembagaan {{ $info['name'] }} yang profesional, akuntabel, dan amanah dalam mengemban amanah dakwah pendidikan Islam terpadu.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14 space-y-12 sm:space-y-16">

    {{-- BAGAN HIRARKI VISUAL --}}
    <div class="bg-white rounded-3xl p-6 sm:p-12 shadow-xl border border-gray-100">
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-2">
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block">
                Bagan Kepemimpinan Sekolah
            </span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Hirarki Manajemen Satuan Pendidikan
            </h2>
            <div class="w-16 h-1 bg-unit-primary rounded-full mx-auto"></div>
        </div>

        {{-- VISUAL ORGANIZATIONAL CHART --}}
        <div class="max-w-4xl mx-auto space-y-8">
            
            {{-- LEVEL 1: YAYASAN & KOMITE --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8">
                <div class="w-full sm:w-72 bg-gradient-to-br from-indigo-900 to-indigo-950 text-white p-4 sm:p-5 rounded-2xl text-center shadow-lg border border-indigo-700/50">
                    <span class="text-[10px] font-bold text-amber-400 uppercase tracking-wider block">Badan Penyelenggara</span>
                    <h3 class="text-sm sm:text-base font-extrabold mt-0.5">Yayasan Generasi Robbani</h3>
                    <p class="text-[11px] text-indigo-200 mt-1">Ketua: Sughesti Wulandari, S.Pd</p>
                </div>
                <div class="hidden sm:block w-8 h-0.5 bg-gray-300"></div>
                <div class="w-full sm:w-72 bg-gray-50 border border-gray-200 text-gray-800 p-4 sm:p-5 rounded-2xl text-center shadow-sm">
                    <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">Mitra Sinergi</span>
                    <h3 class="text-sm sm:text-base font-extrabold mt-0.5">Komite Sekolah</h3>
                    <p class="text-[11px] text-gray-500 mt-1">Perwakilan Orang Tua &amp; Tokoh</p>
                </div>
            </div>

            {{-- CONNECTOR LINE --}}
            <div class="flex justify-center">
                <div class="w-0.5 h-8 bg-indigo-300"></div>
            </div>

            {{-- LEVEL 2: KEPALA SEKOLAH --}}
            <div class="flex justify-center">
                <div class="w-full sm:w-80 bg-unit-primary text-white p-5 rounded-2xl text-center shadow-xl border border-white/20 transform hover:scale-105 transition">
                    <span class="text-[10px] font-bold text-amber-300 uppercase tracking-wider block">Pimpinan Satuan Pendidikan</span>
                    <h3 class="text-base sm:text-lg font-black mt-0.5">{{ $info['principal_name'] }}</h3>
                    <p class="text-xs text-indigo-100 mt-1">{{ $info['principal_title'] ?? 'Kepala Sekolah' }}</p>
                </div>
            </div>

            {{-- CONNECTOR LINE --}}
            <div class="flex justify-center">
                <div class="w-0.5 h-8 bg-indigo-300"></div>
            </div>

            {{-- LEVEL 3: WAKIL KEPALA & KOORDINATOR --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-slate-50/70 border border-indigo-100 p-4 rounded-2xl text-center">
                    <div class="w-8 h-8 rounded-lg bg-unit-primary text-white flex items-center justify-center text-xs mx-auto mb-2">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h4 class="text-xs font-bold text-gray-900">Waka Kurikulum</h4>
                    <p class="text-[10px] text-gray-500 mt-1">Pengembangan Modul &amp; Mutu Akademik</p>
                </div>
                <div class="bg-amber-50/70 border border-amber-100 p-4 rounded-2xl text-center">
                    <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs mx-auto mb-2">
                        <i class="fa-solid fa-book-quran"></i>
                    </div>
                    <h4 class="text-xs font-bold text-gray-900">Waka Kesiswaan &amp; Al-Qur'an</h4>
                    <p class="text-[10px] text-gray-500 mt-1">Tahfidz, BPI &amp; Kedisiplinan Adab</p>
                </div>
                <div class="bg-emerald-50/70 border border-emerald-100 p-4 rounded-2xl text-center">
                    <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs mx-auto mb-2">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h4 class="text-xs font-bold text-gray-900">Waka Sarana Prasarana</h4>
                    <p class="text-[10px] text-gray-500 mt-1">Fasilitas, Kebersihan &amp; Keamanan</p>
                </div>
                <div class="bg-blue-50/70 border border-blue-100 p-4 rounded-2xl text-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-xs mx-auto mb-2">
                        <i class="fa-solid fa-handshake"></i>
                    </div>
                    <h4 class="text-xs font-bold text-gray-900">Waka Humas &amp; Kemitraan</h4>
                    <p class="text-[10px] text-gray-500 mt-1">SPMB, Kerjasama &amp; Media Sosial</p>
                </div>
            </div>

            {{-- CONNECTOR LINE --}}
            <div class="flex justify-center">
                <div class="w-0.5 h-8 bg-gray-300"></div>
            </div>

            {{-- LEVEL 4: PELAKSANA TEKNIS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gray-50 border border-gray-200 p-4 rounded-2xl text-center">
                    <h4 class="text-xs font-extrabold text-gray-900 flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-chalkboard-user text-unit-primary"></i>
                        <span>Dewan Guru &amp; Wali Kelas</span>
                    </h4>
                    <p class="text-[10px] text-gray-500 mt-1">Pendidik profesional, guru bidang studi, pembina tahfidz dan asatidz asrama.</p>
                </div>
                <div class="bg-gray-50 border border-gray-200 p-4 rounded-2xl text-center">
                    <h4 class="text-xs font-extrabold text-gray-900 flex items-center justify-center gap-1.5">
                        <i class="fa-solid fa-id-badge text-amber-500"></i>
                        <span>Tata Usaha &amp; Tenaga Kependidikan</span>
                    </h4>
                    <p class="text-[10px] text-gray-500 mt-1">Administrasi, E-SPP, IT Support, Pustakawan, Laboran, dan Keamanan Kampus.</p>
                </div>
            </div>

        </div>
    </div>

    {{-- KARTU PIMPINAN UTAMA --}}
    <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 sm:p-10 border border-gray-100 shadow-xl">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 items-center">
            <div class="md:col-span-4 flex justify-center">
                <div class="w-44 h-56 sm:w-52 sm:h-64 rounded-2xl overflow-hidden shadow-lg border-4 border-white ring-4 ring-indigo-100 bg-slate-50">
                    <img src="{{ asset($info['principal_photo'] ?: '/uploads/dewan/kepala-sekolah.webp') }}" 
                         alt="{{ $info['principal_name'] }}" 
                         class="w-full h-full object-cover object-top"
                         onerror="this.src='/uploads/dewan/kepala-sekolah.webp'">
                </div>
            </div>
            <div class="md:col-span-8 space-y-3 text-center md:text-left">
                <span class="inline-block px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-unit-primary">
                    Profil Pimpinan Unit
                </span>
                <h3 class="text-xl sm:text-2xl font-black text-gray-900">
                    {{ $info['principal_name'] }}
                </h3>
                <p class="text-xs sm:text-sm font-semibold text-unit-primary">
                    {{ $info['principal_title'] ?? ('Kepala ' . $info['name']) }}
                </p>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-light">
                    Mengemban tanggung jawab utama dalam memimpin proses manajerial, supervisi kurikulum, pembinaan guru dan siswa, serta memastikan seluruh visi misi {{ $info['name'] }} terlaksana dengan standar keunggulan tinggi.
                </p>
                <div class="pt-2 flex flex-wrap gap-2 justify-center md:justify-start">
                    <a href="{{ url('/unit/' . $codeLower . '/dewan-guru') }}" 
                       class="px-5 py-2 rounded-full text-xs font-bold bg-unit-primary text-white hover:brightness-110 shadow transition">
                        <span>Lihat Seluruh Dewan Guru</span>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/sambutan') }}" 
                       class="px-5 py-2 rounded-full text-xs font-bold bg-gray-100 text-gray-800 hover:bg-gray-200 transition">
                        <span>Baca Sambutan Resmi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
