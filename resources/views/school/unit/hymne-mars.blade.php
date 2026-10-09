@extends('school.unit.layouts.master')

@section('title', 'Mars JSIT & Hymne Sekolah - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Lirik resmi dan video Mars JSIT Indonesia serta Hymne ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Pedoman semangat siswa dan pendidik SIT.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $hymneMars = $info['hymne_mars'] ?? \App\Http\Controllers\SchoolWebsiteController::getDefaultHymneMars($info['name'] ?? 'Sekolah Islam Terpadu');
    $ytUrl = $hymneMars['youtube_url'] ?? 'https://www.youtube.com/watch?v=ijDo1wLvZ6w';
    $ytId = 'ijDo1wLvZ6w';
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $ytUrl, $match)) {
        $ytId = $match[1];
    }
    $audioUrl = $hymneMars['audio_url'] ?? 'uploads/mars-jsit.mp3';
    $audioSrc = (str_starts_with($audioUrl, 'http://') || str_starts_with($audioUrl, 'https://')) ? $audioUrl : asset($audioUrl);
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
            <span class="text-amber-300 font-semibold shrink-0">Mars JSIT &amp; Hymne</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Mars JSIT Indonesia &amp; Hymne Sekolah</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Lagu kebanggaan civitas akademika {{ $info['name'] }} sebagai bagian dari Jaringan Sekolah Islam Terpadu (JSIT) Indonesia dalam membina generasi yang unggul dan berakhlak mulia.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14 space-y-12">

    {{-- SECTION 1: MARS JSIT INDONESIA (SESUAI WEB REFERENSI) --}}
    <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 space-y-8">
        
        {{-- HEADER & YOUTUBE BUTTON --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-gray-100">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-unit-primary block">
                    Lagu Resmi Sekolah Islam Terpadu
                </span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mt-1 tracking-tight">
                    {{ $hymneMars['mars_title'] ?? 'MARS JSIT INDONESIA' }}
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 mt-1">
                    {{ $hymneMars['mars_subtitle'] ?? 'Pedoman semangat siswa & pendidik Jaringan Sekolah Islam Terpadu (JSIT) se-Indonesia' }}
                </p>
            </div>
            @if(!empty($ytUrl))
            <a href="{{ $ytUrl }}" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="inline-flex items-center space-x-2 bg-[#da251c] hover:bg-[#b91c1c] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition shrink-0 transform hover:scale-105">
                <i class="fa-brands fa-youtube text-base"></i>
                <span>Tonton di YouTube</span>
            </a>
            @endif
        </div>

        {{-- VIDEO YOUTUBE EMBED --}}
        @if(!empty($ytId))
        <div class="bg-slate-950 rounded-2xl p-3 sm:p-4 border border-slate-800 space-y-3 shadow-2xl">
            <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-inner">
                <iframe 
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/{{ $ytId }}?rel=0" 
                    title="Mars Jaringan Sekolah Islam Terpadu (JSIT) Indonesia Resmi" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>
            <div class="flex items-center justify-between px-2 text-xs text-slate-300">
                <span class="flex items-center gap-1.5 font-medium">
                    <i class="fa-solid fa-circle-play text-red-500"></i>
                    {{ $hymneMars['mars_title'] ?? 'Mars Resmi JSIT Indonesia' }}
                </span>
                <span class="text-slate-400 font-light">Audio &amp; Lirik Resmi</span>
            </div>
        </div>
        @endif

        {{-- AUDIO PLAYER BAR --}}
        @if(!empty($audioUrl))
        <div class="bg-gray-50 dark:bg-slate-900 rounded-2xl p-4 sm:p-5 border border-gray-200 dark:border-slate-800 space-y-2.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <i class="fa-solid fa-headphones text-unit-primary dark:text-cyan-400 text-sm"></i>
                    <span>Dengarkan Audio Mars JSIT</span>
                </span>
                <span class="text-[11px] text-gray-500 dark:text-slate-400 font-medium">Format Audio Player</span>
            </div>
            <audio controls class="w-full focus:outline-none rounded-lg">
                <source src="{{ $audioSrc }}" type="audio/mpeg">
                Browser Anda tidak mendukung pemutar audio.
            </audio>
        </div>
        @endif

        {{-- LIRIK MARS JSIT INDONESIA --}}
        <div class="bg-gradient-to-b from-indigo-50/40 via-white to-transparent dark:from-slate-900 dark:via-slate-900 dark:to-slate-900 p-6 sm:p-10 rounded-2xl border border-indigo-100 dark:border-slate-800 text-center space-y-6 text-sm sm:text-base text-gray-800 dark:text-slate-200 leading-relaxed font-serif">
            <h3 class="font-sans text-xs font-black text-unit-primary dark:text-amber-400 uppercase tracking-widest mb-4">
                LIRIK MARS RESMI JSIT INDONESIA
            </h3>

            <div class="prose max-w-none text-slate-800 dark:text-slate-200 font-medium leading-relaxed">
                {!! nl2br(e($hymneMars['mars_lyrics'] ?? '')) !!}
            </div>
        </div>

        {{-- 10 KARAKTER SISWA JSIT (MUWASHOFAT) --}}
        @if(!empty($hymneMars['muwashofat']))
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 dark:from-slate-900 dark:to-slate-900 rounded-2xl p-6 sm:p-8 border border-emerald-200 dark:border-slate-800">
            <h4 class="text-base sm:text-lg font-bold text-emerald-950 dark:text-emerald-300 flex items-center mb-2 gap-2">
                <i class="fa-solid fa-medal text-emerald-600"></i>
                <span>10 Karakter Siswa JSIT (Muwashofat)</span>
            </h4>
            <p class="text-xs text-gray-700 dark:text-slate-300 mb-5 leading-relaxed font-medium">
                Sebagai sekolah anggota resmi Jaringan Sekolah Islam Terpadu (JSIT) Indonesia, {{ $info['name'] }} menanamkan 10 standar kompetensi lulusan karakter siswa:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-800 dark:text-slate-200 font-medium">
                @foreach($hymneMars['muwashofat'] as $idx => $m)
                <div class="flex items-center space-x-3 bg-white dark:bg-slate-800 p-3.5 rounded-xl border border-emerald-100 dark:border-slate-700 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">{{ $m['no'] ?? ($idx + 1) }}</span>
                    <span><strong>{{ $m['title'] ?? '' }}</strong>@if(!empty($m['desc'])) ({{ $m['desc'] }})@endif</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    {{-- SECTION 2: HYMNE SIT ROBBANI --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 dark:border-slate-800 space-y-6">
        <div class="flex items-center space-x-3 pb-4 border-b border-gray-100 dark:border-slate-800">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-slate-800 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shrink-0 shadow-inner">
                <i class="fa-solid fa-star-and-crescent"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-unit-primary dark:text-cyan-400 block">Senandung Jiwa Qur'ani</span>
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 dark:text-white tracking-tight">{{ $hymneMars['hymne_title'] ?? 'Hymne Sekolah Robbani' }}</h2>
            </div>
        </div>

        @if(!empty($hymneMars['hymne_subtitle']))
        <div class="bg-amber-50/70 dark:bg-slate-800/80 rounded-2xl p-4 border border-amber-200/80 dark:border-slate-700 space-y-1">
            <span class="text-xs font-bold text-amber-900 dark:text-amber-300 block flex items-center gap-1.5">
                <i class="fa-solid fa-heart text-amber-600"></i>
                <span>Nilai Luhur &amp; Karakter Robbani</span>
            </span>
            <p class="text-xs text-amber-800 dark:text-amber-200/90 font-light leading-relaxed">
                {{ $hymneMars['hymne_subtitle'] }}
            </p>
        </div>
        @endif

        <div class="prose-content text-xs sm:text-sm text-gray-700 dark:text-slate-200 leading-relaxed font-serif space-y-4 text-center py-4 bg-gradient-to-b from-amber-50/20 to-transparent dark:from-slate-800/50 dark:to-transparent p-5 rounded-2xl border border-amber-50 dark:border-slate-800">
            <div class="prose max-w-none text-slate-800 font-medium leading-relaxed">
                {!! nl2br(e($hymneMars['hymne_lyrics'] ?? '')) !!}
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
            <span>{{ $info['name'] }}</span>
            <span class="font-bold text-amber-600">Generasi Qur'ani &amp; Berkarakter</span>
        </div>
    </div>

</div>
@endsection
