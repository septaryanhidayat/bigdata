@extends('school.unit.layouts.master')

@section('title', 'E-Book & Modul Siswa - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'E-Library dan rak modul digital siswa ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Akses modul belajar mandiri, buku saku tahfidz, dan suplemen kurikulum.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    
    $ebooksList = [
        [
            'title' => 'Modul Panduan Tahfidz & Tajwid Al-Qur\'an',
            'author' => 'Tim Pengembang Tahfidz Robbani',
            'level' => 'Semua Jenjang Siswa',
            'cover' => '/uploads/covers/cover-tahfidz-mutqin.webp',
            'pages' => '84 Halaman',
            'size' => '4.2 MB',
            'desc' => 'Panduan makharijul huruf, sifat huruf, kaidah tajwid praktis, dan mutabaah hafalan harian.'
        ],
        [
            'title' => 'Buku Saku 10 Muwashofat Siswa Robbani',
            'author' => 'Bidang Pembinaan Karakter & BPI',
            'level' => 'Pegangan Siswa & Wali',
            'cover' => '/uploads/covers/cover-karakter-siswa.webp',
            'pages' => '62 Halaman',
            'size' => '2.8 MB',
            'desc' => 'Ulasan 10 pilar karakter pribadi muslim unggul standar mutu JSIT Indonesia dan penerapannya di rumah.'
        ],
        [
            'title' => 'Modul Pembiasaan Bahasa Arab & Inggris (Bilingual)',
            'author' => 'Language Center SIT Robbani',
            'level' => 'Semester Ganjil & Genap',
            'cover' => '/uploads/covers/cover-bilingual-arab-inggris.webp',
            'pages' => '96 Halaman',
            'size' => '3.5 MB',
            'desc' => 'Kamus tematik percakapan harian, ungkapan islami, dan latihan dialog siswa.'
        ],
        [
            'title' => 'Buku Panduan Praktikum Sains & Nalar Kritis',
            'author' => 'Laboratorium Sains & Robotika',
            'level' => 'Kurikulum Merdeka & JSIT',
            'cover' => '/uploads/covers/cover-praktikum-sains.webp',
            'pages' => '110 Halaman',
            'size' => '5.1 MB',
            'desc' => 'Eksperimen sains sederhana, pemahaman ayat kauniyah, dan panduan proyek riset pelajar.'
        ]
    ];
@endphp

@section('content')
{{-- SUBPAGE HERO HEADER --}}
<div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} border-b border-indigo-950 text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-indigo-200 mb-2.5 sm:mb-3 flex items-center space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">
            <a href="{{ url('/unit/' . $codeLower) }}" class="hover:text-white transition shrink-0">Beranda</a>
            <span>/</span>
            <span class="shrink-0">Download</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold shrink-0">E-Book &amp; Modul</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">E-Library &amp; Modul Pembelajaran</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Koleksi buku panduan digital, suplemen kurikulum terpadu, dan buku saku adab siswa {{ $info['name'] }} yang dapat diakses mandiri di rumah.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14">

    <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14 space-y-2">
        <span class="text-xs font-black uppercase tracking-wider text-unit-primary block">
            Perpustakaan Digital Siswa
        </span>
        <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
            Rak Modul &amp; Sumber Belajar Mandiri
        </h2>
        <div class="w-16 h-1 bg-unit-primary rounded-full mx-auto"></div>
    </div>

    {{-- 4-COLUMN EBOOK CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
        @foreach($ebooksList as $b)
            <div class="bg-white rounded-3xl p-5 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col justify-between group">
                
                <div class="space-y-4">
                    {{-- 3D-STYLE BOOK COVER --}}
                    <div class="relative h-60 rounded-2xl overflow-hidden shadow-md bg-slate-900 border-2 border-gray-100 group-hover:border-amber-400 transition">
                        <img src="{{ asset($b['cover']) }}" 
                             alt="{{ $b['title'] }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                             onerror="this.src='/images/logo-robbani-official.png'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                        
                        {{-- BOOK BADGE --}}
                        <div class="absolute top-2.5 left-2.5">
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow">
                                E-Book Resmi
                            </span>
                        </div>

                        <div class="absolute bottom-2.5 inset-x-3 text-white text-right">
                            <span class="text-[10px] font-bold text-amber-300">{{ $b['pages'] }}</span>
                        </div>
                    </div>

                    {{-- DETAILS --}}
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-bold text-unit-primary uppercase tracking-wider block">
                            {{ $b['level'] }}
                        </span>
                        <h3 class="text-sm sm:text-base font-extrabold text-gray-900 group-hover:text-unit-primary transition leading-snug line-clamp-2">
                            {{ $b['title'] }}
                        </h3>
                        <p class="text-[11px] text-gray-400 font-medium">
                            Penyusun: {{ $b['author'] }}
                        </p>
                        <p class="text-xs text-gray-600 leading-relaxed font-light line-clamp-2 pt-1">
                            {{ $b['desc'] }}
                        </p>
                    </div>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="pt-4 mt-4 border-t border-gray-100 space-y-2">
                    <a href="{{ asset('/uploads/pedoman-adab-siswa.pdf') }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="w-full inline-flex items-center justify-center space-x-2 py-2.5 rounded-full text-xs font-bold bg-unit-primary text-white hover:brightness-110 shadow transition">
                        <i class="fa-solid fa-download text-xs"></i>
                        <span>Unduh E-Book ({{ $b['size'] }})</span>
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    {{-- BOTTOM READING PROMOTION --}}
    <div class="mt-12 sm:mt-16 bg-slate-900 rounded-3xl p-6 sm:p-10 text-white border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
        <div class="space-y-1 max-w-xl">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400">Gerakan Literasi Sekolah</span>
            <h3 class="text-lg sm:text-xl font-black">Budayakan Membaca &amp; Menghafal Al-Qur'an Setiap Hari</h3>
            <p class="text-xs text-slate-300 font-light leading-relaxed">
                Seluruh siswa dan wali murid dapat memanfaatkan koleksi digital ini untuk muraja'ah tahfidz dan penguatan materi akademis mandiri.
            </p>
        </div>
        <a href="{{ url('/unit/' . $codeLower . '/download') }}" 
           class="px-6 py-3 rounded-full text-xs font-bold bg-white text-slate-950 hover:bg-amber-400 transition shrink-0">
            Lihat Berkas Publik Lainnya
        </a>
    </div>

</div>
@endsection
