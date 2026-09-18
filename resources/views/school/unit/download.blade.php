@extends('school.unit.layouts.master')

@section('title', 'Pusat Unduhan Berkas Publik - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Pusat unduhan dokumen publik, brosur SPMB, pedoman adab siswa, kalender akademik, dan formulir administrasi ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    
    $downloadsList = [
        [
            'title' => 'Brosur Resmi SPMB TA 2026/2027',
            'desc' => 'Informasi lengkap persyaratan pendaftaran, jadwal seleksi, kuota kelas, dan rincian biaya pendidikan.',
            'category' => 'spmb',
            'format' => 'PDF',
            'size' => '2.8 MB',
            'downloads' => 1420,
            'url' => asset($info['flyer'] ?: '/uploads/pedoman-adab-siswa.pdf')
        ],
        [
            'title' => 'Buku Saku Adab & Muwashofat Siswa',
            'desc' => 'Panduan adab harian islami, tata tertib siswa, dan pembiasaan ibadah yaumiyah di sekolah dan rumah.',
            'category' => 'tatatertib',
            'format' => 'PDF',
            'size' => '1.4 MB',
            'downloads' => 980,
            'url' => asset('/uploads/pedoman-adab-siswa.pdf')
        ],
        [
            'title' => 'Kalender Akademik Terpadu TA 2026/2027',
            'desc' => 'Jadwal masuk sekolah, penilaian tengah semester, asesmen sumatif, munaqosah tahfidz, dan hari libur nasional.',
            'category' => 'kurikulum',
            'format' => 'PDF',
            'size' => '850 KB',
            'downloads' => 2130,
            'url' => asset('/uploads/pedoman-adab-siswa.pdf')
        ],
        [
            'title' => 'Panduan Target Capaian Mutqin Tahfidz Al-Qur\'an',
            'desc' => 'Silabus target hafalan per jenjang kelas, metode talaqqi mandiri, dan kisi-kisi munaqosah bersertifikat.',
            'category' => 'kurikulum',
            'format' => 'PDF',
            'size' => '1.9 MB',
            'downloads' => 1670,
            'url' => asset('/uploads/pedoman-adab-siswa.pdf')
        ],
        [
            'title' => 'Formulir Permohonan Izin Kunjungan / Studi Banding',
            'desc' => 'Format surat resmi pengajuan studi tiru atau silaturahmi instansi mitra ke kampus SIT Robbani.',
            'category' => 'formulir',
            'format' => 'DOCX',
            'size' => '320 KB',
            'downloads' => 450,
            'url' => url('/unit/' . $codeLower . '/layanan/kunjungan')
        ],
        [
            'title' => 'Formulir Pengajuan Beasiswa Siswa Berprestasi & Yatim',
            'desc' => 'Berkas persyaratan permohonan keringanan biaya pendidikan dan beasiswa yayasan bagi siswa berprestasi.',
            'category' => 'formulir',
            'format' => 'PDF',
            'size' => '640 KB',
            'downloads' => 780,
            'url' => asset('/uploads/pedoman-adab-siswa.pdf')
        ],
        [
            'title' => 'Paket Logo Resmi & Identitas Visual HD',
            'desc' => 'Logo transparan PNG resolusi tinggi dan vektor lambang resmi SIT Robbani untuk publikasi.',
            'category' => 'logo',
            'format' => 'PNG/SVG',
            'size' => '3.2 MB',
            'downloads' => 610,
            'url' => url('/unit/' . $codeLower . '/logo')
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
            <span class="text-amber-300 font-semibold shrink-0">Pusat Unduhan</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Pusat Unduhan Berkas Publik</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Akses dan unduh dokumen resmi, buku pedoman, kalender akademik, brosur pendaftaran, dan modul pembelajaran {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14"
     x-data="{ 
        search: '',
        activeCat: 'all',
        matches(item) {
            const matchesSearch = !this.search || item.title.toLowerCase().includes(this.search.toLowerCase()) || item.desc.toLowerCase().includes(this.search.toLowerCase());
            if (!matchesSearch) return false;
            if (this.activeCat === 'all') return true;
            return item.category === this.activeCat;
        }
     }">

    {{-- SEARCH & FILTER BAR --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 pb-6 border-b border-gray-200">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                Pusat Berkas Digital
            </span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Dokumen &amp; Berkas Resmi Sekolah
            </h2>
            <div class="w-16 h-1 bg-unit-primary rounded-full mt-2"></div>
        </div>

        {{-- SEARCH BAR --}}
        <div class="w-full md:w-80">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       x-model="search" 
                       placeholder="Cari berkas dokumen..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200 bg-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-4 mb-8">
        <button type="button" 
                @click="activeCat = 'all'"
                :class="activeCat === 'all' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition">
            Semua Berkas
        </button>
        <button type="button" 
                @click="activeCat = 'spmb'"
                :class="activeCat === 'spmb' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-graduation-cap text-[10px]"></i>
            <span>Brosur &amp; SPMB</span>
        </button>
        <button type="button" 
                @click="activeCat = 'kurikulum'"
                :class="activeCat === 'kurikulum' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-book-open text-[10px]"></i>
            <span>Kurikulum &amp; Kalender</span>
        </button>
        <button type="button" 
                @click="activeCat = 'tatatertib'"
                :class="activeCat === 'tatatertib' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-scale-balanced text-[10px]"></i>
            <span>Tata Tertib &amp; Adab</span>
        </button>
        <button type="button" 
                @click="activeCat = 'formulir'"
                :class="activeCat === 'formulir' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-file-signature text-[10px]"></i>
            <span>Formulir Administrasi</span>
        </button>
    </div>

    {{-- FILE CARDS LIST --}}
    <div class="space-y-4">
        @foreach($downloadsList as $f)
            <div x-show="matches({ title: '{{ addslashes($f['title']) }}', desc: '{{ addslashes($f['desc']) }}', category: '{{ $f['category'] }}' })"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-white rounded-3xl p-5 sm:p-6 shadow-md hover:shadow-xl hover:border-indigo-200 border border-gray-100 transition duration-300 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 group">
                
                {{-- LEFT: ICON & DETAILS --}}
                <div class="flex items-start space-x-4 min-w-0 flex-1">
                    <div class="w-12 h-14 sm:w-14 sm:h-16 rounded-2xl bg-red-50 text-red-600 border border-red-100 flex flex-col items-center justify-center shrink-0 shadow-inner group-hover:scale-105 transition">
                        <i class="fa-solid fa-file-pdf text-xl sm:text-2xl"></i>
                        <span class="text-[9px] font-black uppercase mt-0.5 tracking-wider">{{ $f['format'] }}</span>
                    </div>

                    <div class="space-y-1 min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider bg-gray-100 text-gray-700">
                                {{ strtoupper($f['category']) }}
                            </span>
                            <span class="text-[11px] text-gray-400 font-medium">
                                Ukuran: {{ $f['size'] }}
                            </span>
                            <span class="text-[11px] text-gray-400 font-medium">
                                • Diunduh: {{ number_format($f['downloads'], 0, ',', '.') }} kali
                            </span>
                        </div>

                        <h3 class="text-sm sm:text-base font-extrabold text-gray-900 group-hover:text-unit-primary transition leading-snug">
                            {{ $f['title'] }}
                        </h3>

                        <p class="text-xs text-gray-600 leading-relaxed font-light">
                            {{ $f['desc'] }}
                        </p>
                    </div>
                </div>

                {{-- RIGHT: DOWNLOAD ACTION BUTTON --}}
                <div class="self-stretch md:self-center shrink-0 pt-2 md:pt-0">
                    <a href="{{ $f['url'] }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="w-full md:w-auto inline-flex items-center justify-center space-x-2 px-6 py-3 rounded-full text-xs font-bold bg-unit-primary text-white hover:brightness-110 shadow-md transition group-hover:shadow-lg">
                        <i class="fa-solid fa-download text-xs"></i>
                        <span>Unduh Berkas</span>
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    {{-- BOTTOM BANNER --}}
    <div class="mt-12 sm:mt-16 p-6 sm:p-8 rounded-3xl bg-gradient-to-r {{ $uTheme['nav_gradient'] }} text-white flex flex-col sm:flex-row items-center justify-between gap-6 border border-white/20">
        <div class="space-y-1 text-center sm:text-left">
            <h4 class="text-base sm:text-lg font-bold">Membutuhkan Dokumen Khusus Lainnya?</h4>
            <p class="text-xs text-indigo-100 font-light">Hubungi staf tata usaha dan administrasi kami untuk permohonan legalisir dan berkas dinas.</p>
        </div>
        <a href="{{ url('/unit/' . $codeLower . '/hubungi') }}" 
           class="px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-wider bg-white text-slate-950 hover:bg-amber-400 transition shrink-0">
            Hubungi Tata Usaha
        </a>
    </div>

</div>
@endsection
