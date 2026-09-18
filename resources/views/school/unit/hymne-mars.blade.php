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
                    MARS JSIT INDONESIA
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 mt-1">
                    Pedoman semangat siswa &amp; pendidik Jaringan Sekolah Islam Terpadu (JSIT) se-Indonesia
                </p>
            </div>
            <a href="https://www.youtube.com/watch?v=ijDo1wLvZ6w" 
               target="_blank" 
               rel="noopener noreferrer" 
               class="inline-flex items-center space-x-2 bg-[#da251c] hover:bg-[#b91c1c] text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition shrink-0 transform hover:scale-105">
                <i class="fa-brands fa-youtube text-base"></i>
                <span>Tonton di YouTube</span>
            </a>
        </div>

        {{-- VIDEO YOUTUBE EMBED --}}
        <div class="bg-slate-950 rounded-2xl p-3 sm:p-4 border border-slate-800 space-y-3 shadow-2xl">
            <div class="relative w-full aspect-video rounded-xl overflow-hidden shadow-inner">
                <iframe 
                    class="w-full h-full"
                    src="https://www.youtube.com/embed/ijDo1wLvZ6w?rel=0" 
                    title="Mars Jaringan Sekolah Islam Terpadu (JSIT) Indonesia Resmi" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>
            <div class="flex items-center justify-between px-2 text-xs text-slate-300">
                <span class="flex items-center gap-1.5 font-medium">
                    <i class="fa-solid fa-circle-play text-red-500"></i>
                    Mars Resmi JSIT Indonesia
                </span>
                <span class="text-slate-400 font-light">Audio &amp; Lirik Resmi</span>
            </div>
        </div>

        {{-- AUDIO PLAYER BAR --}}
        <div class="bg-gray-50 rounded-2xl p-4 sm:p-5 border border-gray-200 space-y-2.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-headphones text-unit-primary text-sm"></i>
                    <span>Dengarkan Audio Mars JSIT</span>
                </span>
                <span class="text-[11px] text-gray-500 font-medium">Format MP3 Stereo</span>
            </div>
            <audio controls class="w-full focus:outline-none rounded-lg">
                <source src="{{ asset('uploads/mars-jsit.mp3') }}" type="audio/mpeg">
                Browser Anda tidak mendukung pemutar audio.
            </audio>
        </div>

        {{-- LIRIK MARS JSIT INDONESIA --}}
        <div class="bg-gradient-to-b from-indigo-50/40 via-white to-transparent p-6 sm:p-10 rounded-2xl border border-indigo-100 text-center space-y-6 text-sm sm:text-base text-gray-800 leading-relaxed font-serif">
            <h3 class="font-sans text-xs font-black text-unit-primary uppercase tracking-widest mb-4">
                LIRIK MARS RESMI JSIT INDONESIA
            </h3>

            <div class="space-y-2">
                <span class="font-sans text-[11px] font-bold text-gray-400 uppercase tracking-widest block">Bait I</span>
                <p class="text-slate-800 font-medium">
                    Dengan berbekal semangat kami melangkah<br>
                    Menjalin ukhuwah dengan tekad membaja<br>
                    Menuju mutu pendidikan Indonesia<br>
                    Melahirkan generasi cerdas mulia (2x)
                </p>
            </div>

            <div class="py-4 my-2 border-y border-indigo-100/80 bg-white/70 rounded-xl shadow-xs">
                <span class="font-sans text-xs font-black text-amber-600 uppercase tracking-widest block mb-1">Reff / Koor</span>
                <p class="font-bold text-gray-900 text-base sm:text-lg">
                    Kami Jaringan Sekolah Islam Terpadu<br>
                    Sambut masa depan wajah Indonesia baru<br>
                    Bersama tinggikan martabat dan citra guru<br>
                    Indonesia pasti maju! (pasti maju)
                </p>
            </div>

            <div class="space-y-2">
                <span class="font-sans text-[11px] font-bold text-gray-400 uppercase tracking-widest block">Bait II</span>
                <p class="text-slate-800 font-medium">
                    Di sinilah tempat kami berkarya<br>
                    Menggapai harapan meraih cita-cita<br>
                    Sebagai penggerak dan pemberdaya bangsa<br>
                    Wujudkan masyarakat cerdas dan sejahtera (2x)
                </p>
            </div>

            <div class="py-4 my-2 border-y border-indigo-100/80 bg-white/70 rounded-xl shadow-xs">
                <span class="font-sans text-xs font-black text-amber-600 uppercase tracking-widest block mb-1">Reff / Koor</span>
                <p class="font-bold text-gray-900 text-base sm:text-lg">
                    Kami Jaringan Sekolah Islam Terpadu<br>
                    Bangkit serentak menyongsong peradaban baru<br>
                    Bulatkan tekad dan cita membangun bangsa<br>
                    Indonesia maju dan berjaya! (dan berjaya)
                </p>
            </div>
        </div>

        {{-- 10 KARAKTER SISWA JSIT (MUWASHOFAT) --}}
        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 sm:p-8 border border-emerald-200">
            <h4 class="text-base sm:text-lg font-bold text-emerald-950 flex items-center mb-2 gap-2">
                <i class="fa-solid fa-medal text-emerald-600"></i>
                <span>10 Karakter Siswa JSIT (Muwashofat)</span>
            </h4>
            <p class="text-xs text-gray-700 mb-5 leading-relaxed font-medium">
                Sebagai sekolah anggota resmi Jaringan Sekolah Islam Terpadu (JSIT) Indonesia, {{ $info['name'] }} menanamkan 10 standar kompetensi lulusan karakter siswa:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-gray-800 font-medium">
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">1</span>
                    <span><strong>Salimul Aqidah</strong> (Aqidah yang Lurus)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">2</span>
                    <span><strong>Shahihul Ibadah</strong> (Ibadah yang Benar)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">3</span>
                    <span><strong>Matinul Khuluq</strong> (Akhlak yang Kokoh)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">4</span>
                    <span><strong>Qadirun 'alal Kasbi</strong> (Mandiri &amp; Berjiwa Usaha)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">5</span>
                    <span><strong>Mutsaqqaful Fikri</strong> (Berwawasan Luas &amp; Cerdas)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">6</span>
                    <span><strong>Qawiyyul Jismi</strong> (Jasmani yang Sehat &amp; Tangguh)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">7</span>
                    <span><strong>Mujahidun Linafsihi</strong> (Mampu Mengendalikan Diri)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">8</span>
                    <span><strong>Munazzhamun fi Syu'unihi</strong> (Tertib dalam Segala Urusan)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">9</span>
                    <span><strong>Haritsun 'ala Waqtihi</strong> (Disiplin Terhadap Waktu)</span>
                </div>
                <div class="flex items-center space-x-3 bg-white p-3.5 rounded-xl border border-emerald-100 shadow-xs">
                    <span class="w-6 h-6 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center text-[10px] shrink-0">10</span>
                    <span><strong>Nafi'un Lighairihi</strong> (Bermanfaat Bagi Sesama)</span>
                </div>
            </div>
        </div>

    </div>

    {{-- SECTION 2: HYMNE SIT ROBBANI --}}
    <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 space-y-6">
        <div class="flex items-center space-x-3 pb-4 border-b border-gray-100">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0 shadow-inner">
                <i class="fa-solid fa-star-and-crescent"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-unit-primary block">Senandung Jiwa Qur'ani</span>
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">Hymne Sekolah Robbani</h2>
            </div>
        </div>

        <div class="bg-amber-50/70 rounded-2xl p-4 border border-amber-200/80 space-y-1">
            <span class="text-xs font-bold text-amber-900 block flex items-center gap-1.5">
                <i class="fa-solid fa-heart text-amber-600"></i>
                <span>Nilai Luhur &amp; Karakter Robbani</span>
            </span>
            <p class="text-xs text-amber-800 font-light leading-relaxed">
                Lirik hymne mengiringi setiap siswa dan pendidik dalam menuntut ilmu dengan ikhlas lillahi ta'ala, meneladani akhlak Rasulullah, serta berbakti bagi umat dan bangsa.
            </p>
        </div>

        <div class="prose-content text-xs sm:text-sm text-gray-700 leading-relaxed font-serif space-y-4 text-center py-4 bg-gradient-to-b from-amber-50/20 to-transparent p-5 rounded-2xl border border-amber-50">
            <p class="font-bold text-gray-900 not-italic font-sans text-xs uppercase tracking-wider text-amber-600">
                Bait I
            </p>
            <p class="font-medium text-slate-800">
                Di bumi Indralaya nan damai permai<br>
                Tumbuh mekar generasi Robbani<br>
                Menuntut ilmu ikhlas di hati<br>
                Cinta Allah dan Rasul abadi
            </p>

            <p class="font-bold text-gray-900 not-italic font-sans text-xs uppercase tracking-wider text-amber-600 pt-2">
                Reff
            </p>
            <p class="font-bold text-gray-900 text-sm sm:text-base">
                Robbani sekolah kebanggaanku<br>
                Tempat terukir ilmu dan adabku<br>
                Hafidz Al-Qur'an pedoman langkahku<br>
                Menjadi lentera bagi bangsaku
            </p>

            <p class="font-bold text-gray-900 not-italic font-sans text-xs uppercase tracking-wider text-amber-600 pt-2">
                Penutup
            </p>
            <p class="font-medium text-slate-800">
                Kuserahkan jiwa dan raga ini<br>
                Membela kebenaran ilahi<br>
                Jayalah selalu Robbani tercinta<br>
                Hingga akhir masa menyapa
            </p>
        </div>

        <div class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
            <span>{{ $info['name'] }}</span>
            <span class="font-bold text-amber-600">Generasi Qur'ani &amp; Berkarakter</span>
        </div>
    </div>

</div>
@endsection
