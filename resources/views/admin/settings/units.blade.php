@extends('admin.layout')

@section('title', 'Pengaturan Unit Sekolah')

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Sub-navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
        @if(Auth::user()->isSuperAdmin() || Auth::user()->isYayasan() || Auth::user()->isHumas())
        <a href="{{ route('admin.settings.portal') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            🏛️ Web Portal Sekolah
        </a>
        @endif
        @if(Auth::user()->isSuperAdmin() || Auth::user()->isYayasan())
        <a href="{{ route('admin.settings.sales') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            📦 Landing Sales 25 Modul
        </a>
        @endif
        <a href="{{ route('admin.settings.units') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-theme-gradient text-white shadow-md">
            🏢 Profil Unit Sekolah (SDIT/SMPIT/SMAIT)
        </a>
    </div>

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Profil Unit Sekolah (SDIT, SMPIT, SMAIT)</h1>
            <p class="text-xs text-slate-600 font-medium mt-1">Kelola data profil, warna aksen, kepala sekolah, NPSN, dan alamat masing-masing unit sekolah yayasan.</p>
        </div>
        @if(Auth::user()->canAccessModule('master'))
        <a href="{{ route('admin.master.schools') }}" class="px-4 py-2.5 rounded-xl bg-theme-gradient text-white font-bold text-xs shadow-md">
            + Edit Master Data Unit
        </a>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($schools as $sc)
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full text-xs font-black text-white" style="background-color: {{ $sc->theme_color ?? '#059669' }}">
                        {{ $sc->code }}
                    </span>
                    <span class="text-[10px] font-bold text-slate-400">NPSN: {{ $sc->npsn }}</span>
                </div>
                <h3 class="text-lg font-black text-slate-900">{{ $sc->name }}</h3>
                <div class="space-y-1 text-xs text-slate-600">
                    <p>👤 <strong>Kepsek:</strong> {{ $sc->principal_name }}</p>
                    <p>📍 <strong>Alamat:</strong> {{ $sc->address }}</p>
                    <p>📞 <strong>Telepon:</strong> {{ $sc->phone ?? '-' }}</p>
                </div>
                <div class="pt-2 flex items-center gap-3 text-xs text-slate-500 font-bold border-t border-slate-100">
                    <span>👨‍🎓 {{ $sc->students_count }} Siswa</span>
                    <span>👨‍🏫 {{ $sc->employees_count }} Guru</span>
                    <span>🏫 {{ $sc->classrooms_count }} Kelas</span>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-200 flex items-center justify-between gap-2">
                <a href="{{ route('school.unit', strtolower($sc->code)) }}" target="_blank" class="text-xs font-black text-emerald-700 hover:underline flex items-center gap-1">
                    <span>Web Unit ➔</span>
                </a>
                <a href="{{ route('admin.settings.units.edit', strtolower($sc->code)) }}" class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black shadow-sm">
                    ✏️ Edit Profil Unit
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
