<!DOCTYPE html>
<html lang="id" class="scroll-smooth light" x-data="layananPage" :class="darkMode ? 'dark' : 'light'">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Publik Terpadu Humas &amp; Sarpras | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        
        /* LIGHT MODE: Emerald Green & Warm Orange Palette (High Contrast & High Readability) */
        html.light {
            --bg-main: #f8fafc;
            --bg-card: #ffffff;
            --border-card: #e2e8f0;
            --bg-input: #ffffff;
            --border-input: #cbd5e1;
            --text-heading: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --box-green-bg: #ecfdf5;
            --box-green-border: #a7f3d0;
            --box-green-text: #065f46;
            --box-orange-bg: #fff7ed;
            --box-orange-border: #fed7aa;
            --box-orange-text: #9a3412;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
        }

        /* DARK MODE: Hijau Obsidian & Electric Neon Lime Palette */
        html.dark {
            --bg-main: #030904;
            --bg-card: #0a180c;
            --border-card: #1a3b1d;
            --bg-input: #051006;
            --border-input: #214725;
            --text-heading: #ffffff;
            --text-body: #f1f5f9;
            --text-muted: #94a3b8;
            --box-green-bg: #081a0b;
            --box-green-border: #164019;
            --box-green-text: #a8f52c;
            --box-orange-bg: #1c1205;
            --box-orange-border: #422909;
            --box-orange-text: #fb923c;
            --card-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.75);
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: var(--bg-main); 
            color: var(--text-body); 
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .layanan-card { 
            background-color: var(--bg-card) !important; 
            border: 1px solid var(--border-card) !important; 
            box-shadow: var(--card-shadow);
        }

        .layanan-input { 
            background-color: var(--bg-input) !important; 
            border: 1px solid var(--border-input) !important; 
            color: var(--text-heading) !important; 
        }

        /* Action Submit Button */
        html.light .btn-action-gradient {
            background: linear-gradient(135deg, #059669 0%, #ea580c 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 8px 20px rgba(234, 88, 12, 0.25);
        }
        html.light .btn-action-gradient:hover {
            opacity: 0.96;
            transform: translateY(-1px);
        }

        html.dark .btn-action-gradient {
            background: #a8f52c !important;
            color: #030904 !important;
            font-weight: 900 !important;
            box-shadow: 0 0 25px rgba(168, 245, 44, 0.35);
        }
        html.dark .btn-action-gradient:hover {
            background: #bbf846 !important;
            transform: translateY(-1px);
        }

        /* Active & Inactive Service Tab Switchers */
        html.light .tab-btn-active {
            background-color: #059669 !important;
            color: #ffffff !important;
            border-color: #047857 !important;
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.3);
        }
        html.dark .tab-btn-active {
            background-color: #143b18 !important;
            color: #a8f52c !important;
            border-color: #a8f52c !important;
            box-shadow: 0 0 18px rgba(168, 245, 44, 0.25);
        }

        .tab-btn-inactive {
            background-color: var(--bg-card) !important;
            color: var(--text-body) !important;
            border: 1px solid var(--border-card) !important;
        }
        .tab-btn-inactive:hover {
            border-color: #059669 !important;
            color: #059669 !important;
        }
        html.dark .tab-btn-inactive:hover {
            border-color: #a8f52c !important;
            color: #a8f52c !important;
        }
    </style>
