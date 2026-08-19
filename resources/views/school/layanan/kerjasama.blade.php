<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Kerja Sama Lembaga | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #040905; color: #f1f5f9; }
        .btn-lime-primary { background: linear-gradient(135deg, #a8f52c 0%, #10b981 100%) !important; color: #040905 !important; }
        .card-dark-surface { background: rgba(11, 23, 13, 0.95) !important; border: 1px solid #1f4224 !important; backdrop-filter: blur(16px); }
        .tab-active { background: #16361a !important; border-color: #a8f52c !important; color: #a8f52c !important; }
        .tab-inactive { background: #0b170d !important; border-color: #19331d !important; color: #94a3b8 !important; }
    </style>
</head>
<body class="bg-[#040905] text-slate-100 antialiased min-h-screen pb-24">

    <!-- Top Sticky Header -->
    <header class="bg-[#0b170d]/90 backdrop-blur-md py-4 px-6 sticky top-0 z-50 border-b border-[#1f4224]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="/images/logo robbani dark.png" class="h-9 w-auto object-contain" alt="Logo SIT Robbani">
                <div>
                    <span class="font-black text-xs block text-[#a8f52c] uppercase tracking-wider">LAYANAN PUBLIC HUMAS & FASILITAS</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl bg-[#142c17] hover:bg-[#1e4222] text-[#a8f52c] border border-[#234928] text-xs font-extrabold transition-all flex items-center gap-1.5">
                    <span>🏠</span> <span>Beranda Utama</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="py-10 max-w-5xl mx-auto px-4 space-y-8">
        
        <!-- Page Title Header -->
        <div class="text-center space-y-3">
            <span class="px-4 py-1.5 rounded-full bg-[#10240d] border border-[#234928] text-[#a8f52c] font-black text-xs uppercase tracking-widest inline-flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#a8f52c] animate-ping"></span>
                <span>LAYANAN TERPADU SEKOLAH ISLAM TERPADU ROBBANI</span>
            </span>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">Permohonan Kerja Sama &amp; Kemitraan</h1>
            <p class="text-slate-400 text-xs sm:text-sm font-medium max-w-2xl mx-auto">
                Pengajuan kemitraan program pendidikan, sponsorship kegiatan, media partner, serta sinergi dakwah bersama SIT Robbani.
            </p>
        </div>

        <!-- 3 Public Service Tabs Navigation -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-1.5 rounded-2xl bg-[#08120a] border border-[#1a381d]">
            <a href="{{ route('school.layanan.kunjungan') }}" class="p-3.5 rounded-xl border text-center font-black text-xs flex items-center justify-center gap-2 transition-all hover:border-[#a8f52c]/50 tab-inactive">
                <span class="text-base">📌</span>
                <span>1. Izin Kunjungan Sekolah</span>
            </a>
            <a href="{{ route('school.layanan.kerjasama') }}" class="p-3.5 rounded-xl border text-center font-black text-xs flex items-center justify-center gap-2 transition-all shadow-md tab-active">
                <span class="text-base">🤝</span>
                <span>2. Permohonan Kerja Sama</span>
            </a>
            <a href="{{ route('school.layanan.sewa') }}" class="p-3.5 rounded-xl border text-center font-black text-xs flex items-center justify-center gap-2 transition-all hover:border-[#a8f52c]/50 tab-inactive">
                <span class="text-base">🏢</span>
                <span>3. Sewa Barang & Fasilitas</span>
            </a>
        </div>

        <!-- Comprehensive Standard Service Information Card -->
        <div class="card-dark-surface p-6 sm:p-8 rounded-[2rem] space-y-6 shadow-2xl">
            
            <div class="flex items-center gap-3 border-b border-[#1f4224] pb-4">
                <div class="w-10 h-10 rounded-2xl bg-[#a8f52c]/10 border border-[#a8f52c]/30 flex items-center justify-center text-xl text-[#a8f52c]">
                    📜
                </div>
                <div>
                    <h2 class="text-lg font-black text-white">Standar Operasional & Persyaratan Pelayanan</h2>
                    <p class="text-xs text-slate-400 font-semibold">Ketentuan resmi pengajuan permohonan kerja sama ke SIT Robbani</p>
                </div>
            </div>

            <!-- Grid 2 Column Info Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                
                <!-- Persyaratan Pelayanan (8 Poin) -->
                <div class="p-5 rounded-2xl bg-[#071208] border border-[#1a381d] space-y-3">
                    <div class="flex items-center gap-2 font-black text-[#a8f52c] uppercase tracking-wider text-[11px]">
                        <span>📋</span> <span>Persyaratan Pelayanan:</span>
                    </div>
                    <ul class="space-y-2 text-slate-300 font-medium pl-1">
                        <li class="flex items-start gap-2">
                            <span class="text-[#a8f52c] font-black">1.</span>
                            <span>Pemohon memiliki akun pada sistem untuk melakukan permohonan kunjungan / kerja sama.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#a8f52c] font-black">2.</span>
                            <span>Pemohon melakukan pengajuan resmi melalui sistem online ini.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#a8f52c] font-black">3.</span>
                            <span>Bukti permohonan kerja sama sudah ditandatangani oleh pejabat berwenang &amp; stempel basah dibawa ketika hari kunjungan.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#a8f52c] font-black">4.</span>
                            <span>Maksimal jumlah pengunjung sebanyak <strong>100 orang</strong>.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#a8f52c] font-black">5.</span>
                            <span>Hari kunjungan resmi adalah hari <strong>Senin dan Kamis</strong>.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#a8f52c] font-black">6.</span>
                            <span>Waktu kunjungan adalah pukul <strong>09.00 - 11.00 WIB</strong>.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#a8f52c] font-black">7.</span>
                            <span>Pengunjung menggunakan pakaian yang <strong>sopan dan rapi</strong> (Menutup Aurat).</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-[#a8f52c] font-black">8.</span>
                            <span>Wajib menerapkan protokol kesehatan (protkes) secara ketat.</span>
                        </li>
                    </ul>
                </div>

                <!-- Detail Pelayanan & Pengaduan -->
                <div class="space-y-4">
                    
                    <!-- Meta Grid (Waktu, Biaya, Produk) -->
                    <div class="p-5 rounded-2xl bg-[#071208] border border-[#1a381d] space-y-3">
                        
                        <div>
                            <span class="text-[10px] font-black text-slate-400 uppercase block tracking-wider">⏱️ Jangka Waktu Penyelesaian</span>
                            <p class="text-xs font-bold text-white mt-0.5">Waktu respon atas permohonan paling lambat <strong>10 (sepuluh) hari kerja</strong>.</p>
                        </div>

                        <div class="border-t border-[#19331d] pt-2.5">
                            <span class="text-[10px] font-black text-slate-400 uppercase block tracking-wider">💰 Biaya dan Tarif</span>
                            <p class="text-xs font-bold text-[#a8f52c] mt-0.5">Proses permohonan dan pelaksanaan kunjungan <strong>TIDAK DIPUNGUT BIAYA (GRATIS)</strong>.</p>
                        </div>

                        <div class="border-t border-[#19331d] pt-2.5">
                            <span class="text-[10px] font-black text-slate-400 uppercase block tracking-wider">📦 Produk Layanan</span>
                            <p class="text-xs font-bold text-white mt-0.5">Permohonan Kerja Sama</p>
                        </div>
                    </div>

                    <!-- Pengaduan, Saran & Masukan -->
                    <div class="p-5 rounded-2xl bg-[#071208] border border-[#1a381d] space-y-2">
                        <div class="flex items-center gap-2 font-black text-emerald-400 uppercase tracking-wider text-[11px]">
                            <span>💬</span> <span>Pengaduan, Saran, dan Masukan:</span>
                        </div>
                        <p class="text-[11px] text-slate-300 font-medium">
                            Dapat disampaikan ke Bagian Humas dan Media Layanan Terpadu Sekolah Islam Terpadu Robbani:
                        </p>
                        <div class="space-y-1 text-slate-200 font-semibold pt-1 text-[11px]">
                            <p class="flex items-center gap-2"><span>📍</span> <span><strong>Alamat:</strong> Gedung KPA SIT Robbani</span></p>
                            <p class="flex items-center gap-2"><span>📱</span> <span><strong>No. HP (WA):</strong> 0811747472 (Humas SIT Robbani)</span></p>
                            <p class="flex items-center gap-2"><span>🌐</span> <span><strong>Website:</strong> sitrobbani.sch.id</span></p>
                            <p class="flex items-center gap-2"><span>✉️</span> <span><strong>Email:</strong> humas@sitrobbani.sch.id</span></p>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        @if(session('success'))
        <div class="p-5 rounded-2xl bg-[#a8f52c] text-[#040905] font-black text-sm space-y-1 shadow-2xl flex items-center gap-3">
            <span class="text-2xl">🤝</span>
            <div>
                <p class="text-sm font-black">{{ session('success') }}</p>
                <p class="text-xs font-bold text-emerald-950">Tim Kemitraan SIT Robbani akan meninjau pengajuan Anda paling lambat 10 hari kerja.</p>
            </div>
        </div>
        @endif

        <!-- Form Section -->
        <form action="{{ route('school.layanan.kerjasama.store') }}" method="POST" class="card-dark-surface p-6 sm:p-8 rounded-[2rem] space-y-5 shadow-2xl">
            @csrf
            
            <div class="border-b border-[#1f4224] pb-3 flex items-center justify-between">
                <h3 class="text-base font-black text-white flex items-center gap-2">
                    <span>📝</span> <span>Isi Form Pengajuan Kerja Sama</span>
                </h3>
                <span class="text-[10px] text-slate-400 font-bold">* Wajib diisi</span>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black text-[#a8f52c] uppercase">Nama Perusahaan / Lembaga / Mitra *</label>
                <input type="text" name="nama_lembaga" required placeholder="PT / Yayasan / Komunitas / Universitas" class="w-full px-4 py-3 rounded-xl bg-[#071208] border border-[#234928] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#a8f52c] uppercase">Nama Penanggung Jawab *</label>
                    <input type="text" name="nama_kontak" required placeholder="Nama lengkap penanggung jawab" class="w-full px-4 py-3 rounded-xl bg-[#071208] border border-[#234928] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#a8f52c] uppercase">No. WhatsApp / Telepon *</label>
                    <input type="text" name="no_hp" required placeholder="081234567890" class="w-full px-4 py-3 rounded-xl bg-[#071208] border border-[#234928] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#a8f52c] uppercase">Email Resmi *</label>
                    <input type="email" name="email" required placeholder="mitra@perusahaan.com" class="w-full px-4 py-3 rounded-xl bg-[#071208] border border-[#234928] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#a8f52c] uppercase">Kategori Kerja Sama *</label>
                    <select name="jenis_kerjasama" required class="w-full px-4 py-3 rounded-xl bg-[#071208] border border-[#234928] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                        <option value="Pendidikan & Akademik">Pendidikan & Akademik</option>
                        <option value="Sponsorship & Event">Sponsorship & Event Sekolah</option>
                        <option value="Media & Publikasi">Media & Publikasi</option>
                        <option value="Sosial & Kemanusiaan">Sosial & Kemanusiaan</option>
                    </select>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black text-[#a8f52c] uppercase">Ringkasan Proposal / Bentuk Kerjasama *</label>
                <textarea name="deskripsi" rows="4" required placeholder="Jelaskan penawaran kerjasama, bentuk sinergi, dan manfaat bersama..." class="w-full px-4 py-3 rounded-xl bg-[#071208] border border-[#234928] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]"></textarea>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl btn-lime-primary font-black text-xs uppercase tracking-widest shadow-xl hover:scale-[1.01] transition-transform">
                Kirim Pengajuan Kerja Sama ➔
            </button>
        </form>

    </main>

    <footer class="bg-[#0b170d] text-slate-400 text-xs py-8 text-center border-t border-[#1f4224]">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'success',
                title: 'Permohonan Berhasil Dikirim!',
                text: @json(session('success')),
                timer: 4500,
                timerProgressBar: true,
                showConfirmButton: false,
                background: '#0b170d',
                color: '#ffffff',
                iconColor: '#a8f52c',
                customClass: {
                    popup: 'rounded-3xl border border-[#234928] shadow-2xl p-6 text-xs'
                }
            });
        });
    </script>
    @endif

</body>
</html>
