@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 6: Sub-Modul 6.1</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">POS Kantin Cashless RFID Tap</h1>
            <p class="text-xs text-slate-500 font-medium">Checkout kasir kantin tanpa uang tunai (tap kartu RFID), limit harian ortu, & kelola outlet tenant.</p>
        </div>
    </div>

    <!-- POS Kasir Simulator Box -->
    <div class="bg-gradient-to-r from-emerald-950 via-teal-950 to-slate-950 text-white p-6 rounded-2xl border border-emerald-800 shadow-xl space-y-4">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-amber-300 uppercase tracking-wider">💳 Cashless POS Terminal Checkout Kasir Kantin</span>
            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500 text-slate-950 text-[10px] font-black">POS TERMINAL READY</span>
        </div>

        <form action="{{ route('admin.canteen.checkout') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            @csrf
            <div>
                <label class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Outlet Kantin</label>
                <select name="outlet_id" required class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold">
                    @foreach($outlets as $ot)
                        <option value="{{ $ot->id }}">{{ $ot->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Total Belanja (Rp)</label>
                <input type="number" name="total_amount" value="12000" min="500" required class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono text-xs font-bold">
            </div>

            <div>
                <label class="block text-[10px] text-slate-400 font-bold uppercase mb-1">Kode Kartu RFID Siswa</label>
                <input type="text" name="rfid_tag" value="RFID-STU-7001" required placeholder="Tap / Scan Kartu..." class="w-full px-3 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white font-mono text-xs font-bold">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-amber-400 text-slate-950 font-black text-xs hover:bg-amber-300 transition-colors shadow">
                    Checkout Tap RFID ➔
                </button>
            </div>
        </form>
    </div>

    <!-- Multi Outlet Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Outlets -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-base text-slate-900">🏪 Outlet Kantin Tenant Terdaftar</h3>

            <div class="space-y-3">
                @foreach($outlets as $ot)
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                    <div>
                        <h4 class="font-black text-slate-900 text-sm">{{ $ot->name }}</h4>
                        <span class="text-xs text-slate-500 font-medium">Pemilik: {{ $ot->owner_name ?? '-' }} ({{ $ot->phone ?? '-' }})</span>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-xs">
                        {{ $ot->products_count }} Produk
                    </span>
                </div>
                @endforeach
            </div>

            <!-- Form Tambah Outlet -->
            <form action="{{ route('admin.canteen.outlets.store') }}" method="POST" class="pt-4 border-t border-slate-100 space-y-3 text-xs font-bold">
                @csrf
                <span class="block text-slate-800 font-extrabold">➕ Tambah Tenant Outlet Baru</span>
                <input type="hidden" name="school_id" value="1">

                <input type="text" name="name" required placeholder="Nama Outlet (Contoh: Kantin Barokah SDIT)" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="owner_name" placeholder="Nama Pemilik" class="px-3 py-2 rounded-xl border border-slate-300">
                    <input type="text" name="phone" placeholder="No HP" class="px-3 py-2 rounded-xl border border-slate-300">
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 text-white font-extrabold">
                    Simpan Tenant Outlet ➔
                </button>
            </form>
        </div>

        <!-- Transaksi Log -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-base text-slate-900">🧾 Log Transaksi POS Cashless Kantin</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase">
                        <tr>
                            <th class="p-3">Waktu</th>
                            <th class="p-3">Siswa</th>
                            <th class="p-3">Outlet</th>
                            <th class="p-3">Total (Rp)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                        @foreach($transactions as $ctx)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-mono text-slate-500">{{ $ctx->created_at->format('H:i') }} WIB</td>
                            <td class="p-3 font-bold text-slate-900">{{ $ctx->student->full_name ?? '-' }}</td>
                            <td class="p-3 font-bold text-emerald-800">{{ $ctx->outlet->name ?? '-' }}</td>
                            <td class="p-3 font-black text-slate-900">Rp {{ number_format($ctx->total_amount, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
