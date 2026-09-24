@extends('admin.layout')

@section('title', 'Pengaturan SPMB & Formulir PPDB')

@section('content')
<div class="max-w-5xl space-y-6" x-data="{ activeTab: 'unit' }">

    <!-- Sub-navigation Tabs -->
    <div class="flex flex-wrap items-center gap-2 border-b border-slate-200 pb-3">
        <a href="{{ route('admin.settings.portal') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-slate-100 text-slate-700 hover:bg-slate-200 transition-colors">
            🏛️ Web Portal Sekolah
        </a>
        <a href="{{ route('admin.settings.spmb') }}" class="px-4 py-2 rounded-xl text-xs font-black bg-emerald-700 text-white shadow-md">
            📝 SPMB & Formulir PPDB
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
            📋 Data Pendaftar PPDB
        </a>
    </div>

    <!-- Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase border border-emerald-300">
                    Modul 13: SPMB / PPDB Manager
                </span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                ⚙️ Pengaturan Konten SPMB & Formulir PPDB
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Kelola semua konten teks, informasi unit, biaya formulir, banner hero, rekening pembayaran, dan formulir isian secara dinamis.
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
                📝 Formulir Isian PPDB
            </button>
        </div>

        <!-- 1. TAB: PILIHAN UNIT & BIAYA FORMULIR -->
        <div x-show="activeTab === 'unit'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-black text-base text-slate-900">🏫 Kelola 6 Pilihan Unit Sekolah & Biaya Pendaftaran</h3>
                    <p class="text-xs text-slate-500 font-medium">
                        Atur nama unit, badge usia/kategori, alamat, mascot/foto, dan nominal biaya pendaftaran yang akan dihitung otomatis pada formulir isian pendaftaran.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($spmb['units'] as $code => $unit)
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4 relative">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-emerald-100 text-emerald-800 uppercase">
                                Unit: {{ $code }}
                            </span>
                            <label class="inline-flex items-center gap-2 cursor-pointer text-xs font-bold text-slate-700">
                                <input type="checkbox" name="units[{{ $code }}][is_active]" value="1" {{ ($unit['is_active'] ?? true) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                <span>Buka Pendaftaran</span>
                            </label>
                        </div>

                        <!-- Foto Mascot Preview & Upload -->
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 rounded-2xl bg-white border border-slate-200 flex items-center justify-center p-2 shadow-inner shrink-0 overflow-hidden">
                                <img src="{{ asset($unit['image'] ?? '') }}" alt="{{ $code }}" class="w-full h-full object-contain">
                            </div>
                            <div class="space-y-1.5 flex-1">
                                <label class="block text-[11px] font-bold text-slate-700">Ganti Foto / Mascot:</label>
                                <input type="file" name="unit_image_{{ $code }}" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-emerald-100 file:text-emerald-800 hover:file:bg-emerald-200">
                                <input type="hidden" name="units[{{ $code }}][image]" value="{{ $unit['image'] ?? '' }}">
                            </div>
                        </div>

                        <div class="space-y-3 text-xs">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Unit:</label>
                                <input type="text" name="units[{{ $code }}][name]" value="{{ $unit['name'] ?? '' }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Keterangan Jenjang:</label>
                                    <input type="text" name="units[{{ $code }}][level]" value="{{ $unit['level'] ?? '' }}" placeholder="Contoh: SD Islam Terpadu" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                </div>
                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Badge Usia / Syarat:</label>
                                    <input type="text" name="units[{{ $code }}][age_badge]" value="{{ $unit['age_badge'] ?? '' }}" placeholder="Contoh: Usia Min. 6 Tahun" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                                </div>
                            </div>

                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Alamat Unit:</label>
                                <textarea name="units[{{ $code }}][address]" rows="2" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">{{ $unit['address'] ?? '' }}</textarea>
                            </div>

                            <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-200">
                                <label class="block font-black text-emerald-950 mb-1">Biaya Formulir Pendaftaran (Rp):</label>
                                <p class="text-[10px] text-emerald-700 mb-1.5">Nominal ini otomatis muncul dan ditagihkan saat calon siswa mengisi formulir pendaftaran.</p>
                                <input type="number" name="units[{{ $code }}][fee]" value="{{ $unit['fee'] ?? 350000 }}" step="10000" class="w-full px-3 py-2 rounded-xl bg-white border border-emerald-300 font-mono font-black text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                            </div>
                        </div>
                    </div>
                    @endforeach
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
                        <div class="w-24 h-24 rounded-2xl bg-emerald-900 flex items-center justify-center p-2 shrink-0">
                            <img src="{{ asset($spmb['hero_image']) }}" alt="Hero Santri" class="w-full h-full object-contain">
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

        <!-- 4. TAB: PROGRAM UNGGULAN -->
        <div x-show="activeTab === 'program'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-black text-base text-slate-900">🌟 Pengaturan 5 Program Unggulan Sekolah</h3>
                    <p class="text-xs text-slate-500 font-medium">Ubah judul, deskripsi, dan ikon program keunggulan SIT Robbani.</p>
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
                    @foreach($spmb['programs'] as $idx => $prog)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center gap-4">
                        <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 flex items-center justify-center p-2 shrink-0 overflow-hidden">
                            <img src="{{ asset($prog['image'] ?? '') }}" alt="Prog {{ $idx }}" class="w-full h-full object-contain">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 flex-1 text-xs w-full">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Program {{ $idx + 1 }}:</label>
                                <input type="text" name="programs[{{ $idx }}][title]" value="{{ $prog['title'] ?? '' }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Keterangan:</label>
                                <input type="text" name="programs[{{ $idx }}][desc]" value="{{ $prog['desc'] ?? '' }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block font-bold text-slate-700 mb-1">Ganti Ikon / Gambar:</label>
                                <input type="file" name="program_image_{{ $idx }}" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-xl file:border-0 file:text-[11px] file:font-bold file:bg-slate-200 file:text-slate-800">
                                <input type="hidden" name="programs[{{ $idx }}][image]" value="{{ $prog['image'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 5. TAB: SYARAT & REKENING PEMBAYARAN -->
        <div x-show="activeTab === 'syarat'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-black text-base text-slate-900">📋 Pengaturan Syarat Berkas & Rekening Resmi Pembayaran</h3>
                    <p class="text-xs text-slate-500 font-medium">Atur nomor rekening yayasan, nama pemilik rekening, dan tips untuk orang tua calon siswa.</p>
                </div>

                <div class="space-y-4 text-xs">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Judul Kelengkapan Berkas:</label>
                            <input type="text" name="spmb_syarat_title" value="{{ $spmb['syarat_title'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Subjudul Berkas:</label>
                            <input type="text" name="spmb_syarat_desc" value="{{ $spmb['syarat_desc'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Pesan Tips untuk Orang Tua:</label>
                        <textarea name="spmb_syarat_tips" rows="2" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 leading-relaxed focus:outline-none focus:ring-2 focus:ring-emerald-600">{{ $spmb['syarat_tips'] }}</textarea>
                    </div>

                    <!-- Rekening Bank 1 -->
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 space-y-3">
                        <span class="px-2.5 py-1 rounded-full bg-emerald-200 text-emerald-900 font-black text-[10px] uppercase">
                            Rekening Bank Utama (BSI)
                        </span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Bank 1:</label>
                                <input type="text" name="spmb_bank1_name" value="{{ $spmb['bank1_name'] }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nomor Rekening 1:</label>
                                <input type="text" name="spmb_bank1_number" value="{{ $spmb['bank1_number'] }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-mono font-black text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Atas Nama Rekening 1:</label>
                                <input type="text" name="spmb_bank1_holder" value="{{ $spmb['bank1_holder'] }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                        </div>
                    </div>

                    <!-- Rekening Bank 2 -->
                    <div class="p-4 rounded-2xl bg-cyan-50 border border-cyan-200 space-y-3">
                        <span class="px-2.5 py-1 rounded-full bg-cyan-200 text-cyan-900 font-black text-[10px] uppercase">
                            Rekening Bank Kedua (Muamalat)
                        </span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Bank 2:</label>
                                <input type="text" name="spmb_bank2_name" value="{{ $spmb['bank2_name'] }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nomor Rekening 2:</label>
                                <input type="text" name="spmb_bank2_number" value="{{ $spmb['bank2_number'] }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-mono font-black text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Atas Nama Rekening 2:</label>
                                <input type="text" name="spmb_bank2_holder" value="{{ $spmb['bank2_holder'] }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Catatan Tambahan Pembayaran:</label>
                        <input type="text" name="spmb_payment_note" value="{{ $spmb['payment_note'] }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. TAB: TESTIMONI -->
        <div x-show="activeTab === 'testi'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-black text-base text-slate-900">💬 Pengaturan Testimoni Orang Tua Siswa</h3>
                    <p class="text-xs text-slate-500 font-medium">Kelola ulasan dan pengalaman nyata orang tua wali murid yang ditampilkan di landing page SPMB.</p>
                </div>

                <div class="space-y-4">
                    @foreach($spmb['testimonials'] as $idx => $testi)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3 text-xs">
                        <span class="px-2.5 py-1 rounded-full bg-slate-200 text-slate-800 font-black text-[10px] uppercase">
                            Testimoni {{ $idx + 1 }}
                        </span>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Nama Wali Murid:</label>
                                <input type="text" name="testimonials[{{ $idx }}][name]" value="{{ $testi['name'] ?? '' }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Jabatan / Profesi / Wali Siswa:</label>
                                <input type="text" name="testimonials[{{ $idx }}][role]" value="{{ $testi['role'] ?? '' }}" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Isi Kutipan Testimoni:</label>
                            <textarea name="testimonials[{{ $idx }}][quote]" rows="3" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 leading-relaxed focus:outline-none focus:ring-2 focus:ring-emerald-600" required>{{ $testi['quote'] ?? '' }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 7. TAB: FORMULIR ISIAN PPDB -->
        <div x-show="activeTab === 'form'" class="space-y-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <h3 class="font-black text-base text-slate-900">📝 Pengaturan Teks Formulir Isian PPDB (/spmb/daftar)</h3>
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
                        <strong class="font-black text-xs block">💡 Catatan Sinkronisasi Biaya:</strong>
                        <p class="text-[11px] leading-relaxed">
                            Biaya pendaftaran masing-masing unit (TK, SD, SMP, SMA) diatur langsung di <strong>Tab "Pilihan Unit & Biaya"</strong>. Ketika nominal diubah di tab tersebut, biaya yang terhitung di dalam formulir isian otomatis mengikuti pembaruan Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Submit Button -->
        <div class="sticky bottom-4 z-20 bg-white/95 backdrop-blur-md p-4 rounded-2xl border border-slate-300 shadow-xl flex items-center justify-between gap-4">
            <div class="hidden sm:block text-xs text-slate-500 font-semibold">
                Perubahan akan langsung diterapkan ke Landing Page & Formulir SPMB publik.
            </div>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.settings.spmb') }}" class="px-5 py-3 rounded-xl bg-slate-100 text-slate-700 font-bold text-xs hover:bg-slate-200 transition-colors">
                    Reset
                </a>
                <button type="submit" class="px-7 py-3 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-lg shadow-emerald-700/25 transition-all transform hover:-translate-y-0.5">
                    💾 Simpan Semua Perubahan
                </button>
            </div>
        </div>

    </form>

</div>
@endsection
