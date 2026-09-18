@extends('school.unit.layouts.master')

@section('title', 'Pengumuman Resmi - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Pengumuman resmi, surat edaran dinas & sekolah, kalender libur, dan warta penting ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $announcementList = !empty($unitAnnouncements) ? $unitAnnouncements : (!empty($info['announcements']) ? $info['announcements'] : []);
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
            <span class="text-amber-300 font-semibold shrink-0">Pengumuman</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Pengumuman Resmi Sekolah</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Pemberitahuan kedinasan, surat edaran pimpinan sekolah, jadwal libur siswa, serta pengumuman penting bagi wali murid {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14"
     x-data="{ 
        search: '',
        matches(item) {
            return !this.search || item.title.toLowerCase().includes(this.search.toLowerCase()) || item.summary.toLowerCase().includes(this.search.toLowerCase());
        }
     }">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
        
        {{-- MAIN COLUMN (8/12) --}}
        <div class="lg:col-span-8 space-y-6">
            
            {{-- SEARCH & FILTER BAR --}}
            <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="relative w-full sm:w-80">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    <input type="text" 
                           x-model="search" 
                           placeholder="Cari pengumuman..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-full border border-gray-200 bg-gray-50 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <span class="text-xs text-gray-500 font-semibold self-end sm:self-auto">
                    {{ count($announcementList) }} Warta Resmi
                </span>
            </div>

            {{-- ANNOUNCEMENT CARDS --}}
            <div class="space-y-4">
                @forelse($announcementList as $an)
                    <div x-show="matches({ title: '{{ addslashes($an['title'] ?? '') }}', summary: '{{ addslashes($an['summary'] ?? '') }}' })"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white rounded-3xl p-5 sm:p-7 shadow-md hover:shadow-xl hover:border-indigo-200 border border-gray-100 transition duration-300 space-y-3 group">
                        
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center space-x-2">
                                <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xs shadow-inner">
                                    <i class="fa-solid fa-bullhorn"></i>
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-indigo-50 text-unit-primary border border-indigo-100">
                                    {{ $an['category'] ?? 'Pengumuman Resmi' }}
                                </span>
                            </div>
                            <span class="text-[11px] text-gray-400 font-medium flex items-center gap-1">
                                <i class="fa-regular fa-clock text-[10px]"></i>
                                <span>{{ $an['date'] ?? '18 Sep 2026' }}</span>
                            </span>
                        </div>

                        <h3 class="text-base sm:text-lg font-black text-gray-900 group-hover:text-unit-primary transition leading-snug">
                            {{ $an['title'] }}
                        </h3>

                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-light text-justify">
                            {{ $an['summary'] ?? ($an['desc'] ?? 'Pemberitahuan resmi dari pihak sekolah untuk seluruh wali murid, guru, dan peserta didik.') }}
                        </p>

                        <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-[10px] text-gray-400 font-medium">
                                Unit: {{ $info['name'] }}
                            </span>
                            <a href="{{ $an['link'] ?? url('/unit/' . $codeLower . '/download') }}" 
                               class="inline-flex items-center space-x-1.5 text-xs font-bold text-unit-primary hover:underline">
                                <span>Unduh Surat / Lihat Info</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-10 text-center text-gray-400 border border-gray-100">
                        <i class="fa-solid fa-envelope-open-text text-3xl mb-2 text-gray-300"></i>
                        <p class="text-xs">Belum ada pengumuman terbaru.</p>
                    </div>
                @endforelse
            </div>

        </div>

        {{-- SIDEBAR COLUMN (4/12) --}}
        <div class="lg:col-span-4 space-y-6">
            @include('school.unit.partials.sidebar')
        </div>

    </div>

</div>
@endsection
