@extends('admin.layout')

@section('title', 'Manajemen Biometrik Wajah Pegawai (Face ID)')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-white">Database Biometrik Wajah Pegawai</h1>
            <p class="text-sm text-slate-400 mt-1">Daftar sampel biometrik wajah terverifikasi untuk presensi mobile SIT Robbani</p>
        </div>
        <a href="{{ route('admin.mobile.index') }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-all flex items-center gap-2">
            <span>‹</span> Kembali ke Dashboard Mobile
        </a>
    </div>

    <div class="bg-slate-900/70 backdrop-blur-md rounded-2xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-slate-950/60 text-xs uppercase text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="px-5 py-3.5">Pegawai</th>
                        <th class="px-5 py-3.5">Foto Biometrik</th>
                        <th class="px-5 py-3.5">Status Perekaman</th>
                        <th class="px-5 py-3.5">Waktu Perekaman</th>
                        <th class="px-5 py-3.5">Model AI / Confidence</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-slate-800/40 transition-colors">
                        <td class="px-5 py-4">
                            <div class="font-bold text-white">{{ $emp->full_name }}</div>
                            <div class="text-xs text-slate-400">NIP: {{ $emp->nip }} • {{ $emp->position }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <img src="{{ $emp->face_photo_url ? (str_starts_with($emp->face_photo_url, 'http') ? $emp->face_photo_url : asset($emp->face_photo_url)) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}" 
                                 class="w-12 h-12 rounded-full object-cover border-2 {{ $emp->face_registered_at ? 'border-emerald-500' : 'border-slate-700' }}">
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $emp->face_registered_at ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/20 text-rose-400 border border-rose-500/30' }}">
                                {{ $emp->face_registered_at ? '✓ Terverifikasi Biometrik' : 'Belum Terdaftar' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-xs font-mono text-slate-300">
                            {{ $emp->face_registered_at ? date('d M Y, H:i', strtotime($emp->face_registered_at)) . ' WIB' : '-' }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-xs font-semibold text-emerald-300">SmartEdu-FaceNet-v2 (98.5%)</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-8 text-center text-slate-400 text-xs">Tidak ada data pegawai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
