@extends('school.unit.layouts.master')

@section('title', 'Video Kegiatan & Dokumentasi - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Galeri video dokumentasi kegiatan, profil sekolah, murottal siswa, dan event resmi ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $videosList = !empty($unitVideos) ? $unitVideos : (!empty($info['videos']) ? $info['videos'] : []);
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
            <span class="text-amber-300 font-semibold shrink-0">Video Dokumentasi</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Video Kegiatan &amp; Dokumentasi</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Saksikan liputan visual resmi kegiatan belajar, munaqosah tahfidz, seminar parenting, dan kebersamaan siswa {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA WITH YOUTUBE PLAYER MODAL --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14"
     x-data="{ 
        activeVideo: null,
        activeTitle: '',
        openVideo(id, title) {
            this.activeVideo = id;
            this.activeTitle = title;
        },
        closeVideo() {
            this.activeVideo = null;
        }
     }">

    {{-- YOUTUBE CHANNEL HEADER BANNER --}}
    <div class="bg-gradient-to-r from-red-950 via-slate-900 to-red-950 rounded-3xl p-6 sm:p-8 border border-red-900/60 text-white shadow-2xl flex flex-col md:flex-row items-center justify-between gap-6 mb-10 sm:mb-12">
        <div class="flex items-center space-x-4 text-center md:text-left">
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-2xl bg-red-600 text-white flex items-center justify-center text-3xl shrink-0 shadow-lg shadow-red-600/40">
                <i class="fa-brands fa-youtube"></i>
            </div>
            <div>
                <span class="text-[10px] font-black uppercase tracking-wider text-amber-400 block">
                    Saluran YouTube Resmi
                </span>
                <h2 class="text-lg sm:text-2xl font-black text-white">
                    SIT Robbani Official Channel
                </h2>
                <p class="text-xs text-slate-300 font-light mt-0.5">
                    Liputan kegiatan, ceramah parenting, podcast edukasi, dan murottal siswa.
                </p>
            </div>
        </div>
        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" 
           class="px-7 py-3 rounded-full font-black text-xs uppercase tracking-wider bg-red-600 hover:bg-red-700 text-white shadow-xl shadow-red-600/30 hover:scale-105 active:scale-95 transition flex items-center space-x-2 shrink-0">
            <i class="fa-brands fa-youtube text-base"></i>
            <span>Subscribe Channel</span>
        </a>
    </div>

    {{-- 3-COLUMN VIDEO GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @forelse($videosList as $v)
            @php
                $embedId = $v['embed_id'] ?? '';
                if (empty($embedId) && !empty($v['url'])) {
                    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $v['url'], $match)) {
                        $embedId = $match[1];
                    }
                }
                $rawThumb = !empty($v['thumbnail']) ? $v['thumbnail'] : (!empty($v['image']) ? $v['image'] : '');
                if (!empty($embedId) && (empty($rawThumb) || str_contains($rawThumb, 'mockup') || str_contains($rawThumb, 'logo-robbani') || str_contains($rawThumb, 'galeri-'))) {
                    $videoThumb = "https://img.youtube.com/vi/{$embedId}/hqdefault.jpg";
                } elseif (!empty($rawThumb)) {
                    $videoThumb = (str_starts_with($rawThumb, 'http://') || str_starts_with($rawThumb, 'https://')) ? $rawThumb : asset($rawThumb);
                } elseif (!empty($embedId)) {
                    $videoThumb = "https://img.youtube.com/vi/{$embedId}/hqdefault.jpg";
                } else {
                    $videoThumb = asset('/images/mockup_desktop_4.png');
                }
            @endphp
            <div class="bg-white rounded-3xl overflow-hidden shadow-md hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 flex flex-col justify-between group reveal-fade-up">
                
                {{-- THUMBNAIL WITH PLAY BUTTON --}}
                <div class="relative h-48 sm:h-52 bg-slate-900 flex items-center justify-center overflow-hidden cursor-pointer"
                     @if(!empty($embedId))
                        @click="openVideo('{{ $embedId }}', '{{ addslashes($v['title'] ?? '') }}')"
                     @else
                        onclick="window.open('{{ $v['url'] ?? 'https://youtube.com' }}', '_blank')"
                     @endif>
                    <img src="{{ $videoThumb }}" 
                         alt="{{ $v['title'] }}" 
                         class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition duration-500"
                         onerror="this.onerror=null; @if(!empty($embedId)) this.src='https://img.youtube.com/vi/{{ $embedId }}/hqdefault.jpg'; @else this.src='/images/mockup_desktop_4.png'; @endif">
                    <div class="absolute inset-0 bg-black/25 group-hover:bg-black/10 transition duration-300"></div>

                    {{-- PLAY BUTTON BADGE --}}
                    <div class="absolute w-14 h-14 rounded-full bg-red-600 text-white flex items-center justify-center text-xl shadow-2xl shadow-red-600/50 group-hover:scale-110 group-hover:bg-red-700 transition duration-300">
                        <i class="fa-solid fa-play ml-1"></i>
                    </div>

                    {{-- VIDEO BADGE --}}
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-black/70 text-white backdrop-blur-md">
                            {{ $info['code'] ?? 'SIT' }} Video
                        </span>
                    </div>
                </div>

                {{-- CARD BODY --}}
                <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between space-y-3">
                    <div class="space-y-1.5">
                        <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider block">
                            {{ $v['date'] ?? 'Dokumentasi Resmi' }}
                        </span>
                        <h3 class="text-sm sm:text-base font-extrabold text-gray-900 group-hover:text-unit-primary transition leading-snug line-clamp-2">
                            {{ $v['title'] }}
                        </h3>
                        @if(!empty($v['desc']))
                            <p class="text-xs text-gray-500 line-clamp-2 font-light leading-relaxed">
                                {{ $v['desc'] }}
                            </p>
                        @endif
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-unit-primary font-bold">
                        <span class="flex items-center gap-1.5">
                            <i class="fa-brands fa-youtube text-red-600"></i> Putar Video
                        </span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition duration-200"></i>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-3 bg-white rounded-3xl p-12 text-center text-gray-400 border border-gray-100">
                <i class="fa-brands fa-youtube text-4xl mb-2 text-red-500"></i>
                <p class="text-xs">Dokumentasi video sedang diperbarui.</p>
            </div>
        @endforelse
    </div>

    {{-- INTERACTIVE YOUTUBE PLAYER MODAL --}}
    <div x-show="activeVideo" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="closeVideo()"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
         style="display: none;">
        
        <div class="relative max-w-4xl w-full bg-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-white/20"
             @click.away="closeVideo()">
            
            <button @click="closeVideo()" 
                    class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-black/60 text-white hover:bg-red-600 transition flex items-center justify-center text-sm focus:outline-none">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="aspect-video w-full bg-black">
                <template x-if="activeVideo">
                    <iframe :src="'https://www.youtube-nocookie.com/embed/' + activeVideo + '?autoplay=1&rel=0'" 
                            title="YouTube video player" 
                            class="w-full h-full"
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen></iframe>
                </template>
            </div>

            <div class="p-5 text-white bg-slate-900">
                <h3 class="text-sm sm:text-lg font-bold" x-text="activeTitle"></h3>
            </div>

        </div>
    </div>

</div>
@endsection
