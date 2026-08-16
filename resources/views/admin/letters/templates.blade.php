@extends('admin.layout')

@section('title', 'Master Format Template Dokumen')

@section('content')
<div class="space-y-6">

    <!-- Header Box -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-800 font-black text-[10px] uppercase border border-cyan-200">
                    Template Engine Persuratan
                </span>
                <span class="w-2 h-2 rounded-full bg-cyan-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                📝 Master Template Baku Surat Dinas
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Standarisasi format baku surat tugas, surat edaran, nota dinas, surat keterangan aktif, dan undangan.
            </p>
        </div>

        <button onclick="document.getElementById('addTemplateModal').classList.remove('hidden')" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center gap-2">
            <span>➕</span> Tambah Template Baru
        </button>
    </div>

    <!-- Template Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($templates as $tpl)
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 space-y-4 hover:shadow-md transition-shadow flex flex-col justify-between">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="font-mono text-[10px] font-black text-cyan-800 bg-cyan-50 px-2.5 py-1 rounded-lg border border-cyan-200">
                        {{ $tpl->code }}
                    </span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase">{{ $tpl->category }}</span>
                </div>

                <h3 class="font-black text-base text-slate-900 leading-snug">{{ $tpl->name }}</h3>
                <div class="p-3 rounded-2xl bg-slate-50 border border-slate-200/80 text-[11px] font-mono text-slate-600">
                    Pola Nomor: <span class="text-emerald-700 font-bold">{{ $tpl->format_number_pattern }}</span>
                </div>

                <div class="text-xs text-slate-600 bg-slate-50 p-3.5 rounded-2xl border border-slate-100 max-h-36 overflow-y-auto font-medium whitespace-pre-line leading-relaxed">
                    {{ Str::limit($tpl->content_template, 250) }}
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                <span class="px-2 py-0.5 rounded-full text-[9px] font-black {{ $tpl->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-600' }}">
                    {{ $tpl->is_active ? 'AKTIF DIGUNAKAN' : 'NON-AKTIF' }}
                </span>

                <a href="{{ route('admin.letters.outgoing') }}" class="text-xs font-bold text-theme-accent hover:underline">
                    Gunakan Template ➔
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full p-12 bg-white rounded-3xl border border-slate-100 text-center text-slate-400 italic">
            Belum ada format template tersimpan. Klik tombol di atas untuk menambahkan.
        </div>
        @endforelse
    </div>

</div>

<!-- Modal Tambah Template -->
<div id="addTemplateModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-2xl w-full shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Tambah Format Template Baru</h3>
            <button onclick="document.getElementById('addTemplateModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.letters.templates.store') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Nama Template Dokumen:</label>
                <input type="text" name="name" required placeholder="Contoh: Surat Tugas Pembina Ekstrakurikuler" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Kategori Surat:</label>
                <select name="category" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <option value="SURAT_TUGAS">Surat Tugas (ST)</option>
                    <option value="SURAT_EDARAN">Surat Edaran (SE)</option>
                    <option value="NOTA_DINAS">Nota Dinas (ND)</option>
                    <option value="SURAT_KETERANGAN">Surat Keterangan (SKet)</option>
                    <option value="UNDANGAN">Surat Undangan</option>
                    <option value="SURAT_KEPUTUSAN">Surat Keputusan (SK)</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Draf Isi Template (Gunakan placeholder teks):</label>
                <textarea name="content_template" rows="7" required placeholder="Tuliskan format narasi standar di sini..." class="w-full p-4 rounded-2xl bg-slate-50 border border-slate-200 font-mono"></textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addTemplateModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Simpan Template ➔</button>
            </div>
        </form>
    </div>
</div>
@endsection
