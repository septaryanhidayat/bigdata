<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Sewa Menyewa Barang & Fasilitas | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #0f172a; }
        .btn-brand-primary { background: linear-gradient(135deg, #059669 0%, #ea580c 100%) !important; color: #ffffff !important; }
        .btn-brand-primary:hover { opacity: 0.95; transform: scale(1.01); }
        .card-light-surface { background-color: #ffffff !important; border: 1px solid #e2e8f0 !important; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03); }
        .tab-active { background: #059669 !important; border-color: #047857 !important; color: #ffffff !important; box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25); }
        .tab-inactive { background: #ffffff !important; border-color: #cbd5e1 !important; color: #334155 !important; }
        .tab-inactive:hover { background-color: #ecfdf5 !important; color: #047857 !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen pb-24">

    <!-- Top Header Navigation -->
    <header class="bg-gradient-to-r from-[#004532] via-[#065f46] to-[#0f172a] py-4 px-6 sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="/images/logo robbani dark.png" class="h-9 w-auto object-contain" alt="Logo SIT Robbani">
                <div>
                    <span class="font-black text-xs block text-emerald-200 uppercase tracking-wider">LAYANAN PUBLIC HUMAS & FASILITAS</span>
                    <span class="text-[10px] text-orange-300 font-extrabold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/20 text-xs font-extrabold transition-all flex items-center gap-1.5 shadow-sm">
                    <span>🏠</span> <span>Beranda Utama</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="py-10 max-w-5xl mx-auto px-4 space-y-8">
        
        <!-- Page Title Header -->
        <div class="text-center space-y-3">
            <span class="px-4 py-1.5 rounded-full bg-orange-100 border border-orange-300 text-orange-700 font-black text-xs uppercase tracking-widest inline-flex items-center gap-2 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-orange-500 animate-ping"></span>
                <span>LAYANAN TERPADU SEKOLAH ISLAM TERPADU ROBBANI</span>
            </span>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">Permohonan Sewa Menyewa Barang Sekolah</h1>
            <p class="text-slate-600 text-xs sm:text-sm font-medium max-w-2xl mx-auto">
                Permohonan sewa aula pertemuan, lapangan olahraga, laboratorium, peralatan sound system, atau perlengkapan acara SIT Robbani.
            </p>
        </div>

        <!-- 3 Public Service Tabs Navigation -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 p-2 rounded-2xl bg-slate-200/70 border border-slate-300 shadow-inner">
            <a href="{{ route('school.layanan.kunjungan') }}" class="p-3.5 rounded-xl border text-center font-black text-xs flex items-center justify-center gap-2 transition-all tab-inactive">
                <span class="text-base">📌</span>
                <span>1. Izin Kunjungan Sekolah</span>
            </a>
            <a href="{{ route('school.layanan.kerjasama') }}" class="p-3.5 rounded-xl border text-center font-black text-xs flex items-center justify-center gap-2 transition-all tab-inactive">
                <span class="text-base">🤝</span>
                <span>2. Permohonan Kerja Sama</span>
            </a>
            <a href="{{ route('school.layanan.sewa') }}" class="p-3.5 rounded-xl border text-center font-black text-xs flex items-center justify-center gap-2 transition-all tab-active">
                <span class="text-base">🏢</span>
                <span>3. Sewa Barang & Fasilitas</span>
            </a>
        </div>

        <!-- Comprehensive Standard Service Information Card (Light Mode) -->
        <div class="card-light-surface p-6 sm:p-8 rounded-[2rem] space-y-6">
            
            <div class="flex items-center gap-3 border-b border-slate-200 pb-4">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 border border-emerald-300 flex items-center justify-center text-xl text-emerald-800 shadow-xs">
                    📜
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-900">Standar Operasional & Persyaratan Pelayanan</h2>
                    <p class="text-xs text-slate-500 font-semibold">Ketentuan resmi pengajuan permohonan sewa menyewa barang/fasilitas ke SIT Robbani</p>
                </div>
            </div>

            <!-- Grid 2 Column Info Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                
                <!-- Persyaratan Pelayanan (8 Poin) -->
                <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200 space-y-3">
                    <div class="flex items-center gap-2 font-black text-emerald-900 uppercase tracking-wider text-[11px]">
                        <span>📋</span> <span>Persyaratan Pelayanan:</span>
                    </div>
                    <ul class="space-y-2 text-slate-700 font-medium pl-1">
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-700 font-black">1.</span>
                            <span>Pemohon memiliki akun pada sistem untuk melakukan permohonan kunjungan / sewa fasilitas.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-700 font-black">2.</span>
                            <span>Pemohon melakukan pengajuan resmi melalui sistem online ini.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-700 font-black">3.</span>
                            <span>Bukti permohonan sewa barang sudah ditandatangani oleh pejabat berwenang &amp; stempel basah dibawa ketika hari penggunaan.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-700 font-black">4.</span>
                            <span>Maksimal pengunjung / pengguna fasilitas sebanyak <strong>100 orang</strong>.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-700 font-black">5.</span>
                            <span>Hari kunjungan &amp; penggunaan resmi adalah hari <strong>Senin dan Kamis</strong>.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-700 font-black">6.</span>
                            <span>Waktu kunjungan &amp; penggunaan adalah pukul <strong>09.00 - 11.00 WIB</strong>.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-700 font-black">7.</span>
                            <span>Pengunjung menggunakan pakaian yang <strong>sopan dan rapi</strong> (Menutup Aurat).</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-emerald-700 font-black">8.</span>
                            <span>Wajib menerapkan protokol kesehatan (protkes) secara ketat.</span>
                        </li>
                    </ul>
                </div>

                <!-- Detail Pelayanan & Pengaduan -->
                <div class="space-y-4">
                    
                    <!-- Meta Grid (Waktu, Biaya, Produk) -->
                    <div class="p-5 rounded-2xl bg-orange-50/60 border border-orange-200 space-y-3">
                        
                        <div>
                            <span class="text-[10px] font-black text-orange-800 uppercase block tracking-wider">⏱️ Jangka Waktu Penyelesaian</span>
                            <p class="text-xs font-bold text-slate-900 mt-0.5">Waktu respon atas permohonan paling lambat <strong>10 (sepuluh) hari kerja</strong>.</p>
                        </div>

                        <div class="border-t border-orange-200/80 pt-2.5">
                            <span class="text-[10px] font-black text-orange-800 uppercase block tracking-wider">💰 Biaya dan Tarif</span>
                            <p class="text-xs font-black text-emerald-700 mt-0.5">Proses permohonan dan pelaksanaan kunjungan <strong>TIDAK DIPUNGUT BIAYA (GRATIS)</strong>.</p>
                        </div>

                        <div class="border-t border-orange-200/80 pt-2.5">
                            <span class="text-[10px] font-black text-orange-800 uppercase block tracking-wider">📦 Produk Layanan</span>
                            <p class="text-xs font-bold text-slate-900 mt-0.5">Permohonan Sewa Menyewa Barang Sekolah</p>
                        </div>
                    </div>

                    <!-- Pengaduan, Saran & Masukan -->
                    <div class="p-5 rounded-2xl bg-slate-100 border border-slate-300 space-y-2">
                        <div class="flex items-center gap-2 font-black text-slate-900 uppercase tracking-wider text-[11px]">
                            <span>💬</span> <span>Pengaduan, Saran, dan Masukan:</span>
                        </div>
                        <p class="text-[11px] text-slate-600 font-medium">
                            Dapat disampaikan ke Bagian Humas dan Media Layanan Terpadu Sekolah Islam Terpadu Robbani:
                        </p>
                        <div class="space-y-1 text-slate-800 font-semibold pt-1 text-[11px]">
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
        <div class="p-5 rounded-2xl bg-emerald-600 text-white font-black text-sm space-y-1 shadow-lg flex items-center gap-3">
            <span class="text-2xl">🏢</span>
            <div>
                <p class="text-sm font-black">{{ session('success') }}</p>
                <p class="text-xs font-bold text-emerald-100">Tim Sarpras & Humas SIT Robbani akan memproses ketersediaan barang/fasilitas paling lambat 10 hari kerja.</p>
            </div>
        </div>
        @endif

        <!-- Form Section -->
        <form action="{{ route('school.layanan.sewa.store') }}" method="POST" class="card-light-surface p-6 sm:p-8 rounded-[2rem] space-y-5">
            @csrf
            
            <div class="border-b border-slate-200 pb-3 flex items-center justify-between">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>📝</span> <span>Isi Form Permohonan Sewa Menyewa Barang / Fasilitas</span>
                </h3>
                <span class="text-[10px] text-slate-400 font-bold">* Wajib diisi</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-emerald-800 uppercase">Nama Penyewa / Organisasi *</label>
                    <input type="text" name="nama_penyewa" required placeholder="Nama lengkap / perwakilan lembaga" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-emerald-800 uppercase">No. WhatsApp / HP *</label>
                    <input type="text" name="no_hp" required placeholder="081234567890" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-emerald-800 uppercase">Fasilitas / Barang yang Ingin Disewa *</label>
                    <select name="fasilitas_disewa" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white">
                        <option value="Aula Pertemuan Utama">Aula Pertemuan Utama SIT Robbani</option>
                        <option value="Lapangan Olahraga Outdoor">Lapangan Olahraga Outdoor</option>
                        <option value="Laboratorium Komputer & IT">Laboratorium Komputer & IT</option>
                        <option value="Ruang Kelas Training & Seminar">Ruang Kelas Training & Seminar</option>
                        <option value="Sound System & Equipment Audio">Sound System & Equipment Audio</option>
                        <option value="Tenda & Kursi Acara Sekolah">Tenda & Kursi Acara Sekolah</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-emerald-800 uppercase">Tanggal Penggunaan (Senin / Kamis) *</label>
                    <input type="date" name="tgl_sewa" required class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black text-emerald-800 uppercase">Keperluan & Deskripsi Barang/Fasilitas *</label>
                <textarea name="keperluan" rows="4" required placeholder="Jelaskan nama acara, spesifikasi barang/fasilitas yang dibutuhkan, jumlah peserta, dan durasi penggunaan..." class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white"></textarea>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl btn-brand-primary font-black text-xs uppercase tracking-widest shadow-xl transition-all">
                Kirim Permohonan Sewa Barang / Fasilitas ➔
            </button>
        </form>

    </main>

    <footer class="bg-slate-900 text-slate-400 text-xs py-8 text-center border-t border-slate-800">
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
                customClass: {
                    popup: 'rounded-3xl shadow-2xl p-6 text-xs'
                }
            });
        });
    </script>
    @endif

</body>
</html>
