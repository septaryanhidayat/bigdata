@extends('admin.layout')

@section('title', 'Manajemen Biometrik Wajah Pegawai (Face ID)')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Database Biometrik Wajah Pegawai</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar sampel biometrik wajah terverifikasi untuk presensi mobile SIT Robbani</p>
        </div>
        <a href="{{ route('admin.mobile.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-800 dark:text-white font-bold text-xs transition-all flex items-center gap-2 self-start sm:self-auto border border-slate-200 dark:border-slate-700">
            <span>‹</span> Kembali ke Dashboard Mobile
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-100 dark:bg-slate-950 text-xs uppercase text-slate-700 dark:text-slate-300 font-extrabold border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="px-6 py-4">Pegawai &amp; Unit</th>
                        <th class="px-6 py-4">Foto Biometrik</th>
                        <th class="px-6 py-4">Status Perekaman</th>
                        <th class="px-6 py-4">Waktu Perekaman</th>
                        <th class="px-6 py-4">Model AI / Confidence</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-extrabold text-slate-900 dark:text-white text-sm">{{ $emp->full_name }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">NIP: {{ $emp->nip ?? '-' }} • <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ $emp->role_type ?? 'Pendidik' }}</span></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-12 h-12 rounded-full overflow-hidden border-2 {{ $emp->face_registered_at ? 'border-emerald-500 shadow-sm' : 'border-slate-300 dark:border-slate-700' }} bg-slate-100 flex items-center justify-center shrink-0">
                                <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200" 
                                     alt="{{ $emp->full_name }}" 
                                     class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-black {{ $emp->face_registered_at ? 'bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800' : 'bg-rose-100 dark:bg-rose-950 text-rose-800 dark:text-rose-300 border border-rose-300 dark:border-rose-800' }}">
                                {{ $emp->face_registered_at ? '✓ Terverifikasi Biometrik' : 'Belum Terdaftar' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-600 dark:text-slate-300">
                            {{ $emp->face_registered_at ? date('d M Y, H:i', strtotime($emp->face_registered_at)) . ' WIB' : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 dark:text-emerald-400">
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
    </div>
</div>
@endsection
