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
            📦 Landing Sales 25 Modul
        </a>
        <a href="{{ route('admin.settings.units') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            🏢 Profil Unit Sekolah (SDIT/SMPIT/SMAIT)
        </a>
    </div>

    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Pengaturan Website Utama Sekolah (`/`)</h1>
        <p class="text-xs text-slate-600 font-medium mt-1">Atur skema warna tema, identitas sekolah, hero banner, sambutan pimpinan, dan kontak resmi yayasan.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6">
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

        <!-- 0.5 Upload Logo Light Mode & Dark Mode -->
        <div class="space-y-4 border-b border-slate-100 pb-6">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-theme-accent pl-3">🏷️ Upload Logo Resmi Website (Mode Light &amp; Mode Dark)</h3>
            <p class="text-xs text-slate-500 font-medium">Unggah logo resmi sekolah untuk mode terang dan mode malam. Sistem otomatis mengompresi gambar tanpa merusak transparansi PNG!</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- 1. Logo Light Mode -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">☀️ Logo Mode Terang (Light Mode):</label>
                        <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded">Default / Full Color</span>
                    </div>

                    <div class="h-24 rounded-xl overflow-hidden border border-slate-300 relative bg-white flex items-center justify-center p-3 shadow-inner">
                        <img id="logoLightPreview" src="{{ $settings['logo_light'] ?? '/images/logo robbani light.png' }}" alt="Logo Light Preview" class="max-h-full max-w-full object-contain">
                        <span id="logoLightBadge" class="hidden absolute top-2 left-2 bg-emerald-600 text-white text-[10px] font-black px-2 py-0.5 rounded shadow animate-pulse">PRATINJAU BARU</span>
                    </div>

                    <input type="file" id="logoLightFileInput" name="logo_light_file" accept="image/*" class="text-xs text-slate-600 border border-slate-300 rounded-xl p-2 w-full cursor-pointer bg-white" onchange="processLogoFile(this, 'logoLightPreview', 'logoLightBase64Input', 'logoLightBadge')">
                    <input type="hidden" id="logoLightBase64Input" name="logo_light_base64">
                    <span class="text-[10px] text-slate-500 block">Tampil saat mode terang. Format PNG transparan direkomendasikan.</span>
                </div>

                <!-- 2. Logo Dark Mode -->
                <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 text-white space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-black text-emerald-400 uppercase tracking-wider">🌙 Logo Mode Malam (Dark Mode):</label>
                        <span class="text-[10px] bg-slate-800 text-emerald-300 font-bold px-2 py-0.5 rounded">Solid White / Transparent</span>
                    </div>

                    <div class="h-24 rounded-xl overflow-hidden border border-slate-700 relative bg-[#071208] flex items-center justify-center p-3 shadow-inner">
                        <img id="logoDarkPreview" src="{{ $settings['logo_dark'] ?? '/images/logo robbani dark.png' }}" alt="Logo Dark Preview" class="max-h-full max-w-full object-contain">
                        <span id="logoDarkBadge" class="hidden absolute top-2 left-2 bg-emerald-500 text-slate-950 text-[10px] font-black px-2 py-0.5 rounded shadow animate-pulse">PRATINJAU BARU</span>
                    </div>

                    <input type="file" id="logoDarkFileInput" name="logo_dark_file" accept="image/*" class="text-xs text-slate-300 border border-slate-700 rounded-xl p-2 w-full cursor-pointer bg-slate-800" onchange="processLogoFile(this, 'logoDarkPreview', 'logoDarkBase64Input', 'logoDarkBadge')">
                    <input type="hidden" id="logoDarkBase64Input" name="logo_dark_base64">
                    <span class="text-[10px] text-slate-400 block">Tampil saat mode malam/gelap aktif di website.</span>
                </div>
            </div>
        </div>

        <!-- 0.6 Upload Favicon & Social Share Image -->
        <div class="space-y-4 border-b border-slate-100 pb-6">
            <h3 class="font-extrabold text-sm text-slate-900 border-l-4 border-theme-accent pl-3">🔖 Upload Favicon Tab Browser &amp; Gambar Sharing Sosmed (OG Image)</h3>
            <p class="text-xs text-slate-500 font-medium">Unggah favicon khusus tab browser dan gambar thumbnail yang muncul saat tautan website dibagikan di WhatsApp, Facebook, Telegram, dll.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- 1. Favicon Upload -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">🔖 Favicon Tab Browser:</label>
                        <span class="text-[10px] bg-teal-100 text-teal-800 font-bold px-2 py-0.5 rounded">Icon Tab Browser</span>
                    </div>

                    <div class="h-20 rounded-xl overflow-hidden border border-slate-300 relative bg-white flex items-center justify-center p-3 shadow-inner">
                        <img id="faviconPreview" src="{{ $settings['website_favicon'] ?? '/favicon.png' }}" alt="Favicon Preview" class="w-10 h-10 object-contain">
                        <span id="faviconBadge" class="hidden absolute top-2 left-2 bg-emerald-600 text-white text-[10px] font-black px-2 py-0.5 rounded shadow animate-pulse">BARU</span>
                    </div>

                    <input type="file" id="faviconFileInput" name="favicon_file" accept="image/*" class="text-xs text-slate-600 border border-slate-300 rounded-xl p-2 w-full cursor-pointer bg-white" onchange="processLogoFile(this, 'faviconPreview', 'faviconBase64Input', 'faviconBadge')">
                    <input type="hidden" id="faviconBase64Input" name="favicon_base64">
                    <span class="text-[10px] text-slate-500 block">Digunakan di ikon tab browser seluruh halaman website. Format PNG/ICO disarankan.</span>
                </div>

                <!-- 2. Social Share Image Upload -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">📱 Gambar Sharing Sosmed (OG Image):</label>
                        <span class="text-[10px] bg-blue-100 text-blue-800 font-bold px-2 py-0.5 rounded">WhatsApp / FB Thumbnail</span>
                    </div>

                    <div class="h-20 rounded-xl overflow-hidden border border-slate-300 relative bg-slate-100 flex items-center justify-center p-2 shadow-inner">
                        <img id="socialSharePreview" src="{{ $settings['social_share_image'] ?? '/images/logo robbani light.png' }}" alt="Social Share Preview" class="max-h-full max-w-full object-contain">
                        <span id="socialShareBadge" class="hidden absolute top-2 left-2 bg-emerald-600 text-white text-[10px] font-black px-2 py-0.5 rounded shadow animate-pulse">BARU</span>
                    </div>

                    <input type="file" id="socialShareFileInput" name="social_share_file" accept="image/*" class="text-xs text-slate-600 border border-slate-300 rounded-xl p-2 w-full cursor-pointer bg-white" onchange="processLogoFile(this, 'socialSharePreview', 'socialShareBase64Input', 'socialShareBadge')">
                    <input type="hidden" id="socialShareBase64Input" name="social_share_base64">
                    <span class="text-[10px] text-slate-500 block">Tampil sebagai pratinjau thumbnail saat link web dikirim melalui WhatsApp / Medsos.</span>
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

            <!-- Hero Banner Background Image & Opacity Control -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
                <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                    <span>🖼️</span> <span>Foto Background Hero Banner &amp; Kontrol Transparansi Opacity Overlay</span>
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Ganti Foto Background Banner (Pilih Foto dari Komputer):</label>
                        <div class="mb-2 h-32 rounded-xl overflow-hidden border border-slate-300 relative bg-slate-100 shadow-inner">
                            <img id="heroBgPreview" src="{{ !empty($settings['hero_bg_image']) ? $settings['hero_bg_image'] : asset('uploads/media/banner hero.webp') }}" alt="Current Hero Banner" class="w-full h-full object-cover">
                            <span id="previewBadge" class="hidden absolute top-2 left-2 bg-emerald-600 text-white text-[10px] font-black px-2.5 py-1 rounded-lg shadow-md animate-pulse">PRATINJAU FOTO BARU (SIAP DISIMPAN)</span>
                        </div>
                        <input type="file" id="heroBgFileInput" name="hero_bg_file" accept="image/*" class="text-xs text-slate-600 border border-slate-300 rounded-xl p-2 w-full cursor-pointer bg-white hover:bg-slate-50 transition-colors" onchange="processHeroBgFile(this)">
                        
                        <!-- Hidden Input for Compressed Data Payload -->
                        <input type="hidden" id="heroBgBase64Input" name="hero_bg_base64">
                        
                        <span class="text-[10px] text-slate-500 block mt-1">Pilih file foto dari komputer. Sistem otomatis mengompresi di browser &amp; diproses cepat tanpa batasan ukuran file!</span>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">URL Foto Background (Alternatif Link Teks):</label>
                        <input type="text" id="heroBgUrlInput" name="hero_bg_image" value="{{ $settings['hero_bg_image'] ?? '' }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-900 mb-3" oninput="document.getElementById('heroBgPreview').src = this.value">

                        <label class="block text-xs font-bold text-slate-700 mb-1">
                            Kepekatan Transparansi Overlay Banner:
                            <span id="opacityVal" class="text-emerald-700 font-black">{{ $settings['hero_banner_opacity'] ?? '70' }}%</span>
                        </label>
                        <input type="range" name="hero_banner_opacity" min="0" max="100" value="{{ $settings['hero_banner_opacity'] ?? '70' }}" oninput="document.getElementById('opacityVal').innerText = this.value + '%'" class="w-full h-2 bg-slate-300 rounded-lg appearance-none cursor-pointer accent-emerald-600">
                        <span class="text-[10px] text-slate-500 block mt-1">Geser slider untuk menyesuaikan opacity layar gelap banner secara real-time.</span>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function processHeroBgFile(input) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const img = new Image();
                        img.onload = function() {
                            // HTML5 Canvas client-side compression
                            const canvas = document.createElement('canvas');
                            const maxW = 1600;
                            let width = img.width;
                            let height = img.height;

                            if (width > maxW) {
                                height = Math.round((height * maxW) / width);
                                width = maxW;
                            }

                            canvas.width = width;
                            canvas.height = height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, width, height);

                            // Convert image to WebP Data URL at 80% quality
                            const compressedBase64 = canvas.toDataURL('image/webp', 0.80);
                            
                            // Update live preview & hidden input field
                            const previewImg = document.getElementById('heroBgPreview');
                            const badge = document.getElementById('previewBadge');
                            const base64Input = document.getElementById('heroBgBase64Input');
                            const urlInput = document.getElementById('heroBgUrlInput');

                            if (previewImg) previewImg.src = compressedBase64;
                            if (base64Input) base64Input.value = compressedBase64;
                            if (badge) badge.classList.remove('hidden');
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>

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

            <!-- Upload Foto Resmi Pimpinan / Ketua Yayasan -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">👤 Foto Resmi Ketua Yayasan / Kepala Sekolah:</label>
                
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="w-24 h-24 rounded-full overflow-hidden border-4 border-emerald-600 p-0.5 bg-white shrink-0 relative shadow">
                        <img id="principalPhotoPreview" src="{{ $settings['principal_photo'] ?? '/images/logo robbani light.png' }}" alt="Foto Ketua Yayasan" class="w-full h-full object-cover rounded-full">
                        <span id="principalPhotoBadge" class="hidden absolute top-0 left-0 bg-emerald-600 text-white text-[9px] font-black px-1.5 py-0.5 rounded shadow animate-pulse">BARU</span>
                    </div>
                    <div class="space-y-2 flex-1 w-full">
                        <input type="file" id="principalPhotoFileInput" name="principal_photo_file" accept="image/*" class="text-xs text-slate-600 border border-slate-300 rounded-xl p-2 w-full cursor-pointer bg-white" onchange="processLogoFile(this, 'principalPhotoPreview', 'principalPhotoBase64Input', 'principalPhotoBadge')">
                        <input type="hidden" id="principalPhotoBase64Input" name="principal_photo_base64">
                        <span class="text-[10px] text-slate-500 block">Unggah foto resmi Ketua Yayasan / Pimpinan Sekolah. Sistem otomatis mengompresi di browser!</span>
                    </div>
                </div>
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

    function processLogoFile(input, previewId, base64InputId, badgeId) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const maxW = 1200;
                    let width = img.width;
                    let height = img.height;

                    if (width > maxW) {
                        height = Math.round((height * maxW) / width);
                        width = maxW;
                    }

                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);

                    const compressedBase64 = canvas.toDataURL('image/png');

                    const previewImg = document.getElementById(previewId);
                    const base64Input = document.getElementById(base64InputId);
                    const badge = document.getElementById(badgeId);

                    if (previewImg) previewImg.src = compressedBase64;
                    if (base64Input) base64Input.value = compressedBase64;
                    if (badge) badge.classList.remove('hidden');
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const currentTheme = "{{ $settings['website_theme'] ?? 'theme-emerald' }}";
        selectThemeRadio(currentTheme);
    });
</script>
@endsection
