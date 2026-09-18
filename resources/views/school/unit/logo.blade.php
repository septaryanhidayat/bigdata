@extends('school.unit.layouts.master')

@section('title', 'Makna & Identitas Logo Resmi - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Filosofi, makna elemen lambang, dan panduan identitas visual resmi ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Simbol generasi Qur\'ani, berakhlak mulia, dan unggul teknologi.')

@php
    $uTheme = $info['theme'] ?? [
        'primary' => '#4338ca',
        'primary_dark' => '#312e81',
        'nav_gradient' => 'from-indigo-950 via-indigo-900 to-blue-950',
        'gold' => '#f59e0b',
    ];
    $codeLower = strtolower($schoolCode ?? $info['code'] ?? 'smpit');
    $logoSrc = asset($info['logo'] ?? '/images/logo-robbani-official.png');
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
            <span class="text-amber-300 font-semibold shrink-0">Logo &amp; Identitas</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Identitas &amp; Makna Logo Resmi</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Filosofi mendalam dari setiap garis, warna, dan elemen visual yang merepresentasikan visi peradaban Islam di {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
        
        {{-- MAIN COLUMN (8/12) --}}
        <div class="lg:col-span-8 space-y-8">
            
            {{-- LOGO DISPLAY SHOWCASE CARD --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pb-8 border-b border-gray-100">
                    <div class="w-36 h-36 sm:w-48 sm:h-48 p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl flex items-center justify-center border border-gray-200/70 shadow-inner shrink-0">
                        <img src="{{ $logoSrc }}" 
                             alt="Logo Resmi {{ $info['name'] }}" 
                             class="max-h-full max-w-full object-contain filter drop-shadow"
                             onerror="this.src='/images/logo-robbani-official.png'">
                    </div>
                    <div class="space-y-3 text-center sm:text-left flex-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold tracking-wider uppercase bg-amber-50 text-amber-700 border border-amber-200">
                            <i class="fa-solid fa-certificate text-amber-500"></i>
                            Official Brand Identity
                        </span>
                        <h2 class="text-xl sm:text-2xl font-black text-gray-900 leading-snug">
                            Lambang Keagungan Ilmu &amp; Ketakwaan Robbani
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            Logo {{ $info['name'] }} memadukan nilai keislaman luhur, tradisi keilmuan Al-Qur'an, dan orientasi masa depan sains dan teknologi berstandar Sekolah Islam Terpadu (JSIT).
                        </p>
                        <div class="pt-2 flex flex-wrap gap-2 justify-center sm:justify-start">
                            <a href="{{ $logoSrc }}" download="Logo-{{ strtoupper($codeLower) }}-SIT-Robbani.png"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-white bg-unit-primary hover:opacity-90 shadow-md transition">
                                <i class="fa-solid fa-download"></i> Unduh PNG Transparan
                            </a>
                            <a href="{{ url('/unit/' . $codeLower . '/profil') }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition">
                                <i class="fa-solid fa-school"></i> Profil Lengkap
                            </a>
                        </div>
                    </div>
                </div>

                {{-- VARIAN LOGO PREVIEW --}}
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-200/80 text-center">
                        <div class="h-24 flex items-center justify-center mb-2">
                            <img src="{{ $logoSrc }}" alt="Full Color" class="max-h-16 object-contain">
                        </div>
                        <h4 class="text-xs font-bold text-gray-900">Varian Full Color</h4>
                        <p class="text-[11px] text-gray-500 mt-0.5">Penggunaan utama kop surat &amp; publikasi resmi</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-900 border border-gray-800 text-center text-white">
                        <div class="h-24 flex items-center justify-center mb-2">
                            <img src="{{ $logoSrc }}" alt="Dark Mode" class="max-h-16 object-contain brightness-110">
                        </div>
                        <h4 class="text-xs font-bold text-white">Varian Dark Contrast</h4>
                        <p class="text-[11px] text-gray-400 mt-0.5">Khusus latar belakang gelap &amp; media digital</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200/70 text-center">
                        <div class="h-24 flex items-center justify-center mb-2">
                            <i class="fa-solid fa-shield-halved text-4xl text-amber-500"></i>
                        </div>
                        <h4 class="text-xs font-bold text-gray-900">Crest / Lencana Badge</h4>
                        <p class="text-[11px] text-gray-500 mt-0.5">Emblem seragam siswa &amp; bendera institusi</p>
                    </div>
                </div>
            </div>

            {{-- FILOSOFI & MAKNA ELEMEN LAMBANG --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="mb-6">
                    <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                        Filosofi Komponen
                    </span>
                    <h3 class="text-lg sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Makna Setiap Unsur Lambang
                    </h3>
                    <div class="w-16 h-1 bg-unit-primary rounded-full mt-2"></div>
                </div>

                <div class="space-y-4">
                    {{-- 1. KUBAH MASJID --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:border-indigo-200 transition">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-sm shrink-0">
                            <i class="fa-solid fa-mosque"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Kubah Masjid &amp; Mihrab Keimanan</h4>
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                Melambangkan bahwa seluruh nafas kehidupan dan aktivitas pembelajaran bersumber dari Tauhidullah, ketaqwaan yang kokoh, dan kepatuhan mutlak pada syariat Allah SWT.
                            </p>
                        </div>
                    </div>

                    {{-- 2. AL-QUR'AN TERBUKA --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:border-indigo-200 transition">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm shrink-0">
                            <i class="fa-solid fa-book-quran"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Mushaf Al-Qur'an yang Terbuka</h4>
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                Simbol pedoman hidup utama yang senantiasa dibaca, dihafal, dipahami, dan diamalkan oleh setiap siswa. Menjadi rujukan tertinggi dalam seluruh cabang ilmu pengetahuan.
                            </p>
                        </div>
                    </div>

                    {{-- 3. PENA & SAYAP KELAS DUNIA --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:border-indigo-200 transition">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm shrink-0">
                            <i class="fa-solid fa-feather-pointed"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Pena Emas &amp; Sayap Pengetahuan Modern</h4>
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                Menggambarkan kecendekiaan, daya nalar kritis, riset sains, dan kemampuan adaptasi tinggi terhadap kemajuan teknologi digital masa depan demi kemaslahatan umat.
                            </p>
                        </div>
                    </div>

                    {{-- 4. BINTANG BERSUDUT --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:border-indigo-200 transition">
                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm shrink-0">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Bintang Kemilau Cita-cita Luhur</h4>
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                Menunjukkan tekad mencetak generasi Robbani yang menjadi lentera penerang di tengah masyarakat, menginspirasi melalui keteladanan akhlak mulia dan prestasi gemilang.
                            </p>
                        </div>
                    </div>

                    {{-- 5. LINGKARAN & PITA UKHUWAH --}}
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 border border-gray-100 hover:border-indigo-200 transition">
                        <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center font-bold text-sm shrink-0">
                            <i class="fa-solid fa-hands-holding-child"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Pita Kesatuan &amp; Lingkaran Ukhuwah</h4>
                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                Sinergi harmonis yang saling menguatkan antara Yayasan, Dewan Guru, Orang Tua Murid, dan masyarakat dalam membentuk ekosistem pendidikan yang penuh berkah.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PALET WARNA IDENTITAS RESMI --}}
            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="mb-6">
                    <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                        Pedoman Identitas Visual
                    </span>
                    <h3 class="text-lg sm:text-2xl font-extrabold text-gray-900 tracking-tight">
                        Palet Warna Resmi Unit
                    </h3>
                    <div class="w-16 h-1 bg-unit-primary rounded-full mt-2"></div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    {{-- COLOR 1: UNIT PRIMARY --}}
                    <div class="border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="h-20" style="background-color: {{ $uTheme['primary'] }};"></div>
                        <div class="p-4 bg-white space-y-1">
                            <h4 class="text-xs font-extrabold text-gray-900 uppercase">Warna Utama Unit</h4>
                            <p class="text-[11px] text-gray-500 font-mono">HEX: {{ $uTheme['primary'] }}</p>
                            <span class="inline-block text-[10px] px-2 py-0.5 rounded bg-gray-100 text-gray-600 font-medium">Karakter &amp; Identitas Pokok</span>
                        </div>
                    </div>

                    {{-- COLOR 2: ACCENT GOLD --}}
                    <div class="border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="h-20 bg-amber-500"></div>
                        <div class="p-4 bg-white space-y-1">
                            <h4 class="text-xs font-extrabold text-gray-900 uppercase">Robbani Gold</h4>
                            <p class="text-[11px] text-gray-500 font-mono">HEX: #f59e0b</p>
                            <span class="inline-block text-[10px] px-2 py-0.5 rounded bg-amber-50 text-amber-700 font-medium">Keagungan &amp; Prestasi</span>
                        </div>
                    </div>

                    {{-- COLOR 3: NAVY DEEP --}}
                    <div class="border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="h-20 bg-indigo-950"></div>
                        <div class="p-4 bg-white space-y-1">
                            <h4 class="text-xs font-extrabold text-gray-900 uppercase">Deep Navy</h4>
                            <p class="text-[11px] text-gray-500 font-mono">HEX: #1e1b4b</p>
                            <span class="inline-block text-[10px] px-2 py-0.5 rounded bg-gray-100 text-gray-600 font-medium">Integritas &amp; Keteguhan</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- SIDEBAR COLUMN (4/12) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- KOTAK INFORMASI UNIT --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <div class="flex items-center gap-3 pb-4 border-b border-gray-100">
                    <img src="{{ $logoSrc }}" alt="Logo" class="w-12 h-12 object-contain" onerror="this.src='/images/logo-robbani-official.png'">
                    <div>
                        <h4 class="text-xs font-extrabold text-gray-900">{{ $info['name'] }}</h4>
                        <span class="text-[11px] text-gray-500">NPSN: {{ $school->npsn ?? $info['npsn'] ?? '-' }}</span>
                    </div>
                </div>
                <div class="mt-4 space-y-2.5 text-xs text-gray-600">
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <span class="text-gray-400">Akreditasi:</span>
                        <span class="font-bold text-gray-800">{{ $school->accreditation ?? $info['accreditation'] ?? 'A (Unggul)' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <span class="text-gray-400">Kepala Sekolah:</span>
                        <span class="font-bold text-gray-800">{{ $info['principal_name'] ?? 'Kepala Sekolah' }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b border-gray-50">
                        <span class="text-gray-400">Kurikulum:</span>
                        <span class="font-bold text-gray-800">Merdeka &amp; Khas JSIT</span>
                    </div>
                </div>
            </div>

            {{-- MENU PROFIL TERKAIT --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <h4 class="text-xs font-black uppercase tracking-wider text-unit-primary mb-4">Navigasi Profil</h4>
                <div class="space-y-2 text-xs font-bold">
                    <a href="{{ url('/unit/' . $codeLower . '/sambutan-kepala-sekolah') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-microphone-lines mr-2 text-unit-primary"></i> Sambutan Kepala Sekolah</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/tentang-kami') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-school mr-2 text-unit-primary"></i> Profil Lengkap Sekolah</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/visi-dan-misi') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-bullseye mr-2 text-unit-primary"></i> Visi &amp; Misi Pendidikan</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/sejarah') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-timeline mr-2 text-unit-primary"></i> Sejarah Sekolah</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/struktur-organisasi') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-sitemap mr-2 text-unit-primary"></i> Struktur Organisasi</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/hymne-mars') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-music mr-2 text-unit-primary"></i> Hymne &amp; Mars</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                </div>
            </div>

            {{-- CTA KONTAK KAMI --}}
            <div class="bg-gradient-to-br from-indigo-900 to-unit-primary text-white rounded-3xl p-6 shadow-xl text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mx-auto text-amber-300 text-lg">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h4 class="text-sm font-black">Butuh Informasi Resmi?</h4>
                <p class="text-xs text-indigo-100 font-light leading-relaxed">
                    Hubungi tim Humas &amp; Pusat Informasi {{ $info['name'] }} untuk konsultasi dan pendaftaran.
                </p>
                <a href="{{ url('/unit/' . $codeLower . '/hubungi') }}" class="inline-block w-full py-2.5 rounded-xl text-xs font-bold bg-amber-400 hover:bg-amber-300 text-gray-900 shadow-md transition">
                    Hubungi Kami
                </a>
            </div>

        </div>

    </div>
</div>
@endsection
