@extends('school.unit.layouts.master')

@section('title', 'Portal Layanan Terpadu - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Portal Pelayanan Publik dan Administrasi Terpadu Satu Pintu di ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '. Pengajuan izin kunjungan, permohonan kerjasama, dan pemanfaatan sarana.')

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
            <span class="text-amber-300 font-semibold shrink-0">Layanan Terpadu</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Portal Layanan Terpadu Satu Pintu</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Layanan administrasi, perizinan kunjungan, kemitraan institusi, dan pemanfaatan sarana prasarana sekolah secara terpadu, cepat, dan akuntabel.
        </p>
    </div>
</div>

{{-- MAIN CONTAINER --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14">
    
    {{-- ALERT PESAN SUCCESS JIKA ADA --}}
    @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-sm reveal-fade-up">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5 shrink-0"></i>
            <div>
                <h4 class="text-xs sm:text-sm font-bold">Permohonan Berhasil Dikirim!</h4>
                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- SECTION TITLE --}}
    <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
        <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
            Pelayanan Publik Online
        </span>
        <h2 class="text-xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">
            Pilih Layanan yang Anda Butuhkan
        </h2>
        <div class="w-16 h-1 bg-unit-primary rounded-full mx-auto mt-2 mb-3"></div>
        <p class="text-xs sm:text-sm text-gray-600">
            Seluruh permohonan diproses secara profesional oleh bagian Hubungan Masyarakat (Humas) dan Sarana Prasarana {{ $info['name'] }}.
        </p>
    </div>

    {{-- 3 SERVICE CARDS GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8 mb-14">
        
        {{-- CARD 1: IZIN KUNJUNGAN SEKOLAH --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 hover:border-indigo-200 hover:-translate-y-1.5 transition duration-300 flex flex-col justify-between reveal-fade-up">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl mb-6 shadow-sm border border-blue-100">
                    <i class="fa-solid fa-school-flag"></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                    Studi Banding &amp; Edukasi
                </span>
                <h3 class="text-lg font-bold text-gray-900 mt-3 mb-2">
                    Izin Kunjungan Sekolah
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Layanan pengajuan izin kunjungan resmi bagi sekolah lain, kampus, lembaga dakwah, atau instansi yang ingin melakukan studi tiru program tahfidz, kurikulum JSIT, dan sistem manajemen kami.
                </p>
            </div>
            <div class="pt-6 border-t border-gray-100 mt-6">
                <a href="{{ url('/unit/' . $codeLower . '/layanan/kunjungan') }}" 
                   class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold text-white bg-unit-primary hover:opacity-90 shadow-md transition">
                    <span>Ajukan Izin Kunjungan</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        {{-- CARD 2: PERMOHONAN KERJASAMA --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 hover:border-emerald-200 hover:-translate-y-1.5 transition duration-300 flex flex-col justify-between reveal-fade-up">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-6 shadow-sm border border-emerald-100">
                    <i class="fa-solid fa-handshake-angle"></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
                    Kemitraan &amp; MoU
                </span>
                <h3 class="text-lg font-bold text-gray-900 mt-3 mb-2">
                    Permohonan Kerja Sama
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Fasilitas kemitraan strategis dengan perguruan tinggi, perbankan syariah, lembaga kesehatan, korporasi, program magang mahasiswa, beasiswa siswa, serta donasi dan program CSR keumatan.
                </p>
            </div>
            <div class="pt-6 border-t border-gray-100 mt-6">
                <a href="{{ url('/unit/' . $codeLower . '/layanan/kerjasama') }}" 
                   class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition">
                    <span>Ajukan Kemitraan</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        {{-- CARD 3: SEWA SARANA & FASILITAS --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-xl border border-gray-100 hover:border-amber-200 hover:-translate-y-1.5 transition duration-300 flex flex-col justify-between reveal-fade-up">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mb-6 shadow-sm border border-amber-100">
                    <i class="fa-solid fa-building-circle-check"></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-600 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-100">
                    Sarana &amp; Prasarana
                </span>
                <h3 class="text-lg font-bold text-gray-900 mt-3 mb-2">
                    Sewa Sarana &amp; Fasilitas
                </h3>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Peminjaman dan penyewaan fasilitas kampus seperti Aula Serbaguna, Lapangan Olahraga, Laboratorium Komputer CBT, serta sarana pendukung kegiatan tabligh akbar dan perlombaan Islami.
                </p>
            </div>
            <div class="pt-6 border-t border-gray-100 mt-6">
                <a href="{{ url('/unit/' . $codeLower . '/layanan/sewa') }}" 
                   class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-md transition">
                    <span>Ajukan Sewa Sarana</span>
                    <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

    </div>

    {{-- 3-STEP PROSEDUR ALUR PELAYANAN --}}
    <div class="bg-gradient-to-br from-gray-900 via-indigo-950 to-blue-950 text-white rounded-3xl p-8 sm:p-12 shadow-2xl reveal-fade-up mb-14">
        <div class="max-w-2xl mx-auto text-center mb-10">
            <span class="text-xs font-black uppercase tracking-wider text-amber-300 block mb-1">
                Alur Mudah &amp; Cepat
            </span>
            <h3 class="text-xl sm:text-3xl font-extrabold tracking-tight">
                Prosedur Pelayanan Terpadu
            </h3>
            <p class="text-xs sm:text-sm text-indigo-200 mt-1 font-light">
                Hanya butuh 3 langkah praktis untuk mendapatkan persetujuan resmi dan pelayanan terbaik dari kami.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15 relative">
                <div class="w-10 h-10 rounded-full bg-amber-400 text-gray-950 font-black flex items-center justify-center text-sm mb-4 shadow">
                    1
                </div>
                <h4 class="text-sm font-bold text-white">1. Isi Formulir Online</h4>
                <p class="text-xs text-indigo-100 mt-1.5 leading-relaxed font-light">
                    Pilih jenis layanan, lengkapi data kontak pemohon, tanggal kegiatan, serta lampirkan surat permohonan resmi dalam format PDF/DOC.
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15 relative">
                <div class="w-10 h-10 rounded-full bg-amber-400 text-gray-950 font-black flex items-center justify-center text-sm mb-4 shadow">
                    2
                </div>
                <h4 class="text-sm font-bold text-white">2. Verifikasi &amp; Telaah Humas</h4>
                <p class="text-xs text-indigo-100 mt-1.5 leading-relaxed font-light">
                    Tim Humas dan Kepala Sekolah melakukan pengecekan jadwal, ketersediaan sarana prasarana, serta koordinasi internal unit (maksimal 2x24 jam).
                </p>
            </div>

            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15 relative">
                <div class="w-10 h-10 rounded-full bg-amber-400 text-gray-950 font-black flex items-center justify-center text-sm mb-4 shadow">
                    3
                </div>
                <h4 class="text-sm font-bold text-white">3. Konfirmasi &amp; Surat Balasan</h4>
                <p class="text-xs text-indigo-100 mt-1.5 leading-relaxed font-light">
                    Pemohon menerima notifikasi WhatsApp / Email berisi surat balasan resmi berstempel dan Tanda Tangan Elektronik (TTE) siap cetak.
                </p>
            </div>
        </div>
    </div>

    {{-- HELPDESK & QUICK ACTION CALLOUT --}}
    <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 grid grid-cols-1 md:grid-cols-2 gap-8 items-center reveal-fade-up">
        <div>
            <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                Pusat Bantuan &amp; Pengaduan
            </span>
            <h3 class="text-xl sm:text-2xl font-black text-gray-900 leading-snug">
                Butuh Bantuan Langsung dari Narahubung Kami?
            </h3>
            <p class="text-xs sm:text-sm text-gray-600 mt-2 leading-relaxed">
                Jika Anda memiliki pertanyaan spesifik mengenai prosedur, ketersediaan aula, atau ingin berdiskusi mengenai MoU kerjasama, hubungi tim kami sekarang.
            </p>
            <div class="mt-4 flex flex-wrap gap-3">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $school->phone ?? $info['phone'] ?? '6281271708899') }}?text=Halo%20Humas%20{{ urlencode($info['name']) }}%2C%20saya%20ingin%20bertanya%20tentang%20layanan%20sekolah" 
                   target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>Chat WhatsApp Hotline</span>
                </a>
                <a href="{{ url('/unit/' . $codeLower . '/hubungi') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition">
                    <i class="fa-solid fa-location-dot text-sm text-unit-primary"></i>
                    <span>Lihat Alamat &amp; Kontak</span>
                </a>
            </div>
        </div>

        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200/70 space-y-3">
            <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider">Jam Operasional Kantor Pusat Administrasi (KPA):</h4>
            <ul class="text-xs text-gray-600 space-y-2">
                <li class="flex items-center justify-between py-1 border-b border-gray-200/60">
                    <span>Senin - Kamis</span>
                    <span class="font-bold text-gray-800">07.30 - 16.00 WIB</span>
                </li>
                <li class="flex items-center justify-between py-1 border-b border-gray-200/60">
                    <span>Jum'at</span>
                    <span class="font-bold text-gray-800">07.30 - 11.30 &amp; 13.30 - 16.00 WIB</span>
                </li>
                <li class="flex items-center justify-between py-1 border-b border-gray-200/60">
                    <span>Sabtu</span>
                    <span class="font-bold text-gray-800">07.30 - 13.00 WIB</span>
                </li>
                <li class="flex items-center justify-between py-1 text-rose-600 font-bold">
                    <span>Ahad &amp; Hari Libur Nasional</span>
                    <span>Tutup (Tersedia Hotline WA)</span>
                </li>
            </ul>
        </div>
    </div>

</div>
@endsection
