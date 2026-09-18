@extends('school.unit.layouts.master')

@section('title', 'Visi & Misi Sekolah - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Visi & Misi resmi ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . ': Membentuk generasi Qur\'ani, berakhlak mulia, dan unggul dalam sains teknologi.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
@endphp

@section('content')
{{-- SUBPAGE HERO HEADER --}}
<div class="bg-gradient-to-r {{ $uTheme['nav_gradient'] }} border-b border-indigo-950 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="text-xs text-indigo-200 mb-3 flex items-center space-x-2">
            <a href="{{ url('/unit/' . $codeLower) }}" class="hover:text-white transition">Beranda</a>
            <span>/</span>
            <span>Profil</span>
            <span>/</span>
            <span class="text-amber-300 font-semibold">Visi dan Misi</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Visi &amp; Misi Sekolah</h1>
        <p class="text-sm text-indigo-100 mt-2 font-light max-w-2xl">
            Arah dan komitmen luhur {{ $info['name'] }} dalam membimbing generasi unggul berkarakter Qur'ani dan berwawasan masa depan.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        {{-- KOLOM UTAMA (8/12) --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- KARTU VISI SEKOLAH --}}
            <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50/80 text-unit-primary flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
                        <i class="fa-solid fa-compass"></i>
                    </div>
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-orange-500 block">Falsafah Arah</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Visi Sekolah</h2>
                    </div>
                </div>
                <div class="w-16 h-1 bg-unit-primary rounded-full mb-6"></div>

                <div class="bg-gradient-to-r from-indigo-50/50 via-amber-50/40 to-white p-6 sm:p-8 rounded-2xl border-l-4 border-unit-primary shadow-sm">
                    <p class="text-lg sm:text-xl font-bold text-gray-900 leading-relaxed font-serif italic text-center sm:text-left">
                        “{{ $info['vision'] }}”
                    </p>
                </div>
            </div>

            {{-- KARTU MISI SEKOLAH --}}
            <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up delay-1">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
                        <i class="fa-solid fa-list-check"></i>
                    </div>
                    <div>
                        <span class="text-xs font-black uppercase tracking-wider text-orange-600 block">Langkah Konkret</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Misi Sekolah</h2>
                    </div>
                </div>
                <div class="w-16 h-1 bg-orange-500 rounded-full mb-8"></div>

                <div class="space-y-6">
                    @php
                        $missions = $info['missions'] ?? [];
                        $bgBadges = ['bg-unit-primary', 'bg-orange-500', 'bg-unit-primary', 'bg-orange-500'];
                        $hoverBorders = ['hover:border-indigo-300', 'hover:border-orange-300', 'hover:border-indigo-300', 'hover:border-orange-300'];
                    @endphp

                    @foreach($missions as $index => $misi)
                        @php
                            $badgeColor = $bgBadges[$index % count($bgBadges)];
                            $hoverColor = $hoverBorders[$index % count($hoverBorders)];
                            $title = is_array($misi) ? ($misi['title'] ?? '') : 'Misi #' . ($index + 1);
                            $desc = is_array($misi) ? ($misi['desc'] ?? '') : $misi;
                        @endphp
                        <div class="flex items-start space-x-4 p-5 rounded-2xl bg-gray-50/80 border border-gray-100 {{ $hoverColor }} transition">
                            <div class="w-9 h-9 rounded-xl {{ $badgeColor }} text-white flex items-center justify-center font-extrabold text-sm flex-shrink-0 shadow">
                                {{ $index + 1 }}
                            </div>
                            <div class="space-y-1">
                                <h3 class="font-bold text-sm sm:text-base text-gray-900">{{ $title }}</h3>
                                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                    {{ $desc }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- KOLOM SIDEBAR (4/12) --}}
        <div class="lg:col-span-4">
            @include('school.unit.partials.sidebar')
        </div>

    </div>
</div>
@endsection
