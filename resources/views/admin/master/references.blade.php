@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 1: Sub-Modul 10</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Referensi Mata Pelajaran & Ruangan</h1>
            <p class="text-xs text-slate-500 font-medium">Pengelolaan referensi mata pelajaran (Muatan Nasional & Diniyah/JSIT) dan ruangan kelas/lab/perpustakaan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Tab Pelajaran -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-base text-slate-900">📚 Referensi Mata Pelajaran (Mapel)</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase">
                        <tr>
                            <th class="p-3">Kode</th>
                            <th class="p-3">Nama Mapel</th>
                            <th class="p-3">Kelompok</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                        @foreach($subjects as $sb)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-mono font-bold text-emerald-700">{{ $sb->code }}</td>
                            <td class="p-3 font-bold text-slate-900">{{ $sb->name }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-700">
                                    {{ $sb->group }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Form Tambah Mapel -->
            <form action="{{ route('admin.master.subjects.store') }}" method="POST" class="pt-4 border-t border-slate-100 space-y-3 text-xs font-bold">
                @csrf
                <span class="block text-slate-800 font-extrabold">➕ Form Tambah Mapel Baru</span>
                
                <input type="hidden" name="school_id" value="{{ $schools->first()->id ?? 1 }}">

                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="code" required placeholder="Kode (PAI-01)" class="px-3 py-2 rounded-xl border border-slate-300">
                    <input type="text" name="name" required placeholder="Nama Mapel" class="px-3 py-2 rounded-xl border border-slate-300">
                </div>

                <select name="group" required class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    <option value="PAI_DINIYAH">PAI & Diniyah (Tahfidz/Fiqih)</option>
                    <option value="MUATAN_NASIONAL">Muatan Nasional (Matematika/IPA/Bahasa)</option>
                    <option value="MUATAN_LOKAL">Muatan Lokal / Keterampilan</option>
                </select>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 text-white font-extrabold">
                    Simpan Mapel Baru ➔
                </button>
            </form>
        </div>

        <!-- Tab Ruangan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-base text-slate-900">🏫 Referensi Ruangan & Gedung Sekolah</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase">
                        <tr>
                            <th class="p-3">Kode</th>
                            <th class="p-3">Nama Ruangan</th>
                            <th class="p-3">Gedung / Kapasitas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                        @foreach($rooms as $rm)
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-mono font-bold text-slate-900">{{ $rm->code }}</td>
                            <td class="p-3 font-bold text-slate-900">{{ $rm->name }}</td>
                            <td class="p-3 text-slate-500">{{ $rm->building ?? 'Gedung Utama' }} ({{ $rm->capacity }} Kursi)</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Form Tambah Ruangan -->
            <form action="{{ route('admin.master.rooms.store') }}" method="POST" class="pt-4 border-t border-slate-100 space-y-3 text-xs font-bold">
                @csrf
                <span class="block text-slate-800 font-extrabold">➕ Form Tambah Ruangan Baru</span>

                <input type="hidden" name="school_id" value="{{ $schools->first()->id ?? 1 }}">

                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="code" required placeholder="Kode Ruang (R-101)" class="px-3 py-2 rounded-xl border border-slate-300">
                    <input type="text" name="name" required placeholder="Nama Ruang (Lab CBT 1)" class="px-3 py-2 rounded-xl border border-slate-300">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="building" placeholder="Nama Gedung" class="px-3 py-2 rounded-xl border border-slate-300" value="Gedung Utama A">
                    <input type="number" name="capacity" value="36" required placeholder="Kapasitas" class="px-3 py-2 rounded-xl border border-slate-300">
                </div>

                <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 text-white font-extrabold">
                    Simpan Ruangan Baru ➔
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
