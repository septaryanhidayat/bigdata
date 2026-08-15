@extends('admin.layout')

@section('title', 'Manajemen PPDB Online')

@section('content')
<div class="space-y-6">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-700 font-black text-[10px] uppercase border border-cyan-200">Modul 13: SPMB / PPDB Manager</span>
                <span class="w-2 h-2 rounded-full bg-cyan-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                📋 Pengelolaan Pendaftaran PPDB / SPMB Online
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Verifikasi pendaftaran calon siswa baru, dokumen syarat, pembayaran pendaftaran, & kelulusan.</p>
        </div>

        <a href="{{ route('school.ppdb') }}" target="_blank" class="px-4 py-2.5 rounded-2xl bg-slate-900 text-white font-black text-xs shadow-md hover:bg-slate-800 flex items-center gap-2">
            <span>🌐</span> Buka Form PPDB Public ↗
        </a>
    </div>

    <!-- Table of Registrations -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Data Calon Siswa Baru Terdaftar (PPDB 2026/2027)</h3>
            <span class="text-xs font-bold text-slate-400">Total {{ count($registrations) }} Pendaftar</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-4">No. Registrasi</th>
                        <th class="p-4">Nama Calon Siswa</th>
                        <th class="p-4">Jenjang Target</th>
                        <th class="p-4">Orang Tua / HP</th>
                        <th class="p-4">Sekolah Asal</th>
                        <th class="p-4">Biaya Pendaftaran</th>
                        <th class="p-4">Status Kelulusan</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($registrations as $reg)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-mono font-bold text-slate-900">{{ $reg->registration_number }}</td>
                        <td class="p-4 font-black text-slate-900">{{ $reg->full_name }}</td>
                        <td class="p-4"><span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 font-black text-[10px]">{{ $reg->target_level }}</span></td>
                        <td class="p-4 space-y-0.5">
                            <span class="font-bold text-slate-900 block">{{ $reg->parent_name }}</span>
                            <span class="text-[10px] text-slate-500 block">{{ $reg->phone_number }}</span>
                        </td>
                        <td class="p-4 font-bold text-slate-600">{{ $reg->previous_school ?? '-' }}</td>
                        <td class="p-4 font-mono font-black text-emerald-700">
                            Rp {{ number_format($reg->registration_fee, 0, ',', '.') }}
                            <span class="text-[9px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded-full font-bold block w-fit mt-1">LUNAS</span>
                        </td>
                        <td class="p-4">
                            @if($reg->status == 'PASSED')
                                <span class="px-3 py-1 rounded-full bg-emerald-500 text-white font-black text-[10px]">✓ DITERIMA / PASSED</span>
                            @elseif($reg->status == 'PENDING')
                                <span class="px-3 py-1 rounded-full bg-amber-500 text-white font-black text-[10px]">VERIFIKASI BERKAS</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-500 text-white font-black text-[10px]">DITOLAK</span>
                            @endif
                        </td>
                        <td class="p-4 flex items-center gap-1.5">
                            <form action="{{ route('admin.ppdb-admin.update-status', $reg->id) }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="status" value="PASSED">
                                <button type="submit" class="px-3 py-1.5 rounded-xl bg-emerald-600 text-white font-black text-[10px] hover:bg-emerald-700 shadow-sm">Set Diterima</button>
                            </form>
                            <a href="{{ route('admin.ppdb-admin.download-pdf', $reg->id) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-slate-900 text-amber-300 font-black text-[10px] hover:bg-slate-800 shadow-sm flex items-center gap-1">
                                <span>🖨️</span> PDF Bukti
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-8 text-center text-slate-400 italic">Belum ada pendaftar PPDB online terrecord.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
