@extends('admin.layout')

@section('title', 'Tambah Modul Fitur Baru')

@section('content')
<div class="max-w-3xl space-y-6">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Tambah Modul Fitur Baru</h1>
        <p class="text-xs text-slate-600 font-medium mt-1">Masukkan rincian modul fitur produk digital yang akan dipromosikan.</p>
    </div>

    <form action="{{ route('admin.modules.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Lengkap Modul:</label>
                <input type="text" name="title" required placeholder="Contoh: 18. Modul Konseling Karir" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Ringkas (App Icon Label):</label>
                <input type="text" name="short_title" placeholder="Contoh: Konseling" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Ikon Emoji (1 Character):</label>
                <input type="text" name="icon" value="✨" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 text-center">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kategori Filter:</label>
                <select name="category" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                    <option value="akademik">🎓 Akademik & Kurikulum</option>
                    <option value="keuangan">💰 Keuangan & POS</option>
                    <option value="bpi">🕌 BPI & Character</option>
                    <option value="operasional">⚙️ HRIS & Operasional</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Nama Label Kategori:</label>
                <input type="text" name="category_name" value="Akademik Base" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas (Tampil pada Kartu):</label>
            <textarea name="short_desc" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Lengkap (Tampil di Modal Popup):</label>
            <textarea name="full_desc" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Sub-Fitur & Bullet Points (Pisahkan tiap baris baru):</label>
            <textarea name="highlights_text" rows="5" required placeholder="Fitur sub-modul 1&#10;Fitur sub-modul 2&#10;Fitur sub-modul 3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Sort Order (Angka):</label>
            <input type="number" name="sort_order" value="18" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
        </div>

        <div class="pt-4 flex justify-end gap-3">
            <a href="{{ route('admin.modules.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-800 font-bold text-xs">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow">Simpan Modul</button>
        </div>
    </form>
</div>
@endsection
