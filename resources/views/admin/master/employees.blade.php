@extends('admin.layout')

@section('title', 'Master Data Pegawai')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">👨‍🏫 Master Data Guru & Pegawai</h1>
            <p class="text-xs text-slate-600 font-medium mt-1">Daftar tenaga pendidik Ustadz/Ustadzah dan karyawan non-guru terdaftar.</p>
        </div>
        <a href="{{ route('admin.master.index') }}" class="px-4 py-2 rounded-xl bg-slate-200 text-slate-800 font-bold text-xs">
            ← Kembali ke Master
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">NIP / NIK</th>
                        <th class="py-3.5 px-4">Nama Lengkap & Gelar</th>
                        <th class="py-3.5 px-4">Unit Sekolah</th>
                        <th class="py-3.5 px-4">Role / Jabatan</th>
                        <th class="py-3.5 px-4">Status Kepegawaian</th>
                        <th class="py-3.5 px-4">Kontak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($employees as $emp)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3.5 px-4 font-mono font-bold text-slate-700">
                            {{ $emp->nip ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4">
                            <h4 class="font-extrabold text-slate-900 text-sm">{{ $emp->formatted_name }}</h4>
                            <span class="text-[10px] text-slate-400">{{ $emp->email }}</span>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-emerald-700">
                            {{ $emp->school->code ?? '-' }}
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200">
                                {{ $emp->role_type }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 font-bold text-slate-600">
                            {{ $emp->employment_status }}
                        </td>
                        <td class="py-3.5 px-4 text-slate-700 font-medium">
                            {{ $emp->phone ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
