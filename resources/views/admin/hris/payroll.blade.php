@extends('admin.layout')

@section('title', 'Payroll & HRIS Pegawai')

@section('content')
<div class="space-y-6">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 font-black text-[10px] uppercase border border-purple-200">Modul 7 & 17: HRIS & E-Payroll</span>
                <span class="w-2 h-2 rounded-full bg-purple-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                💼 E-Payroll & Penggajian Pegawai Sekolah
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Kalkulasi gaji pokok, tunjangan jabatan, BPJS, PPh21, kasbon, & generate E-Slip Gaji PDF.</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block">
                <span class="text-[10px] text-slate-400 font-bold block uppercase">Total Gaji Bulan Ini</span>
                <span class="text-lg font-black text-emerald-600">Rp {{ number_format($totalPayrollMonth, 0, ',', '.') }}</span>
            </div>
            <button onclick="document.getElementById('addPayrollModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center gap-2">
                <span>+</span> Generate Slip Gaji
            </button>
        </div>
    </div>

    <!-- Table of Payroll Records -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Data Payroll & E-Slip Gaji Terbit (Bulan {{ date('F Y') }})</h3>
            <span class="text-xs font-bold text-slate-400">Total {{ count($payrollLogs) }} Pegawai Tergaji</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-4">Bulan</th>
                        <th class="p-4">Nama Pegawai</th>
                        <th class="p-4">Unit Sekolah</th>
                        <th class="p-4">Gaji Pokok</th>
                        <th class="p-4">Tunjangan</th>
                        <th class="p-4">Potongan (BPJS/Tax)</th>
                        <th class="p-4">Gaji Bersih (THP)</th>
                        <th class="p-4">Status & E-Slip</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($payrollLogs as $pay)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono font-bold text-slate-900">{{ $pay->month_year }}</td>
                        <td class="p-4 font-black text-slate-900">{{ $pay->employee->full_name ?? 'Pegawai' }}</td>
                        <td class="p-4 font-bold text-slate-600">{{ $pay->employee->school->code ?? '-' }}</td>
                        <td class="p-4 font-mono font-bold text-slate-900">Rp {{ number_format($pay->basic_salary, 0, ',', '.') }}</td>
                        <td class="p-4 font-mono text-emerald-700 font-bold">+ Rp {{ number_format($pay->position_allowance + $pay->transport_allowance, 0, ',', '.') }}</td>
                        <td class="p-4 font-mono text-rose-600 font-bold">- Rp {{ number_format($pay->bpjs_deduction + $pay->tax_deduction, 0, ',', '.') }}</td>
                        <td class="p-4 font-mono font-black text-emerald-600 text-sm">Rp {{ number_format($pay->net_salary, 0, ',', '.') }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full bg-emerald-500 text-white font-black text-[10px]">✓ E-Slip PDF Ready</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-400 italic">Belum ada data payroll tergenerate.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Generate Slip Gaji -->
<div id="addPayrollModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Generate E-Slip Gaji Pegawai</h3>
            <button onclick="document.getElementById('addPayrollModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.payroll.generate') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Pilih Pegawai:</label>
                <select name="employee_id" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->role_type }} • {{ $emp->school->code ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Periode Gaji (YYYY-MM):</label>
                <input type="text" name="month_year" value="{{ date('Y-m') }}" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-slate-700 mb-1">Gaji Pokok (Rp):</label>
                    <input type="number" name="basic_salary" value="3500000" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">Tunjangan Jabatan (Rp):</label>
                    <input type="number" name="position_allowance" value="750000" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-slate-700 mb-1">Potongan BPJS (Rp):</label>
                    <input type="number" name="bpjs_deduction" value="120000" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">Potongan PPh21 (Rp):</label>
                    <input type="number" name="tax_deduction" value="50000" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addPayrollModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Generate E-Slip Gaji</button>
            </div>
        </form>
    </div>
</div>
@endsection
