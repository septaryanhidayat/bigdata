@extends('school.unit.layouts.master')

@section('title', 'Dewan Guru & GTK - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Dewan Guru dan Tenaga Kependidikan (GTK) ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Pendidik profesional, berkarakter Qur\'ani, dan berdedikasi tinggi membimbing santri.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $teachersList = !empty($info['teachers']) ? $info['teachers'] : [];
    if (empty($teachersList) && !empty($info['principal_name'])) {
        $teachersList = [
            [
                'name' => $info['principal_name'],
                'role' => $info['principal_title'] ?? 'Kepala Sekolah',
                'photo' => $info['principal_photo'] ?: '/uploads/dewan/kepala-sekolah.webp',
                'bio' => 'Pendidik berdedikasi dan praktisi pendidikan karakter Islami.'
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
            <span class="shrink-0">Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold shrink-0">Dewan Guru &amp; GTK</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Dewan Guru &amp; GTK</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Para asatidz dan tenaga kependidikan {{ $info['name'] }} yang berdedikasi, amanah, dan berkarakter Qur'ani membimbing santri meraih prestasi dunia dan akhirat.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14" 
     x-data="{ 
        search: '', 
        filterRole: 'all',
        matches(tc) {
            const matchesSearch = !this.search || tc.name.toLowerCase().includes(this.search.toLowerCase()) || tc.role.toLowerCase().includes(this.search.toLowerCase());
            if (!matchesSearch) return false;
            if (this.filterRole === 'all') return true;
            if (this.filterRole === 'pimpinan') return tc.role.toLowerCase().includes('kepala') || tc.role.toLowerCase().includes('waka') || tc.role.toLowerCase().includes('koordinator');
            if (this.filterRole === 'tahfidz') return tc.role.toLowerCase().includes('tahfidz') || tc.role.toLowerCase().includes('qur\'an') || tc.role.toLowerCase().includes('quran') || tc.role.toLowerCase().includes('diniyah');
            if (this.filterRole === 'mapel') return tc.role.toLowerCase().includes('guru') || tc.role.toLowerCase().includes('sentra') || tc.role.toLowerCase().includes('kelas');
            if (this.filterRole === 'staf') return tc.role.toLowerCase().includes('tu') || tc.role.toLowerCase().includes('tata usaha') || tc.role.toLowerCase().includes('staf') || tc.role.toLowerCase().includes('it') || tc.role.toLowerCase().includes('laboran');
            return true;
        }
     }">

    {{-- SECTION HEADER WITH SEARCH & FILTER TABS --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 pb-6 border-b border-gray-200">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                Pendidik &amp; Tenaga Kependidikan
            </span>
            <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                Mengenal Dewan Asatidz ({{ count($teachersList) }} GTK)
            </h2>
            <div class="w-16 h-1 bg-unit-primary rounded-full mt-2"></div>
        </div>

        {{-- SEARCH BAR --}}
        <div class="w-full md:w-80">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       x-model="search" 
                       placeholder="Cari nama guru / jabatan..." 
                       class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200 bg-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
            </div>
        </div>
    </div>

    {{-- FILTER TABS --}}
    <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-4 mb-8">
        <button type="button" 
                @click="filterRole = 'all'"
                :class="filterRole === 'all' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition">
            Semua ({{ count($teachersList) }})
        </button>
        <button type="button" 
                @click="filterRole = 'pimpinan'"
                :class="filterRole === 'pimpinan' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-user-tie text-[10px]"></i>
            <span>Pimpinan &amp; Koordinator</span>
        </button>
        <button type="button" 
                @click="filterRole = 'tahfidz'"
                :class="filterRole === 'tahfidz' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-book-quran text-[10px]"></i>
            <span>Guru Al-Qur'an &amp; Tahfidz</span>
        </button>
        <button type="button" 
                @click="filterRole = 'mapel'"
                :class="filterRole === 'mapel' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-chalkboard-user text-[10px]"></i>
            <span>Guru Kelas / Bidang Studi</span>
        </button>
        <button type="button" 
                @click="filterRole = 'staf'"
                :class="filterRole === 'staf' ? 'bg-unit-primary text-white shadow-md' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200'"
                class="px-4 py-2 rounded-full text-xs font-bold shrink-0 transition flex items-center gap-1.5">
            <i class="fa-solid fa-id-badge text-[10px]"></i>
            <span>Staf &amp; Tata Usaha</span>
        </button>
    </div>

    {{-- TEACHERS GRID (4-COL DESKTOP, 2-COL MOBILE) --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        @foreach($teachersList as $tc)
            <div x-show="matches({ name: '{{ addslashes($tc['name']) }}', role: '{{ addslashes($tc['role']) }}' })"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 flex flex-col justify-between group">
                
                {{-- PHOTO CONTAINER --}}
                <div class="h-48 sm:h-64 overflow-hidden bg-gradient-to-b from-gray-50 to-indigo-50/50 relative">
                    <img src="{{ asset($tc['photo'] ?? '/uploads/dewan/kepala-sekolah.webp') }}" 
                         alt="{{ $tc['name'] }}" 
                         class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500"
                         onerror="this.src='/uploads/dewan/kepala-sekolah.webp'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300"></div>
                    
                    {{-- TOP BADGE --}}
                    <div class="absolute top-2.5 right-2.5">
                        <span class="w-7 h-7 rounded-full bg-white/90 backdrop-blur-md text-unit-primary flex items-center justify-center text-xs shadow-sm">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </span>
                    </div>
                </div>

                {{-- CARD BODY --}}
                <div class="p-3.5 sm:p-5 text-center flex-1 flex flex-col justify-between space-y-2">
                    <div class="space-y-1">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[9px] sm:text-[10px] font-extrabold uppercase tracking-wider bg-indigo-50 text-unit-primary border border-indigo-100/60 line-clamp-1">
                            {{ $tc['role'] }}
                        </span>
                        <h3 class="text-xs sm:text-sm font-extrabold text-gray-900 group-hover:text-unit-primary transition line-clamp-2 leading-snug pt-0.5">
                            {{ $tc['name'] }}
                        </h3>
                    </div>

                    @if(!empty($tc['bio']))
                        <p class="text-[10px] sm:text-[11px] text-gray-500 line-clamp-2 leading-relaxed font-light italic">
                            “{{ $tc['bio'] }}”
                        </p>
                    @endif

                    <div class="pt-2 border-t border-gray-100 flex items-center justify-between text-[10px] text-gray-400">
                        <span class="truncate">{{ $info['code'] ?? 'SIT' }} Robbani</span>
                        <span class="text-amber-500 flex items-center gap-0.5">
                            <i class="fa-solid fa-star text-[9px]"></i>
                            <i class="fa-solid fa-star text-[9px]"></i>
                            <i class="fa-solid fa-star text-[9px]"></i>
                        </span>
                    </div>
                </div>

            </div>
        @endforeach
    </div>

    {{-- CALLOUT CONVERSION BANNER --}}
    <div class="mt-12 sm:mt-16 p-6 sm:p-10 rounded-3xl bg-gradient-to-r {{ $uTheme['nav_gradient'] }} text-white shadow-2xl flex flex-col sm:flex-row items-center justify-between gap-6 border border-white/20 text-center sm:text-left">
        <div class="space-y-2 max-w-xl">
            <span class="inline-block px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-400 text-slate-950">
                Penerimaan Santri Baru
            </span>
            <h3 class="text-xl sm:text-2xl font-black text-white tracking-tight">
                Mari Bergabung Bersama Keluarga Besar {{ $info['name'] }}
            </h3>
            <p class="text-xs sm:text-sm text-indigo-100 font-light leading-relaxed">
                Bimbingan intensif para asatidz berpengalaman menanti putra-putri tercinta untuk tumbuh menjadi generasi Qur'ani berprestasi.
            </p>
        </div>
        <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
           class="px-8 py-3.5 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-xl shadow-amber-500/30 hover:scale-105 active:scale-95 transition shrink-0 flex items-center justify-center space-x-2">
            <i class="fa-solid fa-graduation-cap text-sm"></i>
            <span>Daftar SPMB Online</span>
        </a>
    </div>

</div>
@endsection
