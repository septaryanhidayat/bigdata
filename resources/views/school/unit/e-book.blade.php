@extends('school.unit.layouts.master')

@section('title', 'Etalase E-Book & Modul Digital - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Etalase buku digital dan modul belajar siswa ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Unduh modul kurikulum, buku saku adab, sains, dan tahfidz.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    
    // Master catalogue by unit
    $catalogueByUnit = [
        'tkit' => [
            [
                'title' => 'Modul Bermain Kreatif & Sentra Karakter TKIT',
                'author' => 'Tim Pendidik PAUD IT Robbani',
                'level' => 'Kelompok Bermain & TK-A/B',
                'cover' => '/uploads/covers/cover-sentra-tkit.webp',
                'pages' => '72 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Panduan sentra bermain peran, eksplorasi seni, pengenalan hijaiyah, doa harian, dan pembiasaan adab islami usia dini.',
                'file' => asset('downloads/ebooks/modul-sentra-dan-bermain-kreatif-tkit.pdf'),
                'filename' => 'Modul-Bermain-Kreatif-TKIT.pdf',
                'tag' => 'Kreativitas & Karakter'
            ],
            [
                'title' => 'Panduan Tahfidz Mutqin Ceria Anak & Balita',
                'author' => 'Tim Tahfidz PAUD Robbani',
                'level' => 'Juz 30 & Doa Harian',
                'cover' => '/uploads/covers/cover-tahfidz-mutqin.webp',
                'pages' => '84 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Metode talaqqi ceria, murottal visual, dan mutabaah hafalan surat-surat pendek bagi anak usia dini.',
                'file' => asset('downloads/ebooks/panduan-kurikulum-tahfidz-mutqin.pdf'),
                'filename' => 'Panduan-Tahfidz-Anak-Robbani.pdf',
                'tag' => 'Tahfidz Al-Qur\'an'
            ],
            [
                'title' => 'Buku Saku 10 Adab & Karakter Siswa',
                'author' => 'Bidang Karakter SIT Robbani',
                'level' => 'Pegangan Siswa & Orang Tua',
                'cover' => '/uploads/covers/cover-karakter-siswa.webp',
                'pages' => '62 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Ulasan 10 pilar karakter pribadi muslim cilik standar mutu JSIT Indonesia dan penerapannya di rumah.',
                'file' => asset('downloads/ebooks/buku-saku-adab-karakter-siswa.pdf'),
                'filename' => 'Buku-Saku-Adab-Siswa.pdf',
                'tag' => 'Adab & Akhlak'
            ],
            [
                'title' => 'Kamus Bergambar Kosakata Arab - Inggris',
                'author' => 'Language Center SIT Robbani',
                'level' => 'Bilingual Kids',
                'cover' => '/uploads/covers/cover-bilingual-arab-inggris.webp',
                'pages' => '96 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Kamus tematik bergambar kosakata benda di sekitar, anggota tubuh, dan percakapan islami dwibahasa.',
                'file' => asset('downloads/ebooks/buku-saku-kosakata-bilingual-arab-inggris.pdf'),
                'filename' => 'Kamus-Bergambar-Anak.pdf',
                'tag' => 'Bahasa Asing'
            ]
        ],
        'sdit' => [
            [
                'title' => 'Modul Literasi Sains Tematik SDIT Robbani',
                'author' => 'Dr. H. Ahmad Fauzi, M.Pd. & Tim',
                'level' => 'Kelas 1 - 6 SDIT',
                'cover' => '/uploads/covers/cover-tematik-sdit.webp',
                'pages' => '120 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Buku panduan Kurikulum Merdeka terintegrasi keislaman, eksperimen sains seru, dan lembar kerja tadabbur alam.',
                'file' => asset('downloads/ebooks/modul-literasi-sains-tematik-sdit.pdf'),
                'filename' => 'Modul-Literasi-Sains-SDIT.pdf',
                'tag' => 'Sains & Kurikulum'
            ],
            [
                'title' => 'Modul Panduan Tahfidz & Tajwid Al-Qur\'an',
                'author' => 'Tim Pengembang Tahfidz Robbani',
                'level' => 'Target 3 Juz Mutqin',
                'cover' => '/uploads/covers/cover-tahfidz-mutqin.webp',
                'pages' => '84 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Panduan makharijul huruf, sifat huruf, kaidah tajwid praktis, dan mutabaah hafalan mandiri siswa.',
                'file' => asset('downloads/ebooks/panduan-kurikulum-tahfidz-mutqin.pdf'),
                'filename' => 'Panduan-Tahfidz-Tajwid-SDIT.pdf',
                'tag' => 'Tahfidz Al-Qur\'an'
            ],
            [
                'title' => 'Buku Saku 10 Muwashofat Siswa Robbani',
                'author' => 'Bidang Pembinaan Karakter & BPI',
                'level' => 'Standar Mutu JSIT',
                'cover' => '/uploads/covers/cover-karakter-siswa.webp',
                'pages' => '62 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Pedoman pengamalan 10 kompetensi karakter siswa Robbani: ibadah benar, aqidah lurus, dan akhlak kokoh.',
                'file' => asset('downloads/ebooks/buku-saku-adab-karakter-siswa.pdf'),
                'filename' => 'Buku-Saku-Karakter-Siswa.pdf',
                'tag' => 'Adab & Karakter'
            ],
            [
                'title' => 'Buku Saku Kosakata Bilingual Arab & Inggris',
                'author' => 'Language Center SIT Robbani',
                'level' => 'Kelas 3 - 6 SDIT',
                'cover' => '/uploads/covers/cover-bilingual-arab-inggris.webp',
                'pages' => '96 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Kamus saku tematik, ungkapan harian di sekolah, dan latihan percakapan dwibahasa Arab-Inggris.',
                'file' => asset('downloads/ebooks/buku-saku-kosakata-bilingual-arab-inggris.pdf'),
                'filename' => 'Buku-Saku-Bilingual-SDIT.pdf',
                'tag' => 'Bahasa Asing'
            ]
        ],
        'smpit' => [
            [
                'title' => 'Modul Panduan Tahfidz Mutqin & Munaqosah',
                'author' => 'Tim Pengembang Tahfidz Robbani',
                'level' => 'Target 5 - 10 Juz Mutqin',
                'cover' => '/uploads/covers/cover-tahfidz-mutqin.webp',
                'pages' => '84 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Metode ziyadah dan muraja\'ah mandiri, standar tartil tajwid, serta kisi-kisi munaqosah bersertifikat JSIT.',
                'file' => asset('downloads/ebooks/panduan-kurikulum-tahfidz-mutqin.pdf'),
                'filename' => 'Panduan-Tahfidz-SMPIT.pdf',
                'tag' => 'Tahfidz Al-Qur\'an'
            ],
            [
                'title' => 'Petunjuk Praktikum Laboratorium IPA Terpadu',
                'author' => 'Laboratorium IPA & STEM Robbani',
                'level' => 'Kelas VII - IX SMPIT',
                'cover' => '/uploads/covers/cover-praktikum-sains.webp',
                'pages' => '110 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Panduan eksperimen fisika, biologi, kimia ramah lingkungan, serta lembar kerja penyelidikan sains ilmiah.',
                'file' => asset('downloads/ebooks/petunjuk-praktikum-lab-ipa-terpadu.pdf'),
                'filename' => 'Petunjuk-Praktikum-IPA-SMPIT.pdf',
                'tag' => 'Sains & Praktikum'
            ],
            [
                'title' => 'Modul Pembinaan Da\'i Muda & Public Speaking',
                'author' => 'Tim Pembina Da\'i & Muballigh',
                'level' => 'Ekskul & Kepemimpinan',
                'cover' => '/uploads/covers/cover-dai-muda.webp',
                'pages' => '78 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Teknik retorika dakwah, khutbah jum\'at, kultum subuh, dan kepemimpinan islami siswa terpadu.',
                'file' => asset('downloads/ebooks/modul-pembinaan-dai-muda-public-speaking.pdf'),
                'filename' => 'Modul-Dai-Muda-SMPIT.pdf',
                'tag' => 'Kepemimpinan Da\'i'
            ],
            [
                'title' => 'Buku Saku Kosakata Bilingual Arab & Inggris',
                'author' => 'Language Center SIT Robbani',
                'level' => 'Bilingual Program SMPIT',
                'cover' => '/uploads/covers/cover-bilingual-arab-inggris.webp',
                'pages' => '96 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Kamus tematik muhadatsah & daily English conversation untuk pembiasaan berbahasa asing di kampus.',
                'file' => asset('downloads/ebooks/buku-saku-kosakata-bilingual-arab-inggris.pdf'),
                'filename' => 'Buku-Saku-Bilingual-SMPIT.pdf',
                'tag' => 'Bahasa Asing'
            ]
        ],
        'smait' => [
            [
                'title' => 'Panduan Sukses Asesmen Nasional & SNBT PTN',
                'author' => 'Tim Bimbingan Sukses PTN Robbani',
                'level' => 'Persiapan PTN & Kedinasan',
                'cover' => '/uploads/covers/cover-sukses-snbt.webp',
                'pages' => '135 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Bedah materi TPS, literasi bahasa, penalaran matematika, dan strategi lolos seleksi perguruan tinggi negeri favorit.',
                'file' => asset('downloads/ebooks/panduan-sukses-asesmen-nasional-snbt.pdf'),
                'filename' => 'Panduan-Sukses-SNBT-SMAIT.pdf',
                'tag' => 'Sukses PTN'
            ],
            [
                'title' => 'Modul Panduan Tahfidz Mutqin Lanjutan',
                'author' => 'Tim Pengembang Tahfidz Robbani',
                'level' => 'Target 10 - 30 Juz',
                'cover' => '/uploads/covers/cover-tahfidz-mutqin.webp',
                'pages' => '84 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Panduan sanad Al-Qur\'an, kaidah qira\'at, dan strategi muraja\'ah hafalan mutqin jenjang lanjutan.',
                'file' => asset('downloads/ebooks/panduan-kurikulum-tahfidz-mutqin.pdf'),
                'filename' => 'Panduan-Tahfidz-SMAIT.pdf',
                'tag' => 'Tahfidz Al-Qur\'an'
            ],
            [
                'title' => 'Modul Pembinaan Da\'i Muda & Leadership',
                'author' => 'Tim Kepemimpinan Generasi Robbani',
                'level' => 'Pengurus OSIS & Da\'i',
                'cover' => '/uploads/covers/cover-dai-muda.webp',
                'pages' => '78 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Manajemen dakwah sekolah, public speaking, debat ilmiah, dan pembinaan kader pemimpin masa depan.',
                'file' => asset('downloads/ebooks/modul-pembinaan-dai-muda-public-speaking.pdf'),
                'filename' => 'Modul-Leadership-SMAIT.pdf',
                'tag' => 'Kepemimpinan'
            ],
            [
                'title' => 'Petunjuk Praktikum & Riset Sains Terapan',
                'author' => 'Laboratorium Riset SMAIT',
                'level' => 'KIR & Sains Terapan',
                'cover' => '/uploads/covers/cover-praktikum-sains.webp',
                'pages' => '110 Halaman',
                'size' => '1.2 MB',
                'desc' => 'Panduan metodologi penelitian ilmiah, penulisan karya tulis ilmiah (KIR), dan praktikum kimia-biologi lanjutan.',
                'file' => asset('downloads/ebooks/petunjuk-praktikum-lab-ipa-terpadu.pdf'),
                'filename' => 'Petunjuk-Riset-Sains-SMAIT.pdf',
                'tag' => 'Sains & Riset'
            ]
        ]
    ];

    $ebooksList = $catalogueByUnit[$codeLower] ?? $catalogueByUnit['smpit'];
@endphp

@section('content')
{{-- SUBPAGE HERO HEADER --}}
<div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} border-b border-indigo-950 text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-indigo-200 mb-2.5 sm:mb-3 flex items-center space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">
            <a href="{{ url('/unit/' . $codeLower) }}" class="hover:text-white transition shrink-0">Beranda</a>
            <span>/</span>
            <a href="{{ url('/unit/' . $codeLower . '/download') }}" class="hover:text-white transition shrink-0">Download</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold shrink-0">Etalase E-Book</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Etalase Buku Digital &amp; Modul Belajar</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Koleksi buku panduan digital resmi, suplemen kurikulum terpadu, buku saku adab, dan modul belajar mandiri siswa {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14"
     x-data="{ 
        search: '',
        matches(title, desc, author) {
            if (!this.search) return true;
            const q = this.search.toLowerCase();
            return title.toLowerCase().includes(q) || desc.toLowerCase().includes(q) || author.toLowerCase().includes(q);
        }
     }">

    {{-- HEADER & SEARCH BAR --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10 pb-6 border-b border-gray-200">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                E-Library &amp; Digital Showcase
            </span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Koleksi E-Book Digital Resmi
            </h2>
            <div class="w-16 h-1 bg-unit-primary rounded-full mt-2"></div>
        </div>

        <div class="w-full md:w-80">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       x-model="search" 
                       placeholder="Cari judul modul atau buku..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200 bg-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-unit-primary shadow-sm">
            </div>
        </div>
    </div>

    {{-- ETALASE GRID BUKU DIGITAL (3:4 ASPECT RATIO COVERS) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
        @foreach($ebooksList as $b)
            <div x-show="matches('{{ addslashes($b['title']) }}', '{{ addslashes($b['desc']) }}', '{{ addslashes($b['author']) }}')"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-3xl p-5 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col justify-between group">
                
                <div class="space-y-4">
                    {{-- 3D BOOK COVER MOCKUP CONTAINER --}}
                    <div class="relative aspect-[3/4] w-full rounded-2xl overflow-hidden shadow-md bg-slate-900 border-2 border-gray-100 group-hover:border-amber-400 transition-all duration-300">
                        <img src="{{ asset($b['cover']) }}" 
                             alt="{{ $b['title'] }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                             loading="lazy"
                             onerror="this.src='/images/logo-robbani-official.png'">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent pointer-events-none"></div>
                        
                        {{-- BADGE TAG --}}
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-400 text-slate-950 shadow-md">
                                {{ $b['tag'] }}
                            </span>
                        </div>

                        {{-- BOTTOM SPECS --}}
                        <div class="absolute bottom-3 inset-x-3 text-white flex items-center justify-between text-[10px] font-bold">
                            <span class="bg-white/20 backdrop-blur-xs px-2 py-0.5 rounded-md">
                                <i class="fa-solid fa-file-pdf text-red-400 mr-1"></i>PDF
                            </span>
                            <span class="text-amber-300 font-semibold">{{ $b['pages'] }}</span>
                        </div>
                    </div>

                    {{-- DETAILS --}}
                    <div class="space-y-1.5 pt-1">
                        <span class="text-[10px] font-bold text-unit-primary uppercase tracking-wider block">
                            {{ $b['level'] }}
                        </span>
                        <h3 class="text-sm sm:text-base font-black text-gray-900 group-hover:text-unit-primary transition leading-snug line-clamp-2">
                            {{ $b['title'] }}
                        </h3>
                        <p class="text-[11px] text-gray-500 font-medium line-clamp-1">
                            Penyusun: {{ $b['author'] }}
                        </p>
                        <p class="text-xs text-gray-600 leading-relaxed font-light line-clamp-3 pt-1">
                            {{ $b['desc'] }}
                        </p>
                    </div>
                </div>

                {{-- ACTION DOWNLOAD BUTTON --}}
                <div class="pt-4 mt-4 border-t border-gray-100">
                    <a href="{{ $b['file'] }}" 
                       download="{{ $b['filename'] }}"
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="w-full inline-flex items-center justify-center space-x-2 py-3 rounded-full text-xs font-bold bg-unit-primary text-white hover:brightness-110 shadow-md hover:shadow-lg transition">
                        <i class="fa-solid fa-download text-xs"></i>
                        <span>Unduh PDF ({{ $b['size'] }})</span>
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    {{-- BOTTOM READING PROMOTION --}}
    <div class="mt-12 sm:mt-16 bg-slate-900 rounded-3xl p-6 sm:p-10 text-white border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left shadow-xl">
        <div class="space-y-1 max-w-xl">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-400">Gerakan Literasi Sekolah SIT Robbani</span>
            <h3 class="text-lg sm:text-xl font-black">Budayakan Membaca &amp; Menghafal Al-Qur'an Setiap Hari</h3>
            <p class="text-xs text-slate-300 font-light leading-relaxed">
                Seluruh siswa dan orang tua murid dapat memanfaatkan koleksi etalase digital ini secara cuma-cuma untuk penguatan tahfidz dan pembelajaran mandiri di rumah.
            </p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ url('/unit/' . $codeLower . '/download') }}" 
               class="px-6 py-3 rounded-full text-xs font-bold bg-white/10 hover:bg-white/20 text-white border border-white/20 transition">
                Lihat Berkas Lainnya
            </a>
            <a href="{{ url('/unit/' . $codeLower . '/hubungi') }}" 
               class="px-6 py-3 rounded-full text-xs font-bold bg-amber-400 text-slate-950 hover:bg-amber-300 shadow transition">
                Kontak Perpustakaan
            </a>
        </div>
    </div>

</div>
@endsection
