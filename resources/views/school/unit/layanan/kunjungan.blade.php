@extends('school.unit.layouts.master')

@section('title', 'Izin Kunjungan Sekolah & Studi Banding - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Formulir online permohonan izin kunjungan studi tiru, observasi kurikulum, dan silaturahmi ke ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

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
            <a href="{{ url('/unit/' . $codeLower . '/layanan') }}" class="hover:text-white transition shrink-0">Layanan</a>
            <span>/</span>
            <span class="text-amber-300 font-semibold shrink-0">Izin Kunjungan</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Izin Kunjungan Sekolah</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Formulir permohonan resmi studi banding, observasi kurikulum JSIT, tahfidz, dan program unggulan di {{ $info['name'] }}.
        </p>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14">
    
    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start gap-3 shadow-sm reveal-fade-up">
            <i class="fa-solid fa-circle-check text-emerald-600 text-lg mt-0.5 shrink-0"></i>
            <div>
                <h4 class="text-xs sm:text-sm font-bold">Permohonan Berhasil Terkirim!</h4>
                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- ERROR VALIDATION ALERT --}}
    @if($errors->any())
        <div class="mb-8 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 space-y-1 text-xs">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                Mohon periksa kembali isian formulir:
            </div>
            <ul class="list-disc list-inside pl-4 text-rose-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
        
        {{-- FORM COLUMN (8/12) --}}
        <div class="lg:col-span-8">
            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-gray-100 reveal-fade-up">
                
                <div class="border-b border-gray-100 pb-5 mb-6">
                    <span class="text-xs font-black uppercase tracking-wider text-unit-primary block mb-1">
                        Formulir Permohonan Resmi
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
                        Surat Izin Kunjungan &amp; Studi Banding
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Silakan isi data instansi dan rencana kunjungan dengan lengkap. Tim kami akan segera menindaklanjuti.
                    </p>
                </div>

                <form action="{{ url('/unit/' . $codeLower . '/layanan/kunjungan') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- NAMA INSTANSI --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Nama Lembaga / Instansi / Sekolah <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="instansi" value="{{ old('instansi') }}" required
                               placeholder="Contoh: SMP IT Al-Fityan / Universitas Sriwijaya"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    </div>

                    {{-- NAMA PENANGGUNG JAWAB & NOMOR HP --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Nama Penanggung Jawab <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama_pemohon" value="{{ old('nama_pemohon') }}" required
                                   placeholder="Contoh: Ustadz H. Abdullah, S.Pd.I"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                No. WhatsApp / HP Aktif <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" name="no_hp" value="{{ old('no_hp') }}" required
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                    </div>

                    {{-- EMAIL RESMI --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Alamat Email Resmi <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="Contoh: info@sekolah.sch.id / kontak@instansi.org"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                    </div>

                    {{-- TANGGAL RENCANA & ESTIMASI JUMLAH PESERTA --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Rencana Tanggal Kunjungan <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="tgl_kunjungan" value="{{ old('tgl_kunjungan') }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Estimasi Jumlah Peserta <span class="text-rose-500">*</span>
                            </label>
                            <input type="number" name="jumlah_peserta" value="{{ old('jumlah_peserta', 1) }}" min="1" required
                                   placeholder="Contoh: 25"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        </div>
                    </div>

                    {{-- TUJUAN KUNJUNGAN --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Maksud &amp; Tujuan Kunjungan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="tujuan" rows="4" required
                                  placeholder="Jelaskan bidang studi banding yang diminati (misal: kurikulum tahfidz al-qur'an, manajemen asrama, kesiswaan JSIT, laboratorium robotik, dll)..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">{{ old('tujuan') }}</textarea>
                    </div>

                    {{-- UPLOAD SURAT RESMI --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Unggah Surat Permohonan / Proposal (PDF / DOC / Foto)
                        </label>
                        <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-unit-primary file:text-white hover:file:opacity-90">
                        <span class="text-[11px] text-gray-400 mt-1 block">Format file: PDF, DOC, DOCX, JPG, PNG (Maksimal 10 MB).</span>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-[11px] text-gray-500">
                            <i class="fa-solid fa-lock text-emerald-600 mr-1"></i> Data Anda dijamin kerahasiaannya oleh SIT Robbani.
                        </div>
                        <button type="submit" 
                                class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-xs font-bold text-white bg-unit-primary hover:opacity-90 shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim Permohonan Kunjungan</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        {{-- SIDEBAR COLUMN (4/12) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- KETENTUAN KUNJUNGAN --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <h3 class="text-xs font-black uppercase tracking-wider text-unit-primary mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info"></i>
                    Ketentuan Kunjungan
                </h3>
                <ul class="space-y-3 text-xs text-gray-600">
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-emerald-600 mt-0.5 shrink-0"></i>
                        <span>Pengajuan surat permohonan disarankan diajukan minimal <strong>H-7</strong> sebelum hari pelaksanaan.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-emerald-600 mt-0.5 shrink-0"></i>
                        <span>Waktu kunjungan disarankan pada hari efektif sekolah (Senin - Kamis pukul 08.30 - 14.00 WIB).</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-emerald-600 mt-0.5 shrink-0"></i>
                        <span>Peserta berpakaian sopan dan menutup aurat sesuai adab Islami di lingkungan kampus.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-check text-emerald-600 mt-0.5 shrink-0"></i>
                        <span>Surat balasan resmi akan dikirim via WhatsApp &amp; Email dalam waktu maksimal 2x24 jam kerja.</span>
                    </li>
                </ul>
            </div>

            {{-- TAUTAN LAYANAN LAINNYA --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <h4 class="text-xs font-black uppercase tracking-wider text-unit-primary mb-4">Layanan Terkait</h4>
                <div class="space-y-2 text-xs font-bold">
                    <a href="{{ url('/unit/' . $codeLower . '/layanan/kerjasama') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-handshake-angle mr-2 text-emerald-600"></i> Permohonan Kerja Sama</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/layanan/sewa') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-building-circle-check mr-2 text-amber-600"></i> Sewa Sarana &amp; Fasilitas</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/layanan') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-layer-group mr-2 text-unit-primary"></i> Portal Layanan Terpadu</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                </div>
            </div>

            {{-- WHATSAPP HOTLINE --}}
            <div class="bg-gradient-to-br from-emerald-800 to-teal-900 text-white rounded-3xl p-6 shadow-xl text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mx-auto text-emerald-300 text-xl">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h4 class="text-sm font-black">Konfirmasi Cepat via WhatsApp?</h4>
                <p class="text-xs text-emerald-100 font-light leading-relaxed">
                    Setelah mengisi formulir, Anda dapat mengonfirmasi permohonan kunjungan langsung ke Humas Unit {{ $info['name'] }}.
                </p>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $school->phone ?? $info['phone'] ?? '6281271708899') }}?text=Halo%20Humas%20{{ urlencode($info['name']) }}%2C%20saya%20sudah%20mengisi%20formulir%20kunjungan%20sekolah." 
                   target="_blank" rel="noopener"
                   class="inline-block w-full py-2.5 rounded-xl text-xs font-bold bg-white text-emerald-900 hover:bg-emerald-50 shadow-md transition">
                    Hubungi Humas via WhatsApp
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