</head>
<body class="antialiased min-h-screen pb-24">

    <!-- Top Sticky Header Bar -->
    <header class="bg-gradient-to-r from-[#004532] via-[#059669] to-[#0f172a] dark:from-[#030904] dark:via-[#08180c] dark:to-[#020503] py-4 px-6 sticky top-0 z-50 shadow-md border-b border-emerald-900/40 dark:border-[#1a3b1d]">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="/images/logo robbani dark.png" class="h-9 w-auto object-contain" alt="Logo SIT Robbani">
                <div>
                    <span class="font-black text-xs block text-emerald-200 dark:text-[#a8f52c] uppercase tracking-wider">LAYANAN PUBLIC HUMAS &amp; FASILITAS</span>
                    <span class="text-[10px] text-orange-300 dark:text-orange-400 font-extrabold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            
            <div class="flex items-center gap-3 sm:gap-4">
                <!-- Theme Mode Switcher Toggle Button -->
                <button @click="toggleTheme()" class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-black transition-all flex items-center gap-1.5 shadow-sm cursor-pointer">
                    <span x-text="darkMode ? '🌙' : '☀️'"></span>
                    <span x-text="darkMode ? 'Mode Gelap (Obsidian)' : 'Mode Terang (Hijau-Orange)'" class="hidden sm:inline"></span>
                </button>

                <!-- Navigation Quick Links -->
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 dark:bg-[#a8f52c] dark:hover:bg-[#bbf846] text-white dark:text-[#030904] font-black text-xs transition-all flex items-center gap-1.5 shadow-sm">
                    <span>🏠</span> <span class="hidden sm:inline">Beranda Utama</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="py-10 max-w-5xl mx-auto px-4 space-y-8">
        
        <!-- Page Title Header -->
        <div class="text-center space-y-3">
            <span class="px-4 py-1.5 rounded-full bg-orange-100 dark:bg-[#1f1709] border border-orange-300 dark:border-[#422909] text-orange-700 dark:text-[#fb923c] font-black text-xs uppercase tracking-widest inline-flex items-center gap-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-orange-500 dark:bg-[#a8f52c] animate-ping"></span>
                <span>LAYANAN TERPADU SEKOLAH ISLAM TERPADU ROBBANI</span>
            </span>
            <h1 class="text-3xl sm:text-4xl font-black text-[var(--text-heading)] tracking-tight">Portal Pengajuan Layanan Publik</h1>
            <p class="text-[var(--text-muted)] text-xs sm:text-sm font-medium max-w-2xl mx-auto">
                Silakan pilih jenis layanan di bawah ini untuk melihat standar operasional (SOP) dan mengirimkan formulir permohonan resmi secara online.
            </p>
        </div>

        <!-- 3 Public Service Tabs Navigation (DEFAULT: LAYANAN 1 / KUNJUNGAN) -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-2 rounded-2xl bg-slate-200/70 dark:bg-[#051006] border border-slate-300 dark:border-[#1a3b1d] shadow-inner">
            <button type="button" @click="switchTab('kunjungan')" 
                    :class="activeTab === 'kunjungan' ? 'tab-btn-active' : 'tab-btn-inactive'"
                    class="p-3.5 rounded-xl text-center font-black text-xs flex items-center justify-center gap-2 transition-all cursor-pointer">
                <span class="text-base">📌</span>
                <span>1. Izin Kunjungan Sekolah</span>
            </button>

            <button type="button" @click="switchTab('kerjasama')" 
                    :class="activeTab === 'kerjasama' ? 'tab-btn-active' : 'tab-btn-inactive'"
                    class="p-3.5 rounded-xl text-center font-black text-xs flex items-center justify-center gap-2 transition-all cursor-pointer">
                <span class="text-base">🤝</span>
                <span>2. Permohonan Kerja Sama</span>
            </button>

            <button type="button" @click="switchTab('sewa')" 
                    :class="activeTab === 'sewa' ? 'tab-btn-active' : 'tab-btn-inactive'"
                    class="p-3.5 rounded-xl text-center font-black text-xs flex items-center justify-center gap-2 transition-all cursor-pointer">
                <span class="text-base">🏢</span>
                <span>3. Sewa Barang &amp; Fasilitas</span>
            </button>
        </div>

        @if(session('success'))
        <div class="p-5 rounded-2xl bg-emerald-600 dark:bg-[#143b18] text-white dark:text-[#a8f52c] border border-emerald-500 dark:border-[#a8f52c] font-black text-sm space-y-1 shadow-lg flex items-center gap-3">
            <span class="text-2xl">✅</span>
            <div>
                <p class="text-sm font-black">{{ session('success') }}</p>
                <p class="text-xs font-bold text-emerald-100 dark:text-emerald-300">Permohonan Anda telah masuk ke sistem Layanan Terpadu SIT Robbani Ogan Ilir.</p>
            </div>
        </div>
        @endif

        <!-- ==================================================================== -->
        <!-- TAB 1 CONTENT: PERMOHONAN IZIN KUNJUNGAN KE SEKOLAH                   -->
        <!-- ==================================================================== -->
        <div x-show="activeTab === 'kunjungan'" x-cloak class="space-y-8">
            
            <!-- Standard Service Info Card for Kunjungan -->
            <div class="layanan-card p-6 sm:p-8 rounded-[2rem] space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200 dark:border-[#1a3b1d] pb-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950/90 border border-emerald-300 dark:border-emerald-700 flex items-center justify-center text-xl text-emerald-800 dark:text-[#a8f52c] shadow-xs">
                        📌
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-[var(--text-heading)]">Standar Pelayanan: Permohonan Izin Kunjungan ke Sekolah</h2>
                        <p class="text-xs text-[var(--text-muted)] font-semibold">Persyaratan &amp; Prosedur Resmi Kunjungan Studi Banding / Observasi ke SIT Robbani</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <!-- Persyaratan Pelayanan (7 Poin Tanpa Kewajiban Akun) -->
                    <div class="p-5 rounded-2xl bg-[var(--box-green-bg)] border border-[var(--box-green-border)] space-y-3">
                        <div class="flex items-center gap-2 font-black text-slate-900 dark:text-[#a8f52c] uppercase tracking-wider text-[11px]">
                            <span>📋</span> <span>Persyaratan Pelayanan:</span>
                        </div>
                        <ul class="space-y-2 text-slate-900 dark:text-slate-200 font-semibold pl-1">
                            <li class="flex items-start gap-2">
                                <span class="text-slate-900 dark:text-[#a8f52c] font-black">1.</span>
                                <span>Pemohon melakukan pengajuan resmi melalui sistem formulir online ini.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-slate-900 dark:text-[#a8f52c] font-black">2.</span>
                                <span>Bukti permohonan kunjungan sudah ditandatangani oleh pejabat berwenang &amp; cap stempel basah dibawa ketika hari kunjungan.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-slate-900 dark:text-[#a8f52c] font-black">3.</span>
                                <span>Maksimal jumlah pengunjung sebanyak <strong>100 orang</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-slate-900 dark:text-[#a8f52c] font-black">4.</span>
                                <span>Hari kunjungan resmi adalah hari <strong>Senin dan Kamis</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-slate-900 dark:text-[#a8f52c] font-black">5.</span>
                                <span>Waktu kunjungan adalah pukul <strong>09.00 - 11.00 WIB</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-slate-900 dark:text-[#a8f52c] font-black">6.</span>
                                <span>Pengunjung menggunakan pakaian yang <strong>sopan dan rapi</strong>.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-slate-900 dark:text-[#a8f52c] font-black">7.</span>
                                <span>Wajib menerapkan protokol kesehatan (protkes) secara ketat.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Meta Detail SOP -->
                    <div class="space-y-4">
                        <div class="p-5 rounded-2xl bg-[var(--box-orange-bg)] border border-[var(--box-orange-border)] space-y-3">
                            <div>
                                <span class="text-[10px] font-black text-orange-950 dark:text-[#fb923c] uppercase block tracking-wider">⏱️ Jangka Waktu Penyelesaian</span>
                                <p class="text-xs font-bold text-slate-900 dark:text-white mt-0.5">Waktu respon atas permohonan paling lambat <strong>10 (sepuluh) hari kerja</strong>.</p>
                            </div>
                            <div class="border-t border-orange-200 dark:border-[#422909] pt-2.5">
                                <span class="text-[10px] font-black text-orange-950 dark:text-[#fb923c] uppercase block tracking-wider">💰 Biaya dan Tarif</span>
                                <p class="text-xs font-black text-slate-900 dark:text-[#a8f52c] mt-0.5">Proses permohonan dan pelaksanaan kunjungan <strong>GRATIS (Tidak Dipungut Biaya)</strong>.</p>
                            </div>
                            <div class="border-t border-orange-200 dark:border-[#422909] pt-2.5">
                                <span class="text-[10px] font-black text-orange-950 dark:text-[#fb923c] uppercase block tracking-wider">📦 Produk Layanan</span>
                                <p class="text-xs font-bold text-slate-900 dark:text-white mt-0.5">Surat Izin / Konfirmasi Kunjungan Sekolah</p>
                            </div>
                        </div>

                        <!-- Pengaduan & Layanan Contact -->
                        <div class="p-5 rounded-2xl bg-slate-900 text-white space-y-2 border border-slate-800 dark:border-[#1a3b1d]">
                            <div class="flex items-center gap-2 font-black text-emerald-400 dark:text-[#a8f52c] uppercase tracking-wider text-[11px]">
                                <span>💬</span> <span>Pengaduan, Saran dan Masukan:</span>
                            </div>
                            <p class="text-[11px] text-slate-300 font-medium">
                                Bagian Humas dan Media Layanan Terpadu Sekolah Islam Terpadu Robbani Ogan Ilir:
                            </p>
                            <div class="space-y-1 text-white font-semibold pt-1 text-[11px]">
                                <p class="flex items-center gap-2"><span>📍</span> <span><strong>Alamat:</strong> Gedung KPA SIT Robbani</span></p>
                                <p class="flex items-center gap-2"><span>📱</span> <span><strong>No. HP (WA):</strong> 0811747472</span></p>
                                <p class="flex items-center gap-2"><span>🌐</span> <span><strong>Website:</strong> sitrobbani.sch.id</span></p>
                                <p class="flex items-center gap-2"><span>✉️</span> <span><strong>Email:</strong> humas@sitrobbani.sch.id</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Permohonan Kunjungan -->
            <form action="{{ route('school.layanan.kunjungan.store') }}" method="POST" enctype="multipart/form-data" class="layanan-card p-6 sm:p-8 rounded-[2rem] space-y-5">
                @csrf
                <div class="border-b border-slate-200 dark:border-[#1a3b1d] pb-3 flex items-center justify-between">
                    <h3 class="text-base font-black text-[var(--text-heading)] flex items-center gap-2">
                        <span>📝</span> <span>Formulir Pengajuan Permohonan Kunjungan</span>
                    </h3>
                    <span class="text-[10px] text-[var(--text-muted)] font-bold">* Wajib diisi</span>
                </div>
                
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Nama Instansi / Sekolah / Lembaga *</label>
                    <input type="text" name="instansi" required placeholder="Contoh: SDIT Nurul Islam / Instansi Dinas / Komunitas Educational" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Nama Penanggung Jawab *</label>
                        <input type="text" name="nama_pemohon" required placeholder="Nama lengkap &amp; gelar penanggung jawab" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">No. WhatsApp / HP *</label>
                        <input type="text" name="no_hp" required placeholder="081234567890" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Email Aktif *</label>
                        <input type="email" name="email" required placeholder="email@instansi.com" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Rencana Tanggal Kunjungan (Senin / Kamis) *</label>
                        <input type="date" name="tgl_kunjungan" required class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Estimasi Jumlah Peserta (Maksimal 100 Orang) *</label>
                    <input type="number" name="jumlah_peserta" max="100" min="1" required placeholder="Contoh: 30" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Maksud &amp; Tujuan Kunjungan *</label>
                    <textarea name="tujuan" rows="3" required placeholder="Jelaskan agenda studi banding, topik pembahasan, atau maksud kunjungan..." class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600"></textarea>
                </div>

                <!-- Upload File Pendukung -->
                <div class="space-y-1.5 pt-2">
                    <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">📁 Upload Berkas / Surat Permohonan Kunjungan (Opsional)</label>
                    <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    <p class="text-[10px] text-[var(--text-muted)] font-medium">Format yang diterima: PDF, DOCX, JPG, PNG (Maksimal 10MB).</p>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl btn-action-gradient font-black text-xs uppercase tracking-widest transition-all">
                    Kirim Permohonan Izin Kunjungan ➔
                </button>
            </form>
        </div>

        <!-- ==================================================================== -->
        <!-- TAB 2 CONTENT: PERMOHONAN KERJA SAMA                                 -->
        <!-- ==================================================================== -->
        <div x-show="activeTab === 'kerjasama'" x-cloak class="space-y-8">
            
            <!-- Standard Service Info Card for Kerjasama -->
            <div class="layanan-card p-6 sm:p-8 rounded-[2rem] space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200 dark:border-[#1a3b1d] pb-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950/90 border border-emerald-300 dark:border-emerald-700 flex items-center justify-center text-xl text-emerald-800 dark:text-[#a8f52c] shadow-xs">
                        🤝
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-[var(--text-heading)]">Standar Pelayanan: Permohonan Kerja Sama</h2>
                        <p class="text-xs text-[var(--text-muted)] font-semibold">Persyaratan &amp; Prosedur Pengajuan Kemitraan Lembaga / Sponsorship Bersama SIT Robbani</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <!-- Persyaratan Pelayanan Kerjasama -->
                    <div class="p-5 rounded-2xl bg-[var(--box-green-bg)] border border-[var(--box-green-border)] space-y-3">
                        <div class="flex items-center gap-2 font-black text-emerald-900 dark:text-[#a8f52c] uppercase tracking-wider text-[11px]">
                            <span>📋</span> <span>Persyaratan Pelayanan Kerja Sama:</span>
                        </div>
                        
                        <div class="space-y-3 text-slate-800 dark:text-slate-200">
                            <div>
                                <span class="font-black text-emerald-900 dark:text-[#a8f52c] block">• Individu (Perorangan):</span>
                                <ul class="list-disc pl-5 space-y-1 font-semibold mt-1">
                                    <li>Surat Permohonan Kerja Sama</li>
                                    <li>Fotokopi / Scan KTP Pemohon</li>
                                    <li>Proposal Ringkas Sinergi / Kemitraan</li>
                                </ul>
                            </div>
                            
                            <div class="border-t border-emerald-200 dark:border-[#1a3b1d] pt-2">
                                <span class="font-black text-emerald-900 dark:text-[#a8f52c] block">• Lembaga / Organisasi / Perusahaan:</span>
                                <ul class="list-disc pl-5 space-y-1 font-semibold mt-1">
                                    <li>Surat Pengajuan Kerja Sama Resmi (Kop Surat &amp; Stempel)</li>
                                    <li>Fotokopi NPWP Perusahaan / Lembaga</li>
                                    <li>Proposal Penawaran Kerja Sama / Sponsorship</li>
                                    <li>Profil Lembaga / Company Profile</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Sistem Mekanisme dan Prosedur Kerjasama -->
                    <div class="space-y-4">
                        <div class="p-5 rounded-2xl bg-[var(--box-orange-bg)] border border-[var(--box-orange-border)] space-y-3">
                            <div class="flex items-center gap-2 font-black text-orange-900 dark:text-[#fb923c] uppercase tracking-wider text-[11px]">
                                <span>⚙️</span> <span>Sistem Mekanisme dan Prosedur:</span>
                            </div>
                            <ol class="list-decimal pl-4 space-y-1.5 text-slate-900 dark:text-white font-semibold">
                                <li>Mitra mengajukan permohonan kerjasama secara online melalui sistem.</li>
                                <li>Tim Kemitraan &amp; Humas meninjau proposal. Jika disetujui akan disampaikan penawaran/undangan diskusi; jika tidak disetujui akan diberitahukan via surat/pesan pemberitahuan.</li>
                                <li>Melakukan negosiasi draf perjanjian kesepahaman (MoU / MoA).</li>
                                <li>Setelah draf disepakati &amp; ditandatangani, pelaksanaan kegiatan kerjasama dapat dimulai.</li>
                            </ol>
                        </div>

                        <!-- Meta Waktu & Biaya Kerjasama -->
                        <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2 border border-slate-800 dark:border-[#1a3b1d]">
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="font-bold text-slate-400">⏱️ Respon Pelayanan:</span>
                                <span class="font-black text-white">Paling lambat 10 Hari Kerja</span>
                            </div>
                            <div class="flex justify-between items-center text-[11px] border-t border-slate-800 pt-1.5">
                                <span class="font-bold text-slate-400">💰 Biaya / Tarif:</span>
                                <span class="font-black text-emerald-400 dark:text-[#a8f52c]">GRATIS (Tanpa Biaya Administrasi)</span>
                            </div>
                            <div class="flex justify-between items-center text-[11px] border-t border-slate-800 pt-1.5">
                                <span class="font-bold text-slate-400">📦 Produk Layanan:</span>
                                <span class="font-black text-white">Nota Kesepahaman Kerjasama (MoU)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Permohonan Kerja Sama -->
            <form action="{{ route('school.layanan.kerjasama.store') }}" method="POST" enctype="multipart/form-data" class="layanan-card p-6 sm:p-8 rounded-[2rem] space-y-5">
                @csrf
                <div class="border-b border-slate-200 dark:border-[#1a3b1d] pb-3 flex items-center justify-between">
                    <h3 class="text-base font-black text-[var(--text-heading)] flex items-center gap-2">
                        <span>📝</span> <span>Formulir Pengajuan Kerja Sama &amp; Kemitraan</span>
                    </h3>
                    <span class="text-[10px] text-[var(--text-muted)] font-bold">* Wajib diisi</span>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Nama Perusahaan / Lembaga / Mitra *</label>
                    <input type="text" name="nama_lembaga" required placeholder="PT / Yayasan / Komunitas / Instansi Mitra" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Nama Penanggung Jawab *</label>
                        <input type="text" name="nama_kontak" required placeholder="Nama lengkap penanggung jawab" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">No. WhatsApp / Telepon *</label>
                        <input type="text" name="no_hp" required placeholder="081234567890" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Email Resmi *</label>
                        <input type="email" name="email" required placeholder="mitra@perusahaan.com" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Kategori Kerja Sama *</label>
                        <select name="jenis_kerjasama" required class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="Pendidikan & Akademik">Pendidikan &amp; Akademik</option>
                            <option value="Sponsorship & Event">Sponsorship &amp; Event Sekolah</option>
                            <option value="Media & Publikasi">Media &amp; Publikasi</option>
                            <option value="Sosial & Kemanusiaan">Sosial &amp; Kemanusiaan</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Ringkasan Proposal / Bentuk Kerjasama *</label>
                    <textarea name="deskripsi" rows="3" required placeholder="Jelaskan penawaran kerjasama, bentuk sinergi, dan manfaat bersama..." class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600"></textarea>
                </div>

                <!-- Upload File Proposal -->
                <div class="space-y-1.5 pt-2">
                    <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">📁 Upload Proposal / Berkas Penawaran Kerja Sama (Opsional)</label>
                    <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    <p class="text-[10px] text-[var(--text-muted)] font-medium">Format yang diterima: PDF, DOCX, JPG, PNG (Maksimal 10MB).</p>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl btn-action-gradient font-black text-xs uppercase tracking-widest transition-all">
                    Kirim Pengajuan Kerja Sama ➔
                </button>
            </form>
        </div>

        <!-- ==================================================================== -->
        <!-- TAB 3 CONTENT: PERMOHONAN SEWA MENYEWA BARANG SEKOLAH                  -->
        <!-- ==================================================================== -->
        <div x-show="activeTab === 'sewa'" x-cloak class="space-y-8">
            
            <!-- Standard Service Info Card for Sewa Barang -->
            <div class="layanan-card p-6 sm:p-8 rounded-[2rem] space-y-6">
                <div class="flex items-center gap-3 border-b border-slate-200 dark:border-[#1a3b1d] pb-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950/90 border border-emerald-300 dark:border-emerald-700 flex items-center justify-center text-xl text-emerald-800 dark:text-[#a8f52c] shadow-xs">
                        🏢
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-[var(--text-heading)]">Standar Pelayanan: Permohonan Sewa Menyewa Barang Sekolah</h2>
                        <p class="text-xs text-[var(--text-muted)] font-semibold">Persyaratan &amp; Prosedur Sewa Aula, Lapangan, Lab, Peralatan Audio &amp; Perlengkapan Acara</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <!-- Persyaratan Pelayanan Sewa -->
                    <div class="p-5 rounded-2xl bg-[var(--box-green-bg)] border border-[var(--box-green-border)] space-y-3">
                        <div class="flex items-center gap-2 font-black text-slate-900 dark:text-[#a8f52c] uppercase tracking-wider text-[11px]">
                            <span>📋</span> <span>Persyaratan Pelayanan Sewa Menyewa:</span>
                        </div>
                        
                        <div class="space-y-3 text-slate-900 dark:text-slate-200">
                            <div>
                                <span class="font-black text-slate-900 dark:text-[#a8f52c] block">• Individu (Perorangan):</span>
                                <ul class="list-disc pl-5 space-y-1 font-semibold mt-1">
                                    <li>Surat Permohonan Sewa</li>
                                    <li>Fotokopi / Scan KTP Pemohon</li>
                                    <li>Fotokopi NPWP (jika ada)</li>
                                </ul>
                            </div>
                            
                            <div class="border-t border-emerald-200 dark:border-[#1a3b1d] pt-2">
                                <span class="font-black text-slate-900 dark:text-[#a8f52c] block">• Lembaga / Organisasi:</span>
                                <ul class="list-disc pl-5 space-y-1 font-semibold mt-1">
                                    <li>Surat Permohonan Sewa Resmi (Kop Surat &amp; Stempel Basah)</li>
                                    <li>Fotokopi NPWP Lembaga / Organisasi</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Sistem Mekanisme dan Prosedur Sewa -->
                    <div class="space-y-4">
                        <div class="p-5 rounded-2xl bg-[var(--box-orange-bg)] border border-[var(--box-orange-border)] space-y-3">
                            <div class="flex items-center gap-2 font-black text-orange-950 dark:text-[#fb923c] uppercase tracking-wider text-[11px]">
                                <span>⚙️</span> <span>Sistem Mekanisme dan Prosedur:</span>
                            </div>
                            <ol class="list-decimal pl-4 space-y-1.5 text-slate-900 dark:text-white font-semibold">
                                <li>Penyewa mengajukan surat permohonan ditujukan kepada kepala sekolah.</li>
                                <li>Jika permohonan disetujui akan disampaikan penawaran harga kepada Mitra; jika tidak disetujui akan diberitahukan melalui surat pemberitahuan kepada Mitra.</li>
                                <li>Melakukan negosiasi harga. Jika setuju dilanjutkan dengan membuat draf perjanjian sewa menyewa; jika tidak setuju akan terjadi pembatalan sewa.</li>
                                <li>Setelah perjanjian pembayaran sewa ditandatangani, Mitra melakukan pembayaran sewa.</li>
                            </ol>
                        </div>

                        <!-- Meta Waktu & Biaya Sewa -->
                        <div class="p-4 rounded-2xl bg-slate-900 text-white space-y-2 border border-slate-800 dark:border-[#1a3b1d]">
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="font-bold text-slate-400">⏱️ Respon Pelayanan:</span>
                                <span class="font-black text-white">Paling lambat 10 Hari Kerja</span>
                            </div>
                            <div class="flex justify-between items-center text-[11px] border-t border-slate-800 pt-1.5">
                                <span class="font-bold text-slate-400">💰 Biaya dan Tarif:</span>
                                <span class="font-black text-emerald-400 dark:text-[#a8f52c]">Gratis Administrasi (Kecuali Tarif Sewa Aset)</span>
                            </div>
                            <div class="flex justify-between items-center text-[11px] border-t border-slate-800 pt-1.5">
                                <span class="font-bold text-slate-400">📦 Produk Layanan:</span>
                                <span class="font-black text-white">Perjanjian Sewa Asset / Fasilitas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Permohonan Sewa Barang -->
            <form action="{{ route('school.layanan.sewa.store') }}" method="POST" enctype="multipart/form-data" class="layanan-card p-6 sm:p-8 rounded-[2rem] space-y-5">
                @csrf
                <div class="border-b border-slate-200 dark:border-[#1a3b1d] pb-3 flex items-center justify-between">
                    <h3 class="text-base font-black text-[var(--text-heading)] flex items-center gap-2">
                        <span>📝</span> <span>Formulir Pengajuan Sewa Menyewa Barang &amp; Fasilitas</span>
                    </h3>
                    <span class="text-[10px] text-[var(--text-muted)] font-bold">* Wajib diisi</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Nama Penyewa / Organisasi *</label>
                        <input type="text" name="nama_penyewa" required placeholder="Nama lengkap / perwakilan lembaga" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">No. WhatsApp / HP *</label>
                        <input type="text" name="no_hp" required placeholder="081234567890" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Barang / Fasilitas yang Ingin Disewa *</label>
                        <select name="fasilitas_disewa" required class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="Aula Pertemuan Utama">Aula Pertemuan Utama SIT Robbani</option>
                            <option value="Lapangan Olahraga Outdoor">Lapangan Olahraga Outdoor</option>
                            <option value="Laboratorium Komputer & IT">Laboratorium Komputer &amp; IT</option>
                            <option value="Ruang Kelas Training & Seminar">Ruang Kelas Training &amp; Seminar</option>
                            <option value="Sound System & Equipment Audio">Sound System &amp; Equipment Audio</option>
                            <option value="Tenda & Kursi Acara Sekolah">Tenda &amp; Kursi Acara Sekolah</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Tanggal Penggunaan *</label>
                        <input type="date" name="tgl_sewa" required class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">Keperluan &amp; Deskripsi Barang/Fasilitas *</label>
                    <textarea name="keperluan" rows="3" required placeholder="Jelaskan nama acara, spesifikasi barang/fasilitas yang dibutuhkan, jumlah peserta, dan durasi penggunaan..." class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600"></textarea>
                </div>

                <!-- Upload File Identitas / KTP / Surat -->
                <div class="space-y-1.5 pt-2">
                    <label class="block text-xs font-black text-slate-900 dark:text-[#a8f52c] uppercase">📁 Upload KTP / NPWP / Surat Permohonan Sewa (Opsional)</label>
                    <input type="file" name="file_dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="w-full px-4 py-3 rounded-xl layanan-input text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    <p class="text-[10px] text-[var(--text-muted)] font-medium">Format yang diterima: PDF, DOCX, JPG, PNG (Maksimal 10MB).</p>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl btn-action-gradient font-black text-xs uppercase tracking-widest transition-all">
                    Kirim Permohonan Sewa Barang / Fasilitas ➔
                </button>
            </form>
        </div>

    </main>

    <footer class="bg-slate-900 dark:bg-[#061207] text-slate-400 text-xs py-8 text-center border-t border-slate-800 dark:border-[#1a3b1d]">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

    <!-- Robbani AI Chatbot Widget -->
    @include('components.chat-ai-widget')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('layananPage', () => ({
                activeTab: '{{ $activeTab ?? "kunjungan" }}',
                darkMode: false,
                init() {
                    const savedTheme = localStorage.getItem('layanan_theme_pref');
                    if (savedTheme === 'dark') {
                        this.darkMode = true;
                    } else {
                        this.darkMode = false;
                    }

                    const path = window.location.pathname;
                    if (path.includes('kerjasama')) {
                        this.activeTab = 'kerjasama';
                    } else if (path.includes('sewa')) {
                        this.activeTab = 'sewa';
                    } else {
                        this.activeTab = 'kunjungan'; // DEFAULT LAYANAN 1 (KUNJUNGAN)
                    }
                },
                switchTab(tabName) {
                    this.activeTab = tabName;
                    const newUrl = '/layanan/' + tabName;
                    history.pushState(null, '', newUrl);
                    window.scrollTo({ top: 180, behavior: 'smooth' });
                },
                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('layanan_theme_pref', this.darkMode ? 'dark' : 'light');
                }
            }));
        });
    </script>

</body>
</html>
