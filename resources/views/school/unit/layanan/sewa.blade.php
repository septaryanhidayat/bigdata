@extends('school.unit.layouts.master')

@section('title', 'Sewa Sarana & Fasilitas Sekolah - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Formulir online permohonan sewa sarana prasarana, aula serbaguna, lapangan olahraga, dan laboratorium di ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

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
            <span class="text-amber-300 font-semibold shrink-0">Sewa Sarana</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Sewa Sarana &amp; Fasilitas Kampus</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Pemanfaatan sarana prasarana terbaik milik {{ $info['name'] }} untuk kegiatan keumatan, seminar, olahraga, dan majelis taklim.
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
                <h4 class="text-xs sm:text-sm font-bold">Permohonan Sewa Berhasil Diajukan!</h4>
                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- ERROR ALERT --}}
    @if($errors->any())
        <div class="mb-8 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 space-y-1 text-xs">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                Mohon periksa kembali isian formulir sewa:
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
                    <span class="text-xs font-black uppercase tracking-wider text-amber-600 block mb-1">
                        Pemanfaatan Sarana Prasarana
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
                        Formulir Peminjaman &amp; Sewa Sarana
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Pastikan tanggal dan waktu yang diajukan tidak berbenturan dengan agenda utama kegiatan siswa.
                    </p>
                </div>

                <form action="{{ url('/unit/' . $codeLower . '/layanan/sewa') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- NAMA PENYEWA / LEMBAGA --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Nama Pemohon / Lembaga Penyelenggara <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_penyewa" value="{{ old('nama_penyewa') }}" required
                               placeholder="Contoh: Panitia Kajian Akbar Ogan Ilir / Bpk. Rahmat Fauzi"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                    </div>

                    {{-- NO HP & TANGGAL PENGGUNAAN --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                No. WhatsApp / HP Penanggung Jawab <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" name="no_hp" value="{{ old('no_hp') }}" required
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Rencana Tanggal Penggunaan <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" name="tgl_sewa" value="{{ old('tgl_sewa') }}" required
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                        </div>
                    </div>

                    {{-- FASILITAS YANG DISEWA --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Fasilitas / Sarana yang Dimohon <span class="text-rose-500">*</span>
                        </label>
                        <select name="fasilitas_disewa" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">
                            <option value="">-- Pilih Fasilitas / Sarana --</option>
                            <option value="Aula Serbaguna Utama" {{ old('fasilitas_disewa') == 'Aula Serbaguna Utama' ? 'selected' : '' }}>Aula Serbaguna Utama (Kapasitas 300+ Orang, Full AC &amp; Sound)</option>
                            <option value="Lapangan Olahraga Futsal & Basket" {{ old('fasilitas_disewa') == 'Lapangan Olahraga Futsal & Basket' ? 'selected' : '' }}>Lapangan Olahraga Terbuka (Futsal, Basket, Voli &amp; Panahan)</option>
                            <option value="Laboratorium Komputer CBT" {{ old('fasilitas_disewa') == 'Laboratorium Komputer CBT' ? 'selected' : '' }}>Laboratorium Komputer CBT (40 Unit PC + Internet Gigabit)</option>
                            <option value="Ruang Kelas AC & Workshop" {{ old('fasilitas_disewa') == 'Ruang Kelas AC & Workshop' ? 'selected' : '' }}>Ruang Seminar / Kelas Ber-AC (Kapasitas 35 Orang)</option>
                            <option value="Perlengkapan Sound System & Panggung" {{ old('fasilitas_disewa') == 'Perlengkapan Sound System & Panggung' ? 'selected' : '' }}>Perlengkapan Sound System, Mic Wireless &amp; Panggung Mini</option>
                            <option value="Bus / Kendaraan Operasional Sekolah" {{ old('fasilitas_disewa') == 'Bus / Kendaraan Operasional Sekolah' ? 'selected' : '' }}>Bus / Mobil Operasional Kampus</option>
                        </select>
                    </div>

                    {{-- KEPERLUAN ACARA --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Deskripsi Rangkaian Acara / Keperluan <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="keperluan" rows="4" required
                                  placeholder="Jelaskan jenis kegiatan, susunan jadwal dari jam berapa sampai jam berapa, serta estimasi jumlah hadirin..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-amber-500 transition">{{ old('keperluan') }}</textarea>
                    </div>

                    {{-- UPLOAD SURAT / IDENTITAS --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Unggah Surat Permohonan / Salinan KTP Penanggung Jawab
                        </label>
                        <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-600 file:text-white hover:file:opacity-90">
                        <span class="text-[11px] text-gray-400 mt-1 block">Format: PDF, DOC, DOCX, JPG, PNG (Maksimal 10 MB).</span>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-[11px] text-gray-500">
                            <i class="fa-solid fa-shield-halved text-amber-600 mr-1"></i> Penggunaan sarana wajib menjunjung adab Islami.
                        </div>
                        <button type="submit" 
                                class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim Permohonan Sewa</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        {{-- SIDEBAR COLUMN (4/12) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- TATA TERTIB PENGGUNAAN SARANA --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <h3 class="text-xs font-black uppercase tracking-wider text-amber-600 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-list-check"></i>
                    Ketentuan &amp; Tata Tertib Sarana
                </h3>
                <ul class="space-y-3 text-xs text-gray-600">
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-ban text-rose-500 mt-0.5 shrink-0"></i>
                        <span><strong>Kawasan Bebas Asap Rokok:</strong> Dilarang keras merokok dan membawa rokok/vape di seluruh area kampus.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-vest text-indigo-600 mt-0.5 shrink-0"></i>
                        <span><strong>Adab &amp; Busana Islami:</strong> Panitia dan hadirin wajib berpakaian sopan dan menutup aurat.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-trash-can text-emerald-600 mt-0.5 shrink-0"></i>
                        <span><strong>Kebersihan &amp; Ketertiban:</strong> Pengguna wajib membuang sampah pada tempatnya dan menjaga fasilitas tetap utuh.</span>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <i class="fa-solid fa-clock text-amber-600 mt-0.5 shrink-0"></i>
                        <span><strong>Waktu Acara:</strong> Kegiatan malam maksimal selesai pukul 22.00 WIB untuk menjaga kenyamanan siswa asrama.</span>
                    </li>
                </ul>
            </div>

            {{-- TAUTAN LAYANAN LAINNYA --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <h4 class="text-xs font-black uppercase tracking-wider text-unit-primary mb-4">Layanan Terkait</h4>
                <div class="space-y-2 text-xs font-bold">
                    <a href="{{ url('/unit/' . $codeLower . '/layanan/kunjungan') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-school-flag mr-2 text-blue-600"></i> Izin Kunjungan Sekolah</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/layanan/kerjasama') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-handshake-angle mr-2 text-emerald-600"></i> Permohonan Kerja Sama</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                    <a href="{{ url('/unit/' . $codeLower . '/fasilitas') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-building-circle-check mr-2 text-unit-primary"></i> Daftar Fasilitas Kampus</span>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
                    </a>
                </div>
            </div>

            {{-- WHATSAPP SARPRAS --}}
            <div class="bg-gradient-to-br from-amber-800 to-amber-950 text-white rounded-3xl p-6 shadow-xl text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mx-auto text-amber-300 text-xl">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <h4 class="text-sm font-black">Cek Jadwal &amp; Biaya Sewa?</h4>
                <p class="text-xs text-amber-100 font-light leading-relaxed">
                    Hubungi bagian Sarana &amp; Prasarana {{ $info['name'] }} untuk info ketersediaan aula dan rincian tarif infaq kebersihan.
                </p>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $school->phone ?? $info['phone'] ?? '6281271708899') }}?text=Halo%20Pengelola%20Sarpras%20{{ urlencode($info['name']) }}%2C%20saya%20ingin%20menanyakan%20ketersediaan%20fasilitas%20sekolah." 
                   target="_blank" rel="noopener"
                   class="inline-block w-full py-2.5 rounded-xl text-xs font-bold bg-white text-amber-950 hover:bg-amber-50 shadow-md transition">
                    Tanya Sarpras via WA
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
