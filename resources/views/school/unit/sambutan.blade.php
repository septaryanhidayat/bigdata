@extends('school.unit.layouts.master')

@section('title', 'Sambutan Kepala Sekolah - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Sambutan resmi Kepala Sekolah ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . ': ' . ($info['principal_name'] ?? 'Kepala Sekolah') . '.')

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
            <span class="text-amber-300 font-semibold">Sambutan Kepala Sekolah</span>
        </nav>
        <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Sambutan Kepala Sekolah</h1>
        <p class="text-sm text-indigo-100 mt-2 font-light max-w-2xl">
            Pesan dan komitmen pembinaan karakter, iman, dan ilmu di {{ $info['name'] }}.
        </p>
    </div>
</div>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-gray-100 reveal-fade-up">

        {{-- PROFIL PIMPINAN HEADER --}}
        <div class="flex flex-col md:flex-row items-center gap-8 mb-8 pb-8 border-b border-gray-100 text-center md:text-left">
            <div class="w-48 h-56 sm:w-52 sm:h-60 rounded-2xl overflow-hidden shadow-lg border-4 border-white ring-4 ring-indigo-100 flex-shrink-0 bg-indigo-50 mx-auto md:mx-0">
                <img src="{{ asset($info['principal_photo'] ?: '/uploads/dewan/kepala-sekolah.webp') }}" 
                     alt="{{ $info['principal_name'] }}" 
                     class="w-full h-full object-cover object-top" 
                     onerror="this.src='/uploads/dewan/kepala-sekolah.webp'">
            </div>
            <div class="space-y-2 text-center md:text-left">
                <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-bold px-3.5 py-1.5 rounded-full uppercase tracking-wider">
                    Kepala Sekolah
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
                    {{ $info['principal_name'] }}
                </h2>
                <p class="text-xs sm:text-sm font-semibold text-unit-primary">
                    Pendidik Berpengalaman &amp; Praktisi Pendidikan Karakter Islami
                </p>
                <p class="text-xs sm:text-sm text-gray-500 italic pt-2 max-w-xl">
                    “{{ $info['principal_quote'] ?? 'Membina Generasi Qur\'ani, Berakhlak Mulia, Cerdas, dan Siap Memimpin Peradaban Masa Depan.' }}”
                </p>
            </div>
        </div>

        {{-- KONTEN TEKS SAMBUTAN LENGKAP --}}
        <div class="prose-content text-xs sm:text-sm text-gray-700 leading-relaxed space-y-4">
            <p class="font-bold text-gray-900 text-sm sm:text-base">
                Bismillahirrohmanirrohim. Assalamu'alaikum Warahmatullahi Wabarakatuh.
            </p>
            
            @if(!empty($info['principal_greeting']))
                @foreach(explode("\n\n", $info['principal_greeting']) as $paragraph)
                    @if(trim($paragraph))
                        <p class="text-justify">{{ trim($paragraph) }}</p>
                    @endif
                @endforeach
            @else
                <p class="text-justify">
                    Segala puji dan syukur kita panjatkan kehadirat Allah SWT yang senantiasa melimpahkan rahmat, taufik, dan inayah-Nya kepada kita semua. Sholawat beriring salam senantiasa tercurah kepada junjungan alam Nabi Besar Muhammad SAW, para keluarga, sahabat, dan pengikutnya hingga akhir zaman.
                </p>
                <p class="text-justify">
                    Selamat datang di website resmi <strong>{{ $info['name'] }}</strong>. Di era transformasi digital dan revolusi industri saat ini, kehadiran media informasi digital menjadi sarana vital untuk mempererat ukhuwah, menyajikan transparansi kegiatan sekolah, serta memberikan kemudahan akses informasi bagi para orang tua, siswa, dan masyarakat luas.
                </p>
                <p class="text-justify">
                    Sebagai Sekolah Islam Terpadu, kami berkomitmen menghadirkan pendidikan holistik yang memadukan keunggulan kurikulum nasional, penguatan adab Islami, target hafalan Al-Qur'an mutqin, kompetensi sains-teknologi, dan pembiasaan bahasa asing.
                </p>
                <p class="text-justify">
                    Kami mengucapkan terima kasih yang sebesar-besarnya kepada Pembina dan Pengurus Yayasan, seluruh asatidz dan asatidzah, staf kependidikan, serta para wali murid yang senantiasa membersamai langkah kami dalam mendidik generasi terbaik umat. Mari bersama-sama kita wujudkan anak-anak yang sholih-sholihah, cerdas, berprestasi, dan berakhlakul karimah.
                </p>
            @endif

            <p class="font-bold text-gray-900 pt-2">
                Wassalamu'alaikum Warahmatullahi Wabarakatuh.
            </p>

            <div class="pt-4">
                <p class="font-bold text-gray-900">Kepala {{ $info['name'] }}</p>
                <p class="text-unit-primary font-extrabold">{{ $info['principal_name'] }}</p>
            </div>
        </div>

        {{-- CALLOUT BANNER: PENDAFTARAN SISWA BARU (SPMB ONLINE) --}}
        <div class="mt-8 sm:mt-10 p-5 sm:p-8 rounded-2xl bg-gradient-to-r {{ $uTheme['nav_gradient'] }} text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-5 sm:gap-6 border border-white/20 text-center sm:text-left">
            <div class="space-y-1">
                <h4 class="text-base sm:text-lg font-black text-white tracking-tight">
                    Pendaftaran Siswa Baru (SPMB Online)
                </h4>
                <p class="text-xs text-indigo-200 font-light max-w-md">
                    Mari bergabung bersama keluarga besar {{ $info['name'] }}. Gelombang exclusive kuota terbatas telah dibuka.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3 w-full sm:w-auto shrink-0">
                <a href="{{ route('school.ppdb') }}?unit={{ $codeLower }}" 
                   class="w-full sm:w-auto px-5 py-2.5 rounded-full font-black text-xs uppercase tracking-wider bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 shadow-lg shadow-amber-500/25 hover:shadow-amber-500/40 hover:brightness-105 transition flex items-center justify-center space-x-1.5">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <span>Daftar SPMB Online</span>
                </a>
                <a href="https://api.whatsapp.com/send?phone=62{{ ltrim($info['whatsapp'] ?? $info['phone'] ?? '85269908696', '0') }}" 
                   target="_blank" 
                   rel="noopener noreferrer"
                   class="w-full sm:w-auto px-4 py-2.5 rounded-full font-bold text-xs border border-white/30 text-white hover:bg-white/10 transition flex items-center justify-center space-x-1.5">
                    <i class="fa-solid fa-phone text-xs"></i>
                    <span>Hubungi Kami</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
