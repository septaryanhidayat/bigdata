@extends('school.unit.layouts.master')

@section('title', 'Program Unggulan - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Program Unggulan dan Pembinaan Karakter Santri di ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Kurikulum terpadu JSIT & Nasional, tahfidz mutqin, dan sains teknologi.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    
    // Unit programs data
    $programsList = !empty($unitPrograms) ? $unitPrograms : (!empty($info['programs']) ? $info['programs'] : (!empty($unitEkskul) ? $unitEkskul : []));
    
    if (empty($programsList)) {
        if ($codeLower === 'tkit') {
            $programsList = [
                ['title' => 'Sentra Adab & Doa Harian', 'icon' => '🤲', 'target' => 'Adab Mulia Sejak Dini', 'desc' => 'Penanaman tauhid dan pembiasaan adab islami sehari-hari dengan metode menyenangkan bagi anak usia dini.'],
                ['title' => 'Hafalan Al-Qur\'an Juz 30', 'icon' => '📖', 'target' => 'Hafal Surah Pendek & Hadits', 'desc' => 'Mengenalkan Al-Qur\'an dengan metode talaqqi riang gembira dan murottal harian.'],
                ['title' => 'Kemandirian & Motorik Ceria', 'icon' => '🎨', 'target' => 'Kecakapan Hidup Mandiri', 'desc' => 'Stimulasi motorik halus dan kasar melalui sentra balok, sentra seni, dan sentra bahan alam.'],
                ['title' => 'Outbond & Field Trip Edukatif', 'icon' => '🏕️', 'target' => 'Eksplorasi Lingkungan', 'desc' => 'Pembelajaran luar kelas mengenalkan alam ciptaan Allah dan melatih keberanian ananda.']
            ];
        } else {
            $programsList = [
                ['title' => 'Tahfidz Al-Qur\'an Mutqin', 'icon' => '📖', 'target' => $info['target_hafalan'] ?? '2-3 Juz Mutqin', 'desc' => 'Program tahfidz terstruktur dengan metode talaqqi, tasmi\' akbar, dan ujian munaqosah bersertifikat.'],
                ['title' => 'Bilingual Arabic & English', 'icon' => '🗣️', 'target' => 'Percakapan Bahasa Asing Sehari-hari', 'desc' => 'Pembiasaan kosakata harian dan muhadatsah untuk membangun rasa percaya diri berkomunikasi global.'],
                ['title' => 'Bina Karakter Muwashofat (BPI)', 'icon' => '🌟', 'target' => '10 Karakter Santri JSIT', 'desc' => 'Mentoring pekanan kelompok kecil, mabit qiyamul lail, dan buku mutabaah ibadah yaumiyah.'],
                ['title' => 'Bina Prestasi Sains & Robotika', 'icon' => '🔬', 'target' => 'Juara KSN & Olimpiade', 'desc' => 'Klub sains dan riset teknologi terpadu untuk mengasah nalar kritis dan daya cipta santri.'],
                ['title' => 'Kepanduan Pramuka SIT', 'icon' => '🏕️', 'target' => 'Jiwa Tangguh & Mandiri', 'desc' => 'Latihan kepemimpinan, survival, jambore nasional JSIT, dan kepedulian sosial kemanusiaan.'],
                ['title' => 'Ekosistem Digital SmartEdu', 'icon' => '💻', 'target' => 'Literasi Teknologi Modern', 'desc' => 'Pembelajaran interaktif komputer, presensi digital, CBT online, dan perpustakaan digital.']
            ];
        }
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
            <span class="text-amber-300 font-semibold shrink-0">Program Unggulan</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Program Unggulan Sekolah</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Kurikulum integratif JSIT Indonesia dan Kemendikbudristek yang dirancang mencetak generasi Qur'ani, cerdas, berkarakter, dan berdaya saing global.
        </p>
    </div>
</div>

{{-- MAIN CONTENT AREA --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14">

    {{-- SECTION TITLE --}}
    <div class="text-center max-w-3xl mx-auto mb-10 sm:mb-14 space-y-3">
        <span class="text-xs font-black uppercase tracking-wider text-unit-primary block">
            Keunggulan Pendidikan Terpadu
        </span>
        <h2 class="text-2xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
            Fondasi Keunggulan Santri {{ $info['name'] }}
        </h2>
        <div class="w-16 h-1 bg-unit-primary rounded-full mx-auto"></div>
        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-light">
            Setiap program dirancang dengan indikator capaian terukur, didampingi guru pembina yang amanah, serta berorientasi pada kemuliaan adab dan prestasi.
        </p>
    </div>

    {{-- PROGRAMS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach($programsList as $idx => $prog)
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 border border-gray-100 flex flex-col justify-between group relative overflow-hidden">
                
                {{-- TOP ACCENT GLOW --}}
                <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-amber-400/10 to-transparent rounded-bl-full pointer-events-none"></div>

                <div class="space-y-4">
                    {{-- ICON & STAR RATING --}}
                    <div class="flex items-center justify-between">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-unit-primary flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition duration-300">
                            <span>{{ $prog['icon'] ?? '🌟' }}</span>
                        </div>
                        <div class="flex items-center space-x-1 text-amber-400 text-xs">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                    </div>

                    {{-- TITLE & TARGET --}}
                    <div class="space-y-1">
                        <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-50 text-amber-800 border border-amber-200">
                            Target: {{ $prog['target'] ?? ($info['target_hafalan'] ?? 'Unggul Berkelanjutan') }}
                        </span>
                        <h3 class="text-lg sm:text-xl font-black text-gray-900 group-hover:text-unit-primary transition leading-snug pt-1">
                            {{ $prog['title'] }}
                        </h3>
                    </div>

                    {{-- DESCRIPTION --}}
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-light">
                        {{ $prog['desc'] }}
                    </p>

                    {{-- BULLET HIGHLIGHTS --}}
                    <div class="space-y-1.5 pt-2 text-xs text-gray-700">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i>
                            <span>Didampingi Guru Pembina Khusus</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i>
                            <span>Evaluasi &amp; Mutabaah Berkala</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-xs"></i>
                            <span>Sertifikasi Capaian Kelulusan</span>
                        </div>
                    </div>
                </div>

                {{-- BUTTON CTA --}}
                <div class="pt-6 mt-6 border-t border-gray-100">
                    <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
                       class="w-full inline-flex items-center justify-center space-x-2 py-2.5 rounded-full font-bold text-xs bg-gray-50 text-gray-800 hover:bg-unit-primary hover:text-white transition group-hover:shadow-md">
                        <span>Daftar Melalui Program Ini</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

            </div>
        @endforeach
    </div>

    {{-- CALLOUT BOX: 10 KARAKTER MUWASHOFAT JSIT --}}
    <div class="mt-14 sm:mt-18 rounded-3xl bg-white p-6 sm:p-10 shadow-xl border border-gray-100">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="space-y-3 text-center lg:text-left max-w-2xl">
                <span class="text-xs font-black uppercase tracking-wider text-amber-500 block">
                    Standar Mutu JSIT Indonesia
                </span>
                <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                    10 Karakter Muwashofat Santri Robbani
                </h3>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-light">
                    Aqidah yang bersih, ibadah yang benar, akhlak yang mulia, jasmani yang kuat, wawasan yang luas, teratur urusannya, mandiri, disiplin waktu, bermanfaat bagi orang lain, serta bersungguh-sungguh memerangi hawa nafsu.
                </p>
            </div>
            <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
               class="px-8 py-3.5 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 shadow-xl shadow-amber-500/30 hover:scale-105 active:scale-95 transition shrink-0 flex items-center justify-center space-x-2">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Gabung Santri Baru</span>
            </a>
        </div>
    </div>

</div>
@endsection
