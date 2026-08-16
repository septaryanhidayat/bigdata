@extends('admin.layout')

@section('title', 'Sistem Persuratan & E-Office TTE')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    <!-- Top Header Card (Responsive) -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase border border-emerald-200">
                    Modul 22: E-Office & TTE Internal
                </span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1.5">
                📬 Sistem Informasi Persuratan & Tanda Tangan Elektronik (TTE)
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5 leading-relaxed">
                Otomasi surat masuk & keluar, alur disposisi pimpinan, generator multi-template, & TTE digital internal ber-QR Code.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5 w-full md:w-auto">
            <a href="{{ route('admin.letters.outgoing') }}" class="flex-1 sm:flex-none px-4 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center justify-center gap-1.5">
                <span>➕</span> Buat Surat Keluar
            </a>
            <a href="{{ route('admin.letters.incoming') }}" class="flex-1 sm:flex-none px-4 py-2.5 rounded-2xl bg-slate-900 text-white font-black text-xs shadow-md hover:bg-slate-800 transition-transform active:scale-95 flex items-center justify-center gap-1.5">
                <span>📥</span> Catat Surat Masuk
            </a>
        </div>
    </div>

    <!-- 4 Summary Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Total Surat Masuk -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Surat Masuk (Inbox)</span>
                <h3 class="text-2xl font-black text-slate-900">{{ number_format($totalIncoming) }}</h3>
                <span class="text-[10px] font-bold text-emerald-600">📥 Buku Agenda Aktif</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 font-black text-xl flex items-center justify-center border border-emerald-100 shrink-0">
                📬
            </div>
        </div>

        <!-- Total Surat Keluar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Surat Keluar (Outbox)</span>
                <h3 class="text-2xl font-black text-slate-900">{{ number_format($totalOutgoing) }}</h3>
                <span class="text-[10px] font-bold text-blue-600">📤 Terbit Resmi</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 font-black text-xl flex items-center justify-center border border-blue-100 shrink-0">
                📨
            </div>
        </div>

        <!-- Antrian TTE Pejabat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Antrian TTE Digital</span>
                <h3 class="text-2xl font-black text-purple-700">{{ number_format($pendingTte) }}</h3>
                <a href="{{ route('admin.letters.tte-queue') }}" class="text-[10px] font-black text-purple-600 hover:underline">
                    ✍️ Butuh Tanda Tangan ➔
                </a>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 font-black text-xl flex items-center justify-center border border-purple-100 shrink-0">
                🖋️
            </div>
        </div>

        <!-- Disposisi Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Disposisi Berjalan</span>
                <h3 class="text-2xl font-black text-amber-600">{{ number_format($activeDispositions) }}</h3>
                <a href="{{ route('admin.letters.dispositions') }}" class="text-[10px] font-black text-amber-600 hover:underline">
                    📌 Pantau Respon Staf ➔
                </a>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 font-black text-xl flex items-center justify-center border border-amber-100 shrink-0">
                📑
            </div>
        </div>

    </div>

    <!-- Quick Navigation Hub (Responsive 6 Buttons) -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <a href="{{ route('admin.letters.incoming') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-emerald-500 hover:shadow-md transition-all text-center space-y-1.5 group">
            <span class="text-2xl block">📥</span>
            <h4 class="font-black text-xs text-slate-900 group-hover:text-emerald-700">Surat Masuk</h4>
            <span class="text-[10px] text-slate-400 font-medium block">Agenda & Scan</span>
        </a>

        <a href="{{ route('admin.letters.outgoing') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-blue-500 hover:shadow-md transition-all text-center space-y-1.5 group">
            <span class="text-2xl block">📤</span>
            <h4 class="font-black text-xs text-slate-900 group-hover:text-blue-700">Surat Keluar</h4>
            <span class="text-[10px] text-slate-400 font-medium block">Draft & Nomor</span>
        </a>

        <a href="{{ route('admin.letters.dispositions') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-amber-500 hover:shadow-md transition-all text-center space-y-1.5 group">
            <span class="text-2xl block">📌</span>
            <h4 class="font-black text-xs text-slate-900 group-hover:text-amber-700">Disposisi</h4>
            <span class="text-[10px] text-slate-400 font-medium block">Instruksi Pimpinan</span>
        </a>

        <a href="{{ route('admin.letters.tte-queue') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-purple-500 hover:shadow-md transition-all text-center space-y-1.5 group">
            <span class="text-2xl block">✍️</span>
            <h4 class="font-black text-xs text-slate-900 group-hover:text-purple-700">TTE Digital</h4>
            <span class="text-[10px] text-slate-400 font-medium block">QR Code Sign</span>
        </a>

        <a href="{{ route('admin.letters.templates') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-cyan-500 hover:shadow-md transition-all text-center space-y-1.5 group">
            <span class="text-2xl block">📝</span>
            <h4 class="font-black text-xs text-slate-900 group-hover:text-cyan-700">Template Baku</h4>
            <span class="text-[10px] text-slate-400 font-medium block">Undangan, ST, SE</span>
        </a>

        <a href="{{ route('admin.letters.archive') }}" class="p-4 rounded-2xl bg-white border border-slate-200 hover:border-rose-500 hover:shadow-md transition-all text-center space-y-1.5 group">
            <span class="text-2xl block">🗄️</span>
            <h4 class="font-black text-xs text-slate-900 group-hover:text-rose-700">E-Filing Arsip</h4>
            <span class="text-[10px] text-slate-400 font-medium block">Pencarian Digital</span>
        </a>
    </div>

    <!-- 2 Column Layout: Recent Letters & Recent Dispositions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
        
        <!-- Recent Letters Card (Fixed Layout & Non-overlapping Badges) -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-black text-base text-slate-900">📄 Aktivitas Surat Terbaru</h3>
                    <p class="text-xs text-slate-400 font-medium">Histori dokumen masuk & keluar terkini</p>
                </div>
                <a href="{{ route('admin.letters.archive') }}" class="text-xs font-bold text-emerald-700 hover:underline">Semua ➔</a>
            </div>

            <div class="space-y-3">
                @forelse($recentLetters as $lt)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-slate-100/70 transition-colors">
                    <div class="flex items-start gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl {{ $lt->type === 'INCOMING' ? 'bg-emerald-100 text-emerald-700' : 'bg-blue-100 text-blue-700' }} font-black text-base flex items-center justify-center shrink-0 mt-0.5">
                            {{ $lt->type === 'INCOMING' ? '📥' : '📤' }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-black text-xs text-slate-900 truncate leading-snug">{{ $lt->title }}</h4>
                            <p class="text-[10px] font-mono text-slate-500 mt-0.5 truncate">
                                {{ $lt->reference_number ?? $lt->agenda_number }} • {{ $lt->letter_date->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-2 shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-slate-200/50">
                        @if($lt->status === 'SIGNED')
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[9px] whitespace-nowrap">
                                ✓ TTE VALID
                            </span>
                        @elseif($lt->status === 'WAITING_SIGNATURE')
                            <span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 font-black text-[9px] whitespace-nowrap">
                                WAITING TTE
                            </span>
                        @elseif($lt->status === 'DRAFT')
                            <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-black text-[9px] whitespace-nowrap">
                                📝 DRAFT
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-full bg-slate-200 text-slate-700 font-bold text-[9px] whitespace-nowrap">
                                {{ $lt->status }}
                            </span>
                        @endif

                        <div class="flex items-center gap-1">
                            @if($lt->type === 'OUTGOING' && $lt->status !== 'SIGNED')
                                <a href="{{ route('admin.letters.outgoing') }}" class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 flex items-center justify-center text-xs" title="Edit Draft">
                                    ✏️
                                </a>
                            @endif
                            <a href="{{ route('admin.letters.preview-pdf', $lt->id) }}" target="_blank" title="Cetak Dokumen PDF" class="w-7 h-7 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-300 flex items-center justify-center text-xs shadow-xs">
                                🖨️
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 italic text-xs">Belum ada surat terdaftar.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Dispositions Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-5 sm:p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-black text-base text-slate-900">📌 Disposisi & Tugas Staf Berjalan</h3>
                    <p class="text-xs text-slate-400 font-medium">Instruksi tindak lanjut pimpinan</p>
                </div>
                <a href="{{ route('admin.letters.dispositions') }}" class="text-xs font-bold text-amber-700 hover:underline">Kelola ➔</a>
            </div>

            <div class="space-y-3">
                @forelse($recentDispositions as $disp)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2">
                        <div class="min-w-0 flex-1">
                            <span class="inline-block font-mono text-[10px] font-bold text-amber-800 bg-amber-100/80 px-2 py-0.5 rounded border border-amber-200">
                                ⚡ {{ $disp->instruction }}
                            </span>
                            <h4 class="font-black text-xs text-slate-900 mt-1 truncate">{{ $disp->letter->title ?? 'Surat Dinas' }}</h4>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black w-fit {{ $disp->status === 'COMPLETED' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $disp->status }}
                        </span>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between text-[10px] text-slate-500 font-medium pt-1.5 border-t border-slate-200/60 gap-1">
                        <span>Penerima: <strong class="text-slate-800">{{ $disp->toEmployee->full_name ?? 'Staf' }}</strong></span>
                        <span>Batas Waktu: <strong class="text-rose-600">{{ $disp->due_date ? $disp->due_date->format('d/m/Y') : '-' }}</strong></span>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-slate-400 italic text-xs">Belum ada disposisi aktif.</div>
                @endforelse
            </div>
        </div>

    </div>

</div>
@endsection
