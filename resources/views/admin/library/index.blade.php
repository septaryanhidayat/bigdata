@extends('admin.layout')

@section('title', 'Perpustakaan Digital E-Library')

@section('content')
<div class="space-y-6">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-800 font-black text-[10px] uppercase border border-cyan-200">Modul 10: Digital E-Library</span>
                <span class="w-2 h-2 rounded-full bg-cyan-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                📚 Perpustakaan Digital & Sirkulasi QR Code
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Katalog buku ISBN, sirkulasi peminjaman QR code, e-book reader, & denda otomatis.</p>
        </div>

        <button onclick="document.getElementById('addBookModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center gap-2">
            <span>+</span> Tambah Buku Katalog
        </button>
    </div>

    <!-- Table of Books -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Katalog Buku Perpustakaan (Total {{ count($books) }} Judul Buku)</h3>
            <span class="text-xs font-bold text-slate-500">Sirkulasi Pinjam QR Active</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase tracking-wider">
                    <tr>
                        <th class="p-4">ISBN</th>
                        <th class="p-4">Judul Buku</th>
                        <th class="p-4">Penulis / Pengarang</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Stok Total</th>
                        <th class="p-4">Tersedia</th>
                        <th class="p-4">E-Book</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($books as $bk)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-mono font-bold text-slate-900">{{ $bk->isbn }}</td>
                        <td class="p-4 font-black text-slate-900">{{ $bk->title }}</td>
                        <td class="p-4 font-bold text-slate-600">{{ $bk->author }}</td>
                        <td class="p-4"><span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 font-black text-[10px]">{{ $bk->category }}</span></td>
                        <td class="p-4 font-bold text-slate-900">{{ $bk->stock }} Eks</td>
                        <td class="p-4 font-black text-emerald-600">{{ $bk->available_stock }} Eks Ready</td>
                        <td class="p-4">
                            @if(!empty($bk->file_path))
                                <a href="{{ asset('storage/' . $bk->file_path) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-900 text-white font-black text-[10px] inline-flex items-center gap-1 hover:bg-slate-800">
                                    📖 Buka PDF
                                </a>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 font-bold text-[10px]">Fisik di Rak</span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            <form action="{{ route('admin.library.destroy', $bk->id) }}" method="POST" onsubmit="return confirm('Hapus buku ini dari katalog perpustakaan?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-black text-[11px] transition-colors" title="Hapus Buku">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-400 italic">Belum ada katalog buku terdaftar. Silakan klik tombol Tambah Buku Katalog di atas.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Add Book -->
<div id="addBookModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-md w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Tambah Buku Katalog</h3>
            <button onclick="document.getElementById('addBookModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.library.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Kode ISBN:</label>
                <input type="text" name="isbn" required placeholder="Contoh: 978-602-1234-01-5" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Judul Buku:</label>
                <input type="text" name="title" required placeholder="Contoh: Sejarah Kebudayaan Islam" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Penulis / Pengarang:</label>
                <input type="text" name="author" required placeholder="Nama Penulis" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-slate-700 mb-1">Kategori:</label>
                    <select name="category" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <option value="AGAMA_ISLAM">Agama Islam</option>
                        <option value="PELAJARAN">Pelajaran KBM</option>
                        <option value="SEJARAH">Sejarah</option>
                        <option value="SAINS">Sains & Teknologi</option>
                        <option value="LITERATUR">Karya & Cerita</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">Stok Eks:</label>
                    <input type="number" name="stock" value="1" min="1" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Upload File E-Book PDF (Opsional):</label>
                <input type="file" name="ebook_file" accept=".pdf" class="w-full p-2.5 rounded-2xl bg-slate-50 border border-slate-200 file:mr-3 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addBookModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>
@endsection
