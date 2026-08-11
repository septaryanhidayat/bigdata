@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 1: Sub-Modul 5</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Tingkat & Rombel Kelas</h1>
            <p class="text-xs text-slate-500 font-medium">Pengelolaan rombel/kelas, kapasitas kuota siswa, dan penetapan wali kelas.</p>
        </div>
    </div>

    <!-- Rombel Grid / Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Rombel / Kelas Terdaftar</h3>
            <span class="text-xs text-slate-400 font-bold">Total: {{ $classrooms->count() }} Kelas</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 font-extrabold text-slate-600">
                        <th class="p-4">Unit Sekolah</th>
                        <th class="p-4">Tingkat/Jenjang</th>
                        <th class="p-4">Nama Rombel/Kelas</th>
                        <th class="p-4">Kapasitas Kuota</th>
                        <th class="p-4">Wali Kelas Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @foreach($classrooms as $cls)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4 font-extrabold text-emerald-800">{{ $cls->school->name ?? '-' }}</td>
                        <td class="p-4">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 font-bold text-[10px]">
                                Tingkat {{ $cls->level->code ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4 font-black text-slate-900">{{ $cls->name }}</td>
                        <td class="p-4 text-slate-600">{{ $cls->capacity }} Siswa</td>
                        <td class="p-4">
                            @if($cls->homeroomTeacher)
                                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-900 font-bold text-[10px] border border-emerald-200">
                                    👨‍🏫 {{ $cls->homeroomTeacher->full_name }}
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 font-bold text-[10px] border border-amber-200">
                                    Belum Diatur
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Form Tambah Rombel Baru -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-black text-base text-slate-900">➕ Tambah Rombel / Kelas Baru</h3>

        <form action="{{ route('admin.master.classrooms.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Unit Sekolah</label>
                <select name="school_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($schools as $sc)
                        <option value="{{ $sc->id }}">{{ $sc->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tingkat / Jenjang</label>
                <select name="level_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    @foreach($levels as $lvl)
                        <option value="{{ $lvl->id }}">Tingkat {{ $lvl->code }} ({{ $lvl->name }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Nama Rombel / Kelas (Misal: 7-Umar, 8-Khadijah)</label>
                <input type="text" name="name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="7-Umar bin Khattab">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Kapasitas Maksimal Siswa</label>
                <input type="number" name="capacity" value="32" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
            </div>

            <div class="md:col-span-2">
                <label class="block text-slate-700 mb-1">Wali Kelas Terdaftar</label>
                <select name="homeroom_teacher_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    <option value="">-- Pilih Guru Wali Kelas --</option>
                    @foreach($teachers as $tch)
                        <option value="{{ $tch->id }}">{{ $tch->full_name }} ({{ $tch->nip }})</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2 pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition-colors shadow">
                    Simpan Rombel Kelas Baru ➔
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
