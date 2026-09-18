@extends('school.unit.layouts.master')

@section('title', 'Galeri Foto Kegiatan - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Dokumentasi foto kegiatan siswa, pembelajaran kelas, munaqosah tahfidz, outbond, dan event sekolah di ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $galleryList = !empty($unitGallery) ? $unitGallery : (!empty($info['gallery']) ? $info['gallery'] : []);
@endphp

@section('content')
{{-- SUBPAGE HERO HEADER --}}
<div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} border-b border-indigo-950 text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-indigo-200 mb-2.5 sm:mb-3 flex items-center space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">
            <a href="{{ url('/unit/' . $codeLower) }}" class="hover:text-white transition shrink-0">Beranda</a>
            <span>/</span>
            <span class="shrink-0">Kabar &amp; Galeri</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold shrink-0">Galeri Foto</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Galeri Foto Kegiatan Siswa</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Rekam jejak aktivitas siswa {{ $info['name'] }} dalam belajar, beribadah, berkarya, berolahraga, dan meraih prestasi.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA WITH LIGHTBOX MODAL --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14"
     x-data="{ 
        search: '',
        activeFilter: 'all',
        activeImage: null,
        activeTitle: '',
        activeDate: '',
        openModal(img, title, date) {
            this.activeImage = img;
            this.activeTitle = title;
            this.activeDate = date;
        },
        closeModal() {
            this.activeImage = null;
        },
        matches(item) {
            const matchSearch = !this.search || item.title.toLowerCase().includes(this.search.toLowerCase()) || (item.desc && item.desc.toLowerCase().includes(this.search.toLowerCase()));
            if (!matchSearch) return false;
            if (this.activeFilter === 'all') return true;
            if (this.activeFilter === 'kelas') return item.title.toLowerCase().includes('kelas') || item.title.toLowerCase().includes('belajar') || item.title.toLowerCase().includes('mpi');
            if (this.activeFilter === 'tahfidz') return item.title.toLowerCase().includes('tahfidz') || item.title.toLowerCase().includes('haji') || item.title.toLowerCase().includes('ramadhan') || item.title.toLowerCase().includes('isra');
            if (this.activeFilter === 'outbond') return item.title.toLowerCase().includes('outbond') || item.title.toLowerCase().includes('flying') || item.title.toLowerCase().includes('kuda') || item.title.toLowerCase().includes('trip') || item.title.toLowerCase().includes('renang');
            if (this.activeFilter === 'event') return item.title.toLowerCase().includes('pensi') || item.title.toLowerCase().includes('lomba') || item.title.toLowerCase().includes('festival') || item.title.toLowerCase().includes('kartini') || item.title.toLowerCase().includes('senam');
            return true;
        }
     }">

    {{-- SECTION HEADER & SEARCH --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 pb-6 border-b border-gray-200">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                Dokumentasi Visual
            </span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Momen Kebersamaan Siswa ({{ count($galleryList) }} Dokumentasi)
            </h2>
            <div class="w-16 h-1 bg-unit-primary rounded-full mt-2"></div>
        </div>

        {{-- SEARCH BAR --}}
        <div class="w-full md:w-80">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       x-model="search" 
                       placeholder="Cari momen foto..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200 bg-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-4 mb-8">
        <button type="button" 
                @click="activeFilter = 'all'"
                :class="activeFilter === 'all' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition">
            Semua Foto
        </button>
        <button type="button" 
                @click="activeFilter = 'kelas'"
                :class="activeFilter === 'kelas' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-chalkboard text-[10px]"></i>
            <span>Pembelajaran &amp; Kelas</span>
        </button>
        <button type="button" 
                @click="activeFilter = 'tahfidz'"
                :class="activeFilter === 'tahfidz' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-book-quran text-[10px]"></i>
            <span>Tahfidz &amp; Ibadah</span>
        </button>
        <button type="button" 
                @click="activeFilter = 'outbond'"
                :class="activeFilter === 'outbond' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-campground text-[10px]"></i>
            <span>Outbond &amp; Ekskul</span>
        </button>
        <button type="button" 
                @click="activeFilter = 'event'"
                :class="activeFilter === 'event' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-trophy text-[10px]"></i>
            <span>Event &amp; Perlombaan</span>
        </button>
    </div>

    {{-- 4-COLUMN PHOTO GRID --}}
    @if(empty($galleryList))
        <div class="bg-white rounded-3xl p-10 sm:p-14 text-center border border-gray-100 shadow-sm space-y-3 reveal-fade-up">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 mx-auto flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-camera-retro"></i>
            </div>
            <h3 class="text-base sm:text-lg font-bold text-gray-900">Dokumentasi Galeri Belum Tersedia</h3>
            <p class="text-xs sm:text-sm text-gray-500 max-w-lg mx-auto leading-relaxed">
                @if($codeLower === 'smait')
                    Galeri foto kegiatan dan peresmian SMA IT Robbani akan dipublikasikan seiring dimulainya operasional kampus.
                @else
                    Dokumentasi kegiatan {{ $info['name'] }} sedang dalam tahap kurasi foto terbaru.
                @endif
            </p>
        </div>
    @else
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($galleryList as $g)
            <div x-show="matches({ title: '{{ addslashes($g['title'] ?? '') }}', desc: '{{ addslashes($g['desc'] ?? '') }}' })"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 @click="openModal('{{ asset($g['image'] ?? '/images/logo-robbani-official.png') }}', '{{ addslashes($g['title'] ?? 'Dokumentasi') }}', '{{ $g['date'] ?? 'Dokumentasi' }}')"
                 class="group relative rounded-3xl overflow-hidden shadow-md hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 bg-gray-100 aspect-square sm:aspect-[4/3] cursor-pointer border border-gray-100">
                
                <img src="{{ asset($g['image'] ?? '/images/logo-robbani-official.png') }}" 
                     alt="{{ $g['title'] ?? 'Dokumentasi Siswa' }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                     onerror="this.src='/images/logo-robbani-official.png'">
                
                {{-- HOVER OVERLAY --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-between p-4 text-white">
                    <div class="self-end">
                        <span class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-xs">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-[10px] text-amber-300 font-semibold uppercase tracking-wider block">
                            {{ $g['date'] ?? 'Dokumentasi' }}
                        </span>
                        <h4 class="text-xs sm:text-sm font-bold line-clamp-2 leading-snug">
                            {{ $g['title'] ?? 'Kegiatan Siswa' }}
                        </h4>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
    @endif

    {{-- LIGHTBOX MODAL --}}
    <div x-show="activeImage" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="closeModal()"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
         style="display: none;">
        
        <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-white/20"
             @click.away="closeModal()">
            
            <button @click="closeModal()" 
                    class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-black/60 text-white hover:bg-red-600 transition flex items-center justify-center text-sm focus:outline-none">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="max-h-[70vh] bg-black flex items-center justify-center overflow-hidden">
                <img :src="activeImage" 
                     :alt="activeTitle" 
                     class="max-h-[70vh] w-auto max-w-full object-contain mx-auto">
            </div>

            <div class="p-6 text-white space-y-1 bg-slate-900">
                <span class="text-xs text-amber-400 font-bold uppercase tracking-wider" x-text="activeDate"></span>
                <h3 class="text-base sm:text-xl font-extrabold" x-text="activeTitle"></h3>
            </div>

        </div>
    </div>

</div>
@endsection
