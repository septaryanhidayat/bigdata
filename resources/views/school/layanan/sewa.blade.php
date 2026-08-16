<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Sewa Fasilitas | {{ $settings['school_name'] }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #0b1206; color: #f7fee7; }
        .btn-lime-primary { background-color: #a8f52c !important; color: #070c04 !important; }
        .card-dark-surface { background-color: #14220c !important; border: 1px solid #264218 !important; }
    </style>
</head>
<body class="bg-[#0b1206] text-lime-50 antialiased min-h-screen pb-24 lg:pb-0">

    <header class="bg-[#070c04] py-4 px-6 sticky top-0 z-50 border-b border-[#1c3011]">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="/images/logo robbani dark.png" class="h-9 w-auto object-contain" alt="Logo SIT Robbani">
                <div>
                    <span class="font-black text-xs block text-[#a8f52c] uppercase">SEWA FASILITAS SEKOLAH</span>
                    <span class="text-[10px] text-slate-300 font-bold block">SIT ROBBANI OGAN ILIR</span>
                </div>
            </a>
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-300 hover:text-[#a8f52c]">← Beranda</a>
        </div>
    </header>

    <main class="py-12 max-w-3xl mx-auto px-4 space-y-8">
        
        <div class="text-center space-y-3">
            <span class="px-3.5 py-1 rounded-full bg-[#14220c] border border-[#264218] text-[#a8f52c] font-black text-xs uppercase">SARANA PRASARANA</span>
            <h1 class="text-3xl font-black text-white">Form Permohonan Sewa Fasilitas</h1>
            <p class="text-slate-400 text-sm font-medium">Permohonan sewa aula pertemuan, lapangan olahraga, laboratorium, atau area outdoor SIT Robbani.</p>
        </div>

        @if(session('success'))
        <div class="p-5 rounded-2xl bg-[#a8f52c] text-[#070c04] font-black text-sm space-y-1 shadow-xl">
            <p class="flex items-center gap-2 text-base"><span>🏢</span> {{ session('success') }}</p>
        </div>
        @endif

        <form action="{{ route('school.layanan.sewa.store') }}" method="POST" class="p-8 rounded-[2rem] card-dark-surface space-y-5">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#a8f52c] uppercase">Nama Penyewa / Organisasi *</label>
                    <input type="text" name="nama_penyewa" required placeholder="Nama lengkap / perwakilan" class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#a8f52c] uppercase">No. WhatsApp / HP *</label>
                    <input type="text" name="no_hp" required placeholder="081234567890" class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#a8f52c] uppercase">Fasilitas yang Ingin Disewa *</label>
                    <select name="fasilitas_disewa" required class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                        <option value="Aula Pertemuan Utama">Aula Pertemuan Utama</option>
                        <option value="Lapangan Olahraga Outdoor">Lapangan Olahraga Outdoor</option>
                        <option value="Laboratorium Komputer & IT">Laboratorium Komputer & IT</option>
                        <option value="Ruang Kelas Training">Ruang Kelas Training</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-black text-[#a8f52c] uppercase">Tanggal Penggunaan *</label>
                    <input type="date" name="tgl_sewa" required class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black text-[#a8f52c] uppercase">Keperluan & Deskripsi Acara *</label>
                <textarea name="keperluan" rows="4" required placeholder="Jelaskan nama acara, jumlah peserta, dan durasi penggunaan..." class="w-full px-4 py-3 rounded-xl bg-[#070c04] border border-[#264218] text-xs font-semibold text-white focus:outline-none focus:border-[#a8f52c]"></textarea>
            </div>

            <button type="submit" class="w-full py-4 rounded-xl btn-lime-primary font-black text-xs uppercase tracking-wider shadow-xl hover:scale-[1.01] transition-transform">
                Kirim Permohonan Sewa ➔
            </button>
        </form>

    </main>

    <footer class="bg-[#070c04] text-slate-400 text-xs py-8 text-center border-t border-[#1c3011]">
        <p>© {{ date('Y') }} {{ $settings['school_name'] }} (SIT Robbani Ogan Ilir, Sumatera Selatan).</p>
    </footer>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Swal.fire({
                icon: 'success',
                title: 'Permohonan Berhasil Dikirim!',
                text: @json(session('success')),
                timer: 4000,
                timerProgressBar: true,
                showConfirmButton: false,
                background: '#14220c',
                color: '#f7fee7',
                iconColor: '#a8f52c',
                customClass: {
                    popup: 'rounded-3xl border border-[#264218] shadow-2xl p-6 text-xs font-bold'
                }
            });
        });
    </script>
    @endif

</body>
</html>
