@extends('school.unit.layouts.master')

@section('title', 'Permohonan Kerja Sama & Kemitraan - ' . ($info['name'] ?? 'Sekolah Islam Terpadu'))
@section('meta_description', 'Formulir permohonan kemitraan strategis, MoU pendidikan, CSR, sponsorship kegiatan, dan magang di ' . ($info['name'] ?? 'Sekolah Islam Terpadu') . '.')

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
            <span class="text-amber-300 font-semibold shrink-0">Kerja Sama</span>
        </nav>
        <h1 class="text-2xl sm:text-4xl font-black tracking-tight">Permohonan Kerja Sama &amp; Kemitraan</h1>
        <p class="text-xs sm:text-sm text-indigo-100 mt-1.5 sm:mt-2 font-light max-w-2xl">
            Membuka pintu sinergi dan kolaborasi kebaikan bersama institusi pendidikan, korporasi, perbankan syariah, dan lembaga sosial di {{ $info['name'] }}.
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
                <h4 class="text-xs sm:text-sm font-bold">Permohonan Kemitraan Diterima!</h4>
                <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- ERROR ALERT --}}
    @if($errors->any())
        <div class="mb-8 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 space-y-1 text-xs">
            <div class="font-bold flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-600"></i>
                Mohon periksa kembali isian formulir kerjasama:
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
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-600 block mb-1">
                        Sinergi &amp; Kolaborasi Kebaikan
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
                        Formulir Pengajuan Kemitraan / MoU
                    </h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Lengkapi proposal kerjasama Anda. Tim Kemitraan &amp; Humas Yayasan akan mempelajari ruang lingkup sinergi.
                    </p>
                </div>

                <form action="{{ url('/unit/' . $codeLower . '/layanan/kerjasama') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- NAMA LEMBAGA / PERUSAHAAN --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Nama Lembaga / Perusahaan / Mitra <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="nama_lembaga" value="{{ old('nama_lembaga') }}" required
                               placeholder="Contoh: PT Bank Syariah Indonesia / Dompet Dhuafa / Universitas Sriwijaya"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                    </div>

                    {{-- NAMA KONTAK & JABATAN --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                Nama Narahubung / PIC <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="nama_kontak" value="{{ old('nama_kontak') }}" required
                                   placeholder="Contoh: Bpk. Kurniawan, S.E (Manager CSR)"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                                No. WhatsApp / Telepon <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" name="no_hp" value="{{ old('no_hp') }}" required
                                   placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                        </div>
                    </div>

                    {{-- EMAIL RESMI --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Alamat Email Resmi Perusahaan / Lembaga <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               placeholder="Contoh: partnership@perusahaan.co.id"
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                    </div>

                    {{-- JENIS KERJASAMA --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Bidang &amp; Jenis Kerja Sama <span class="text-rose-500">*</span>
                        </label>
                        <select name="jenis_kerjasama" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                            <option value="">-- Pilih Bidang Kerja Sama --</option>
                            <option value="Pendidikan & Kurikulum JSIT" {{ old('jenis_kerjasama') == 'Pendidikan & Kurikulum JSIT' ? 'selected' : '' }}>MoU Pendidikan &amp; Pengembangan Kurikulum JSIT</option>
                            <option value="Program Beasiswa Siswa Tahfidz" {{ old('jenis_kerjasama') == 'Program Beasiswa Siswa Tahfidz' ? 'selected' : '' }}>Program Beasiswa Siswa Berprestasi &amp; Yatim/Dhuafa</option>
                            <option value="Magang Mahasiswa & PKL" {{ old('jenis_kerjasama') == 'Magang Mahasiswa & PKL' ? 'selected' : '' }}>Penerimaan Praktik Mengajar / Magang Mahasiswa (PPL/PKL)</option>
                            <option value="CSR & Program Lingkungan" {{ old('jenis_kerjasama') == 'CSR & Program Lingkungan' ? 'selected' : '' }}>Penyaluran CSR Perusahaan &amp; Lingkungan Hidup</option>
                            <option value="Sponsorship Kegiatan & Event" {{ old('jenis_kerjasama') == 'Sponsorship Kegiatan & Event' ? 'selected' : '' }}>Sponsorship Event Lomba, Milad &amp; Wisuda Robbani</option>
                            <option value="Layanan Kesehatan & Psikologi" {{ old('jenis_kerjasama') == 'Layanan Kesehatan & Psikologi' ? 'selected' : '' }}>Pemeriksaan Kesehatan Siswa &amp; Konseling Psikologi</option>
                            <option value="Lainnya" {{ old('jenis_kerjasama') == 'Lainnya' ? 'selected' : '' }}>Bidang Kerja Sama Lainnya</option>
                        </select>
                    </div>

                    {{-- DESKRIPSI RENCANA KERJASAMA --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Deskripsi Rencana Kerjasama / Sinopsis Proposal <span class="text-rose-500">*</span>
                        </label>
                        <textarea name="deskripsi" rows="4" required
                                  placeholder="Tuliskan latar belakang, tujuan kemitraan, bentuk kegiatan, serta manfaat timbal balik bagi kedua belah pihak..."
                                  class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">{{ old('deskripsi') }}</textarea>
                    </div>

                    {{-- UPLOAD FILE PROPOSAL --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Unggah Dokumen Proposal / Draft MoU (Opsional)
                        </label>
                        <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50/50 text-xs text-gray-600 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:opacity-90">
                        <span class="text-[11px] text-gray-400 mt-1 block">Format file: PDF, DOC, DOCX, JPG, PNG (Maksimal 10 MB).</span>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-[11px] text-gray-500">
                            <i class="fa-solid fa-handshake text-emerald-600 mr-1"></i> Kerjasama berasaskan ukhuwah &amp; kebermanfaatan umat.
                        </div>
                        <button type="submit" 
                                class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg hover:shadow-xl transition flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim Permohonan Kerja Sama</span>
                        </button>
                    </div>

                </form>

            </div>
        </div>

        {{-- SIDEBAR COLUMN (4/12) --}}
        <div class="lg:col-span-4 space-y-6">
            
            {{-- RUANG LINGKUP KEMITRAAN --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <h3 class="text-xs font-black uppercase tracking-wider text-emerald-600 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-building-ngo"></i>
                    Bentuk Kemitraan Terbuka
                </h3>
                <div class="space-y-3 text-xs text-gray-600">
                    <div class="p-3 rounded-xl bg-emerald-50/50 border border-emerald-100">
                        <h4 class="font-bold text-gray-900 mb-0.5">Perguruan Tinggi &amp; Kampus</h4>
                        <p class="text-[11px] text-gray-500">Pemberdayaan guru, penelitian pengabdian masyarakat (PkM), dan magang mahasiswa FKIP.</p>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-50/50 border border-blue-100">
                        <h4 class="font-bold text-gray-900 mb-0.5">Perbankan &amp; BUMN / Swasta</h4>
                        <p class="text-[11px] text-gray-500">Pemberian beasiswa dhuafa, literasi keuangan syariah, dan fasilitas CSR sarana sekolah.</p>
                    </div>
                    <div class="p-3 rounded-xl bg-amber-50/50 border border-amber-100">
                        <h4 class="font-bold text-gray-900 mb-0.5">Lembaga Dakwah &amp; Amil Zakat</h4>
                        <p class="text-[11px] text-gray-500">Sinergi pembinaan da'i cilik, penyaluran zakat produktif, dan kajian parenting akbar.</p>
                    </div>
                </div>
            </div>

            {{-- TAUTAN LAYANAN LAINNYA --}}
            <div class="bg-white rounded-3xl p-6 shadow-xl border border-gray-100 reveal-fade-up">
                <h4 class="text-xs font-black uppercase tracking-wider text-unit-primary mb-4">Layanan Terkait</h4>
                <div class="space-y-2 text-xs font-bold">
                    <a href="{{ url('/unit/' . $codeLower . '/layanan/kunjungan') }}" class="flex items-center justify-between p-3 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-unit-primary transition">
                        <span><i class="fa-solid fa-school-flag mr-2 text-blue-600"></i> Izin Kunjungan Sekolah</span>
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

            {{-- WHATSAPP HUMAS KEMITRAAN --}}
            <div class="bg-gradient-to-br from-emerald-900 to-teal-950 text-white rounded-3xl p-6 shadow-xl text-center space-y-3">
                <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mx-auto text-emerald-300 text-xl">
                    <i class="fa-brands fa-whatsapp"></i>
                </div>
                <h4 class="text-sm font-black">Diskusi Proposal via WA?</h4>
                <p class="text-xs text-emerald-100 font-light leading-relaxed">
                    Ingin menjadwalkan audiensi atau presentasi kerjasama bersama pimpinan {{ $info['name'] }}?
                </p>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $school->phone ?? $info['phone'] ?? '6281271708899') }}?text=Halo%20Tim%20Kemitraan%20{{ urlencode($info['name']) }}%2C%20kami%20ingin%20berdiskusi%20tentang%20proposal%20kerjasama." 
                   target="_blank" rel="noopener"
                   class="inline-block w-full py-2.5 rounded-xl text-xs font-bold bg-white text-emerald-950 hover:bg-emerald-50 shadow-md transition">
                    Hubungi Tim Kemitraan
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
