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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Aplikasi:</label>
                    <input type="text" name="app_name" value="{{ $settings['app_name'] ?? 'SmartEdu' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-emerald-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Teks Edisi Header:</label>
                    <input type="text" name="edition_title" value="{{ $settings['edition_title'] ?? 'SmartEdu' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-emerald-600" placeholder="Misal: SmartEdu">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Sekolah / Yayasan:</label>
                    <input type="text" name="school_name" value="{{ $settings['school_name'] ?? 'Sekolah Islam Terpadu Robbani' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-emerald-600">
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

        <div class="space-y-4 border-b border-slate-100 pb-6">
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

        <!-- Sales & Pricing Section Settings -->
        <div class="space-y-6 pt-2">
            <div class="flex items-center justify-between border-l-4 border-teal-600 pl-3">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">Seksi Sales & Paket Harga (Lisensi Produk)</h3>
                    <p class="text-[11px] text-slate-500 font-normal">Atur visibilitas seksi harga serta sunting judul, paket harga 1.5jt / 3jt, fitur, dan link WA.</p>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold text-slate-700">Tampilkan Seksi Sales:</label>
                    <select name="show_sales_section" class="px-3 py-1.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 bg-white focus:outline-teal-600">
                        <option value="1" {{ ($settings['show_sales_section'] ?? '1') === '1' ? 'selected' : '' }}>✓ Ya (Tampilkan)</option>
                        <option value="0" {{ ($settings['show_sales_section'] ?? '1') === '0' ? 'selected' : '' }}>✕ Tidak (Sembunyikan)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Seksi Sales:</label>
                    <input type="text" name="sales_title" value="{{ $settings['sales_title'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-teal-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Badge Seksi Sales:</label>
                    <input type="text" name="sales_badge" value="{{ $settings['sales_badge'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:outline-teal-600">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas Seksi Sales:</label>
                <textarea name="sales_desc" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900 focus:outline-teal-600">{{ $settings['sales_desc'] }}</textarea>
            </div>

            <!-- Paket 1 Editor -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                <h4 class="font-extrabold text-xs text-slate-900 border-b border-slate-200 pb-2">📦 Paket 1 (Source Code Standar)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Paket 1:</label>
                        <input type="text" name="pkg1_title" value="{{ $settings['pkg1_title'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Harga Paket 1:</label>
                        <input type="text" name="pkg1_price" value="{{ $settings['pkg1_price'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold text-teal-800">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Paket 1:</label>
                    <input type="text" name="pkg1_desc" value="{{ $settings['pkg1_desc'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Daftar Fitur Paket 1 (Satu per baris):</label>
                    <textarea name="pkg1_features" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">{{ $settings['pkg1_features'] }}</textarea>
                </div>
            </div>

            <!-- Paket 2 Editor -->
            <div class="p-4 bg-teal-50/70 border border-teal-200 rounded-2xl space-y-3">
                <div class="flex items-center justify-between border-b border-teal-200 pb-2">
                    <h4 class="font-extrabold text-xs text-teal-900">🔥 Paket 2 (Server + Reseller Affiliate - Best Value)</h4>
                    <span class="text-[10px] bg-amber-400 text-slate-950 px-2 py-0.5 rounded font-bold">Best Seller</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Paket 2:</label>
                        <input type="text" name="pkg2_title" value="{{ $settings['pkg2_title'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Harga Paket 2:</label>
                        <input type="text" name="pkg2_price" value="{{ $settings['pkg2_price'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold text-amber-600">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Teks Badge Paket 2:</label>
                        <input type="text" name="pkg2_badge" value="{{ $settings['pkg2_badge'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Paket 2:</label>
                    <input type="text" name="pkg2_desc" value="{{ $settings['pkg2_desc'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Daftar Fitur Paket 2 (Satu per baris):</label>
                    <textarea name="pkg2_features" rows="4" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">{{ $settings['pkg2_features'] }}</textarea>
                </div>
            </div>

            <!-- Paket 3 Editor -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                <h4 class="font-extrabold text-xs text-slate-900 border-b border-slate-200 pb-2">🏛️ Paket 3 (Enterprise Yayasan)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Paket 3:</label>
                        <input type="text" name="pkg3_title" value="{{ $settings['pkg3_title'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Harga Paket 3:</label>
                        <input type="text" name="pkg3_price" value="{{ $settings['pkg3_price'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold text-teal-800">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Deskripsi Paket 3:</label>
                    <input type="text" name="pkg3_desc" value="{{ $settings['pkg3_desc'] }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Daftar Fitur Paket 3 (Satu per baris):</label>
                    <textarea name="pkg3_features" rows="4" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">{{ $settings['pkg3_features'] }}</textarea>
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-extrabold text-xs shadow-md">
                Simpan Perubahan Settings
            </button>
        </div>
    </form>
</div>
@endsection
