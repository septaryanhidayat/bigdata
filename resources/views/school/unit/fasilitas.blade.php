@extends('school.unit.layouts.master')

@section('title', 'Fasilitas & Sarana Kampus - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Fasilitas dan sarana prasarana penunjang pendidikan holistik di ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Lingkungan belajar modern, asri, islami, dan nyaman.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $facilitiesList = !empty($unitFacilities) ? $unitFacilities : (!empty($info['facilities']) ? $info['facilities'] : []);
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
            <span class="text-amber-300 font-semibold shrink-0">Fasilitas &amp; Sarana</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Fasilitas &amp; Sarana Kampus</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Infrastruktur dan sarana prasarana modern, asri, dan islami yang disiapkan khusus untuk mendukung kenyamanan siswa {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14"
     x-data="{ 
        search: '',
        activeCategory: 'all',
        matches(fac) {
            const matchesSearch = !this.search || fac.title.toLowerCase().includes(this.search.toLowerCase()) || fac.desc.toLowerCase().includes(this.search.toLowerCase());
            if (!matchesSearch) return false;
            if (this.activeCategory === 'all') return true;
            if (this.activeCategory === 'kelas') return fac.title.toLowerCase().includes('kelas') || fac.desc.toLowerCase().includes('kelas');
            if (this.activeCategory === 'lab') return fac.title.toLowerCase().includes('lab') || fac.title.toLowerCase().includes('perpustakaan') || fac.desc.toLowerCase().includes('komputer');
            if (this.activeCategory === 'ibadah') return fac.title.toLowerCase().includes('masjid') || fac.title.toLowerCase().includes('musholla') || fac.desc.toLowerCase().includes('ibadah');
            if (this.activeCategory === 'olahraga') return fac.title.toLowerCase().includes('lapangan') || fac.title.toLowerCase().includes('olahraga') || fac.desc.toLowerCase().includes('olahraga') || fac.title.toLowerCase().includes('panahan');
            return true;
        }
     }">

    {{-- SECTION HEADER & SEARCH --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 pb-6 border-b border-gray-200">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                Sarana &amp; Prasarana Unggulan
            </span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Lingkungan Belajar Holistik ({{ count($facilitiesList) }} Fasilitas)
            </h2>
            <div class="w-16 h-1 bg-unit-primary rounded-full mt-2"></div>
        </div>

        {{-- SEARCH BAR --}}
        <div class="w-full md:w-80">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       x-model="search" 
                       placeholder="Cari nama fasilitas..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200 bg-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-4 mb-8">
        <button type="button" 
                @click="activeCategory = 'all'"
                :class="activeCategory === 'all' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition">
            Semua Fasilitas
        </button>
        <button type="button" 
                @click="activeCategory = 'kelas'"
                :class="activeCategory === 'kelas' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-chalkboard text-[10px]"></i>
            <span>Ruang Belajar &amp; Kelas</span>
        </button>
        <button type="button" 
                @click="activeCategory = 'lab'"
                :class="activeCategory === 'lab' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-flask text-[10px]"></i>
            <span>Laboratorium &amp; Perpustakaan</span>
        </button>
        <button type="button" 
                @click="activeCategory = 'ibadah'"
                :class="activeCategory === 'ibadah' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-mosque text-[10px]"></i>
            <span>Sarana Ibadah</span>
        </button>
        <button type="button" 
                @click="activeCategory = 'olahraga'"
                :class="activeCategory === 'olahraga' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-futbol text-[10px]"></i>
            <span>Olahraga &amp; Lapangan</span>
        </button>
    </div>

    {{-- 3-COLUMN FACILITY CARDS GRID --}}
    @if(empty($facilitiesList))
        <div class="bg-white rounded-3xl p-10 sm:p-14 text-center border border-gray-100 shadow-sm space-y-3 reveal-fade-up">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 mx-auto flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <h3 class="text-base sm:text-lg font-bold text-gray-900">Sarana &amp; Fasilitas Dalam Tahap Pembangunan</h3>
            <p class="text-xs sm:text-sm text-gray-500 max-w-lg mx-auto leading-relaxed">
                @if($codeLower === 'smait')
                    Pembangunan sarana belajar modern, laboratorium digital, dan fasilitas pendukung pembelajaran SMA IT Robbani sedang dipersiapkan secara komprehensif.
                @else
                    Data fasilitas kampus unit {{ $info['name'] }} sedang diperbarui.
                @endif
            </p>
        </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach($facilitiesList as $fac)
            <div x-show="matches({ title: '{{ addslashes($fac['title'] ?? '') }}', desc: '{{ addslashes($fac['desc'] ?? '') }}' })"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 flex flex-col justify-between group">
                
                {{-- PHOTO CONTAINER --}}
                <div class="h-52 sm:h-56 overflow-hidden bg-gray-100 relative">
                    <img src="{{ asset($fac['image'] ?? '/uploads/fasilitas/fasilitas-ruang-kelas.webp') }}" 
                         alt="{{ $fac['title'] ?? 'Fasilitas Sekolah' }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                         onerror="this.src='/uploads/fasilitas/fasilitas-ruang-kelas.webp'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end p-4">
                        <span class="text-white text-xs font-bold">{{ $fac['title'] ?? '' }}</span>
                    </div>

                    {{-- FLOATING BADGE --}}
                    <div class="absolute top-3 left-3">
                        <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-white/90 backdrop-blur-md text-unit-primary shadow-md border border-white/30">
                            {{ $info['code'] ?? 'SIT' }} Kampus
                        </span>
                    </div>
                </div>

                {{-- CARD CONTENT --}}
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-3">
                    <div class="space-y-2">
                        <h3 class="text-base sm:text-lg font-black text-gray-900 group-hover:text-unit-primary transition leading-snug">
                            {{ $fac['title'] ?? 'Fasilitas Sekolah' }}
                        </h3>
                        <p class="text-xs text-gray-600 leading-relaxed font-light line-clamp-3 text-justify">
                            {{ $fac['desc'] ?? 'Sarana pendukung kegiatan belajar mengajar dan pembinaan karakter siswa.' }}
                        </p>
                    </div>

                    {{-- FEATURE BADGES --}}
                    <div class="pt-3 border-t border-gray-100 flex flex-wrap gap-2">
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100">
                            <i class="fa-solid fa-check text-emerald-500"></i> Bersih &amp; Asri
                        </span>
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100">
                            <i class="fa-solid fa-shield-halved text-blue-500"></i> Terawat
                        </span>
                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-gray-500 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100">
                            <i class="fa-solid fa-users text-amber-500"></i> Representatif
                        </span>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
    @endif

    {{-- BOTTOM CALLOUT & SERVICE HUB CARDS --}}
    <div class="mt-14 sm:mt-18 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-xl flex flex-col justify-between space-y-4">
            <div class="space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-unit-primary flex items-center justify-center text-xl shadow-inner">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-black text-gray-900">
                    Peminjaman &amp; Sewa Sarana Gedung
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Masyarakat, alumni, dan instansi mitra dapat mengajukan permohonan penggunaan sarana prasarana sekolah untuk kegiatan positif.
                </p>
            </div>
            <a href="{{ url('/unit/' . $codeLower . '/layanan/sewa') }}" 
               class="inline-flex items-center justify-center space-x-2 px-6 py-3 rounded-full text-xs font-bold bg-unit-primary text-white hover:brightness-110 shadow-md transition self-start">
                <i class="fa-solid fa-file-signature"></i>
                <span>Ajukan Permohonan Sewa</span>
            </a>
        </div>

        <div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} rounded-3xl p-6 sm:p-8 text-white shadow-xl flex flex-col justify-between space-y-4 border border-white/20">
            <div class="space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-white/10 text-amber-300 flex items-center justify-center text-xl border border-white/10 shadow-inner">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <h3 class="text-lg sm:text-xl font-black text-white">
                    Daftar Siswa Baru (SPMB Online)
                </h3>
                <p class="text-xs text-indigo-100 font-light leading-relaxed">
                    Nikmati fasilitas pendidikan lengkap, lingkungan belajar terpadu, dan pembinaan karakter Qur'ani di {{ $info['name'] }}.
                </p>
            </div>
            <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
               class="inline-flex items-center justify-center space-x-2 px-7 py-3 rounded-full text-xs font-black uppercase tracking-wider bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-lg hover:brightness-105 transition self-start">
                <span>Daftar Sekarang</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>
    </div>

</div>
@endsection
