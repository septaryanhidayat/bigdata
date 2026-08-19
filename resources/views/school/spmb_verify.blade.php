<!DOCTYPE html>
<html lang="id" class="scroll-smooth light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi & Akses Pendaftaran SPMB - {{ $registration->registration_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; color: #0f172a; }
    </style>

    <!-- Smooth Scroll Reveal Animation Styles -->
    <style>
        .scroll-reveal, .reveal-fade-up, .reveal-scale-up, .reveal-slide-left, .reveal-slide-right {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }
        .reveal-scale-up { transform: scale(0.93); }
        .reveal-slide-left { transform: translateX(-35px); }
        .reveal-slide-right { transform: translateX(35px); }

        .scroll-reveal.is-visible, .reveal-fade-up.is-visible, .reveal-scale-up.is-visible,
        .reveal-slide-left.is-visible, .reveal-slide-right.is-visible, .revealed {
            opacity: 1 !important;
            transform: translateY(0) scale(1) translateX(0) !important;
        }

        .delay-100 { transition-delay: 100ms; }
        .delay-200 { transition-delay: 200ms; }
        .delay-300 { transition-delay: 300ms; }
        .delay-400 { transition-delay: 400ms; }
        .delay-500 { transition-delay: 500ms; }
    </style>
</head>
<body class="antialiased min-h-screen pb-16 flex flex-col justify-between">

    @php
        $d = json_decode($registration->details_json, true) ?? [];
        $verifyUrl = route('school.spmb.verify', $registration->registration_number);
        $qrCodeApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' . urlencode($verifyUrl);
    @endphp

    <!-- Header Navigation Bar -->
    <header class="py-4 px-6 bg-white border-b border-slate-200 sticky top-0 z-50 shadow-xs">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                @php
                    $logoLight = $settings['logo_light'] ?? $settings['school_logo'] ?? null;
                @endphp
                @if($logoLight)
                <img src="{{ $logoLight }}" alt="Logo {{ $settings['school_name'] ?? 'SIT Robbani' }}" class="h-10 w-auto max-w-[180px] object-contain shrink-0">
                @else
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-emerald-600 via-teal-600 to-orange-500 flex items-center justify-center text-white font-black text-lg shadow-md shrink-0">
                    S
                </div>
                @endif
                <div>
                    <h2 class="font-black text-sm sm:text-base tracking-tight leading-none text-slate-900">VERIFIKASI REGISTRASI SPMB</h2>
                    <p class="text-[10px] text-slate-500 font-bold uppercase mt-0.5 tracking-wider">SIT ROBBANI OGAN ILIR</p>
                </div>
            </a>
            
            <a href="{{ route('school.ppdb') }}" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition-all">
                + Formulir Baru
            </a>
        </div>
    </header>

    <main class="py-8 sm:py-12 max-w-3xl mx-auto px-4 w-full space-y-6 flex-1">
        
        <!-- Verification Header Status Banner -->
        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-700 via-teal-600 to-emerald-900 text-white shadow-2xl space-y-4">
            <div class="flex items-center justify-between flex-wrap gap-2">
                <span class="px-3.5 py-1 rounded-full bg-white text-emerald-950 font-black text-xs uppercase shadow-xs">
                    ✓ DOKUMEN REGISTRASI TERVERIFIKASI
                </span>
                <span class="text-xs text-emerald-100 font-bold">Resmi Sistem SmartEdu</span>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pt-2">
                <div class="space-y-1 text-center sm:text-left">
                    <span class="text-xs text-emerald-200 font-bold uppercase tracking-wider block">Nomor Registrasi Resmi:</span>
                    <span class="font-mono text-2xl sm:text-3xl font-black text-amber-300 block tracking-tight">
                        {{ $registration->registration_number }}
                    </span>
                    <p class="text-xs text-emerald-100 font-medium pt-1">
                        Ananda: <strong class="text-white font-black">{{ $registration->full_name }}</strong>
                    </p>
                </div>

                <!-- Live Scannable QR Code -->
                <div class="p-3 rounded-2xl bg-white text-center shadow-lg shrink-0">
                    <img src="{{ $qrCodeApiUrl }}" alt="QR Code Pendaftaran" class="w-32 h-32 mx-auto rounded-xl">
                    <span class="text-[9px] font-bold text-slate-500 uppercase mt-1 block">Scan QR Verifikasi</span>
                </div>
            </div>

            <div class="pt-3 border-t border-emerald-500/40 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-emerald-200">Status Pendaftaran:</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-950 font-black text-[11px] uppercase">
                        {{ $registration->status }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-emerald-200">Biaya Form:</span>
                    <span class="font-mono font-black text-lime-300">
                        Rp {{ number_format($registration->registration_fee, 0, ',', '.') }} (LUNAS)
                    </span>
                </div>
            </div>
        </div>

        <!-- Detailed Summary Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-md space-y-6 text-xs">
            <h3 class="text-sm font-black text-slate-900 border-b pb-3 border-slate-200 flex items-center justify-between">
                <span>📋 Rincian Data Lengkap Pendaftaran Ananda</span>
                <span class="text-emerald-700 font-bold uppercase">UNIT {{ $registration->target_level }}</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <span class="font-black text-[10px] text-emerald-800 uppercase block">🎓 Data Calon Siswa (Ananda)</span>
                    <p class="font-bold text-slate-900">Nama Akta: <span class="font-black text-slate-900">{{ $registration->full_name }}</span></p>
                    <p class="text-slate-600">NIK Siswa / NISN: <span class="font-mono font-bold text-slate-800">{{ $d['nik_siswa'] ?? '-' }} / {{ $d['nisn'] ?? '-' }}</span></p>
                    <p class="text-slate-600">TTL / JK: <span class="font-bold text-slate-800">{{ $d['tempat_lahir'] ?? '-' }}, {{ isset($d['tanggal_lahir']) ? \Carbon\Carbon::parse($d['tanggal_lahir'])->translatedFormat('d F Y') : '-' }} ({{ $d['jenis_kelamin'] ?? '-' }})</span></p>
                    <p class="text-slate-600">Sekolah Asal: <span class="font-bold text-slate-800">{{ $registration->previous_school ?? '-' }}</span></p>
                </div>

                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <span class="font-black text-[10px] text-orange-800 uppercase block">👨‍👩‍👦 Data Orang Tua Kandung</span>
                    <p class="font-bold text-slate-900">Ayah Kandung: <span class="font-black text-slate-900">{{ $registration->parent_name }}</span></p>
                    <p class="text-slate-600">No. WhatsApp Ayah: <span class="font-mono font-bold text-slate-900">{{ $registration->phone_number }}</span></p>
                    <p class="text-slate-600">Ibu Kandung: <span class="font-bold text-slate-900">{{ $d['nama_ibu'] ?? '-' }}</span></p>
                    <p class="text-slate-600">Email Ortu: <span class="font-bold text-slate-900">{{ $d['email_ortu'] ?? '-' }}</span></p>
                </div>
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                <span class="font-black text-[10px] text-teal-800 uppercase block">🏡 Alamat Domisili Tempat Tinggal</span>
                <p class="font-bold text-slate-900">{{ $d['alamat'] ?? '-' }}</p>
                <p class="text-slate-600">Kelurahan: {{ $d['kelurahan'] ?? '-' }} | Kecamatan: {{ $d['kecamatan'] ?? 'Indralaya Utara' }} | Kab: {{ $d['kabupaten'] ?? 'Ogan Ilir' }}</p>
            </div>

            <!-- Action Buttons: Download PDF & WhatsApp Panitia -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-slate-200">
                <a href="{{ route('school.spmb.download-pdf', $registration->id) }}" target="_blank" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-slate-900 hover:bg-slate-800 text-amber-300 font-black text-xs shadow-lg transition-all flex items-center justify-center gap-2">
                    <span>🖨️</span> Cetak / Re-Download Bukti Registrasi PDF
                </a>

                <a href="https://api.whatsapp.com/send?phone=6285377193977&text=Halo%20Panitia%20SPMB%20SIT%20Robbani,%20saya%20sudah%20mengakses%20ulang%20pendaftaran%20No%20Reg:%20{{ $registration->registration_number }}" target="_blank" class="w-full sm:w-auto px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg transition-all flex items-center justify-center gap-2">
                    <span>💬</span> Hubungi Panitia via WhatsApp
                </a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-xs font-semibold text-slate-400 border-t border-slate-200">
        <p>© {{ date('Y') }} SIT Robbani Ogan Ilir (SmartEdu Digital System).</p>
    </footer>


    <!-- Universal Smooth Scroll Reveal IntersectionObserver -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -40px 0px',
                threshold: 0.05
            };

            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const selectors = '.scroll-reveal, .reveal-fade-up, .reveal-scale-up, .reveal-slide-left, .reveal-slide-right';
            document.querySelectorAll(selectors).forEach(el => revealObserver.observe(el));
        });
    </script>
</body>
</html>
