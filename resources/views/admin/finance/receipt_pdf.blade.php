<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran SPP - {{ $payment->receipt_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc; 
            color: #0f172a; 
        }
        
        .receipt-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .gradient-line {
            background: linear-gradient(90deg, #059669 0%, #10b981 50%, #f97316 100%);
        }

        @media print {
            .no-print { display: none !important; }
            body { 
                padding: 0 !important; 
                margin: 0 !important; 
                background: #ffffff !important; 
            }
            .receipt-container {
                box-shadow: none !important;
                border: none !important;
                max-width: 100% !important;
                width: 100% !important;
                padding: 0 !important;
            }
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
        }
    </style>
</head>
<body class="p-4 sm:p-8 antialiased">

    <!-- Top Action Bar (Hidden on print) -->
    <div class="no-print max-w-3xl mx-auto mb-6 p-4 rounded-2xl bg-slate-900 text-white flex items-center justify-between shadow-xl">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500 text-slate-950 font-black text-lg flex items-center justify-center shadow-md">
                🧾
            </div>
            <div>
                <h4 class="font-black text-sm text-white">Kwitansi Resmi Pembayaran SPP</h4>
                <p class="text-xs text-slate-300 font-medium">No. Kwitansi: <span class="font-mono text-amber-300 font-bold">{{ $payment->receipt_number }}</span></p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs shadow-lg transition-all flex items-center gap-1.5">
                <span>🖨️</span> Cetak Kwitansi
            </button>
        </div>
    </div>

    <!-- Main Printable Receipt Container -->
    <div class="receipt-container max-w-3xl mx-auto receipt-card rounded-3xl p-8 sm:p-10 space-y-6 relative overflow-hidden">
        
        <!-- Header Kop Yayasan / Sekolah -->
        <div class="flex items-center justify-between border-b pb-6 border-slate-200">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-emerald-700 text-white font-black text-2xl flex items-center justify-center shadow-md">
                    R
                </div>
                <div>
                    <h1 class="text-base sm:text-lg font-black tracking-tight text-slate-900 uppercase">YAYASAN PENDIDIKAN ISLAM TERPADU ROBBANI</h1>
                    <h2 class="text-xs sm:text-sm font-bold text-emerald-700 uppercase tracking-wide">{{ $payment->sppBill->student->school->name ?? 'SEKOLAH ISLAM TERPADU ROBBANI' }}</h2>
                    <p class="text-[10px] text-slate-500 font-medium mt-0.5">Alamat: Indralaya, Kab. Ogan Ilir, Sumatera Selatan • Telp: (0711) 580012</p>
                </div>
            </div>
            
            <div class="text-right space-y-1">
                <span class="px-3 py-1 rounded-full bg-emerald-100 border border-emerald-200 text-emerald-800 font-mono font-black text-[10px] uppercase">
                    LUNAS / PAID
                </span>
                <p class="text-[9px] font-mono text-slate-400 block">{{ $payment->created_at ? $payment->created_at->format('d/m/Y H:i') : date('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="h-1 w-full rounded-full gradient-line"></div>

        <!-- Receipt Title & Info -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 py-1">
            <div>
                <h3 class="text-sm font-black text-slate-900 uppercase tracking-wide">TANDA BUKTI PEMBAYARAN SPP (KWITANSI)</h3>
                <p class="text-xs text-slate-500 font-medium">Telah diterima pembayaran SPP bulanan siswa dengan rincian berikut:</p>
            </div>
            <div class="px-4 py-2 rounded-xl bg-slate-900 text-white font-mono text-xs font-bold">
                No: <span class="text-amber-300">{{ $payment->receipt_number }}</span>
            </div>
        </div>

        <!-- Table Student Details -->
        <div class="rounded-2xl border border-slate-200 overflow-hidden bg-slate-50/50 p-4 text-xs space-y-2">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Nama Siswa</span>
                    <span class="font-black text-slate-900 text-sm block">{{ $payment->sppBill->student->full_name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">NIS / NISN</span>
                    <span class="font-mono font-bold text-slate-800 block">{{ $payment->sppBill->student->nis ?? '-' }} / {{ $payment->sppBill->student->nisn ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Rombel / Kelas</span>
                    <span class="font-bold text-slate-900 block">{{ $payment->sppBill->student->classroom->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase block">Unit Sekolah</span>
                    <span class="font-bold text-emerald-800 block">{{ $payment->sppBill->student->school->name ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Breakdown -->
        <div class="rounded-2xl border border-slate-200 overflow-hidden">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-3">Keterangan Pembayaran</th>
                        <th class="p-3">Periode Bulan</th>
                        <th class="p-3 text-right">Jumlah Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    <tr>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">Iuran SPP Syahriyah Bulanan</span>
                            <span class="text-[10px] text-slate-500">Metode Bayar: {{ $payment->payment_method ?? 'CASH (Kasir)' }}</span>
                        </td>
                        <td class="p-4 font-bold text-slate-800">
                            {{ $payment->sppBill->month_period ?? 'Bulan Berjalan' }}
                        </td>
                        <td class="p-4 font-mono font-black text-right text-emerald-700 text-sm">
                            Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
                <tfoot class="bg-slate-50 font-bold border-t border-slate-200">
                    <tr>
                        <td colspan="2" class="p-3.5 text-right font-black uppercase text-slate-700">Total Diterima:</td>
                        <td class="p-3.5 font-mono font-black text-right text-base text-emerald-700">
                            Rp {{ number_format($payment->amount_paid, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Signatures & Stamp -->
        <div class="pt-4 grid grid-cols-2 gap-8 text-xs font-semibold text-center items-end">
            <div>
                <p class="text-slate-600">Penyetor / Orang Tua Siswa,</p>
                <div class="h-16"></div>
                <p class="font-bold underline text-slate-900">{{ $payment->sppBill->student->guardian->full_name ?? 'Orang Tua / Wali' }}</p>
            </div>
            <div>
                <p class="text-slate-600">Indralaya, {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->translatedFormat('d F Y') : date('d F Y') }}</p>
                <p class="text-slate-600">Kasir / Bendahara Sekolah,</p>
                <div class="h-16"></div>
                <p class="font-bold underline text-slate-900">{{ auth()->user()->name ?? 'Bendahara Keuangan' }}</p>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="pt-4 border-t border-slate-100 text-[10px] text-slate-400 flex items-center justify-between">
            <span>* Simpan kwitansi ini sebagai bukti pembayaran yang sah.</span>
            <span>SmartEdu Financial System • SIT Robbani</span>
        </div>

    </div>

</body>
</html>
