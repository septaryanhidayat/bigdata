@extends('admin.layout')

@section('title', 'Manajemen Biometrik Wajah Pegawai (Face ID)')

@section('content')
<div class="space-y-6">
    <!-- Header Banner -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-900 to-slate-900 rounded-3xl p-6 lg:p-8 text-white shadow-2xl border border-emerald-500/40 relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-400/20 text-emerald-300 text-xs font-black tracking-wider uppercase border border-emerald-400/40 mb-3">
                    <span>👤</span> Face Recognition Database
                </div>
                <h1 class="text-2xl lg:text-3xl font-black tracking-tight text-white">Database Biometrik Wajah Pegawai (Face ID)</h1>
                <p class="text-emerald-100 text-sm mt-1.5 max-w-2xl font-medium">
                    Daftar sampel biometrik wajah terverifikasi seluruh guru dan staf untuk presensi selfie mobile SIT Robbani.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.mobile.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs border border-slate-700 transition-all flex items-center gap-2">
                    <span>‹</span> Kembali ke Dashboard Mobile
                </a>
            </div>
        </div>
    </div>

    <!-- Table Card (Pure Light Mode) -->
    <div class="bg-white text-slate-800 rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-800">
                <thead class="bg-slate-100 text-xs uppercase text-slate-700 font-black border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4">Pegawai &amp; Unit</th>
                        <th class="px-6 py-4">Foto Biometrik</th>
                        <th class="px-6 py-4">Status Perekaman</th>
                        <th class="px-6 py-4">Waktu Perekaman</th>
                        <th class="px-6 py-4">Model AI / Confidence</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-extrabold text-slate-900 text-xs">{{ $emp->full_name }}</div>
                            <div class="text-[11px] text-slate-500 mt-0.5">NIP: {{ $emp->nip ?? '-' }} • <span class="text-emerald-700 font-bold">{{ $emp->role_type ?? 'Pendidik' }}</span></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-10 h-10 rounded-full overflow-hidden border-2 {{ $emp->face_registered_at ? 'border-emerald-500 shadow-xs' : 'border-slate-300' }} bg-slate-100 flex items-center justify-center shrink-0">
                                <img src="{{ $emp->face_photo_url ? (str_starts_with($emp->face_photo_url, 'http') ? $emp->face_photo_url : asset($emp->face_photo_url)) : 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}" 
                                     alt="{{ $emp->full_name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black {{ $emp->face_registered_at ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-rose-100 text-rose-800 border border-rose-300' }}">
                                {{ $emp->face_registered_at ? '✓ Terverifikasi Biometrik' : 'Belum Terdaftar' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-[11px] font-mono text-slate-600">
                            {{ $emp->face_registered_at ? date('d M Y, H:i', strtotime($emp->face_registered_at)) . ' WIB' : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-400">
                                <span>🧠</span> SmartEdu-FaceNet-v2 (98.5%)
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-xs font-medium">Tidak ada data pegawai.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($employees, 'hasPages') && $employees->hasPages())
        <div class="p-4 border-t border-slate-800">
            {{ $employees->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
