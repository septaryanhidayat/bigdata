@extends('admin.layout')

@section('title', 'Web Portal & Landing Settings')

@section('content')
<div class="max-w-4xl space-y-6">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Website Sekolah & Landing Page Sales</h1>
        <p class="text-xs text-slate-600 font-medium mt-1">Kelola tema warna website publik, profil sekolah, sambutan pimpinan, kontak, serta paket lisensi 21 modul.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <!-- 0. Pilihan Warna Tema Website Publik Sekolah & Admin -->
        <div class="space-y-4 border-b border-slate-100 pb-6">
            <div class="flex items-center justify-between border-l-4 border-theme-accent pl-3">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">🎨 Opsi Pilihan Tema Warna Sistem (Website & Admin)</h3>
                    <p class="text-xs text-slate-500 font-medium">Klik pada salah satu dari 5 paket warna di bawah ini untuk mengubah tema warna sistem secara langsung:</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
                <!-- Option 1: Emerald Robbani -->
                <div onclick="selectThemeRadio('theme-emerald')" id="card-theme-emerald" class="p-3.5 rounded-2xl border-2 cursor-pointer transition-all space-y-2 text-center theme-option-card">
                    <div class="flex items-center justify-center gap-2">
                        <input type="radio" name="website_theme" value="theme-emerald" id="radio-theme-emerald" {{ ($settings['website_theme'] ?? 'theme-emerald') === 'theme-emerald' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                        <span class="text-xs font-black text-slate-900">Emerald Robbani</span>
                    </div>
                    <div class="w-10 h-10 mx-auto rounded-xl bg-gradient-to-r from-emerald-600 via-teal-500 to-cyan-500 shadow-md"></div>
                    <span class="text-[10px] text-slate-500 block font-bold">Hijau & Toska</span>
                </div>

                <!-- Option 2: Royal Sapphire / Cyber Blue -->
                <div onclick="selectThemeRadio('theme-ocean')" id="card-theme-ocean" class="p-3.5 rounded-2xl border-2 cursor-pointer transition-all space-y-2 text-center theme-option-card">
                    <div class="flex items-center justify-center gap-2">
                        <input type="radio" name="website_theme" value="theme-ocean" id="radio-theme-ocean" {{ ($settings['website_theme'] ?? '') === 'theme-ocean' ? 'checked' : '' }} class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                        <span class="text-xs font-black text-slate-900">Royal Sapphire</span>
                    </div>
                    <div class="w-10 h-10 mx-auto rounded-xl bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 shadow-md"></div>
                    <span class="text-[10px] text-slate-500 block font-bold">Biru & Indigo</span>
                </div>

                <!-- Option 3: Neon Magenta -->
                <div onclick="selectThemeRadio('theme-magenta')" id="card-theme-magenta" class="p-3.5 rounded-2xl border-2 cursor-pointer transition-all space-y-2 text-center theme-option-card">
                    <div class="flex items-center justify-center gap-2">
                        <input type="radio" name="website_theme" value="theme-magenta" id="radio-theme-magenta" {{ ($settings['website_theme'] ?? '') === 'theme-magenta' ? 'checked' : '' }} class="w-4 h-4 text-pink-600 focus:ring-pink-500">
                        <span class="text-xs font-black text-slate-900">Neon Magenta</span>
                    </div>
                    <div class="w-10 h-10 mx-auto rounded-xl bg-gradient-to-r from-pink-500 via-purple-600 to-indigo-600 shadow-md"></div>
                    <span class="text-[10px] text-slate-500 block font-bold">Magenta & Purple</span>
                </div>

                <!-- Option 4: Sunset Coral -->
                <div onclick="selectThemeRadio('theme-sunset')" id="card-theme-sunset" class="p-3.5 rounded-2xl border-2 cursor-pointer transition-all space-y-2 text-center theme-option-card">
                    <div class="flex items-center justify-center gap-2">
                        <input type="radio" name="website_theme" value="theme-sunset" id="radio-theme-sunset" {{ ($settings['website_theme'] ?? '') === 'theme-sunset' ? 'checked' : '' }} class="w-4 h-4 text-rose-600 focus:ring-rose-500">
                        <span class="text-xs font-black text-slate-900">Sunset Coral</span>
                    </div>
                    <div class="w-10 h-10 mx-auto rounded-xl bg-gradient-to-r from-rose-500 via-orange-500 to-amber-500 shadow-md"></div>
                    <span class="text-[10px] text-slate-500 block font-bold">Rose & Oranye</span>
                </div>

                <!-- Option 5: Obsidian Gold -->
                <div onclick="selectThemeRadio('theme-gold')" id="card-theme-gold" class="p-3.5 rounded-2xl border-2 cursor-pointer transition-all space-y-2 text-center theme-option-card">
                    <div class="flex items-center justify-center gap-2">
                        <input type="radio" name="website_theme" value="theme-gold" id="radio-theme-gold" {{ ($settings['website_theme'] ?? '') === 'theme-gold' ? 'checked' : '' }} class="w-4 h-4 text-amber-600 focus:ring-amber-500">
                        <span class="text-xs font-black text-slate-900">Obsidian Gold</span>
                    </div>
                    <div class="w-10 h-10 mx-auto rounded-xl bg-gradient-to-r from-amber-500 via-yellow-600 to-amber-700 shadow-md"></div>
                    <span class="text-[10px] text-slate-500 block font-bold">Emas & Hitam</span>
                </div>
            </div>
        </div>

        <!-- 1. Identitas & Hero Banner Portal -->
        <div class="space-y-4 border-b border-slate-100 pb-6">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-theme-accent pl-3">Identitas Sekolah & Hero Banner Portal</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Sekolah / Yayasan:</label>
                    <input type="text" name="school_name" value="{{ $settings['school_name'] ?? 'Sekolah Islam Terpadu Robbani' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Sub-tagline Header Portal:</label>
                    <input type="text" name="tagline" value="{{ $settings['tagline'] ?? 'Membentuk Generasi Rabbani' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Badge Top Hero Banner:</label>
                <input type="text" name="school_hero_badge" value="{{ $settings['hero_badge'] ?? '✨ YAYASAN PENDIDIKAN ISLAM TERPADU ROBBANI' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Hero Banner (School Portal):</label>
                <input type="text" name="school_hero_title" value="{{ $settings['hero_title'] ?? 'Pendidikan Karakter Islami & Keunggulan Akademik Digital' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-extrabold text-slate-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas Hero Banner:</label>
                <textarea name="school_hero_desc" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900">{{ $settings['hero_desc'] ?? 'Sekolah Islam Terpadu Robbani menyelenggarakan pendidikan terpadu...' }}</textarea>
            </div>
        </div>

        <!-- 2. Sambutan Pimpinan & Info SPMB -->
        <div class="space-y-4 border-b border-slate-100 pb-6">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-theme-accent pl-3">Sambutan Pimpinan & Informasi SPMB</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pimpinan / Kepsek:</label>
                    <input type="text" name="principal_name" value="{{ $settings['principal_name'] ?? 'Ustadz Ahmad Fauzi, S.Pd.I, M.Pd' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan Pimpinan:</label>
                    <input type="text" name="principal_title" value="{{ $settings['principal_title'] ?? 'Ketua Yayasan / Kepala Sekolah SIT Robbani' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Teks Sambutan Pimpinan:</label>
                <textarea name="principal_greeting" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900">{{ $settings['principal_greeting'] ?? 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di portal resmi Sekolah Islam Terpadu Robbani.' }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Gelombang SPMB:</label>
                    <input type="text" name="ppdb_status" value="{{ $settings['ppdb_status'] ?? 'GELOMBANG 1 DIBUKA' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-amber-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Ringkas SPMB:</label>
                    <input type="text" name="ppdb_desc" value="{{ $settings['ppdb_desc'] ?? 'Sistem Penerimaan Murid Baru (SPMB) Tahun Ajaran 2026/2027' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900">
                </div>
            </div>
        </div>

        <!-- 3. Kontak & Alamat Sekolah -->
        <div class="space-y-4 border-b border-slate-100 pb-6">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-theme-accent pl-3">Kontak & Alamat Resmi Sekolah</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">No Telepon / WhatsApp Kontak:</label>
                    <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '0812-3456-7890' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi Sekolah:</label>
                    <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'info@robbani.sch.id' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Lengkap Kampus Sekolah:</label>
                <input type="text" name="contact_address" value="{{ $settings['contact_address'] ?? 'Jl. Pendidikan Karakter No. 1-2, Kota Bandung, Jawa Barat' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900">
            </div>
        </div>

        <!-- 4. Sales & Pricing Section Settings (PRESERVED) -->
        <div class="space-y-6 pt-2">
            <div class="flex items-center justify-between border-l-4 border-theme-accent pl-3">
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900">📦 Halaman Sales 21 Modul & Lisensi Produk (/sales)</h3>
                    <p class="text-[11px] text-slate-500 font-normal">Pengaturan harga lisensi paket 1.5jt, 3jt, dan 5.5jt pada halaman sales.</p>
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
                    <label class="block text-xs font-bold text-slate-700 mb-1">Harga Paket Complete Reseller:</label>
                    <input type="text" name="pkg2_price" value="{{ $settings['pkg2_price'] ?? 'Rp 3.000.000' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-theme-accent">
                </div>
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
                        <input type="text" name="pkg1_price" value="{{ $settings['pkg1_price'] ?? 'Rp 1.500.000' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold text-slate-900">
                    </div>
                </div>
            </div>

            <!-- Paket 2 Editor -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <h4 class="font-extrabold text-xs text-slate-900">🔥 Paket 2 (Server + Reseller Affiliate - Best Value)</h4>
                </div>
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
                        <input type="text" name="pkg3_price" value="{{ $settings['pkg3_price'] ?? 'Rp 5.500.000' }}" class="w-full px-3 py-2 rounded-lg border border-slate-300 text-xs font-bold text-slate-900">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-theme-gradient text-white font-extrabold text-xs shadow-lg hover:scale-105 transition-transform">
                Simpan Perubahan Web Settings ➔
            </button>
        </div>
    </form>
</div>

<script>
    function selectThemeRadio(themeName) {
        // Uncheck all radio inputs
        document.querySelectorAll('input[name="website_theme"]').forEach(radio => {
            radio.checked = (radio.value === themeName);
        });

        // Update card styles
        document.querySelectorAll('.theme-option-card').forEach(card => {
            if (card.id === 'card-' + themeName) {
                card.className = 'p-3.5 rounded-2xl border-2 cursor-pointer transition-all space-y-2 text-center theme-option-card border-slate-900 bg-slate-100/80 shadow-md ring-2 ring-slate-900';
            } else {
                card.className = 'p-3.5 rounded-2xl border-2 cursor-pointer transition-all space-y-2 text-center theme-option-card border-slate-200 hover:border-slate-300';
            }
        });

        // Live preview admin theme instantly
        if (typeof setAdminTheme === 'function') {
            setAdminTheme(themeName);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const currentTheme = "{{ $settings['website_theme'] ?? 'theme-emerald' }}";
        selectThemeRadio(currentTheme);
    });
</script>
@endsection
