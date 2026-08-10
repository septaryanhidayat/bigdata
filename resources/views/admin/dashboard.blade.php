@extends('admin.layout')

@section('title', 'Dashboard Overview')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Admin CMS Landing Page</h1>
            <p class="text-xs text-slate-600 font-medium mt-1">Kelola seluruh isi fitur, teks branding, nama sekolah, dan pertanyaan FAQ pada halaman promosi SmartEdu.</p>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs shadow hover:bg-emerald-700">
            Preview Landing Page 🌐
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-800 text-2xl flex items-center justify-center font-bold">🧩</div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase">Jumlah Modul Fitur</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $moduleCount }} Modul</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 text-2xl flex items-center justify-center font-bold">❓</div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase">Jumlah Item FAQ</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $faqCount }} Pertanyaan</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 text-2xl flex items-center justify-center font-bold">🏫</div>
            <div>
                <p class="text-xs font-bold text-slate-500 uppercase">Status Branding</p>
                <h3 class="text-lg font-black text-emerald-700 mt-0.5">SIT Robbani Active</h3>
            </div>
        </div>
    </div>

    <!-- Modules List Quick Access -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="font-extrabold text-base text-slate-900">Modul Fitur Terbaru</h2>
            <a href="{{ route('admin.modules.index') }}" class="text-xs font-bold text-emerald-700 hover:underline">Lihat Semua Modul →</a>
        </div>

        <div class="divide-y divide-slate-100">
            @foreach($recentModules as $mod)
            <div class="py-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xl">{{ $mod->icon }}</span>
                    <div>
                        <h4 class="font-extrabold text-sm text-slate-900">{{ $mod->title }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-1">{{ $mod->short_desc }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.modules.edit', $mod->id) }}" class="px-3 py-1 rounded-lg bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200">Edit</a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
