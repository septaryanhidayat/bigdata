@extends('admin.layout')

@section('title', 'Pengaturan SPMB & Formulir')

@section('content')
<div class="max-w-5xl space-y-6" x-data="spmbCmsApp()">

    <!-- Sub-navigation Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        <a href="{{ route('admin.settings.portal') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            🏛️ Web Portal Sekolah
        </a>
        <a href="{{ route('admin.settings.spmb') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-emerald-700 text-white shadow-md">
            📝 SPMB & Formulir
        </a>
        @if(Auth::user()->isSuperAdmin() || Auth::user()->isYayasan())
        <a href="{{ route('admin.settings.sales') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            📦 Landing Sales Modul
        </a>
        @endif
        <a href="{{ route('admin.settings.units') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            🏢 Profil Unit Sekolah
        </a>
        <a href="{{ route('admin.ppdb-admin.index') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            📋 Data Pendaftar SPMB
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase border border-emerald-300">
                    Modul 13: SPMB Manager & CMS
                </span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                ⚙️ Pengelolaan Konten SPMB & Landing Page
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Kelola fungsi CRUD lengkap: Tambah (+), Edit, dan Hapus (🗑️) untuk Pilihan Unit Sekolah, Program Unggulan, Testimoni, Syarat Berkas, serta Rekening Bank.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('school.spmb') }}" target="_blank" class="px-4 py-2.5 rounded-2xl bg-slate-900 text-amber-300 font-black text-xs shadow-md hover:bg-slate-800 flex items-center gap-1.5 whitespace-nowrap">
                <span>🌐</span> Buka Landing Page ↗
            </a>
            <a href="{{ route('school.spmb.form') }}" target="_blank" class="px-4 py-2.5 rounded-2xl bg-emerald-700 text-white font-black text-xs shadow-md hover:bg-emerald-800 flex items-center gap-1.5 whitespace-nowrap">
                <span>📝</span> Buka Form Isian ↗
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-900 font-bold text-xs flex items-center gap-2">
        <span class="text-base">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Form Setting -->
    <form action="{{ route('admin.settings.spmb.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Tab Selector -->
        <div class="flex flex-wrap gap-2 p-1.5 bg-slate-200/80 rounded-2xl">
            <button type="button" @click="activeTab = 'unit'" :class="activeTab === 'unit' ? 'bg-white text-emerald-900 font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'" class="px-4 py-2 rounded-xl text-xs transition-all">
                🏫 Pilihan Unit & Biaya
            </button>
            <button type="button" @click="activeTab = 'header'" :class="activeTab === 'header' ? 'bg-white text-emerald-900 font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'" class="px-4 py-2 rounded-xl text-xs transition-all">
                📢 Header & Pengumuman
            </button>
            <button type="button" @click="activeTab = 'hero'" :class="activeTab === 'hero' ? 'bg-white text-emerald-900 font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'" class="px-4 py-2 rounded-xl text-xs transition-all">
                🚀 Banner Hero
            </button>
            <button type="button" @click="activeTab = 'program'" :class="activeTab === 'program' ? 'bg-white text-emerald-900 font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'" class="px-4 py-2 rounded-xl text-xs transition-all">
                🌟 Program Unggulan
            </button>
            <button type="button" @click="activeTab = 'syarat'" :class="activeTab === 'syarat' ? 'bg-white text-emerald-900 font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'" class="px-4 py-2 rounded-xl text-xs transition-all">
                📋 Syarat & Rekening Bank
            </button>
            <button type="button" @click="activeTab = 'testi'" :class="activeTab === 'testi' ? 'bg-white text-emerald-900 font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'" class="px-4 py-2 rounded-xl text-xs transition-all">
                💬 Testimoni
            </button>
            <button type="button" @click="activeTab = 'form'" :class="activeTab === 'form' ? 'bg-white text-emerald-900 font-black shadow-sm' : 'text-slate-600 hover:text-slate-900 font-bold'" class="px-4 py-2 rounded-xl text-xs transition-all">
                📝 Formulir Isian SPMB
            </button>
        </div>

        <!-- 1. TAB: PILIHAN UNIT & BIAYA FORMULIR (FULL CRUD) -->
        <div x-show="activeTab === 'unit'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-black text-base text-slate-900">🏫 Kelola Pilihan Unit Sekolah & Biaya Pendaftaran</h3>
                        <p class="text-xs text-slate-500 font-medium">
                            Fungsi CRUD: Anda dapat menambah unit baru (+), mengubah data unit, mengatur nominal biaya formulir, serta menghapus unit yang tidak aktif.
                        </p>
                    </div>
                    <button type="button" @click="addUnit()" class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md flex items-center gap-1.5 self-start sm:self-auto shrink-0">
                        <span>➕</span> Tambah Unit Sekolah
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <template x-for="(unit, index) in units" :key="unit.code">
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4 relative">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase" x-text="'Unit: ' + unit.code"></span>
                                    <input type="hidden" :name="'units[' + unit.code + '][code]'" :value="unit.code">
                                </div>
                                <div class="flex items-center gap-3">
                                    <label class="inline-flex items-center gap-1.5 cursor-pointer text-xs font-bold text-slate-700">
                                        <input type="checkbox" :name="'units[' + unit.code + '][is_active]'" value="1" :checked="unit.is_active" @change="unit.is_active = $event.target.checked" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                        <span>Aktif</span>
                                    </label>
                                    <button type="button" @click="removeUnit(index)" title="Hapus Unit Ini" class="text-rose-600 hover:text-rose-800 text-xs font-black p-1 hover:bg-rose-50 rounded-lg transition-colors">
                                        🗑️ Hapus
                                    </button>
                                </div>
                            </div>

                            <!-- Foto Mascot Preview & Upload -->
                            <div class="flex items-center gap-4">
                                <div class="w-20 h-20 rounded-2xl bg-white border border-slate-200 flex items-center justify-center p-2 shadow-inner shrink-0 overflow-hidden">
                                    <img :src="unit.image.startsWith('/') ? unit.image : '/' + unit.image" :alt="unit.code" class="w-full h-full object-contain" onerror="this.src='/images/logo robbani light.png'">
                                </div>
                                <div class="space-y-1.5 flex-1">
                                    <label class="block text-[11px] font-bold text-slate-700">Ganti Foto / Mascot:</label>
                                    <input type="file" :name="'unit_image_' + unit.code" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200">
                                    <input type="hidden" :name="'units[' + unit.code + '][image]'" :value="unit.image">
                                </div>
                            </div>

                            <div class="space-y-3 text-xs">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Nama Unit:</label>
                                    <input type="text" :name="'units[' + unit.code + '][name]'" x-model="unit.name" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Keterangan Jenjang:</label>
                                        <input type="text" :name="'units[' + unit.code + '][level]'" x-model="unit.level" placeholder="Contoh: SD Islam Terpadu" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                    </div>
                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Badge Usia / Syarat:</label>
                                        <input type="text" :name="'units[' + unit.code + '][age_badge]'" x-model="unit.age_badge" placeholder="Contoh: Usia Min. 6 Tahun" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                    </div>
                                </div>

                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Alamat Unit:</label>
                                    <textarea :name="'units[' + unit.code + '][address]'" x-model="unit.address" rows="2" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600"></textarea>
                                </div>

                                <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200">
                                    <label class="block font-black text-emerald-950 mb-1">Biaya Formulir Pendaftaran (Rp):</label>
                                    <p class="text-[10px] text-emerald-700 mb-1.5">Nominal ini otomatis ditagihkan di formulir pendaftaran unit ini.</p>
                                    <input type="number" :name="'units[' + unit.code + '][fee]'" x-model="unit.fee" step="10000" class="w-full px-3 py-2 rounded-xl bg-white border border-emerald-300 font-mono font-black text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- 2. TAB: HEADER & PENGUMUMAN -->
        <div x-show="activeTab === 'header'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-black text-base text-slate-900">📢 Pengaturan Top Announcement Bar & Header Navigasi</h3>
                    <p class="text-xs text-slate-500 font-medium">Atur informasi gelombang pendaftaran, tanggal dibuka, nomor WhatsApp panitia, dan judul brand header.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Badge Pengumuman:</label>
                        <input type="text" name="spmb_announcement_badge" value="{{ $spmb['announcement_badge'] }}" placeholder="Contoh: Gelombang 1" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Periode Tanggal Pendaftaran:</label>
                        <input type="text" name="spmb_announcement_date" value="{{ $spmb['announcement_date'] }}" placeholder="Contoh: 12 Sept – 31 Des 2026" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor WhatsApp Panitia (Teks):</label>
                        <input type="text" name="spmb_wa_number" value="{{ $spmb['wa_number'] }}" placeholder="Contoh: 0811-747-472" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Link WhatsApp (wa.me/...):</label>
                        <input type="text" name="spmb_wa_link" value="{{ $spmb['wa_link'] }}" placeholder="Contoh: https://wa.me/62811747472" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">Judul Brand Header Navigasi (Singkat agar tidak terpotong):</label>
                        <input type="text" name="spmb_brand_title" value="{{ $spmb['brand_title'] }}" placeholder="Contoh: SPMB ROBBANI" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-black focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        <p class="text-[11px] text-slate-400 mt-1">Disarankan teks singkat 2 kata seperti "SPMB ROBBANI" agar navbar tetap rapi dan tidak terpotong di layar HP.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. TAB: BANNER HERO UTAMA -->
        <div x-show="activeTab === 'hero'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-black text-base text-slate-900">🚀 Pengaturan Banner Hero Utama</h3>
                    <p class="text-xs text-slate-500 font-medium">Atur judul besar, penjelasan, foto ilustrasi anak/santri hero, dan 3 poin kemudahan pendaftaran.</p>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Badge Kecil Atas Hero:</label>
                        <input type="text" name="spmb_hero_badge" value="{{ $spmb['hero_badge'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Besar Hero (H1):</label>
                        <input type="text" name="spmb_hero_title" value="{{ $spmb['hero_title'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-black text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi / Penjelasan Hero:</label>
                        <textarea name="spmb_hero_desc" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 leading-relaxed focus:outline-none focus:ring-2 focus:ring-emerald-600">{{ $spmb['hero_desc'] }}</textarea>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center gap-4">
                        <div class="w-24 h-24 rounded-2xl bg-emerald-900 flex items-center justify-center p-2 shrink-0 overflow-hidden">
                            <img src="{{ asset(ltrim($spmb['hero_image'], '/')) }}" alt="Hero Santri" class="w-full h-full object-contain">
                        </div>
                        <div class="space-y-1.5 flex-1">
                            <label class="block font-bold text-slate-700">Foto Ilustrasi Siswa / Santri Hero:</label>
                            <input type="file" name="spmb_hero_image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-700 file:text-white hover:file:bg-emerald-800">
                            <input type="hidden" name="spmb_hero_image" value="{{ $spmb['hero_image'] }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Poin Kemudahan 1:</label>
                            <input type="text" name="spmb_hero_point1" value="{{ $spmb['hero_point1'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Poin Kemudahan 2:</label>
                            <input type="text" name="spmb_hero_point2" value="{{ $spmb['hero_point2'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Poin Kemudahan 3:</label>
                            <input type="text" name="spmb_hero_point3" value="{{ $spmb['hero_point3'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. TAB: PROGRAM UNGGULAN (FULL CRUD) -->
        <div x-show="activeTab === 'program'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-black text-base text-slate-900">🌟 Kelola Program Unggulan Sekolah</h3>
                        <p class="text-xs text-slate-500 font-medium">Fungsi CRUD: Tambah program baru (+), edit judul & deskripsi, unggah ikon/gambar, atau hapus program.</p>
                    </div>
                    <button type="button" @click="addProgram()" class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md flex items-center gap-1.5 self-start sm:self-auto shrink-0">
                        <span>➕</span> Tambah Program Unggulan
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs mb-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Section Program:</label>
                        <input type="text" name="spmb_program_title" value="{{ $spmb['program_title'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Singkat:</label>
                        <input type="text" name="spmb_program_desc" value="{{ $spmb['program_desc'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>

                <div class="space-y-4">
                    <template x-for="(prog, index) in programs" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center gap-4 relative">
                            <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 flex items-center justify-center p-2 shrink-0 overflow-hidden">
                                <img :src="prog.image.startsWith('/') ? prog.image : '/' + prog.image" :alt="prog.title" class="w-full h-full object-contain" onerror="this.src='/images/logo robbani light.png'">
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 flex-1 text-xs w-full">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1" x-text="'Nama Program #' + (index + 1) + ':'"></label>
                                    <input type="text" :name="'programs[' + index + '][title]'" x-model="prog.title" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Keterangan Singkat:</label>
                                    <input type="text" :name="'programs[' + index + '][desc]'" x-model="prog.desc" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Ganti Ikon / Gambar:</label>
                                    <input type="file" :name="'program_image_' + index" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-slate-200 file:text-slate-800">
                                    <input type="hidden" :name="'programs[' + index + '][image]'" :value="prog.image">
                                </div>
                                <div class="flex items-end justify-end">
                                    <button type="button" @click="removeProgram(index)" class="px-3 py-2 rounded-xl bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-xs flex items-center gap-1 transition-colors">
                                        🗑️ Hapus Program Ini
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- 5. TAB: SYARAT BERKAS & REKENING PEMBAYARAN (FULL CRUD) -->
        <div x-show="activeTab === 'syarat'" class="space-y-6">
            <!-- Kelengkapan Berkas CRUD -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-black text-base text-slate-900">📋 Pengaturan Syarat & Kelengkapan Berkas</h3>
                        <p class="text-xs text-slate-500 font-medium">Fungsi CRUD: Tambah syarat dokumen baru (+), ubah keterangan, tandai wajib/opsional, atau hapus syarat.</p>
                    </div>
                    <button type="button" @click="addSyarat()" class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md flex items-center gap-1.5 self-start sm:self-auto shrink-0">
                        <span>➕</span> Tambah Syarat Dokumen
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Kelengkapan Berkas:</label>
                        <input type="text" name="spmb_syarat_title" value="{{ $spmb['syarat_title'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Subjudul Berkas:</label>
                        <input type="text" name="spmb_syarat_desc" value="{{ $spmb['syarat_desc'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">Pesan Tips untuk Orang Tua:</label>
                        <textarea name="spmb_syarat_tips" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 leading-relaxed focus:outline-none focus:ring-2 focus:ring-emerald-600">{{ $spmb['syarat_tips'] }}</textarea>
                    </div>
                </div>

                <div class="space-y-3 pt-2">
                    <h4 class="font-black text-xs text-slate-800 uppercase tracking-wider">Daftar Berkas Pendaftaran:</h4>
                    <template x-for="(s, index) in syaratItems" :key="index">
                        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center gap-3 text-xs">
                            <div class="flex-1 space-y-2 w-full">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <input type="text" :name="'syarat_items[' + index + '][title]'" x-model="s.title" placeholder="Nama Dokumen (misal: Akta Kelahiran)" class="w-full px-3 py-1.5 rounded-xl bg-white border border-slate-300 font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                                    <input type="text" :name="'syarat_items[' + index + '][desc]'" x-model="s.desc" placeholder="Keterangan singkat dokumen" class="w-full px-3 py-1.5 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                </div>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <label class="inline-flex items-center gap-1.5 cursor-pointer font-bold text-slate-700 text-xs">
                                    <input type="checkbox" :name="'syarat_items[' + index + '][is_mandatory]'" value="1" :checked="s.is_mandatory" @change="s.is_mandatory = $event.target.checked" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                    <span>Wajib</span>
                                </label>
                                <button type="button" @click="removeSyarat(index)" title="Hapus Dokumen Ini" class="text-rose-600 hover:text-rose-800 text-xs font-bold p-1 hover:bg-rose-50 rounded-lg">
                                    🗑️ Hapus
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Rekening Bank CRUD -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-black text-base text-slate-900">💳 Rekening Resmi Pembayaran Formulir</h3>
                        <p class="text-xs text-slate-500 font-medium">Fungsi CRUD: Tambah nomor rekening baru (+), edit rekening, atau hapus rekening bank yayasan.</p>
                    </div>
                    <button type="button" @click="addBank()" class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md flex items-center gap-1.5 self-start sm:self-auto shrink-0">
                        <span>➕</span> Tambah Rekening Bank
                    </button>
                </div>

                <div class="space-y-3">
                    <template x-for="(b, index) in banks" :key="index">
                        <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-200 text-emerald-900 font-black text-[10px] uppercase" x-text="'Rekening #' + (index + 1)"></span>
                                <button type="button" @click="removeBank(index)" class="text-rose-600 hover:text-rose-800 text-xs font-bold p-1 hover:bg-rose-100 rounded-lg">
                                    🗑️ Hapus Rekening
                                </button>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Nama Bank:</label>
                                    <input type="text" :name="'banks[' + index + '][bank_name]'" x-model="b.bank_name" placeholder="Contoh: Bank Syariah Indonesia" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Nomor Rekening:</label>
                                    <input type="text" :name="'banks[' + index + '][account_number]'" x-model="b.account_number" placeholder="Nomor Rekening" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-mono font-black text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Atas Nama Rekening:</label>
                                    <input type="text" :name="'banks[' + index + '][account_holder]'" x-model="b.account_holder" placeholder="Atas Nama" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1 text-xs">Catatan Tambahan Pembayaran:</label>
                    <input type="text" name="spmb_payment_note" value="{{ $spmb['payment_note'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600 text-xs">
                </div>
            </div>
        </div>

        <!-- 6. TAB: TESTIMONI (FULL CRUD) -->
        <div x-show="activeTab === 'testi'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="font-black text-base text-slate-900">💬 Kelola Testimoni Orang Tua Siswa</h3>
                        <p class="text-xs text-slate-500 font-medium">Fungsi CRUD: Tambah ulasan baru (+), edit nama & kutipan, atau hapus testimoni.</p>
                    </div>
                    <button type="button" @click="addTestimonial()" class="px-4 py-2 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md flex items-center gap-1.5 self-start sm:self-auto shrink-0">
                        <span>➕</span> Tambah Testimoni Baru
                    </button>
                </div>

                <div class="space-y-4">
                    <template x-for="(testi, index) in testimonials" :key="index">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 text-xs relative">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-200 text-slate-800 font-black text-[10px] uppercase" x-text="'Testimoni #' + (index + 1)"></span>
                                <button type="button" @click="removeTestimonial(index)" class="text-rose-600 hover:text-rose-800 text-xs font-bold p-1 hover:bg-rose-100 rounded-lg">
                                    🗑️ Hapus Testimoni
                                </button>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Nama Wali Murid:</label>
                                    <input type="text" :name="'testimonials[' + index + '][name]'" x-model="testi.name" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Jabatan / Profesi / Wali Siswa:</label>
                                    <input type="text" :name="'testimonials[' + index + '][role]'" x-model="testi.role" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                </div>
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Isi Kutipan Testimoni:</label>
                                <textarea :name="'testimonials[' + index + '][quote]'" x-model="testi.quote" rows="3" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 leading-relaxed focus:outline-none focus:ring-2 focus:ring-emerald-600" required></textarea>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- 7. TAB: FORMULIR ISIAN SPMB -->
        <div x-show="activeTab === 'form'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-black text-base text-slate-900">📝 Pengaturan Teks Formulir Isian SPMB (/spmb/daftar)</h3>
                    <p class="text-xs text-slate-500 font-medium">Atur judul form, kode formulir, dan petunjuk yang muncul di bagian paling atas form pendaftaran.</p>
                </div>

                <div class="space-y-4 text-xs">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Badge Kode Formulir:</label>
                        <input type="text" name="spmb_form_badge" value="{{ $spmb['form_badge'] }}" placeholder="Contoh: F-SPMB 2026-2027 / 2027-2028" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Formulir:</label>
                        <input type="text" name="spmb_form_title" value="{{ $spmb['form_title'] }}" placeholder="Contoh: Formulir Penerimaan Peserta Didik Baru" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-black text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Petunjuk / Subjudul Formulir:</label>
                        <textarea name="spmb_form_desc" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 leading-relaxed focus:outline-none focus:ring-2 focus:ring-emerald-600">{{ $spmb['form_desc'] }}</textarea>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-950 space-y-1">
                        <strong class="font-black text-xs block">💡 Sinkronisasi Otomatis dengan Sistem SmartEdu:</strong>
                        <p class="text-[11px] leading-relaxed">
                            Biaya pendaftaran masing-masing unit sekolah diatur pada <strong>Tab "Pilihan Unit & Biaya"</strong>. Ketika nominal diubah di tab tersebut, nominal yang ditagihkan di formulir pendaftaran serta modul Keuangan SPP otomatis disinkronkan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Submit Button -->
        <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-300 shadow-xl flex items-center justify-between gap-4">
            <div class="hidden sm:block text-xs text-slate-500 font-semibold">
                Perubahan CRUD akan langsung diterapkan ke Landing Page & Formulir SPMB publik.
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.settings.spmb') }}" class="px-5 py-3 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors">
                    Reset
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-lg shadow-emerald-700/25 transition-all transform hover:-translate-y-0.5">
                    💾 Simpan Semua Perubahan (CRUD)
                </button>
            </div>
        </div>

    </form>

