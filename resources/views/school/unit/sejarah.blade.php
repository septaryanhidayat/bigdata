@extends('school.unit.layouts.master')

@section('title', 'Sejarah Sekolah - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Sejarah pendirian dan rekam jejak perkembangan ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . ' dalam membina generasi Qur\'ani dan berprestasi.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $historyData = $info['history'] ?? [
        'title' => 'Membangun Generasi Emas Ishum di Bumi Caram Seguguk',
        'badge' => 'Jejak Langkah & Perkembangan',
        'image' => '/uploads/campus-smpit-ishum.webp',
        'paragraphs' => [
            $info['name'] . ' didirikan sebagai wujud kepedulian terhadap pentingnya pendidikan generasi muda Islam yang seimbang antara ilmu pengetahuan umum dan pemahaman agama yang mendalam.',
            'Berawal dari kesuksesan pembinaan di tingkat dasar, masyarakat mendambakan kelanjutan pendidikan yang tetap mengusung nilai-nilai Qur\'ani dan pembiasaan adab Islami secara konsisten.',
            'Di bawah kepemimpinan ' . ($info['principal_name'] ?? 'Kepala Sekolah') . ' beserta jajaran dewan guru yang amanah, sekolah terus berinovasi dalam metode pembelajaran, sarana prasarana modern, pembinaan tahfidz, serta prestasi siswa di berbagai ajang kejuaraan daerah dan nasional.'
        ]
    ];
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
            <span class="text-amber-300 font-semibold shrink-0">Sejarah</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight">Sejarah {{ $info['name'] }}</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Jejak langkah pengabdian, dedikasi pendidik, dan perjalanan membangun peradaban pendidikan islam terpadu di {{ $codeLower === 'smpit' ? 'Kota Prabumulih' : 'Kabupaten Ogan Ilir' }}.
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-10">
        
        {{-- KOLOM UTAMA (8/12) --}}
        <div class="lg:col-span-8 space-y-6 sm:space-y-8">
            <article class="bg-white rounded-3xl p-5 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up space-y-5 sm:space-y-6">
                
                {{-- FOTO GEDUNG / KAMPUS SEKOLAH --}}
                <div class="rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-gray-50 max-h-64 sm:max-h-96">
                    <img src="{{ asset($historyData['image'] ?? '/uploads/campus-smpit-ishum.webp') }}" 
                         alt="Gedung Kampus {{ $info['name'] }}" 
                         class="w-full h-full object-cover"
                         onerror="this.src='/uploads/campus-smpit-ishum.webp'">
                </div>

                <div class="border-b border-gray-100 pb-4">
                    <span class="text-[10px] sm:text-xs font-black uppercase tracking-wider text-orange-500 block">
                        {{ $historyData['badge'] ?? 'Jejak Langkah & Perkembangan' }}
                    </span>
                    <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight mt-1">
                        {{ $historyData['title'] ?? ('Membangun Generasi Emas di ' . $info['name']) }}
                    </h2>
                    <div class="w-16 h-1 bg-unit-primary rounded-full mt-3"></div>
                </div>

                <div class="prose-content text-xs sm:text-sm text-gray-700 leading-relaxed space-y-4">
                    <h3 class="font-bold text-gray-900 text-sm sm:text-base">
                        Sejarah dan Latar Belakang Pendirian
                    </h3>

                    @foreach($historyData['paragraphs'] as $par)
                        <p class="text-justify">{{ $par }}</p>
                    @endforeach
                </div>

            </article>
        </div>

        {{-- KOLOM SIDEBAR (4/12) --}}
        <div class="lg:col-span-4">
            @include('school.unit.partials.sidebar')
        </div>

    </div>
</div>
@endsection
