<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Resmi - {{ $letter->reference_number ?? 'Draf Surat' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Times+New+Roman&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-page { box-shadow: none !important; border: none !important; width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 1.5cm 2cm !important; }
        }
        .font-serif-formal { font-family: 'Times New Roman', Times, serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-6 sm:py-8 px-2 sm:px-4 font-serif-formal text-slate-900 text-sm leading-relaxed">

    <!-- Top Action Floating Bar (No Print) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex flex-col sm:flex-row items-center justify-between gap-3 bg-slate-900 text-white p-4 rounded-2xl shadow-xl font-sans">
        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.letters.outgoing') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold transition-colors">
                ← Kembali
            </a>
            <div>
                <h4 class="font-black text-xs text-amber-300">
                    {{ !$letter->school_id ? 'Dokumen Resmi Yayasan (Ketua Yayasan)' : 'Dokumen Resmi Unit (Kepala Unit)' }}
                </h4>
                <p class="text-[10px] text-slate-400">Siap dicetak atau disimpan ke format PDF</p>
            </div>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
            <button onclick="window.print()" class="w-full sm:w-auto px-5 py-2 rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 hover:opacity-90 text-white font-black text-xs shadow-md transition-transform active:scale-95 flex items-center justify-center gap-2">
                <span>🖨️</span> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Official Paper Sheet Container (A4 Proportions) -->
    <div class="print-page max-w-4xl mx-auto bg-white p-8 sm:p-14 rounded-3xl border border-slate-200 shadow-xl space-y-6 min-h-[1050px] flex flex-col justify-between">
        
        <div class="space-y-6">
            
            <!-- 1. KOP SURAT RESMI (1 LOGO DI TENGAH ATAU BANNER KOP RESMI) -->
            @if($letter->school && $letter->school->kop_image_url)
                <!-- Custom Uploaded Banner KOP Surat Unit -->
                <div class="w-full text-center pb-2 border-b-4 border-double border-slate-900">
                    <img src="{{ asset($letter->school->kop_image_url) }}" alt="KOP Surat {{ $letter->school->name }}" class="w-full max-h-36 object-contain mx-auto">
                </div>
            @else
                <!-- Single Centered Logo + Typography KOP Surat -->
                <div class="text-center font-sans space-y-2 pb-4 border-b-4 border-double border-slate-900">
                    <!-- 1 Logo di Tengah Saja -->
                    <div class="flex justify-center mb-1">
                        @if($letter->school && $letter->school->logo_url)
                            <img src="{{ asset($letter->school->logo_url) }}" alt="Logo {{ $letter->school->name }}" class="w-20 h-20 object-contain mx-auto">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-emerald-700 text-white font-black text-2xl flex items-center justify-center shadow-sm mx-auto">
                                SIT
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3 class="text-xs sm:text-sm font-extrabold tracking-widest uppercase text-slate-700">
                            YAYASAN GENERASI ROBBANI SUMATERA SELATAN
                        </h3>
                        @if($letter->school)
                            <h2 class="text-lg sm:text-2xl font-black uppercase text-slate-950 tracking-tight mt-0.5">
                                {{ $letter->school->name }}
                            </h2>
                            <p class="text-[11px] sm:text-xs text-slate-600 font-medium mt-1 leading-snug">
                                {{ $letter->school->address ?? 'Jl. Lintas Timur Km 35, Indralaya, Kab. Ogan Ilir, Sumatera Selatan' }}
                            </p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-0.5">
                                Telp: {{ $letter->school->phone ?? '0811-7474-72' }} | Email: {{ $letter->school->email ?? 'sekretariat@sitrobbani.sch.id' }}
                            </p>
                        @else
                            <h2 class="text-lg sm:text-2xl font-black uppercase text-slate-950 tracking-tight mt-0.5">
                                PENGURUS PUSAT YAYASAN
                            </h2>
                            <p class="text-[11px] sm:text-xs text-slate-600 font-medium mt-1 leading-snug">
                                Jl. Lintas Timur Km 35, Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan
                            </p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-0.5">
                                Telp: 0811-7474-72 | Email: yayasan@sitrobbani.sch.id | Web: https://sitrobbani.sch.id
                            </p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- 2. METADATA SURAT (Nomor, Sifat, Lampiran, Perihal, & Tanggal) -->
            <div class="flex flex-col sm:flex-row justify-between items-start gap-4 pt-1">
                <table class="text-xs space-y-1">
                    <tr>
                        <td class="pr-3 font-bold text-slate-600 w-24">Nomor</td>
                        <td class="font-bold text-slate-900">: {{ $letter->reference_number ?? 'DRAFT/ROBBANI/2026' }}</td>
                    </tr>
                    <tr>
                        <td class="pr-3 font-bold text-slate-600">Sifat</td>
                        <td class="font-bold text-slate-900">: {{ $letter->security_level }}</td>
                    </tr>
                    <tr>
                        <td class="pr-3 font-bold text-slate-600">Lampiran</td>
                        <td class="font-bold text-slate-900">: - (Satu Berkas)</td>
                    </tr>
                    <tr>
                        <td class="pr-3 font-bold text-slate-600">Perihal</td>
                        <td class="font-bold text-slate-900">: <u>{{ $letter->title }}</u></td>
                    </tr>
                </table>

                <div class="text-left sm:text-right text-xs">
                    <p class="font-bold text-slate-800">Indralaya, {{ $letter->letter_date->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <!-- 3. TUJUAN SURAT -->
            <div class="text-xs pt-2 space-y-1">
                <p class="font-bold text-slate-800">Kepada Yth.</p>
                <p class="font-bold text-slate-950 text-sm">{{ $letter->recipient }}</p>
                <p class="text-slate-600">Di Tempat</p>
            </div>

            <!-- 4. ISI / KANDUNGAN SURAT -->
            <div class="text-justify pt-3 space-y-4 text-[13px] sm:text-[14px] leading-relaxed text-slate-900 whitespace-pre-line">
                {{ $letter->content }}
            </div>
        </div>

        <!-- 5. AREA TTE (TANDA TANGAN ELEKTRONIK INTERNAL) & QR CODE -->
        <div class="pt-8 flex justify-end items-end">
            <div class="w-72 sm:w-80 text-center font-sans space-y-1.5">
                
                @if(!$letter->school_id || !$letter->school)
                    <!-- SURAT TERBITAN YAYASAN: ATAS NAMA KETUA YAYASAN -->
                    <p class="text-xs font-bold text-slate-700">
                        Yayasan Generasi Robbani Sumatera Selatan,
                    </p>
                    <p class="text-xs font-extrabold uppercase text-slate-900 tracking-wide">
                        KETUA YAYASAN,
                    </p>
                @else
                    <!-- SURAT TERBITAN UNIT SEKOLAH: ATAS NAMA KEPALA UNIT -->
                    <p class="text-xs font-bold text-slate-700">
                        {{ $letter->school->name }},
                    </p>
                    <p class="text-xs font-extrabold uppercase text-slate-900 tracking-wide">
                        KEPALA SEKOLAH,
                    </p>
                @endif

                <!-- Visual TTE Box Internal -->
                @if($letter->digitalSignature)
                    @php
                        $verifyUrl = url('/verifikasi-surat/' . $letter->digitalSignature->verify_token);
                    @endphp
                    <div class="p-3 my-2 rounded-2xl bg-slate-50 border-2 border-emerald-600 text-left flex items-center gap-3 shadow-xs">
                        <div class="p-1 bg-white rounded-xl border border-slate-200 shrink-0">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($verifyUrl) }}" alt="QR TTE Internal" class="w-14 h-14">
                        </div>
                        <div class="overflow-hidden space-y-0.5">
                            <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-900 font-black text-[8px] uppercase block w-fit">
                                ✓ TTE DIGITAL SAH
                            </span>
                            <h5 class="font-black text-[10px] text-slate-900 truncate leading-tight">{{ $letter->digitalSignature->signer->full_name }}</h5>
                            <p class="text-[8px] text-slate-500 font-mono truncate">
                                {{ $letter->digitalSignature->signer->school_id ? 'NIP' : 'NIY' }}: {{ $letter->digitalSignature->signer->nip }}
                            </p>
                            <p class="text-[7px] text-slate-400 font-mono truncate">ID: {{ $letter->digitalSignature->certificate_serial }}</p>
                        </div>
                    </div>
                @else
                    <div class="h-20 flex items-center justify-center text-slate-400 italic text-xs border border-dashed border-slate-300 rounded-2xl my-2">
                        (Draf Surat - Menunggu Pengesahan TTE)
                    </div>
                @endif

                <div class="pt-1">
                    @if(!$letter->school_id || !$letter->school)
                        <p class="font-extrabold text-xs text-slate-950 underline">
                            {{ $letter->digitalSignature?->signer?->full_name ?? 'Ustadz H. Mukhtarom, Lc., M.H.I' }}
                        </p>
                        <p class="text-[10px] text-slate-500 font-mono">
                            {{ $letter->digitalSignature?->signer?->nip ? 'NIY. ' . $letter->digitalSignature?->signer?->nip : 'NIY. 197808122010011001' }}
                        </p>
                    @else
                        <p class="font-extrabold text-xs text-slate-950 underline">
                            {{ $letter->digitalSignature?->signer?->full_name ?? ($letter->school->principal_name ?? 'Ustadz Kepala Unit, M.Pd') }}
                        </p>
                        <p class="text-[10px] text-slate-500 font-mono">
                            {{ $letter->digitalSignature?->signer?->nip ? 'NIP. ' . $letter->digitalSignature?->signer?->nip : 'NIP. 198505122026011001' }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- 6. FOOTER DISCLAIMER TTE INTERNAL -->
        @if($letter->digitalSignature)
        <div class="pt-3 border-t border-slate-200 text-[9px] text-slate-400 font-sans flex flex-col sm:flex-row items-center justify-between gap-1">
            <div class="flex items-center gap-1.5">
                <span>🔒</span>
                <span>Dokumen ini disahkan secara elektronik melalui Sistem TTE Digital Internal SIT Robbani.</span>
            </div>
            <span class="font-mono text-[8px]">QR Verify ID: {{ Str::limit($letter->digitalSignature->verify_token, 12) }}</span>
        </div>
        @endif

    </div>

</body>
</html>
