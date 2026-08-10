@extends('admin.layout')

@section('title', 'Branding & Landing Page Settings')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Branding & Teks Landing Page</h1>
        <p class="text-xs text-slate-600 font-medium mt-1">Ubah nama sekolah, nama aplikasi, judul header, serta deskripsi promo landing page.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="space-y-4 border-b border-slate-100 pb-6">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-emerald-600 pl-3">Identitas Sekolah & Aplikasi</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Aplikasi:</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-emerald-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Sekolah / Yayasan:</label>
                    <input type="text" name="school_name" value="{{ $settings['school_name'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-emerald-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Sub-tagline Header:</label>
                <input type="text" name="tagline" value="{{ $settings['tagline'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900 focus:outline-emerald-600">
            </div>
        </div>

        <div class="space-y-4 border-b border-slate-100 pb-6">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-emerald-600 pl-3">Hero Section (Tampilan Utama)</h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Badge Atas Hero:</label>
                <input type="text" name="hero_badge" value="{{ $settings['hero_badge'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-emerald-600">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Hero (Hero Title):</label>
                <input type="text" name="hero_title" value="{{ $settings['hero_title'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-extrabold text-slate-900 focus:outline-emerald-600">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas Hero:</label>
                <textarea name="hero_desc" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900 focus:outline-emerald-600">{{ $settings['hero_desc'] }}</textarea>
            </div>
        </div>

        <div class="space-y-4">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-amber-500 pl-3">Bina Pribadi Islami (BPI) Section</h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Seksi BPI:</label>
                <input type="text" name="bpi_title" value="{{ $settings['bpi_title'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-emerald-600">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Seksi BPI:</label>
                <textarea name="bpi_desc" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900 focus:outline-emerald-600">{{ $settings['bpi_desc'] }}</textarea>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-md">
                Simpan Perubahan Settings
            </button>
        </div>
    </form>
</div>
@endsection
