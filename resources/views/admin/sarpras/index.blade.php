@extends('admin.layout')

@section('title', 'Sarana Prasarana & Aset')

@section('content')
<div class="space-y-6">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 font-black text-[10px] uppercase border border-amber-200">Modul 9: Sarana Prasarana</span>
                <span class="w-2 h-2 rounded-full bg-amber-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                📦 Manajemen Aset Sarpras & Barcode Gedung
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Inventaris barang, barcode aset, pergerakan barang habis pakai, & lokasi gedung.</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <span class="text-[10px] text-slate-400 font-bold block uppercase">Total Nilai Aset</span>
                <span class="text-lg font-black text-emerald-600">Rp {{ number_format($totalAssetValue, 0, ',', '.') }}</span>
            </div>
            <button onclick="document.getElementById('addAssetModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center gap-2">
                <span>+</span> Tambah Aset Baru
            </button>
        </div>
    </div>

    <!-- Table of Assets -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Aset Sarpras Terdaftar (Total {{ count($assets) }} Items)</h3>
            <span class="text-xs font-bold text-slate-400">Barcode Scan Ready</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-4">Kode Aset</th>
                        <th class="p-4">Nama Barang / Aset</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Jumlah (Qty)</th>
                        <th class="p-4">Lokasi Ruangan</th>
                        <th class="p-4">Nilai Per Unit</th>
                        <th class="p-4">Kondisi Fisik</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($assets as $ast)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono font-bold text-purple-700">{{ $ast->asset_code }}</td>
                        <td class="p-4 font-black text-slate-900">{{ $ast->name }}</td>
                        <td class="p-4"><span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-black text-[10px]">{{ $ast->category }}</span></td>
                        <td class="p-4 font-black text-slate-900">{{ number_format($ast->quantity) }} Unit</td>
                        <td class="p-4 font-bold text-slate-600">📍 {{ $ast->location }}</td>
                        <td class="p-4 font-mono font-black text-emerald-600">Rp {{ number_format($ast->purchase_cost, 0, ',', '.') }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full bg-emerald-500 text-white font-black text-[10px]">✓ {{ $ast->condition }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400 italic">Belum ada aset terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Add Asset -->
<div id="addAssetModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-md w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Tambah Aset Sarpras</h3>
            <button onclick="document.getElementById('addAssetModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.sarpras.store') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Kode Barcode Aset:</label>
                <input type="text" name="asset_code" value="AST-{{ rand(100,999) }}" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Nama Barang / Aset:</label>
                <input type="text" name="name" placeholder="Contoh: Laptop Acer i5 8GB" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-slate-700 mb-1">Kategori:</label>
                    <select name="category" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <option value="ELEKTRONIK">Elektronik</option>
                        <option value="MEBEL">Mebel</option>
                        <option value="BANGUNAN">Bangunan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">Jumlah (Qty):</label>
                    <input type="number" name="quantity" value="1" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Lokasi Ruangan / Gedung:</label>
                <input type="text" name="location" value="Lab Komputer Utama" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Nilai / Biaya Pembelian (Rp):</label>
                <input type="number" name="purchase_cost" value="5000000" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addAssetModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Simpan Aset</button>
            </div>
        </form>
    </div>
</div>
@endsection
