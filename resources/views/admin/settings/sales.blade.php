@extends('admin.layout')

@section('title', 'Pengaturan Landing Page Sales 21 Modul')

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Sub-navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
        <a href="{{ route('admin.settings.portal') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            🏛️ Web Portal Sekolah
        </a>
        <a href="{{ route('admin.settings.sales') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-theme-gradient text-white shadow-md">
            📦 Landing Sales 21 Modul
        </a>
        <a href="{{ route('admin.settings.units') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            🏢 Profil Unit Sekolah (SDIT/SMPIT/SMAIT)
        </a>
    </div>

    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Halaman Sales & Lisensi Produk (`/sales`)</h1>
        <p class="text-xs text-slate-600 font-medium mt-1">Sunting visibilitas penawaran, judul promo, harga paket lisensi (1.5jt, 3jt, 5.5jt), daftar fitur, dan tautan WhatsApp.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <div class="space-y-6">
            <div class="flex items-center justify-between border-l-4 border-theme-accent pl-3">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">📦 Seksi Sales & Paket Harga Lisensi SmartEdu</h3>
                    <p class="text-[11px] text-slate-500 font-normal">Seksi ini ditampilkan di halaman `/sales` dan halaman utama jika diaktifkan.</p>
                </div>
                <div class="flex items-center gap-2">
                    <label class="text-xs font-bold text-slate-700">Tampilkan Seksi Sales:</label>
                    <select name="show_sales_section" class="px-3 py-1.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 bg-white">
                        <option value="1" {{ ($settings['show_sales_section'] ?? '1') === '1' ? 'selected' : '' }}>✓ Ya (Tampilkan)</option>
                        <option value="0" {{ ($settings['show_sales_section'] ?? '1') === '0' ? 'selected' : '' }}>✕ Tidak (Sembunyikan)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Seksi Sales:</label>
                    <input type="text" name="sales_title" value="{{ $settings['sales_title'] ?? 'Pilihan Paket Investasi & Lisensi SmartEdu' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Badge Headline Sales:</label>
                    <input type="text" name="sales_badge" value="{{ $settings['sales_badge'] ?? 'Penawaran Spesial & Lisensi' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas Sales:</label>
                <textarea name="sales_desc" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900">{{ $settings['sales_desc'] ?? 'Pilih paket sesuai kebutuhan sekolah...' }}</textarea>
            </div>

            <!-- Paket 1 Editor -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                <h4 class="font-extrabold text-xs text-slate-900 border-b border-slate-200 pb-2">📦 Paket 1 (Source Code Standar)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Paket 1:</label>
                        <input type="text" name="pkg1_title" value="{{ $settings['pkg1_title'] ?? 'Paket Source Code' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Harga Paket 1:</label>
                        <input type="text" name="pkg1_price" value="{{ $settings['pkg1_price'] ?? 'Rp 1.500.000' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold text-theme-accent">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Daftar Fitur Paket 1 (Satu per baris):</label>
                    <textarea name="pkg1_features" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">{{ $settings['pkg1_features'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- Paket 2 Editor -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                <h4 class="font-extrabold text-xs text-slate-900 border-b border-slate-200 pb-2">🔥 Paket 2 (Server + Reseller Affiliate - Best Value)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Paket 2:</label>
                        <input type="text" name="pkg2_title" value="{{ $settings['pkg2_title'] ?? 'Paket Server + Reseller' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Harga Paket 2:</label>
                        <input type="text" name="pkg2_price" value="{{ $settings['pkg2_price'] ?? 'Rp 3.000.000' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold text-amber-600">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Daftar Fitur Paket 2 (Satu per baris):</label>
                    <textarea name="pkg2_features" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">{{ $settings['pkg2_features'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- Paket 3 Editor -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                <h4 class="font-extrabold text-xs text-slate-900 border-b border-slate-200 pb-2">🏛️ Paket 3 (Enterprise Yayasan)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Paket 3:</label>
                        <input type="text" name="pkg3_title" value="{{ $settings['pkg3_title'] ?? 'Paket Enterprise Yayasan' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Harga Paket 3:</label>
                        <input type="text" name="pkg3_price" value="{{ $settings['pkg3_price'] ?? 'Rp 5.500.000' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold text-theme-accent">
                    </div>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Daftar Fitur Paket 3 (Satu per baris):</label>
                    <textarea name="pkg3_features" rows="3" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-mono">{{ $settings['pkg3_features'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-theme-gradient text-white font-extrabold text-xs shadow-lg hover:scale-105 transition-transform">
                Simpan Perubahan Sales ➔
            </button>
        </div>
    </form>
</div>
@endsection
