<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false, activeTab: '{{ $activeTab ?? 'portal' }}' }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Layanan Publik Terpadu Satu Pintu | {{ $settings['school_name'] ?? 'SIT Robbani' }}</title>
    <meta name="description" content="Portal Pelayanan Publik dan Administrasi Terpadu Satu Pintu Sekolah Islam Terpadu Robbani Ogan Ilir. Pengajuan izin kunjungan, permohonan kerjasama institusi, dan pemanfaatan sarana fasilitas sekolah.">

    <!-- Favicon & Touch Icons -->
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('favicon.png') }}?v=11">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=11">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=11">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              emerald: {
                950: '#040d06',
                900: '#07170a',
                800: '#0d1e0f',
                700: '#004532',
                600: '#059669',
              }
            },
            fontFamily: {
              sans: ["Plus Jakarta Sans", "sans-serif"],
            }
          }
        }
      }
    </script>

    <!-- Google Fonts, Material Symbols & Alpine.js -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s, color 0.3s; }
        [x-cloak] { display: none !important; }

        .reveal-fade-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-fade-up.is-visible {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-[#040d06] text-slate-900 dark:text-[#f0fdf4] antialiased min-h-screen flex flex-col justify-between transition-colors duration-300">

    <!-- STANDARD UNIFIED NAVIGATION HEADER -->
    @include('school.partials.header')

    <main class="flex-grow">
        {{-- SUBPAGE HERO HEADER (PERSIS DENGAN HALAMAN UNIT) --}}
        <div class="bg-gradient-to-r from-emerald-950 via-[#004532] to-slate-950 border-b border-emerald-900 text-white py-10 sm:py-14 relative overflow-hidden">
            <div class="absolute top-0 right-10 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <nav class="text-xs text-emerald-200 mb-3 flex items-center space-x-2 overflow-x-auto no-scrollbar whitespace-nowrap">
                    <a href="{{ route('home') }}" class="hover:text-white transition shrink-0">Beranda Utama</a>
                    <span>/</span>
                    <span class="text-amber-300 font-semibold shrink-0">Layanan Publik Terpadu</span>
                </nav>
                <div class="inline-flex items-center gap-2 bg-emerald-800/60 border border-emerald-600/50 px-3.5 py-1 rounded-full text-xs font-bold text-amber-300 mb-3 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    <span>Pelayanan Publik Terpadu Satu Pintu (PTSP)</span>
                </div>
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black tracking-tight text-white leading-tight">
                    Portal Layanan Publik Terpadu Satu Pintu
                </h1>
                <p class="text-xs sm:text-sm text-slate-200 mt-2 font-light max-w-3xl leading-relaxed">
                    Layanan administrasi, perizinan kunjungan resmi, kemitraan institusi/MoU, dan pemanfaatan sarana prasarana Sekolah Islam Terpadu Robbani secara terpadu, cepat, dan akuntabel dalam satu database terintegrasi.
                </p>
            </div>
        </div>

        {{-- MAIN CONTAINER --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14 space-y-12">
            
            {{-- ALERT PESAN SUCCESS JIKA ADA --}}
            @if(session('success'))
                <div class="p-5 rounded-2xl bg-emerald-100 dark:bg-[#0e2a14] border border-emerald-300 dark:border-emerald-600 text-emerald-900 dark:text-[#a8f52c] flex items-start gap-3 shadow-md reveal-fade-up is-visible">
                    <i class="fa-solid fa-circle-check text-emerald-600 dark:text-[#a8f52c] text-xl mt-0.5 shrink-0"></i>
                    <div>
                        <h4 class="text-sm font-bold">Permohonan Berhasil Dikirim!</h4>
                        <p class="text-xs mt-0.5">{{ session('success') }}</p>
                        <p class="text-[11px] text-slate-600 dark:text-slate-400 mt-1">Data Anda telah tercatat pada sistem database Humas &amp; Sarpras SIT Robbani Ogan Ilir.</p>
                    </div>
                </div>
            @endif

            {{-- SECTION TITLE --}}
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-black uppercase tracking-wider text-emerald-700 dark:text-[#c6f634] block mb-1">
                    PELAYANAN PUBLIK ONLINE
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Pilih Layanan yang Anda Butuhkan
                </h2>
                <div class="w-16 h-1 bg-emerald-600 dark:bg-[#c6f634] rounded-full mx-auto mt-2 mb-3"></div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                    Seluruh permohonan diproses secara profesional oleh Kantor Pelayanan Administrasi (KPA) dan bagian Humas &amp; Sarana Prasarana Sekolah Islam Terpadu Robbani.
                </p>
            </div>

            {{-- 3 SERVICE CARDS GRID (SAMA PERSIS DENGAN HALAMAN UNIT) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                
                {{-- CARD 1: IZIN KUNJUNGAN SEKOLAH --}}
                <div class="bg-white dark:bg-[#07170a] rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200 dark:border-[#1a381c] hover:border-emerald-500 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 flex items-center justify-center text-2xl mb-6 shadow-xs border border-blue-200 dark:border-blue-800">
                            <i class="fa-solid fa-school-flag"></i>
                        </div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-950/60 px-2.5 py-1 rounded-full border border-blue-200 dark:border-blue-800">
                            Studi Banding &amp; Edukasi
                        </span>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-3 mb-2">
                            Izin Kunjungan Sekolah
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Layanan pengajuan izin kunjungan resmi bagi sekolah lain, kampus, lembaga dakwah, atau instansi yang ingin melakukan studi tiru program tahfidz, kurikulum JSIT, dan sistem manajemen SIT Robbani.
                        </p>
                    </div>
                    <div class="pt-6 border-t border-slate-100 dark:border-[#1a381c] mt-6">
                        <button type="button" @click="activeTab = 'kunjungan'; $nextTick(() => document.getElementById('form-section').scrollIntoView({behavior: 'smooth'}))" 
                           class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800 dark:bg-emerald-600 dark:hover:bg-emerald-500 shadow-md transition cursor-pointer">
                            <span>Ajukan Izin Kunjungan</span>
                            <i class="fa-solid fa-arrow-right text-[11px]"></i>
                        </button>
                    </div>
                </div>

                {{-- CARD 2: PERMOHONAN KERJASAMA --}}
                <div class="bg-white dark:bg-[#07170a] rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200 dark:border-[#1a381c] hover:border-emerald-500 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-2xl mb-6 shadow-xs border border-emerald-200 dark:border-emerald-800">
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-1 rounded-full border border-emerald-200 dark:border-emerald-800">
                            Kemitraan &amp; MoU
                        </span>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-3 mb-2">
                            Permohonan Kerja Sama
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Fasilitas kemitraan strategis dengan perguruan tinggi, perbankan syariah, lembaga kesehatan, korporasi, program magang mahasiswa, beasiswa siswa, serta donasi dan program CSR keumatan.
                        </p>
                    </div>
                    <div class="pt-6 border-t border-slate-100 dark:border-[#1a381c] mt-6">
                        <button type="button" @click="activeTab = 'kerjasama'; $nextTick(() => document.getElementById('form-section').scrollIntoView({behavior: 'smooth'}))" 
                           class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition cursor-pointer">
                            <span>Ajukan Kemitraan</span>
                            <i class="fa-solid fa-arrow-right text-[11px]"></i>
                        </button>
                    </div>
                </div>

                {{-- CARD 3: SEWA SARANA & FASILITAS --}}
                <div class="bg-white dark:bg-[#07170a] rounded-3xl p-6 sm:p-8 shadow-xl border border-slate-200 dark:border-[#1a381c] hover:border-amber-500 hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-2xl mb-6 shadow-xs border border-amber-200 dark:border-amber-800">
                            <i class="fa-solid fa-building-circle-check"></i>
                        </div>
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-700 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/60 px-2.5 py-1 rounded-full border border-amber-200 dark:border-amber-800">
                            Sarana &amp; Prasarana
                        </span>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-3 mb-2">
                            Sewa Sarana &amp; Fasilitas
                        </h3>
                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            Peminjaman dan penyewaan fasilitas kampus SIT Robbani seperti Aula Serbaguna, Lapangan Olahraga, Laboratorium Komputer CBT, serta sarana pendukung kegiatan tabligh akbar dan perlombaan Islami.
                        </p>
                    </div>
                    <div class="pt-6 border-t border-slate-100 dark:border-[#1a381c] mt-6">
                        <button type="button" @click="activeTab = 'sewa'; $nextTick(() => document.getElementById('form-section').scrollIntoView({behavior: 'smooth'}))" 
                           class="w-full inline-flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 shadow-md transition cursor-pointer">
                            <span>Ajukan Sewa Sarana</span>
                            <i class="fa-solid fa-arrow-right text-[11px]"></i>
                        </button>
                    </div>
                </div>

            </div>

            {{-- INTERACTIVE FORM TABS SECTION (DIRECT ONLINE SUBMISSION) --}}
            <div id="form-section" class="scroll-mt-28 space-y-6">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-2 rounded-2xl bg-slate-200/80 dark:bg-[#07170a] border border-slate-300 dark:border-[#1a381c]">
                    <span class="text-xs font-black uppercase text-slate-700 dark:text-slate-300 px-3">
                        Formulir Permohonan:
                    </span>
                    <div class="grid grid-cols-3 gap-2 w-full sm:w-auto">
                        <button type="button" @click="activeTab = 'kunjungan'"
                                :class="activeTab === 'kunjungan' ? 'bg-emerald-700 text-white shadow-md' : 'bg-white dark:bg-[#0d1e0f] text-slate-700 dark:text-slate-300 hover:text-emerald-700'"
                                class="px-4 py-2.5 rounded-xl font-extrabold text-xs transition cursor-pointer text-center">
                            📌 1. Kunjungan
                        </button>
                        <button type="button" @click="activeTab = 'kerjasama'"
                                :class="activeTab === 'kerjasama' ? 'bg-emerald-700 text-white shadow-md' : 'bg-white dark:bg-[#0d1e0f] text-slate-700 dark:text-slate-300 hover:text-emerald-700'"
                                class="px-4 py-2.5 rounded-xl font-extrabold text-xs transition cursor-pointer text-center">
                            🤝 2. Kerjasama
                        </button>
                        <button type="button" @click="activeTab = 'sewa'"
                                :class="activeTab === 'sewa' ? 'bg-emerald-700 text-white shadow-md' : 'bg-white dark:bg-[#0d1e0f] text-slate-700 dark:text-slate-300 hover:text-emerald-700'"
                                class="px-4 py-2.5 rounded-xl font-extrabold text-xs transition cursor-pointer text-center">
                            🏢 3. Sewa Sarana
                        </button>
                    </div>
                </div>

                {{-- FORM 1: IZIN KUNJUNGAN SEKOLAH --}}
                <div x-show="activeTab === 'kunjungan' || activeTab === 'portal'" x-cloak class="bg-white dark:bg-[#07170a] rounded-3xl p-6 sm:p-10 border border-slate-200 dark:border-[#1a381c] shadow-xl space-y-6">
                    <div class="border-b border-slate-200 dark:border-[#1a381c] pb-4">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span>📌</span> <span>Formulir Pengajuan Izin Kunjungan Sekolah</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Harap isi data dengan lengkap. Tim Humas akan memverifikasi dan mengirimkan surat konfirmasi resmi.</p>
                    </div>

                    <form action="{{ route('school.layanan.kunjungan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Lembaga / Sekolah Pemohon *</label>
                                <input type="text" name="instansi" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: SMAIT Insan Mandiri / Kampus UNSRI">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Penanggung Jawab / Kontak Person *</label>
                                <input type="text" name="nama_pemohon" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="Nama Lengkap & Gelar">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Email Resmi *</label>
                                <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="email@instansi.ac.id">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">No. WhatsApp / HP *</label>
                                <input type="text" name="no_hp" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="0812xxxxxxxx">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Perkiraan Jumlah Peserta *</label>
                                <input type="number" name="jumlah_peserta" min="1" max="500" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: 35">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Rencana Tanggal Kunjungan *</label>
                                <input type="date" name="tgl_kunjungan" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                <span class="text-[10px] text-slate-500 dark:text-slate-400 mt-1 block">Hari resmi kunjungan: Senin &amp; Kamis (09.00 - 11.00 WIB)</span>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Lampiran Surat Permohonan Resmi (PDF/Doc/JPG)</label>
                                <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tujuan / Topik Kunjungan Studi Tiru *</label>
                            <textarea name="tujuan" rows="3" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="Jelaskan secara ringkas maksud dan tujuan kunjungan ke SIT Robbani..."></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="px-8 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold text-xs shadow-md transition-all hover:scale-105 flex items-center gap-2">
                                <span>Kirim Permohonan Kunjungan</span>
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- FORM 2: PERMOHONAN KERJASAMA --}}
                <div x-show="activeTab === 'kerjasama'" x-cloak class="bg-white dark:bg-[#07170a] rounded-3xl p-6 sm:p-10 border border-slate-200 dark:border-[#1a381c] shadow-xl space-y-6">
                    <div class="border-b border-slate-200 dark:border-[#1a381c] pb-4">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span>🤝</span> <span>Formulir Pengajuan Kemitraan &amp; Kerja Sama (MoU)</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Kami membuka ruang kolaborasi seluas-luasnya untuk memajukan pendidikan generasi Islam Robbani.</p>
                    </div>

                    <form action="{{ route('school.layanan.kerjasama.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Perusahaan / Universitas / Lembaga *</label>
                                <input type="text" name="nama_lembaga" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="Nama Lembaga Mitra">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Narahubung / Pejabat Penandatangan *</label>
                                <input type="text" name="nama_kontak" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="Nama Lengkap & Jabatan">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Email Resmi *</label>
                                <input type="email" name="email" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="mitra@domain.com">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">No. WhatsApp / HP *</label>
                                <input type="text" name="no_hp" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="0812xxxxxxxx">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Bentuk Kerjasama *</label>
                                <select name="jenis_kerjasama" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                    <option value="Magang / Praktik Kerja Lapangan (PKL)">Magang / Praktik Lapangan Mahasiswa (PKL)</option>
                                    <option value="Beasiswa & Program CSR">Program Beasiswa Siswa / CSR Perusahaan</option>
                                    <option value="Kemitraan Perbankan Syariah">Kemitraan Perbankan &amp; Layanan Syariah</option>
                                    <option value="Kemitraan Kesehatan & Medis">Pemeriksaan Kesehatan Siswa / Lembaga Medis</option>
                                    <option value="Kerjasama Pelatihan & Workshop">Pelatihan Guru &amp; Workshop Pendidikan</option>
                                    <option value="Kerjasama Lainnya">Kerjasama Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Draft Proposal / Term of Reference (TOR)</label>
                                <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Deskripsi Ruang Lingkup &amp; Rencana Program Kemitraan *</label>
                            <textarea name="deskripsi" rows="3" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="Tuliskan gambaran ringkas program kerja sama dan manfaat bagi kedua belah pihak..."></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="px-8 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold text-xs shadow-md transition-all hover:scale-105 flex items-center gap-2">
                                <span>Ajukan Kemitraan &amp; MoU</span>
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- FORM 3: SEWA SARANA & FASILITAS --}}
                <div x-show="activeTab === 'sewa'" x-cloak class="bg-white dark:bg-[#07170a] rounded-3xl p-6 sm:p-10 border border-slate-200 dark:border-[#1a381c] shadow-xl space-y-6">
                    <div class="border-b border-slate-200 dark:border-[#1a381c] pb-4">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span>🏢</span> <span>Formulir Peminjaman &amp; Sewa Sarana Prasarana</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Pemanfaatan sarana prasarana sekolah untuk kegiatan yang edukatif, bernilai positif, dan islami.</p>
                    </div>

                    <form action="{{ route('school.layanan.sewa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Pemohon / Organisasi / Penyewa *</label>
                                <input type="text" name="nama_penyewa" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="Nama Lengkap / Nama Komunitas">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">No. WhatsApp / HP *</label>
                                <input type="text" name="no_hp" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="0812xxxxxxxx">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Fasilitas yang Ingin Digunakan / Disewa *</label>
                                <select name="fasilitas_disewa" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                                    <option value="Aula Serbaguna SIT Robbani">Aula Serbaguna SIT Robbani (Indoor AC)</option>
                                    <option value="Lapangan Olahraga Futsal / Basket">Lapangan Olahraga Serbaguna</option>
                                    <option value="Laboratorium Komputer CBT (50 PC)">Laboratorium Komputer CBT (50 PC Client)</option>
                                    <option value="Masjid Sekolah SIT Robbani">Masjid Sekolah (Kajian / Tabligh Akbar)</option>
                                    <option value="Ruang Kelas AC & Smart TV">Ruang Kelas &amp; Seminar Edukasi</option>
                                    <option value="Fasilitas Lainnya">Fasilitas Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tanggal Rencana Pemakaian *</label>
                                <input type="date" name="tgl_sewa" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Lampiran Surat Permohonan / Dokumen Kegiatan</label>
                                <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Keperluan &amp; Gambaran Acara *</label>
                            <textarea name="keperluan" rows="3" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-[#040d06] border border-slate-300 dark:border-[#1a381c] text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-emerald-500" placeholder="Tuliskan nama acara, estimasi durasi, dan susunan panitia..."></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="px-8 py-3 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-extrabold text-xs shadow-md transition-all hover:scale-105 flex items-center gap-2">
                                <span>Kirim Permohonan Sewa</span>
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- 3-STEP PROSEDUR ALUR PELAYANAN (PERSIS HALAMAN UNIT) --}}
            <div class="bg-gradient-to-br from-emerald-950 via-[#004532] to-slate-950 text-white rounded-3xl p-8 sm:p-12 shadow-2xl">
                <div class="max-w-2xl mx-auto text-center mb-10">
                    <span class="text-xs font-black uppercase tracking-wider text-amber-300 block mb-1">
                        ALUR MUDAH &amp; CEPAT
                    </span>
                    <h3 class="text-xl sm:text-3xl font-extrabold tracking-tight">
                        Prosedur Pelayanan Terpadu
                    </h3>
                    <p class="text-xs sm:text-sm text-emerald-100 mt-1 font-light">
                        Hanya butuh 3 langkah praktis untuk mendapatkan persetujuan resmi dan pelayanan terbaik dari kami.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-8">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15 relative">
                        <div class="w-10 h-10 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-sm mb-4 shadow">
                            1
                        </div>
                        <h4 class="text-sm font-bold text-white">1. Isi Formulir Online</h4>
                        <p class="text-xs text-slate-200 mt-1.5 leading-relaxed font-light">
                            Pilih jenis layanan, lengkapi data kontak pemohon, tanggal kegiatan, serta lampirkan surat permohonan resmi dalam format PDF/DOC.
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15 relative">
                        <div class="w-10 h-10 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-sm mb-4 shadow">
                            2
                        </div>
                        <h4 class="text-sm font-bold text-white">2. Verifikasi &amp; Telaah Humas</h4>
                        <p class="text-xs text-slate-200 mt-1.5 leading-relaxed font-light">
                            Tim Humas dan KPA Sekolah melakukan pengecekan jadwal, ketersediaan sarana prasarana, serta koordinasi internal pimpinan yayasan.
                        </p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/15 relative">
                        <div class="w-10 h-10 rounded-full bg-amber-400 text-slate-950 font-black flex items-center justify-center text-sm mb-4 shadow">
                            3
                        </div>
                        <h4 class="text-sm font-bold text-white">3. Konfirmasi &amp; Surat Balasan</h4>
                        <p class="text-xs text-slate-200 mt-1.5 leading-relaxed font-light">
                            Pemohon menerima notifikasi WhatsApp / Email berisi surat balasan resmi berstempel dan konfirmasi kesiapan pelayanan.
                        </p>
                    </div>
                </div>
            </div>

            {{-- HELPDESK & JAM OPERASIONAL KPA (PERSIS HALAMAN UNIT) --}}
            <div class="bg-white dark:bg-[#07170a] rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200 dark:border-[#1a381c] grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <span class="text-xs font-black uppercase tracking-wider text-emerald-700 dark:text-[#c6f634] block mb-1">
                        PUSAT BANTUAN &amp; PENGADUAN
                    </span>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white leading-snug">
                        Butuh Bantuan Langsung dari Narahubung Kami?
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 mt-2 leading-relaxed">
                        Jika Anda memiliki pertanyaan spesifik mengenai prosedur, ketersediaan aula serbaguna, atau ingin berdiskusi mengenai MoU kerjasama, hubungi tim Humas KPA SIT Robbani sekarang.
                    </p>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <a href="https://api.whatsapp.com/send?phone=62811747472" 
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md transition">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>Chat WhatsApp Hotline KPA</span>
                        </a>
                        <a href="{{ route('home') }}#kontak" 
                           class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-[#0d1e0f] hover:bg-slate-200 dark:hover:bg-[#1a381c] transition">
                            <i class="fa-solid fa-location-dot text-sm text-emerald-700 dark:text-[#c6f634]"></i>
                            <span>Alamat Resmi KPA</span>
                        </a>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-[#040d06] rounded-2xl p-6 border border-slate-200 dark:border-[#1a381c] space-y-3">
                    <h4 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">Jam Operasional Kantor Pelayanan Administrasi (KPA):</h4>
                    <ul class="text-xs text-slate-600 dark:text-slate-300 space-y-2">
                        <li class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-[#1a381c]">
                            <span>Senin - Kamis</span>
                            <span class="font-bold text-slate-800 dark:text-white">07.30 - 16.00 WIB</span>
                        </li>
                        <li class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-[#1a381c]">
                            <span>Jum'at</span>
                            <span class="font-bold text-slate-800 dark:text-white">07.30 - 11.30 &amp; 13.30 - 16.00 WIB</span>
                        </li>
                        <li class="flex items-center justify-between py-1 border-b border-slate-200 dark:border-[#1a381c]">
                            <span>Sabtu</span>
                            <span class="font-bold text-slate-800 dark:text-white">07.30 - 13.00 WIB</span>
                        </li>
                        <li class="flex items-center justify-between py-1 text-rose-600 font-bold">
                            <span>Ahad &amp; Hari Libur Nasional</span>
                            <span>Tutup (Tersedia Hotline WA)</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </main>

    <!-- STANDARD UNIFIED FOOTER -->
    @include('school.partials.footer')

    @include('components.chat-ai-widget')

</body>
</html>
