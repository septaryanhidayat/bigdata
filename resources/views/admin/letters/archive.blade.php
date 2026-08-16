@extends('admin.layout')

@section('title', 'E-Filing & Pengarsipan Digital')

@section('content')
<div class="space-y-6">

    <!-- Header Box -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-black text-[10px] uppercase border border-rose-200">
                    E-Filing & Digital Repository
                </span>
                <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                🗄️ E-Filing & Pengarsipan Digital Surat
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Penyimpanan terpusat surat masuk & surat keluar dengan filter pencarian canggih dan verifikasi TTE terintegrasi.
            </p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
        <form action="{{ route('admin.letters.archive') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div class="lg:col-span-2">
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Cari Kata Kunci:</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor surat, pengirim, perihal..." class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold focus:outline-none">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Jenis Alur Surat:</label>
                <select name="type" class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    <option value="">Semua (Masuk & Keluar)</option>
                    <option value="INCOMING" {{ request('type') == 'INCOMING' ? 'selected' : '' }}>📥 Surat Masuk</option>
                    <option value="OUTGOING" {{ request('type') == 'OUTGOING' ? 'selected' : '' }}>📤 Surat Keluar</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Tahun Arsip:</label>
                <select name="year" class="w-full px-4 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                    <option value="">Semua Tahun</option>
                    @for($y = date('Y'); $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full py-2 px-4 rounded-xl bg-slate-900 text-white font-extrabold text-xs hover:bg-slate-800 transition-colors">
                    🔍 Filter Arsip
                </button>
            </div>
        </form>
    </div>

    <!-- Table of Archived Letters -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Dokumen Arsip Digital Terindeks</h3>
            <span class="text-xs font-bold text-slate-400">Total: {{ $letters->total() }} Dokumen</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-4">Jenis</th>
                        <th class="p-4">Nomor Dokumen</th>
                        <th class="p-4">Perihal & Isi</th>
                        <th class="p-4">Pengirim / Penerima</th>
                        <th class="p-4">Tanggal Arsip</th>
                        <th class="p-4">Integritas TTE</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($letters as $lt)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full font-black text-[9px] {{ $lt->type === 'INCOMING' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $lt->type === 'INCOMING' ? '📥 MASUK' : '📤 KELUAR' }}
                            </span>
                        </td>
                        <td class="p-4 font-mono font-bold text-slate-900">
                            {{ $lt->reference_number ?? $lt->agenda_number }}
                            <span class="text-[10px] text-slate-400 font-sans block">{{ $lt->category_label }}</span>
                        </td>
                        <td class="p-4 max-w-xs">
                            <h4 class="font-black text-slate-900 leading-snug">{{ $lt->title }}</h4>
                            <span class="text-[10px] text-slate-400 line-clamp-1 mt-0.5">{{ Str::limit(strip_tags($lt->content), 60) }}</span>
                        </td>
                        <td class="p-4 text-slate-700">
                            <div class="text-[11px] font-bold">{{ $lt->type === 'INCOMING' ? 'Dari: ' . $lt->sender : 'Kepada: ' . $lt->recipient }}</div>
                            <span class="text-[10px] text-slate-400">{{ $lt->school->name ?? 'Yayasan Robbani' }}</span>
                        </td>
                        <td class="p-4 font-mono text-slate-600">
                            {{ $lt->letter_date->format('d/m/Y') }}
                        </td>
                        <td class="p-4">
                            @if($lt->digitalSignature)
                                <div class="space-y-0.5">
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-black text-[9px]">✓ TTE TERVERIFIKASI</span>
                                    <span class="text-[9px] font-mono text-slate-400 block">{{ $lt->digitalSignature->certificate_serial }}</span>
                                </div>
                            @else
                                <span class="text-[10px] text-slate-400 italic">Non-TTE</span>
                            @endif
                        </td>
                        <td class="p-4 flex items-center gap-1.5">
                            @if($lt->file_url)
                                <a href="{{ $lt->file_url }}" target="_blank" class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px]">
                                    📎 Scan
                                </a>
                            @endif
                            <a href="{{ route('admin.letters.preview-pdf', $lt->id) }}" target="_blank" class="px-2.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-300 font-black text-[10px]">
                                🖨️ PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400 italic">Tidak ada arsip dokumen yang sesuai dengan kriteria pencarian.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $letters->links() }}
        </div>
    </div>

</div>
@endsection
