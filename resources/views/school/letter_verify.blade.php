<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi TTE Digital Internal - SmartEdu</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-950 text-white min-h-screen py-8 sm:py-12 px-4 flex flex-col justify-between">

    <div class="max-w-2xl mx-auto w-full space-y-6">
        
        <!-- Brand Header -->
        <div class="text-center space-y-2">
            @if($signature->letter->school && $signature->letter->school->logo_url)
                <div class="flex items-center justify-center">
                    <img src="{{ asset($signature->letter->school->logo_url) }}" alt="Logo {{ $signature->letter->school->name }}" class="h-14 w-auto object-contain">
                </div>
            @else
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-gradient-to-tr from-emerald-500 via-teal-500 to-cyan-600 text-white font-black text-2xl shadow-xl border border-white/20">
                    S
                </div>
            @endif
            <h1 class="text-lg sm:text-xl font-black tracking-tight text-white uppercase">Sistem Verifikasi TTE Digital Internal</h1>
            <p class="text-xs text-slate-400 font-medium">Layanan Verifikasi Keabsahan Dokumen Resmi {{ $signature->letter->school->name ?? 'Sekolah Islam Terpadu Robbani' }}</p>
        </div>

        <!-- Verification Success Card -->
        <div class="bg-slate-900/95 border-2 border-emerald-500 rounded-3xl p-5 sm:p-8 shadow-2xl space-y-6 backdrop-blur-md relative overflow-hidden">
            
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Status Banner -->
            <div class="flex items-center gap-3.5 bg-emerald-950/70 border border-emerald-500/40 p-4 rounded-2xl">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-slate-950 flex items-center justify-center font-black text-2xl shrink-0 shadow-lg">
                    ✓
                </div>
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-400/20 text-emerald-300 font-black text-[9px] uppercase border border-emerald-400/30">
                        Status: Terverifikasi Sah Internal
                    </span>
                    <h3 class="text-sm sm:text-base font-black text-white mt-0.5">TANDA TANGAN ELEKTRONIK ASLI & RESMI</h3>
                    <p class="text-[11px] text-emerald-200/80">Dokumen terdaftar sah dalam pangkalan data E-Office SIT Robbani.</p>
                </div>
            </div>

            <!-- Details Information Grid -->
            <div class="space-y-4 text-xs">
                <h4 class="font-extrabold text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-800 pb-2">Informasi Surat & Dokumen</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/50">
                        <span class="text-[10px] text-slate-400 font-bold block">Nomor Surat Resmi:</span>
                        <span class="font-mono font-black text-emerald-400 text-xs sm:text-sm block mt-0.5">{{ $signature->letter->reference_number }}</span>
                    </div>

                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/50">
                        <span class="text-[10px] text-slate-400 font-bold block">Tanggal Surat:</span>
                        <span class="font-bold text-white block mt-0.5">{{ $signature->letter->letter_date->translatedFormat('d F Y') }}</span>
                    </div>
                </div>

                <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/50 space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold block">Perihal / Judul Surat:</span>
                    <h4 class="font-black text-white text-xs sm:text-sm leading-snug">{{ $signature->letter->title }}</h4>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/50">
                        <span class="text-[10px] text-slate-400 font-bold block">Instansi Penerbit:</span>
                        <span class="font-bold text-white block mt-0.5">{{ $signature->letter->school->name ?? 'Yayasan Generasi Robbani' }}</span>
                    </div>

                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/50">
                        <span class="text-[10px] text-slate-400 font-bold block">Tujuan Surat:</span>
                        <span class="font-bold text-white block mt-0.5">{{ $signature->letter->recipient }}</span>
                    </div>
                </div>

                <h4 class="font-extrabold text-slate-400 uppercase tracking-wider text-[10px] border-b border-slate-800 pb-2 pt-2">Informasi Penandatangan & TTE Internal</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/50">
                        <span class="text-[10px] text-slate-400 font-bold block">Nama Penandatangan:</span>
                        <span class="font-black text-white text-sm block mt-0.5">{{ $signature->signer->full_name }}</span>
                        <span class="text-[10px] font-mono text-slate-400">NIP: {{ $signature->signer->nip }}</span>
                    </div>

                    <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/50">
                        <span class="text-[10px] text-slate-400 font-bold block">Waktu Penandatanganan (Timestamp):</span>
                        <span class="font-mono font-bold text-white block mt-0.5">{{ $signature->signed_at->format('d/m/Y H:i:s') }} WIB</span>
                        <span class="text-[10px] text-emerald-400 font-bold">✓ Waktu Sah Server</span>
                    </div>
                </div>

                <div class="bg-slate-800/60 p-3.5 rounded-2xl border border-slate-700/50 space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold block">Sistem Penerbit TTE:</span>
                    <span class="font-bold text-cyan-300 block text-xs">{{ $signature->certificate_issuer }}</span>
                    <span class="font-mono text-[10px] text-slate-400 block">Nomor Seri TTE: {{ $signature->certificate_serial }}</span>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-4 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-3">
                <a href="{{ route('home') }}" class="text-xs font-bold text-slate-400 hover:text-white transition-colors">
                    ← Kembali ke Website Utama
                </a>

                <a href="{{ route('admin.letters.preview-pdf', $signature->letter_id) }}" target="_blank" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black text-xs shadow-lg transition-transform active:scale-95 flex items-center justify-center gap-1.5">
                    <span>📄</span> Buka & Unduh Dokumen PDF
                </a>
            </div>

        </div>

    </div>

    <footer class="text-center text-[10px] text-slate-500 font-medium py-4">
        © 2026 Yayasan Generasi Robbani Sumatera Selatan • Sistem Informasi Persuratan & TTE Internal
    </footer>

</body>
</html>