</div>

<script>
function spmbCmsApp() {
    return {
        activeTab: 'unit',
        units: @json(array_values($spmb['units'])),
        programs: @json($spmb['programs']),
        testimonials: @json($spmb['testimonials']),
        syaratItems: @json($spmb['syarat_items'] ?? []),
        banks: @json($spmb['banks'] ?? []),

        addUnit() {
            const rawCode = prompt('Masukkan Kode Singkatan Unit Baru (contoh: DAYCARE, MA, SMK):');
            if (!rawCode) return;
            const codeUpper = rawCode.trim().toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (!codeUpper) {
                alert('Kode unit tidak valid!');
                return;
            }
            if (this.units.some(u => u.code === codeUpper)) {
                alert('Kode unit ' + codeUpper + ' sudah ada di daftar!');
                return;
            }
            this.units.push({
                code: codeUpper,
                name: codeUpper + ' ROBBANI',
                level: codeUpper + ' Islam Terpadu',
                age_badge: 'Usia Standar',
                address: 'Kampus Terpadu ROBBANI Ogan Ilir',
                fee: 450000,
                color: 'emerald',
                image: '/images/spmb/sd.png',
                is_active: true
            });
            alert('✓ Unit ' + codeUpper + ' berhasil ditambahkan ke daftar! Silakan lengkapi data dan klik Simpan.');
        },

        removeUnit(index) {
            const u = this.units[index];
            if (confirm('Yakin ingin menghapus unit ' + (u.name || u.code) + ' dari daftar pilihan landing page?')) {
                this.units.splice(index, 1);
            }
        },

        addProgram() {
            this.programs.push({
                title: 'Program Unggulan Baru',
                desc: 'Keterangan keunggulan program pendidikan',
                image: '/images/spmb/kurikulum.png'
            });
        },

        removeProgram(index) {
            if (confirm('Yakin ingin menghapus program ini?')) {
                this.programs.splice(index, 1);
            }
        },

        addTestimonial() {
            this.testimonials.push({
                name: 'Nama Wali Murid',
                role: 'Wali Murid Siswa',
                quote: 'Kesan dan pengalaman positif menyekolahkan ananda di SIT Robbani.',
                initials: 'WM'
            });
        },

        removeTestimonial(index) {
            if (confirm('Yakin ingin menghapus testimoni ini?')) {
                this.testimonials.splice(index, 1);
            }
        },

        addSyarat() {
            this.syaratItems.push({
                title: 'Nama Dokumen / Syarat',
                desc: 'Foto asli atau fotokopi 1 lembar yang terbaca jelas',
                is_mandatory: true
            });
        },

        removeSyarat(index) {
            if (confirm('Yakin ingin menghapus berkas syarat ini?')) {
                this.syaratItems.splice(index, 1);
            }
        },

        addBank() {
            this.banks.push({
                bank_name: 'Bank Syariah Indonesia (BSI)',
                account_number: '1234567890',
                account_holder: 'YAYASAN GENERASI ROBBANI'
            });
        },

        removeBank(index) {
            if (confirm('Yakin ingin menghapus rekening bank ini?')) {
                this.banks.splice(index, 1);
            }
        }
    }
}
</script>
@endsection
