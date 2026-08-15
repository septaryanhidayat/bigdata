@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 1: Sub-Modul 7 & 8</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Data Guru & Tenaga Pendidik</h1>
            <p class="text-xs text-slate-500 font-medium">CRUD biodata guru, mapel diampu, NIP/NIK, posisi mengajar, dan akun portal login.</p>
        </div>
        <div>
            <a href="{{ route('admin.master.teachers.export') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-extrabold text-xs border border-slate-300 transition-colors inline-flex items-center gap-1">
                📥 Export CSV Guru
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Daftar Guru & Staf Pengajar Terdaftar</h3>
            <span class="text-xs text-slate-400 font-bold">Total: {{ $teachers->total() }} Guru</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">NIP / NIK</th>
                        <th class="py-3.5 px-4">Nama Lengkap & Gelar</th>
                        <th class="py-3.5 px-4">Unit Sekolah</th>
                        <th class="py-3.5 px-4">Posisi / Jabatan</th>
                        <th class="py-3.5 px-4">Kontak / Email</th>
                        <th class="py-3.5 px-4 text-center">Status Account</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($teachers as $tch)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3.5 px-4 font-mono font-extrabold text-slate-900">{{ $tch->nip }}</td>
                        <td class="py-3.5 px-4">
                            <h4 class="font-bold text-slate-900">{{ $tch->full_name }} {{ $tch->title ? ', '.$tch->title : '' }}</h4>
                            <span class="text-[10px] text-slate-400">Guru Tenaga Pendidik ({{ $tch->type }})</span>
                        </td>
                        <td class="py-3.5 px-4 font-extrabold text-emerald-800">{{ $tch->school->name ?? '-' }}</td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-800 font-bold text-[10px]">
                                {{ $tch->position }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600">
                            <div>📞 {{ $tch->phone ?? '-' }}</div>
                            <div class="text-[10px] text-slate-400">✉️ {{ $tch->email ?? '-' }}</div>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                ACTIVE PORTAL
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $teachers->links() }}
        </div>
    </div>

    <!-- Form Tambah Guru Baru -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-black text-base text-slate-900">➕ Input Data Guru / Pendidik Baru</h3>

        <form action="{{ route('admin.master.teachers.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs font-bold">
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
                <label class="block text-slate-700 mb-1">NIP (Nomor Induk Pegawai)</label>
                <input type="text" name="nip" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="198505122026011002">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Kategori Pegawai</label>
                <select name="type" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300">
                    <option value="GURU">GURU / TENAGA PENDIDIK</option>
                    <option value="NON_GURU">NON-GURU (TU / CS / SECURITY)</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="full_name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="Ustadz Abdullah Faqih">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Gelar Akademik (Misal: S.Pd.I, M.Pd)</label>
                <input type="text" name="title" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="S.Pd.I">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Posisi / Jabatan Mengajar</label>
                <input type="text" name="position" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="Guru PAI & Pengampu Tahfidz">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Nomor WhatsApp / HP</label>
                <input type="text" name="phone" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="081234567890">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Email Portal</label>
                <input type="email" name="email" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="guru@smartedu.test">
            </div>

            <div class="md:col-span-3 pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition-colors shadow">
                    Simpan Data Guru ➔
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
