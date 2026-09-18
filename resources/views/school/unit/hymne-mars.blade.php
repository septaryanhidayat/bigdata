@extends('school.unit.layouts.master')

@section('title', 'Mars JSIT & Hymne Sekolah - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Lirik resmi Mars JSIT Indonesia dan Hymne Sekolah ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Penyemangat dakwah pendidikan Islam terpadu.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
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
            <span class="text-amber-300 font-semibold shrink-0">Mars &amp; Hymne</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Mars JSIT &amp; Hymne Sekolah</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Lagu perjuangan dan syair kebangkitan pendidikan Islam terpadu yang menggelorakan semangat santri {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14 space-y-12">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-10">
        
        {{-- KOLOM 1: MARS JSIT INDONESIA --}}
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-unit-primary flex items-center justify-center text-xl shrink-0 shadow-inner">
                        <i class="fa-solid fa-music"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-amber-500 block">Jaringan Sekolah Islam Terpadu</span>
                        <h2 class="text-lg sm:text-2xl font-black text-gray-900 tracking-tight">Mars JSIT Indonesia</h2>
                    </div>
                </div>

                {{-- AUDIO PLAYER BAR --}}
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200/80 space-y-2">
                    <span class="text-[11px] font-bold text-gray-700 block flex items-center gap-2">
                        <i class="fa-solid fa-headphones text-unit-primary"></i>
                        <span>Dengarkan Audio Mars JSIT</span>
                    </span>
                    <audio controls class="w-full">
                        <source src="/uploads/mars-jsit.mp3" type="audio/mpeg">
                        Browser Anda tidak mendukung pemutar audio.
                    </audio>
                </div>

                {{-- LYRICS --}}
                <div class="prose-content text-xs sm:text-sm text-gray-700 leading-relaxed font-serif space-y-4 text-center py-2 bg-gradient-to-b from-indigo-50/20 to-transparent p-5 rounded-2xl border border-indigo-50">
                    <p class="font-bold text-gray-900 not-italic font-sans text-xs uppercase tracking-wider text-unit-primary">
                        Bait I
                    </p>
                    <p>
                        Bangkitlah bangsaku, tegaklah agamaku<br>
                        Bersama JSIT Indonesia tercinta<br>
                        Membina tunas bangsa berakhlak mulia<br>
                        Berilmu, beriman, dan bertaqwa
                    </p>

                    <p class="font-bold text-gray-900 not-italic font-sans text-xs uppercase tracking-wider text-unit-primary pt-2">
                        Reff / Koor
                    </p>
                    <p class="font-semibold text-gray-900">
                        Sekolah Islam Terpadu<br>
                        Menyatu dalam tekad yang padu<br>
                        Mencetak generasi rabbani sejati<br>
                        Harapan umat, jayalah negeri
                    </p>

                    <p class="font-bold text-gray-900 not-italic font-sans text-xs uppercase tracking-wider text-unit-primary pt-2">
                        Bait II
                    </p>
                    <p>
                        Al-Qur'an dan Sunnah panduan hidup kita<br>
                        Teguhkan langkahmu gapai cita mulia<br>
                        Sambut masa depan gemilang bercahaya<br>
                        Maju dan jaya JSIT Indonesia!
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <span>Standar Mutu JSIT Indonesia</span>
                <span class="font-bold text-unit-primary">Robbani Indralaya</span>
            </div>
        </div>

        {{-- KOLOM 2: HYMNE SIT ROBBANI --}}
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0 shadow-inner">
                        <i class="fa-solid fa-star-and-crescent"></i>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-unit-primary block">Senandung Cinta Al-Qur'an</span>
                        <h2 class="text-lg sm:text-2xl font-black text-gray-900 tracking-tight">Hymne Sekolah Robbani</h2>
                    </div>
                </div>

                {{-- VALUE HIGHLIGHT --}}
                <div class="bg-amber-50/70 rounded-2xl p-4 border border-amber-200/80 space-y-1">
                    <span class="text-[11px] font-bold text-amber-900 block flex items-center gap-1.5">
                        <i class="fa-solid fa-heart text-amber-600"></i>
                        <span>Nilai Luhur &amp; Karakter Robbani</span>
                    </span>
                    <p class="text-xs text-amber-800 font-light leading-relaxed">
                        Lirik hymne mengingatkan setiap santri dan asatidz akan niat ikhlas lillahi ta'ala dalam menuntut ilmu dan beramal sholeh.
                    </p>
                </div>

                {{-- LYRICS --}}
                <div class="prose-content text-xs sm:text-sm text-gray-700 leading-relaxed font-serif space-y-4 text-center py-2 bg-gradient-to-b from-amber-50/20 to-transparent p-5 rounded-2xl border border-amber-50">
                    <p class="font-bold text-gray-900 not-italic font-sans text-xs uppercase tracking-wider text-amber-600">
                        Bait I
                    </p>
                    <p>
                        Di bumi Indralaya nan damai permai<br>
                        Tumbuh mekar generasi Robbani<br>
                        Menuntut ilmu ikhlas di hati<br>
                        Cinta Allah dan Rasul abadi
                    </p>

                    <p class="font-bold text-gray-900 not-italic font-sans text-xs uppercase tracking-wider text-amber-600 pt-2">
                        Reff
                    </p>
                    <p class="font-semibold text-gray-900">
                        Robbani sekolah kebanggaanku<br>
                        Tempat terukir ilmu dan adabku<br>
                        Hafidz Al-Qur'an pedoman langkahku<br>
                        Menjadi lentera bagi bangsaku
                    </p>

                    <p class="font-bold text-gray-900 not-italic font-sans text-xs uppercase tracking-wider text-amber-600 pt-2">
                        Penutup
                    </p>
                    <p>
                        Kuserahkan jiwa dan raga ini<br>
                        Membela kebenaran ilahi<br>
                        Jayalah selalu Robbani tercinta<br>
                        Hingga akhir masa menyapa
                    </p>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <span>{{ $info['name'] }}</span>
                <span class="font-bold text-amber-600">Generasi Qur'ani</span>
            </div>
        </div>

    </div>

</div>
@endsection
