@extends('school.unit.layouts.master')

@section('title', 'Agenda Akademik & Santri - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Agenda akademik, kalender kegiatan, ujian tahfidz, dan event penting ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $agendaList = !empty($unitAgendas) ? $unitAgendas : (!empty($info['agenda']) ? $info['agenda'] : []);
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
            <span class="text-amber-300 font-semibold shrink-0">Agenda Akademik</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Agenda Akademik &amp; Kegiatan</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Jadwal kegiatan terpadu, kalender akademik, ujian munaqosah tahfidz, dan agenda santri {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14"
     x-data="{ 
        search: '', 
        filterCategory: 'all',
        matches(ag) {
            const matchesSearch = !this.search || ag.title.toLowerCase().includes(this.search.toLowerCase()) || ag.desc.toLowerCase().includes(this.search.toLowerCase()) || ag.location.toLowerCase().includes(this.search.toLowerCase());
            if (!matchesSearch) return false;
            if (this.filterCategory === 'all') return true;
            if (this.filterCategory === 'akademik') return ag.title.toLowerCase().includes('akademik') || ag.title.toLowerCase().includes('ujian') || ag.title.toLowerCase().includes('rapor') || ag.title.toLowerCase().includes('laporan');
            if (this.filterCategory === 'santri') return ag.title.toLowerCase().includes('camping') || ag.title.toLowerCase().includes('renang') || ag.title.toLowerCase().includes('outbond') || ag.title.toLowerCase().includes('festival');
            if (this.filterCategory === 'tahfidz') return ag.title.toLowerCase().includes('tahfidz') || ag.title.toLowerCase().includes('munaqosah') || ag.title.toLowerCase().includes('tasmi');
            return true;
        }
     }">

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
        
        {{-- MAIN COLUMN (8/12) --}}
        <div class="lg:col-span-8 space-y-6">
            
            {{-- SEARCH & FILTER BAR --}}
            <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-sm border border-gray-100 space-y-4">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <div class="relative w-full sm:w-72">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                        <input type="text" 
                               x-model="search" 
                               placeholder="Cari agenda kegiatan..." 
                               class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-200 bg-gray-50 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <span class="text-xs text-gray-500 font-semibold self-end sm:self-auto">
                        Total: {{ count($agendaList) }} Agenda Terjadwal
                    </span>
                </div>

                {{-- CATEGORY FILTER PILLS --}}
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pt-2 border-t border-gray-100">
                    <button type="button" 
                            @click="filterCategory = 'all'"
                            :class="filterCategory === 'all' ? 'bg-unit-primary text-white shadow' : 'bg-gray-50 text-gray-700 hover:bg-gray-100'"
                            class="px-3.5 py-1.5 rounded-full text-xs font-bold shrink-0 transition">
                        Semua Agenda
                    </button>
                    <button type="button" 
                            @click="filterCategory = 'akademik'"
                            :class="filterCategory === 'akademik' ? 'bg-unit-primary text-white shadow' : 'bg-gray-50 text-gray-700 hover:bg-gray-100'"
                            class="px-3.5 py-1.5 rounded-full text-xs font-bold shrink-0 transition">
                        Akademik &amp; Ujian
                    </button>
                    <button type="button" 
                            @click="filterCategory = 'santri'"
                            :class="filterCategory === 'santri' ? 'bg-unit-primary text-white shadow' : 'bg-gray-50 text-gray-700 hover:bg-gray-100'"
                            class="px-3.5 py-1.5 rounded-full text-xs font-bold shrink-0 transition">
                        Kegiatan Santri
                    </button>
                    <button type="button" 
                            @click="filterCategory = 'tahfidz'"
                            :class="filterCategory === 'tahfidz' ? 'bg-unit-primary text-white shadow' : 'bg-gray-50 text-gray-700 hover:bg-gray-100'"
                            class="px-3.5 py-1.5 rounded-full text-xs font-bold shrink-0 transition">
                        Tahfidz &amp; Munaqosah
                    </button>
                </div>
            </div>

            {{-- AGENDA LIST CARDS --}}
            <div class="space-y-4">
                @forelse($agendaList as $ag)
                    <div x-show="matches({ title: '{{ addslashes($ag['title'] ?? '') }}', desc: '{{ addslashes($ag['desc'] ?? '') }}', location: '{{ addslashes($ag['location'] ?? '') }}' })"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="bg-white rounded-3xl p-4 sm:p-6 shadow-md hover:shadow-xl hover:border-indigo-200 border border-gray-100 transition duration-300 flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 group">
                        
                        {{-- CALENDAR DATE BADGE --}}
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-indigo-50 text-unit-primary border border-indigo-100 flex flex-col items-center justify-center shrink-0 shadow-inner group-hover:scale-105 transition">
                            <span class="text-xl sm:text-2xl font-black leading-none">{{ $ag['date_day'] ?? '15' }}</span>
                            <span class="text-[10px] sm:text-xs font-extrabold uppercase mt-1 tracking-wider text-amber-600">{{ $ag['date_month'] ?? 'AGU' }}</span>
                        </div>

                        {{-- DETAILS --}}
                        <div class="space-y-1.5 flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-wider bg-gray-100 text-gray-700">
                                    {{ $ag['date'] ?? 'Jadwal Mendatang' }}
                                </span>
                                @if(!empty($ag['time']))
                                    <span class="text-[11px] text-gray-500 font-medium flex items-center gap-1">
                                        <i class="fa-regular fa-clock text-amber-500"></i>
                                        <span>{{ $ag['time'] }}</span>
                                    </span>
                                @endif
                            </div>

                            <h3 class="text-sm sm:text-base font-extrabold text-gray-900 group-hover:text-unit-primary transition leading-snug">
                                {{ $ag['title'] }}
                            </h3>

                            @if(!empty($ag['location']))
                                <p class="text-xs text-gray-500 flex items-center gap-1.5 font-medium">
                                    <i class="fa-solid fa-location-dot text-amber-500 text-xs"></i>
                                    <span>{{ $ag['location'] }}</span>
                                </p>
                            @endif

                            @if(!empty($ag['desc']))
                                <p class="text-xs text-gray-600 leading-relaxed font-light line-clamp-2 pt-0.5">
                                    {{ $ag['desc'] }}
                                </p>
                            @endif
                        </div>

                        {{-- ACTION / STATUS BADGE --}}
                        <div class="self-end sm:self-center shrink-0 pt-2 sm:pt-0">
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-[10px] font-extrabold bg-indigo-50 text-unit-primary border border-indigo-100">
                                <i class="fa-solid fa-calendar-check text-[9px]"></i>
                                <span>Terjadwal</span>
                            </span>
                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-3xl p-10 text-center text-gray-400 border border-gray-100">
                        <i class="fa-solid fa-calendar-xmark text-3xl mb-2 text-gray-300"></i>
                        <p class="text-xs">Belum ada agenda kegiatan terjadwal.</p>
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
