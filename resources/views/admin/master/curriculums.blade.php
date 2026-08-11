@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 1: Sub-Modul 3 & 4</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Kurikulum & Tahun Akademik</h1>
            <p class="text-xs text-slate-500 font-medium">Pengaturan Kurikulum K13, Merdeka, JSIT, semester, dan periode aktif akademik.</p>
        </div>
    </div>

    <!-- Table Tahun Akademik -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Tahun Akademik & Kurikulum</h3>
            <span class="text-xs text-slate-400 font-bold">Total: {{ $academicYears->count() }} Periode</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 font-extrabold text-slate-600">
                        <th class="p-4">Tahun Akademik</th>
                        <th class="p-4">Semester</th>
                        <th class="p-4">Kode Kurikulum</th>
                        <th class="p-4">Tanggal Efektif</th>
                        <th class="p-4">Status Aktif</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @foreach($academicYears as $ay)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-black text-slate-900">{{ $ay->name }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $ay->semester == 'GANJIL' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                Semester {{ $ay->semester }}
                            </span>
                        </td>
                        <td class="p-4 font-bold text-emerald-700">{{ $ay->curriculum_code }}</td>
                        <td class="p-4 text-slate-500">{{ $ay->start_date }} s/d {{ $ay->end_date }}</td>
                        <td class="p-4">
                            @if($ay->is_active)
                                <span class="px-3 py-1 rounded-full bg-emerald-500 text-slate-950 font-black text-[10px]">AKTIF SESI INI</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px]">ARSIP</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Tambah Kurikulum / Tahun Akademik -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-black text-base text-slate-900">➕ Tambah Tahun Akademik & Kurikulum Baru</h3>

        <form action="{{ route('admin.master.curriculums.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Tahun Ajaran (Misal: 2026/2027)</label>
                <input type="text" name="name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="2026/2027">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Semester</label>
                <select name="semester" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    <option value="GANJIL">GANJIL</option>
                    <option value="GENAP">GENAP</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Kode Kurikulum (Merdeka / K13 / JSIT)</label>
                <select name="curriculum_code" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    <option value="KURIKULUM_MERDEKA_JSIT">Kurikulum Merdeka + Kekhasan JSIT (Adaptif)</option>
                    <option value="KURIKULUM_2013">Kurikulum 2013 (K13 Revisi)</option>
                    <option value="KURIKULUM_KUSTOM">Kurikulum Kustom Yayasan</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Set Sbg Periode Aktif</label>
                <label class="flex items-center gap-2 mt-2 font-semibold">
                    <input type="checkbox" name="is_active" value="1" class="rounded text-emerald-600 focus:ring-emerald-500">
                    <span>Jadikan Tahun Akademik Aktif Sesi Ini</span>
                </label>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tanggal Mulai Efektif</label>
                <input type="date" name="start_date" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" value="2026-07-15">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tanggal Selesai Efektif</label>
                <input type="date" name="end_date" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" value="2026-12-20">
            </div>

            <div class="md:col-span-2 pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition-colors shadow">
                    Simpan Kurikulum & Tahun Akademik ➔
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
