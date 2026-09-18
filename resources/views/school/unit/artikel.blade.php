@extends('school.unit.layouts.master')

@section('title', 'Artikel & Berita Terkini - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Kumpulan artikel pendidikan Islam, wawasan parenting, kabar prestasi siswa, dan berita kegiatan resmi ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    
    // Combine unitArticles and unitNews for complete repository
    $rawArticles = collect($unitArticles ?? [])->toArray();
    $rawNews = collect($unitNews ?? [])->toArray();
    $combinedList = array_merge($rawArticles, $rawNews);
    
    $agendaList = collect($unitAgendas ?? [])->toArray();
    $announcementList = collect($unitAnnouncements ?? [])->toArray();
    
    if (empty($combinedList)) {
        $combinedList = [
            [
                'title' => 'Membangun Karakter Qur\'ani Sejak Usia Dini dengan Metode Terpadu JSIT',
                'category' => 'Parenting Islami',
                'date' => '15 September 2026',
                'author' => 'Ustadz Pembina',
                'image' => '/images/mockup_desktop_1.png',
                'desc' => 'Pendidikan anak di era digital membutuhkan pondasi nilai Al-Qur\'an yang kuat dan keteladanan orang tua dalam membiasakan adab sehari-hari di rumah.',
                'slug' => 'membangun-karakter-qurani-usia-dini'
            ],
            [
                'title' => 'Prestasi Gemilang Siswa Robbani Raih Juara Olimpiade Sains & Tahfidz Nasional',
                'category' => 'Prestasi Siswa',
                'date' => '10 September 2026',
                'author' => 'Humas Sekolah',
                'image' => '/images/mockup_desktop_2.png',
                'desc' => 'Siswa SIT Robbani kembali menorehkan prestasi membanggakan pada ajang kompetisi nasional tingkat pelajar se-Indonesia.',
                'slug' => 'prestasi-gemilang-siswa-olimpiade-sains'
            ],
            [
                'title' => 'Tips Menghafal Al-Qur\'an Cepat, Melekat, dan Menyenangkan bagi Pelajar',
                'category' => 'Tahfidz Al-Qur\'an',
                'date' => '05 September 2026',
                'author' => 'Koordinator Tahfidz',
                'image' => '/images/mockup_desktop_3.png',
                'desc' => 'Metode talaqqi dan muraja\'ah terstruktur terbukti efektif membantu siswa menuntaskan target hafalan mutqin tanpa tekanan.',
                'slug' => 'tips-menghafal-quran-cepat-melekat'
            ],
            [
                'title' => 'Keseruan Robbani Science & Innovation Day: Membuka Cakrawala Riset Generasi Muda',
                'category' => 'Kegiatan Kampus',
                'date' => '28 Agustus 2026',
                'author' => 'Tim Kesiswaan',
                'image' => '/images/mockup_desktop_4.png',
                'desc' => 'Siswa memamerkan karya inovasi sains terapan, teknologi robotik sederhana, dan percobaan biologi dalam pameran riset tahunan.',
                'slug' => 'robbani-science-innovation-day'
            ]
        ];
    }
@endphp

@section('content')
{{-- SUBPAGE HERO HEADER --}}
<div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} border-b border-indigo-950 text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-indigo-200 mb-2.5 sm:mb-3 flex items-center space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">
            <a href="{{ url('/unit/' . $codeLower) }}" class="hover:text-white transition shrink-0">Beranda</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold shrink-0">Artikel &amp; Berita</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Artikel, Wacana &amp; Berita Terkini</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Inspirasi pendidikan Islam, parenting islami, kabar prestasi siswa, dan laporan kegiatan resmi dari {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTAINER --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14"
     x-data="{
        search: '',
        activeCat: 'all',
        matches(item) {
            const title = (item.title || '').toLowerCase();
            const desc = (item.desc || item.content || '').toLowerCase();
            const q = this.search.toLowerCase();
            const matchSearch = !q || title.includes(q) || desc.includes(q);
            if (!matchSearch) return false;

            if (this.activeCat === 'all') return true;
            const cat = (item.category || '').toLowerCase();
            if (this.activeCat === 'parenting') return cat.includes('parenting') || title.includes('anak') || title.includes('karakter');
            if (this.activeCat === 'prestasi') return cat.includes('prestasi') || title.includes('juara') || title.includes('lomba') || title.includes('olimpiade');
            if (this.activeCat === 'tahfidz') return cat.includes('tahfidz') || title.includes('qur\'an') || title.includes('hafal');
            if (this.activeCat === 'kegiatan') return cat.includes('kegiatan') || cat.includes('berita') || title.includes('expo') || title.includes('day');
            return true;
        }
     }">

    {{-- SEARCH & FILTER BAR --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 pb-6 border-b border-gray-200">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                Publikasi &amp; Literasi Kampus
            </span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Koleksi Wacana &amp; Berita ({{ count($combinedList) }})
            </h2>
            <div class="w-16 h-1 bg-unit-primary rounded-full mt-2"></div>
        </div>

        {{-- SEARCH INPUT --}}
        <div class="w-full md:w-80">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       x-model="search" 
                       placeholder="Cari judul atau topik artikel..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200 bg-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
            </div>
        </div>
    </div>

    {{-- CATEGORY PILLS --}}
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-4 mb-8">
        <button type="button" 
                @click="activeCat = 'all'"
                :class="activeCat === 'all' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition">
            Semua Topik
        </button>
        <button type="button" 
                @click="activeCat = 'parenting'"
                :class="activeCat === 'parenting' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-hands-holding-child text-[10px]"></i>
            <span>Parenting Islami</span>
        </button>
        <button type="button" 
                @click="activeCat = 'prestasi'"
                :class="activeCat === 'prestasi' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-trophy text-[10px]"></i>
            <span>Prestasi Siswa</span>
        </button>
        <button type="button" 
                @click="activeCat = 'tahfidz'"
                :class="activeCat === 'tahfidz' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-book-quran text-[10px]"></i>
            <span>Tahfidz Al-Qur'an</span>
        </button>
        <button type="button" 
                @click="activeCat = 'kegiatan'"
                :class="activeCat === 'kegiatan' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-calendar-check text-[10px]"></i>
            <span>Kegiatan &amp; Event</span>
        </button>
    </div>

    {{-- MAIN GRID & SIDEBAR --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
        
        {{-- ARTICLES LIST (8/12) --}}
        <div class="lg:col-span-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($combinedList as $art)
                    @php
                        $artSlug = $art['slug'] ?? \Illuminate\Support\Str::slug($art['title'] ?? 'artikel');
                        $artImg = !empty($art['image']) ? asset($art['image']) : asset('/images/mockup_desktop_1.png');
                        $artCat = $art['category'] ?? 'Edukasi Islami';
                        $artDate = $art['date'] ?? $art['created_at'] ?? '2026';
                    @endphp
                    <div x-show="matches({ 
                            title: '{{ addslashes($art['title'] ?? '') }}', 
                            desc: '{{ addslashes(strip_tags($art['desc'] ?? $art['content'] ?? '')) }}',
                            category: '{{ addslashes($artCat) }}'
                         })"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         class="bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 hover:border-indigo-200 hover:-translate-y-1.5 transition duration-300 flex flex-col justify-between group">
                        
                        <div>
                            {{-- THUMBNAIL --}}
                            <div class="h-48 overflow-hidden bg-gray-100 relative">
                                <img src="{{ $artImg }}" 
                                     alt="{{ $art['title'] ?? 'Artikel' }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                     onerror="this.src='/images/mockup_desktop_1.png'">
                                <div class="absolute top-3 left-3">
                                    <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-black/60 backdrop-blur-md text-white border border-white/20">
                                        {{ $artCat }}
                                    </span>
                                </div>
                            </div>

                            {{-- CONTENT --}}
                            <div class="p-5 sm:p-6">
                                <div class="flex items-center gap-3 text-[11px] text-gray-500 mb-2">
                                    <span><i class="fa-regular fa-calendar mr-1"></i> {{ $artDate }}</span>
                                    <span>•</span>
                                    <span><i class="fa-regular fa-user mr-1"></i> {{ $art['author'] ?? 'Asatidz' }}</span>
                                </div>

                                <h3 class="text-sm sm:text-base font-bold text-gray-900 group-hover:text-unit-primary transition line-clamp-2 leading-snug">
                                    <a href="{{ route('school.berita.show', ['slug' => $artSlug]) }}">
                                        {{ $art['title'] ?? 'Judul Artikel' }}
                                    </a>
                                </h3>

                                <p class="text-xs text-gray-600 mt-2.5 line-clamp-3 leading-relaxed text-justify">
                                    {{ Str::limit(strip_tags($art['desc'] ?? $art['content'] ?? ''), 130) }}
                                </p>
                            </div>
                        </div>

                        {{-- FOOTER LINK --}}
                        <div class="px-5 sm:px-6 pb-5 sm:pb-6 pt-2 border-t border-gray-50">
                            <a href="{{ route('school.berita.show', ['slug' => $artSlug]) }}" 
                               class="inline-flex items-center gap-1.5 text-xs font-bold text-unit-primary hover:opacity-80 transition">
                                <span>Baca Selengkapnya</span>
                                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition"></i>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- EMPTY STATE --}}
            <div x-show="!$el.previousElementSibling.querySelector('div[x-show]:not([style*=\'display: none\'])')" 
                 style="display: none;"
                 class="bg-white rounded-3xl p-10 text-center border border-gray-200">
                <i class="fa-solid fa-file-circle-question text-4xl text-gray-300 mb-3"></i>
                <h4 class="text-sm font-bold text-gray-700">Tidak ada artikel yang sesuai</h4>
                <p class="text-xs text-gray-500 mt-1">Coba gunakan kata kunci pencarian lain atau pilih kategori Semua Topik.</p>
            </div>
        </div>

        {{-- SIDEBAR COLUMN (4/12) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- AGENDA TERDEKAT --}}
            @if(!empty($agendaList) && count($agendaList) > 0)
                <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                        <h4 class="text-xs font-black uppercase tracking-wider text-unit-primary flex items-center gap-2">
                            <i class="fa-solid fa-calendar-days"></i>
                            Agenda Terdekat
                        </h4>
                        <a href="{{ url('/unit/' . $codeLower . '/agenda') }}" class="text-[11px] font-bold text-gray-500 hover:text-unit-primary">
                            Semua <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach(array_slice($agendaList, 0, 3) as $ag)
                            <div class="flex items-start gap-3 p-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 transition">
                                <div class="w-10 h-10 rounded-lg bg-unit-primary text-white flex flex-col items-center justify-center font-black shrink-0 text-center leading-tight">
                                    <span class="text-[9px] uppercase font-bold">{{ substr($ag['date'] ?? 'Tgl', 0, 3) }}</span>
                                    <span class="text-xs">{{ preg_replace('/[^0-9]/', '', $ag['date'] ?? '1') ?: '1' }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-xs font-bold text-gray-900 truncate">{{ $ag['title'] ?? 'Agenda' }}</h5>
                                    <p class="text-[11px] text-gray-500 mt-0.5"><i class="fa-solid fa-location-dot text-[9px] mr-1"></i> {{ $ag['location'] ?? 'Kampus' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- PENGUMUMAN PENTING --}}
            @if(!empty($announcementList) && count($announcementList) > 0)
                <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                        <h4 class="text-xs font-black uppercase tracking-wider text-amber-600 flex items-center gap-2">
                            <i class="fa-solid fa-bullhorn"></i>
                            Pengumuman Resmi
                        </h4>
                        <a href="{{ url('/unit/' . $codeLower . '/pengumuman') }}" class="text-[11px] font-bold text-gray-500 hover:text-amber-600">
                            Semua <i class="fa-solid fa-chevron-right text-[9px]"></i>
                        </a>
                    </div>
                    <div class="space-y-3">
                        @foreach(array_slice($announcementList, 0, 3) as $an)
                            <div class="p-3 rounded-xl bg-amber-50/50 border border-amber-100">
                                <span class="text-[10px] text-amber-700 font-bold block mb-1">{{ $an['date'] ?? 'Pengumuman' }}</span>
                                <h5 class="text-xs font-bold text-gray-900">{{ $an['title'] ?? 'Informasi' }}</h5>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- DIGITAL LIBRARY & EBOOK BANNER --}}
            <div class="bg-gradient-to-br from-indigo-900 to-unit-primary text-white rounded-3xl p-6 shadow-xl space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-amber-300 text-xl">
                    <i class="fa-solid fa-book-bookmark"></i>
                </div>
                <h4 class="text-sm font-black">Perpustakaan Digital (E-Book)</h4>
                <p class="text-xs text-indigo-100 font-light leading-relaxed">
                    Akses ratusan modul keislaman, kurikulum tahfidz, dan panduan parenting digital gratis untuk siswa dan wali murid.
                </p>
                <a href="{{ url('/unit/' . $codeLower . '/e-book') }}" class="inline-block w-full py-2.5 rounded-xl text-xs font-bold bg-amber-400 hover:bg-amber-300 text-gray-900 text-center shadow-md transition">
                    Buka Rak E-Book Digital
                </a>
            </div>

            {{-- MULTIMEDIA DIRECTORY --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <h4 class="text-xs font-black uppercase tracking-wider text-gray-900 mb-4">Eksplorasi Media</h4>
                <div class="space-y-2 text-xs font-bold">
                    <a href="{{ url('/unit/' . $codeLower . '/galeri') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-images mr-2 text-unit-primary"></i> Galeri Foto Kegiatan</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/video') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-circle-play mr-2 text-rose-600"></i> Video Profil &amp; Dokumentasi</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/download') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-download mr-2 text-emerald-600"></i> Unduh Dokumen &amp; Kalender</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
