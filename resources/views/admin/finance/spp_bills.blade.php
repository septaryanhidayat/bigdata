@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 4: Sub-Modul 4.1</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Keuangan SPP & Kasir Kwitansi</h1>
            <p class="text-xs text-slate-500 font-medium">Generate tagihan SPP bulanan, kasir pembayaran tunai/transfer, & cetak kwitansi resmi.</p>
        </div>
    </div>

    <!-- Table Tagihan SPP -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Tagihan SPP Siswa</h3>
            <span class="text-xs text-slate-400 font-bold">Total: {{ $bills->total() }} Tagihan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase">
                    <tr>
                        <th class="p-4">Siswa & Rombel</th>
                        <th class="p-4">Bulan & Tahun</th>
                        <th class="p-4">Nominal SPP</th>
                        <th class="p-4">Status Tagihan</th>
                        <th class="p-4">Aksi Kasir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @foreach($bills as $bl)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4">
                            <span class="font-black text-slate-900 block">{{ $bl->student->full_name ?? '-' }}</span>
                            <span class="text-[10px] text-slate-400">NIS: {{ $bl->student->nis ?? '-' }} • {{ $bl->student->classroom->name ?? '-' }}</span>
                        </td>
                        <td class="p-4 font-bold text-slate-900">{{ $bl->month }} {{ $bl->year }}</td>
                        <td class="p-4 font-black text-emerald-700">Rp {{ number_format($bl->amount, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @if($bl->status == 'PAID')
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px]">LUNAS</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-black text-[10px]">BELUM BAYAR</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($bl->status == 'UNPAID')
                                <form action="{{ route('admin.finance.spp-bills.pay', $bl->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 text-white font-black text-[10px] hover:bg-emerald-700 transition-colors shadow">
                                        💳 Bayar Kasir (Terima SPP)
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400 font-semibold">Tercatat Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $bills->links() }}
        </div>
    </div>

    <!-- Form Generate Tagihan SPP Baru -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-black text-base text-slate-900">➕ Generate Tagihan SPP Siswa Baru</h3>

        <form action="{{ route('admin.finance.spp-bills.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Pilih Siswa</label>
                <select name="student_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($students as $st)
                        <option value="{{ $st->id }}">{{ $st->full_name }} (NIS: {{ $st->nis }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Bulan Tagihan</label>
                <select name="month" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tahun Tagihan</label>
                <input type="number" name="year" value="2026" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Nominal Tagihan SPP (Rp)</label>
                <input type="number" name="amount" value="500000" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
            </div>

            <div class="md:col-span-2 pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition-colors shadow">
                    Generate Tagihan SPP ➔
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
