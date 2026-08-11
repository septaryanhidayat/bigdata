@extends('admin.layout')

@section('title', 'Pengaturan Web Portal Sekolah')

@section('content')
<div class="max-w-4xl space-y-6">
    <!-- Sub-navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 pb-3">
        <a href="{{ route('admin.settings.portal') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-theme-gradient text-white shadow-md">
            🏛️ Web Portal Sekolah
        </a>
        <a href="{{ route('admin.settings.sales') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            📦 Landing Sales 21 Modul
        </a>
        <a href="{{ route('admin.settings.units') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            🏢 Profil Unit Sekolah (SDIT/SMPIT/SMAIT)
        </a>
    </div>

    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Website Utama Sekolah (`/`)</h1>
        <p class="text-xs text-slate-600 font-medium mt-1">Atur skema warna tema, identitas sekolah, hero banner, sambutan pimpinan, dan kontak resmi yayasan.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <!-- 0. Pilihan Warna Tema Website Publik Sekolah & Admin -->
        <div class="space-y-4 border-b border-slate-100 pb-6">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-theme-accent pl-3">🎨 Opsi Pilihan Tema Warna Sistem (Website & Admin)</h3>
            <p class="text-xs text-slate-500 font-medium">Klik salah satu dari 5 paket warna di bawah ini untuk mengubah tema warna sistem secara langsung:</p>

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
                <input type="text" name="school_hero_badge" value="{{ $settings['school_hero_badge'] ?? '✨ YAYASAN PENDIDIKAN ISLAM TERPADU ROBBANI' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Judul Utama Hero Banner (School Portal):</label>
                <input type="text" name="school_hero_title" value="{{ $settings['school_hero_title'] ?? 'Pendidikan Karakter Islami & Keunggulan Akademik Digital' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-extrabold text-slate-900">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi Ringkas Hero Banner:</label>
                <textarea name="school_hero_desc" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900">{{ $settings['school_hero_desc'] ?? 'Sekolah Islam Terpadu Robbani menyelenggarakan pendidikan terpadu...' }}</textarea>
            </div>
        </div>

        <!-- 2. Sambutan Pimpinan & Info PPDB -->
        <div class="space-y-4 border-b border-slate-100 pb-6">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-theme-accent pl-3">Sambutan Pimpinan & Informasi PPDB</h3>

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
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Gelombang PPDB:</label>
                    <input type="text" name="ppdb_status" value="{{ $settings['ppdb_status'] ?? 'GELOMBANG 1 DIBUKA' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-amber-600">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan Ringkas PPDB:</label>
                    <input type="text" name="ppdb_desc" value="{{ $settings['ppdb_desc'] ?? 'Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2026/2027' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900">
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

        <div class="pt-4 flex justify-end">
            <button type="submit" class="px-6 py-3 rounded-xl bg-theme-gradient text-white font-extrabold text-xs shadow-lg hover:scale-105 transition-transform">
                Simpan Perubahan Web Portal ➔
            </button>
        </div>
    </form>
</div>

<script>
    function selectThemeRadio(themeName) {
        document.querySelectorAll('input[name="website_theme"]').forEach(radio => {
            radio.checked = (radio.value === themeName);
        });

        document.querySelectorAll('.theme-option-card').forEach(card => {
            if (card.id === 'card-' + themeName) {
                card.className = 'p-3.5 rounded-2xl border-2 cursor-pointer transition-all space-y-2 text-center theme-option-card border-slate-900 bg-slate-100/80 shadow-md ring-2 ring-slate-900';
            } else {
                card.className = 'p-3.5 rounded-2xl border-2 cursor-pointer transition-all space-y-2 text-center theme-option-card border-slate-200 hover:border-slate-300';
            }
        });

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
