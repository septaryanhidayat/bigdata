@extends('admin.layout')

@section('title', 'Kelola Konten Website CMS')

@section('content')
<div class="space-y-6 w-full max-w-full">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <div class="flex items-center gap-2 text-xs font-bold text-theme-accent uppercase tracking-wider mb-1">
                <span>🌐 CMS Portal Management</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">Kelola Konten Website</h1>
            <p class="text-xs text-slate-500 font-medium">Edit banner hero, menu header, berita, video, agenda, pengumuman, fasilitas, dan galeri carousel secara realtime.</p>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('home') }}" target="_blank" class="px-4 py-2 bg-emerald-50 text-emerald-700 font-bold text-xs rounded-xl hover:bg-emerald-100 transition-colors flex items-center gap-2 border border-emerald-200">
                <span>👁️ Lihat Website Depan</span>
            </a>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex overflow-x-auto gap-2 border-b border-slate-200 pb-3 w-full">
        <a href="{{ route('admin.cms.content', ['tab' => 'hero']) }}" class="px-4 py-2.5 rounded-2xl font-bold text-xs shrink-0 flex items-center gap-2 transition-all {{ $activeTab === 'hero' ? 'bg-theme-gradient text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>🎨</span> <span>Banner &amp; Background</span>
        </a>
        <a href="{{ route('admin.cms.content', ['tab' => 'menu']) }}" class="px-4 py-2.5 rounded-2xl font-bold text-xs shrink-0 flex items-center gap-2 transition-all {{ $activeTab === 'menu' ? 'bg-theme-gradient text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>📌</span> <span>Menu Header ({{ count($headerMenus) }})</span>
        </a>
        <a href="{{ route('admin.cms.content', ['tab' => 'news']) }}" class="px-4 py-2.5 rounded-2xl font-bold text-xs shrink-0 flex items-center gap-2 transition-all {{ $activeTab === 'news' ? 'bg-theme-gradient text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>📰</span> <span>Berita &amp; Artikel ({{ count($newsList) }})</span>
        </a>
        <a href="{{ route('admin.cms.content', ['tab' => 'video']) }}" class="px-4 py-2.5 rounded-2xl font-bold text-xs shrink-0 flex items-center gap-2 transition-all {{ $activeTab === 'video' ? 'bg-theme-gradient text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>🎥</span> <span>Video Youtube ({{ count($videoList) }})</span>
        </a>
        <a href="{{ route('admin.cms.content', ['tab' => 'agenda']) }}" class="px-4 py-2.5 rounded-2xl font-bold text-xs shrink-0 flex items-center gap-2 transition-all {{ $activeTab === 'agenda' ? 'bg-theme-gradient text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>📅</span> <span>Agenda ({{ count($agendaList) }})</span>
        </a>
        <a href="{{ route('admin.cms.content', ['tab' => 'announcement']) }}" class="px-4 py-2.5 rounded-2xl font-bold text-xs shrink-0 flex items-center gap-2 transition-all {{ $activeTab === 'announcement' ? 'bg-theme-gradient text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>📢</span> <span>Pengumuman ({{ count($announcementList) }})</span>
        </a>
        <a href="{{ route('admin.cms.content', ['tab' => 'facility']) }}" class="px-4 py-2.5 rounded-2xl font-bold text-xs shrink-0 flex items-center gap-2 transition-all {{ $activeTab === 'facility' ? 'bg-theme-gradient text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>🏢</span> <span>Fasilitas ({{ count($facilityList) }})</span>
        </a>
        <a href="{{ route('admin.cms.content', ['tab' => 'gallery']) }}" class="px-4 py-2.5 rounded-2xl font-bold text-xs shrink-0 flex items-center gap-2 transition-all {{ $activeTab === 'gallery' ? 'bg-theme-gradient text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            <span>🖼️</span> <span>Galeri Carousel ({{ count($galleryList) }})</span>
        </a>
    </div>

    <!-- TAB: BANNER & BACKGROUND UTAMA -->
    @if($activeTab === 'hero')
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-6">
        <div class="border-b border-slate-200 pb-4">
            <h3 class="font-black text-base text-slate-900 flex items-center gap-2">
                <span>🎨</span> <span>Kelola Banner Utama &amp; Gambar Background Gedung/Masjid</span>
            </h3>
            <p class="text-xs text-slate-500 mt-1">Ubah judul besar, deskripsi sub-header, badge status, serta gambar background sekolah/masjid secara realtime.</p>
        </div>

        <form action="{{ route('admin.cms.content.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5 text-xs">
            @csrf
            <input type="hidden" name="module" value="hero">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <!-- Form Inputs -->
                <div class="lg:col-span-6 space-y-4">
                    <div>
                        <label class="font-bold text-slate-800 block mb-1">Status Badge Top Banner</label>
                        <input type="text" name="hero_badge" value="{{ $heroSettings['hero_badge'] }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:border-emerald-500 font-semibold" placeholder="e.g. ✨ Penerimaan Peserta Didik Baru (PPDB) 2026/2027">
                    </div>

                    <div>
                        <label class="font-bold text-slate-800 block mb-1">Judul Besar Banner (Hero Title)</label>
                        <textarea name="hero_title" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:border-emerald-500 font-semibold" placeholder="Judul besar...">{!! $heroSettings['hero_title'] !!}</textarea>
                        <span class="text-[10px] text-slate-400 block mt-1">Bisa menggunakan HTML misal: <code>Taman Pendidikan &lt;span class="bg-gradient-to-r from-[#004532] to-emerald-600 bg-clip-text text-transparent"&gt;Robbani&lt;/span&gt;</code></span>
                    </div>

                    <div>
                        <label class="font-bold text-slate-800 block mb-1">Sub-Header / Deskripsi Singkat (Hero Subtitle)</label>
                        <textarea name="hero_desc" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:border-emerald-500 font-semibold" placeholder="Deskripsi ringkas...">{{ $heroSettings['hero_desc'] }}</textarea>
                    </div>

                    <div>
                        <label class="font-bold text-slate-800 block mb-1">📁 Upload / Pilih File Gambar Background (Sekolah &amp; Masjid)</label>
                        <input type="file" name="hero_bg_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 text-xs font-semibold file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white mb-2">
                        <input type="text" name="hero_bg_image" value="{{ $heroSettings['hero_bg_image'] }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold text-slate-600" placeholder="atau tempelkan URL gambar...">
                        <span class="text-[10px] text-slate-400 block mt-1">Pilih file gambar langsung dari komputer atau perangkat Anda.</span>
                    </div>

                    <button type="submit" class="px-6 py-3 bg-theme-gradient text-white font-black text-xs rounded-xl shadow-md hover:opacity-90 transition-all flex items-center gap-2">
                        <span>💾 Simpan Perubahan Banner &amp; Background</span>
                    </button>
                </div>

                <!-- Live Glassmorphism Preview Box -->
                <div class="lg:col-span-6 space-y-3">
                    <label class="font-bold text-slate-800 block">Preview Visual Glassmorphism Live Banner</label>
                    <div class="border border-slate-300 rounded-3xl p-6 relative overflow-hidden bg-cover bg-center min-h-[350px] flex flex-col justify-center shadow-md" style="background-image: linear-gradient(135deg, rgba(0, 69, 50, 0.4) 0%, rgba(15, 23, 42, 0.6) 100%), url('{{ $heroSettings['hero_bg_image'] }}');">
                        <div class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-2xl p-5 space-y-3 shadow-xl">
                            <span class="inline-block bg-orange-100 text-orange-800 border border-orange-200 px-3 py-1 rounded-full text-[10px] font-bold uppercase">
                                {{ $heroSettings['hero_badge'] }}
                            </span>
                            <h2 class="text-lg sm:text-xl font-black text-slate-900 leading-snug">
                                {!! $heroSettings['hero_title'] !!}
                            </h2>
                            <p class="text-xs text-slate-600 font-medium leading-relaxed">
                                {{ $heroSettings['hero_desc'] }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @endif

    <!-- TAB: KELOLA MENU HEADER -->
    @if($activeTab === 'menu')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left: Form Tambah Menu Baru -->
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                <span>➕</span> <span>Tambah Menu Header Baru</span>
            </h3>
            <form action="{{ route('admin.cms.content.add') }}" method="POST" class="space-y-3 text-xs">
                @csrf
                <input type="hidden" name="module" value="menu">
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Nama Menu</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:border-emerald-500 font-semibold" placeholder="e.g. PPDB / Beasiswa">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">URL / Target Link</label>
                    <input type="text" name="url" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold" placeholder="e.g. /ppdb atau #unit-sekolah">
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-theme-gradient text-white font-black shadow-md hover:opacity-90">Tambah Menu Header</button>
            </form>
        </div>

        <!-- Right: List Menu Header Existing & Setting Aktif/Nonaktif -->
        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="border-b border-slate-200 pb-3">
                <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                    <span>📌</span> <span>Pengaturan &amp; Status Aktif Menu Header ({{ count($headerMenus) }})</span>
                </h3>
                <p class="text-[11px] text-slate-500 font-medium">Hapus atau centang/uncheck status aktif untuk menampilkan/menyembunyikan menu di bagian atas website.</p>
            </div>

            <form action="{{ route('admin.cms.content.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="menu">

                <div class="space-y-3">
                    @foreach($headerMenus as $mIdx => $mItem)
                    <div class="flex flex-col sm:flex-row items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-2xl">
                        <div class="flex items-center gap-2 shrink-0">
                            <input type="hidden" name="menus[{{ $mIdx }}][is_active]" value="0">
                            <input type="checkbox" name="menus[{{ $mIdx }}][is_active]" value="1" {{ (!isset($mItem['is_active']) || $mItem['is_active']) ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 rounded focus:ring-emerald-500">
                            <span class="text-xs font-bold text-slate-700">Aktif</span>
                        </div>

                        <div class="flex-grow grid grid-cols-1 sm:grid-cols-2 gap-2 w-full">
                            <input type="text" name="menus[{{ $mIdx }}][title]" value="{{ $mItem['title'] }}" required class="px-3 py-2 rounded-xl border border-slate-300 font-bold text-xs" placeholder="Nama Menu">
                            <input type="text" name="menus[{{ $mIdx }}][url]" value="{{ $mItem['url'] }}" required class="px-3 py-2 rounded-xl border border-slate-300 font-medium text-xs text-slate-600" placeholder="URL">
                        </div>

                        <button type="submit" form="delete-menu-{{ $mIdx }}" class="px-3 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl font-bold text-xs shrink-0" title="Hapus Menu Ini">✕ Hapus</button>
                    </div>
                    @endforeach
                </div>

                <div class="pt-3 border-t border-slate-200">
                    <button type="submit" class="px-6 py-2.5 bg-theme-gradient text-white font-black text-xs rounded-xl shadow-md hover:opacity-90">Simpan Perubahan Menu</button>
                </div>
            </form>

            @foreach($headerMenus as $mIdx => $mItem)
            <form id="delete-menu-{{ $mIdx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="module" value="menu">
                <input type="hidden" name="index" value="{{ $mIdx }}">
            </form>
            @endforeach
        </div>
    </div>
    @endif

    <!-- TAB: BERITA & ARTIKEL -->
    @if($activeTab === 'news')

    <!-- Unit Admin Alert or Global Admin Filter Toolbar -->
    @if(!empty($userUnit))
    <div class="p-4 rounded-2xl bg-indigo-50 border border-indigo-200 text-indigo-900 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-xs">
        <div class="flex items-center gap-3">
            <span class="text-3xl">🔒</span>
            <div>
                <strong class="font-black text-sm block">Mode Akses Unit: {{ strtoupper($userUnit) }} Robbani</strong>
                <p class="text-xs text-indigo-700">Anda login sebagai Admin Unit {{ strtoupper($userUnit) }}. Anda hanya dapat mengelola, menambah, mengunggah foto, dan mengedit konten berita untuk unit <strong>{{ strtoupper($userUnit) }}</strong>.</p>
            </div>
        </div>
        <span class="px-3.5 py-1.5 bg-indigo-600 text-white font-black text-xs rounded-xl uppercase shrink-0 self-start sm:self-auto shadow-xs">
            Unit: {{ strtoupper($userUnit) }}
        </span>
    </div>
    @elseif(!empty($isGlobalAdmin))
    <div class="p-4 rounded-2xl bg-slate-900 text-white flex flex-col lg:flex-row lg:items-center justify-between gap-4 shadow-md border border-slate-800">
        <div class="flex items-center gap-3">
            <span class="text-2xl">🌐</span>
            <div>
                <strong class="font-black text-sm block">Pusat Filter Konten Berita Unit Sekolah:</strong>
                <p class="text-xs text-slate-300">Saring daftar berita berdasarkan unit untuk mempermudah pengelolaan.</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-1.5 bg-slate-950 p-1.5 rounded-xl border border-slate-800">
            <a href="{{ route('admin.cms.content', ['tab' => 'news', 'unit_filter' => 'all']) }}" class="px-3 py-1.5 rounded-lg text-xs font-black transition-all {{ ($selectedUnit ?? 'all') === 'all' ? 'bg-emerald-600 text-white shadow' : 'text-slate-400 hover:text-white' }}">Semua Unit ({{ $unitCounts['all'] ?? 0 }})</a>
            <a href="{{ route('admin.cms.content', ['tab' => 'news', 'unit_filter' => 'tkit']) }}" class="px-3 py-1.5 rounded-lg text-xs font-black transition-all {{ ($selectedUnit ?? '') === 'tkit' ? 'bg-amber-600 text-white shadow' : 'text-slate-400 hover:text-white' }}">KB/TKIT ({{ $unitCounts['tkit'] ?? 0 }})</a>
            <a href="{{ route('admin.cms.content', ['tab' => 'news', 'unit_filter' => 'sdit']) }}" class="px-3 py-1.5 rounded-lg text-xs font-black transition-all {{ ($selectedUnit ?? '') === 'sdit' ? 'bg-blue-600 text-white shadow' : 'text-slate-400 hover:text-white' }}">SDIT ({{ $unitCounts['sdit'] ?? 0 }})</a>
            <a href="{{ route('admin.cms.content', ['tab' => 'news', 'unit_filter' => 'smpit']) }}" class="px-3 py-1.5 rounded-lg text-xs font-black transition-all {{ ($selectedUnit ?? '') === 'smpit' ? 'bg-emerald-700 text-white shadow' : 'text-slate-400 hover:text-white' }}">SMPIT ({{ $unitCounts['smpit'] ?? 0 }})</a>
            <a href="{{ route('admin.cms.content', ['tab' => 'news', 'unit_filter' => 'smait']) }}" class="px-3 py-1.5 rounded-lg text-xs font-black transition-all {{ ($selectedUnit ?? '') === 'smait' ? 'bg-purple-600 text-white shadow' : 'text-slate-400 hover:text-white' }}">SMAIT ({{ $unitCounts['smait'] ?? 0 }})</a>
            <a href="{{ route('admin.cms.content', ['tab' => 'news', 'unit_filter' => 'yayasan']) }}" class="px-3 py-1.5 rounded-lg text-xs font-black transition-all {{ ($selectedUnit ?? '') === 'yayasan' ? 'bg-slate-700 text-white shadow' : 'text-slate-400 hover:text-white' }}">Yayasan ({{ $unitCounts['yayasan'] ?? 0 }})</a>
        </div>
    </div>
    @endif

    <!-- WordPress XML Auto-Importer Banner (High-Contrast Guaranteed) -->
    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); color: #ffffff;" class="p-6 rounded-3xl border border-slate-800 shadow-xl space-y-5 font-sans" x-data="{ importMethod: 'upload' }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-blue-500/25 text-blue-300 font-black text-xs uppercase tracking-wider border border-blue-400/40 inline-block">
                        🚀 AUTOMATED WORDPRESS MIGRATION TOOL
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-bold text-[10px] border border-emerald-500/30">
                        ⚡ Support File Besar (100MB+)
                    </span>
                </div>
                <h3 class="text-xl font-black text-white tracking-tight">Import Konten Berita &amp; Artikel dari WordPress (WXR XML)</h3>
                <p class="text-xs text-slate-200 font-medium max-w-3xl leading-relaxed">
                    Ekspor postingan website WordPress Anda ke berkas XML, lalu impor ke sini. Sistem akan otomatis memindahkan judul, artikel, berita, tanggal rilis, kategori, dan gambar ke CMS SmartEdu.
                </p>
            </div>
            
            <!-- Import Method Toggle Tabs -->
            <div class="flex items-center gap-1.5 bg-slate-900/90 p-1.5 rounded-2xl border border-slate-700 shrink-0">
                <button type="button" @click="importMethod = 'upload'" :class="importMethod === 'upload' ? 'bg-blue-600 text-white font-black' : 'text-slate-400 hover:text-white font-bold'" class="px-3 py-1.5 rounded-xl text-xs transition-all">
                    📁 Unggah File
                </button>
                <button type="button" @click="importMethod = 'path'" :class="importMethod === 'path' ? 'bg-indigo-600 text-white font-black' : 'text-slate-400 hover:text-white font-bold'" class="px-3 py-1.5 rounded-xl text-xs transition-all">
                    📂 Path Server
                </button>
            </div>
        </div>

        @php
            $defaultXmlServerPath = 'public/images/sitrobbani.WordPress.2026-08-16.xml';
            $hasLocalXml = file_exists(base_path($defaultXmlServerPath)) || file_exists(public_path('images/sitrobbani.WordPress.2026-08-16.xml'));
        @endphp
        @if($hasLocalXml)
        <!-- Quick 1-Click Server Import Alert -->
        <div class="bg-emerald-950/80 border border-emerald-500/50 p-3.5 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs shadow-inner">
            <div class="flex items-center gap-3">
                <span class="text-2xl">⚡</span>
                <div>
                    <strong class="text-white block font-black">Berkas XML Siap Pakai di Server: <code class="text-emerald-300 font-mono text-[11px] bg-slate-900 px-1.5 py-0.5 rounded">sitrobbani.WordPress.2026-08-16.xml</code></strong>
                    <span class="text-emerald-200/80 text-[11px]">Anda tidak perlu upload ulang melalui browser (Bebas error 419 / timeout jaringan).</span>
                </div>
            </div>
            <form action="{{ route('admin.cms.import-wordpress') }}" method="POST" onsubmit="if(window.Swal){ Swal.fire({ title: 'Memproses Impor Kilat...', html: '<p class=\'text-xs text-slate-300\'>Sedang mengonversi postingan langsung dari server dalam 0.1 detik...</p>', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } }); }">
                @csrf
                <input type="hidden" name="server_file_path" value="public/images/sitrobbani.WordPress.2026-08-16.xml">
                <button type="submit" class="px-5 py-2.5 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-500 hover:to-teal-500 text-slate-950 font-black text-xs rounded-xl shadow-lg transition-all shrink-0 flex items-center gap-1.5 cursor-pointer">
                    <span>🚀 Langsung Impor 1-Klik (0.1 Detik)</span>
                </button>
            </form>
        </div>
        @endif

        <!-- Forms Container -->
        <div class="bg-slate-900/80 p-4 rounded-2xl border border-slate-700">
            <!-- Option 1: File Upload -->
            <form x-show="importMethod === 'upload'" action="{{ route('admin.cms.import-wordpress') }}" method="POST" enctype="multipart/form-data" onsubmit="if(window.Swal){ Swal.fire({ title: 'Memproses Impor...', html: '<p class=\'text-xs text-slate-300\'>Sedang mengonversi dan memetakan postingan WordPress XML ke database...</p>', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } }); }" class="flex flex-col sm:flex-row items-center gap-3">
                @csrf
                <div class="flex-1 w-full">
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Pilih Berkas XML WordPress (.xml / .txt) - Maks. 100MB:</label>
                    <input type="file" name="xml_file" accept=".xml,.txt" required class="w-full text-xs text-slate-200 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-blue-600 file:text-white hover:file:bg-blue-700 cursor-pointer">
                </div>
                <div class="sm:self-end w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                        <span>⚡ Mulai Import File</span>
                    </button>
                </div>
            </form>

            <!-- Option 2: Server File Path -->
            <form x-show="importMethod === 'path'" x-cloak action="{{ route('admin.cms.import-wordpress') }}" method="POST" onsubmit="if(window.Swal){ Swal.fire({ title: 'Memproses Impor...', html: '<p class=\'text-xs text-slate-300\'>Sedang membaca file server dan memproses konten...</p>', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } }); }" class="flex flex-col sm:flex-row items-center gap-3">
                @csrf
                <div class="flex-1 w-full">
                    <label class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-1">Path Berkas XML di Project / Server (Contoh: <code class="text-indigo-300">storage/app/wordpress.xml</code>):</label>
                    <input type="text" name="server_file_path" required placeholder="Contoh: public/images/sitrobbani.WordPress.2026-08-16.xml" class="w-full px-3.5 py-2 rounded-xl bg-slate-950 border border-slate-700 text-white text-xs font-mono focus:outline-none focus:border-indigo-500">
                </div>
                <div class="sm:self-end w-full sm:w-auto">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs rounded-xl shadow-lg transition-all flex items-center justify-center gap-2">
                        <span>⚡ Import dari Path</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- 1-Click Auto-Categorize Toolbar -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-slate-900/90 p-3.5 rounded-2xl border border-indigo-500/40 text-xs shadow-inner">
            <div class="text-slate-300 flex items-center gap-2.5">
                <span class="text-xl">🏷️</span>
                <div>
                    <strong class="text-white block font-black">Auto-Kategori Cerdas Unit Pendidikan:</strong>
                    <span class="text-slate-400 text-[11px]">Otomatis kelompokkan ratusan berita/artikel ke <strong>TKIT, SDIT, SMPIT, SMAIT, atau Yayasan</strong> &amp; tampilkan tahun 2026 di urutan teratas.</span>
                </div>
            </div>
            <form action="{{ route('admin.cms.auto-categorize') }}" method="POST" onsubmit="if(window.Swal){ Swal.fire({ title: 'Mengategorikan...', html: '<p class=\'text-xs text-slate-300\'>Sedang memindai teks dan mengelompokkan ke unit sekolah serta mengurutkan data...</p>', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } }); }">
                @csrf
                <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs rounded-xl shadow-md transition-all flex items-center gap-1.5 cursor-pointer whitespace-nowrap">
                    <span>✨ Auto-Kategorikan &amp; Urutkan 2026 Sekarang</span>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Form Tambah Berita Baru -->
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-base text-slate-900 flex items-center gap-2">
                <span>➕</span> <span>Tambah Berita Baru</span>
            </h3>
            <form action="{{ route('admin.cms.content.add') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-xs" x-data="{ newPreview: '/images/mockup_desktop_1.png' }">
                @csrf
                <input type="hidden" name="module" value="news">
                <input type="hidden" name="unit_filter" value="{{ $selectedUnit ?? 'all' }}">
                
                <div>
                    <label class="font-black text-slate-800 text-xs uppercase tracking-wider block mb-1">Judul Berita</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:border-emerald-500 font-bold text-slate-900 text-xs" placeholder="Judul berita...">
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="font-black text-slate-800 text-xs uppercase tracking-wider block mb-1">Unit Sekolah</label>
                        @if(!empty($userUnit))
                            <input type="hidden" name="unit" value="{{ $userUnit }}">
                            <input type="text" value="{{ strtoupper($userUnit) }}" disabled class="w-full px-3 py-2 rounded-xl border border-slate-200 font-bold text-slate-500 text-xs bg-slate-100">
                        @else
                            <select name="unit" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white">
                                <option value="smpit" {{ ($selectedUnit ?? '') === 'smpit' ? 'selected' : '' }}>SMPIT</option>
                                <option value="sdit" {{ ($selectedUnit ?? '') === 'sdit' ? 'selected' : '' }}>SDIT</option>
                                <option value="tkit" {{ ($selectedUnit ?? '') === 'tkit' ? 'selected' : '' }}>KB/TKIT</option>
                                <option value="smait" {{ ($selectedUnit ?? '') === 'smait' ? 'selected' : '' }}>SMAIT</option>
                                <option value="yayasan" {{ ($selectedUnit ?? '') === 'yayasan' ? 'selected' : '' }}>Yayasan / Portal</option>
                            </select>
                        @endif
                    </div>
                    <div>
                        <label class="font-black text-slate-800 text-xs uppercase tracking-wider block mb-1">Kategori</label>
                        <input type="text" name="category" value="{{ !empty($userUnit) ? strtoupper($userUnit) : 'Berita' }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="font-black text-slate-800 text-xs uppercase tracking-wider block mb-1">Tanggal</label>
                        <input type="text" name="date" value="{{ date('d F Y') }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs">
                    </div>
                    <div>
                        <label class="font-black text-slate-800 text-xs uppercase tracking-wider block mb-1">Penulis</label>
                        <input type="text" name="author" value="Humas SIT Robbani" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs">
                    </div>
                </div>

                <div class="bg-slate-50 p-3 rounded-2xl border border-slate-200 space-y-2">
                    <label class="font-black text-slate-800 text-xs uppercase tracking-wider block">📁 Upload File Gambar (Choose File)</label>
                    <div class="relative w-full h-28 bg-slate-200 rounded-xl overflow-hidden border border-slate-300 flex items-center justify-center">
                        <img :src="newPreview" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                    </div>
                    <input type="file" name="image_file" accept="image/*" @change="if ($event.target.files.length > 0) { newPreview = URL.createObjectURL($event.target.files[0]); }" class="w-full px-2 py-1.5 rounded-xl border border-slate-300 bg-white text-xs font-semibold file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white cursor-pointer">
                    <input type="text" name="image" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-mono text-slate-700 text-[11px]" placeholder="atau tempelkan URL gambar...">
                </div>

                <div>
                    <label class="font-black text-slate-800 text-xs uppercase tracking-wider block mb-1">Ringkasan (Excerpt)</label>
                    <textarea name="excerpt" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs" placeholder="Ringkasan 1-2 kalimat..."></textarea>
                </div>
                <div>
                    <label class="font-black text-slate-800 text-xs uppercase tracking-wider block mb-1">Isi Berita Lengkap</label>
                    <textarea name="content" rows="4" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-medium text-slate-900 text-xs" placeholder="Paragraf artikel lengkap..."></textarea>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-90 transition-all flex items-center justify-center gap-2">
                    <span>➕ Simpan Berita Baru</span>
                </button>
            </form>
        </div>

        <!-- List Berita Existing with Bulk Selection Checklist & SweetAlert2 -->
        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4" x-data="{ 
            selectedItems: [],
            allSlugs: {{ json_encode(array_map(fn($item) => $item['slug'] ?? \Illuminate\Support\Str::slug($item['title'] ?? ''), $newsList)) }},
            toggleSelectAll(checked) {
                this.selectedItems = checked ? [...this.allSlugs] : [];
            }
        }">
            <!-- Header & Bulk Action Toolbar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200 pb-3">
                <div class="flex items-center gap-2">
                    <h3 class="font-black text-base text-slate-900">Daftar Berita ({{ count($newsList) }})</h3>
                    @if(!empty($selectedUnit) && $selectedUnit !== 'all')
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[11px] uppercase">
                            Unit: {{ strtoupper($selectedUnit) }}
                        </span>
                    @endif
                </div>

                <!-- Bulk Selection Controls -->
                <div class="flex items-center gap-3">
                    <label class="flex items-center gap-1.5 text-xs font-black text-slate-700 bg-slate-100 hover:bg-slate-200 px-3 py-1.5 rounded-xl cursor-pointer transition-all border border-slate-200">
                        <input type="checkbox" @change="toggleSelectAll($event.target.checked)" :checked="selectedItems.length > 0 && selectedItems.length === allSlugs.length" class="w-4 h-4 text-emerald-600 rounded border-slate-300 focus:ring-emerald-500 cursor-pointer">
                        <span>Pilih Semua</span>
                    </label>

                    <template x-if="selectedItems.length > 0">
                        <button type="button" @click="confirmDeleteBulk('news', selectedItems)" class="px-3.5 py-1.5 bg-rose-600 hover:bg-rose-700 text-white font-black text-xs rounded-xl shadow-md transition-all flex items-center gap-1.5 cursor-pointer animate-bounce">
                            <span>🗑️ Hapus <span x-text="selectedItems.length"></span> Berita Terpilih</span>
                        </button>
                    </template>
                </div>
            </div>

            <!-- Floating Selected Counter -->
            <div x-show="selectedItems.length > 0" x-cloak class="p-3 bg-rose-50 border border-rose-200 rounded-2xl flex items-center justify-between gap-2 text-xs">
                <span class="font-black text-rose-900 flex items-center gap-1.5">
                    <span>📌</span>
                    <span><strong x-text="selectedItems.length"></strong> dari {{ count($newsList) }} berita dipilih untuk dihapus massal.</span>
                </span>
                <button type="button" @click="selectedItems = []" class="text-rose-700 font-bold hover:underline">Batalkan Pilihan</button>
            </div>
            
            <form action="{{ route('admin.cms.content.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="news">
                <input type="hidden" name="unit_filter" value="{{ $selectedUnit ?? 'all' }}">
                
                <div class="space-y-4 max-h-[700px] overflow-y-auto pr-2">
                    @forelse($newsList as $idx => $news)
                    @php
                        $itemSlug = $news['slug'] ?? \Illuminate\Support\Str::slug($news['title'] ?? '');
                    @endphp
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3 hover:shadow-md transition-all" :class="selectedItems.includes('{{ $itemSlug }}') ? 'ring-2 ring-rose-500 bg-rose-50/40' : ''" x-data="{ expanded: false, previewSrc: '{{ $news['image'] }}' }">
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 pb-2.5">
                            <div class="flex items-center gap-2.5">
                                <!-- Individual Checklist Checkbox -->
                                <label class="flex items-center gap-1.5 cursor-pointer" title="Centang untuk pilih hapus sekaligus">
                                    <input type="checkbox" value="{{ $itemSlug }}" x-model="selectedItems" class="w-4 h-4 text-rose-600 rounded border-slate-300 focus:ring-rose-500 cursor-pointer">
                                </label>
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-700 text-white font-black text-xs uppercase shadow-xs">
                                    #{{ $idx+1 }} {{ $idx === 0 ? '🏆 HEADLINE' : 'BERITA' }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-md bg-slate-200 text-slate-800 font-extrabold text-[11px] uppercase">
                                    Unit: {{ strtoupper($news['unit'] ?? $news['category'] ?? 'SMPIT') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="expanded = !expanded" class="px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-xl text-xs font-black border border-blue-200 flex items-center gap-1 cursor-pointer">
                                    <span x-text="expanded ? '▲ Tutup Isi Lengkap' : '✏️ Buka Isi Lengkap'"></span>
                                </button>
                                <!-- SweetAlert2 Single Delete Trigger -->
                                <button type="button" @click="confirmDeleteSingle('delete-news-{{ $idx }}', '{{ addslashes($news['title']) }}')" class="px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-xl text-xs font-black border border-rose-200 cursor-pointer flex items-center gap-1">
                                    <span>🗑️ Hapus</span>
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 text-xs">
                            <!-- Image Picker Box -->
                            <div class="md:col-span-4 bg-white p-3 rounded-2xl border border-slate-200 space-y-2">
                                <label class="font-extrabold text-slate-800 text-[11px] uppercase tracking-wider block">📁 Foto / Gambar Berita</label>
                                <div class="relative w-full h-28 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 flex items-center justify-center">
                                    <img :src="previewSrc" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-500 mb-1">Ganti Foto (Choose File):</label>
                                    <input type="file" name="items[{{ $idx }}][image_file]" accept="image/*" @change="if ($event.target.files.length > 0) { previewSrc = URL.createObjectURL($event.target.files[0]); }" class="w-full text-xs font-semibold file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                                </div>
                                <input type="hidden" name="items[{{ $idx }}][image]" value="{{ $news['image'] }}">
                            </div>

                            <!-- Details Inputs -->
                            <div class="md:col-span-8 space-y-2.5">
                                <div>
                                    <label class="font-extrabold text-slate-800 text-xs uppercase tracking-wider block mb-1">Judul Berita</label>
                                    <input type="text" name="items[{{ $idx }}][title]" value="{{ $news['title'] }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white focus:border-emerald-500">
                                    <input type="hidden" name="items[{{ $idx }}][slug]" value="{{ $news['slug'] ?? \Illuminate\Support\Str::slug($news['title']) }}">
                                </div>
                                
                                <div class="grid grid-cols-3 gap-2">
                                    <div>
                                        <label class="font-extrabold text-slate-800 text-[11px] uppercase tracking-wider block mb-1">Unit</label>
                                        @if(!empty($userUnit))
                                            <input type="hidden" name="items[{{ $idx }}][unit]" value="{{ $userUnit }}">
                                            <input type="text" value="{{ strtoupper($userUnit) }}" disabled class="w-full px-2 py-1.5 rounded-xl border border-slate-200 font-bold text-slate-500 text-xs bg-slate-100">
                                        @else
                                            <select name="items[{{ $idx }}][unit]" class="w-full px-2 py-1.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white">
                                                <option value="smpit" {{ ($news['unit'] ?? '') === 'smpit' ? 'selected' : '' }}>SMPIT</option>
                                                <option value="sdit" {{ ($news['unit'] ?? '') === 'sdit' ? 'selected' : '' }}>SDIT</option>
                                                <option value="tkit" {{ ($news['unit'] ?? '') === 'tkit' ? 'selected' : '' }}>KB/TKIT</option>
                                                <option value="smait" {{ ($news['unit'] ?? '') === 'smait' ? 'selected' : '' }}>SMAIT</option>
                                                <option value="yayasan" {{ ($news['unit'] ?? '') === 'yayasan' ? 'selected' : '' }}>Yayasan</option>
                                            </select>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="font-extrabold text-slate-800 text-[11px] uppercase tracking-wider block mb-1">Kategori</label>
                                        <input type="text" name="items[{{ $idx }}][category]" value="{{ $news['category'] }}" class="w-full px-2.5 py-1.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white">
                                    </div>
                                    <div>
                                        <label class="font-extrabold text-slate-800 text-[11px] uppercase tracking-wider block mb-1">Tanggal</label>
                                        <input type="text" name="items[{{ $idx }}][date]" value="{{ $news['date'] }}" class="w-full px-2.5 py-1.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white">
                                    </div>
                                </div>

                                <div>
                                    <label class="font-extrabold text-slate-800 text-[11px] uppercase tracking-wider block mb-1">Penulis</label>
                                    <input type="text" name="items[{{ $idx }}][author]" value="{{ $news['author'] ?? 'Humas SIT Robbani' }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white">
                                </div>

                                <div>
                                    <label class="font-extrabold text-slate-800 text-[11px] uppercase tracking-wider block mb-1">Ringkasan (Excerpt)</label>
                                    <textarea name="items[{{ $idx }}][excerpt]" rows="2" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-semibold text-slate-900 text-xs bg-white">{{ $news['excerpt'] }}</textarea>
                                </div>

                                <div x-show="expanded" x-cloak class="pt-2">
                                    <label class="font-extrabold text-emerald-800 text-xs uppercase tracking-wider block mb-1">Isi Konten Berita Lengkap</label>
                                    <textarea name="items[{{ $idx }}][content]" rows="6" class="w-full px-3 py-2 rounded-xl border border-emerald-300 font-medium text-slate-900 text-xs bg-emerald-50/40 focus:bg-white">{{ $news['content'] ?? $news['excerpt'] }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center bg-slate-50 rounded-2xl border border-slate-200 text-slate-500">
                        <span class="text-3xl block mb-2">📭</span>
                        <p class="font-bold text-sm">Belum ada berita untuk kategori unit ini.</p>
                        <p class="text-xs text-slate-400 mt-1">Gunakan form di samping kiri untuk menambahkan berita baru.</p>
                    </div>
                    @endforelse
                </div>
                
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-7 py-3 rounded-xl bg-emerald-700 text-white font-black text-xs hover:bg-emerald-800 shadow-md transition-all flex items-center gap-2">
                        <span>💾 Simpan Semua Perubahan Berita</span>
                    </button>
                </div>
            </form>

            @foreach($newsList as $idx => $news)
            <form id="delete-news-{{ $idx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="module" value="news">
                <input type="hidden" name="index" value="{{ $idx }}">
                <input type="hidden" name="slug" value="{{ $news['slug'] ?? '' }}">
                <input type="hidden" name="title" value="{{ $news['title'] ?? '' }}">
                <input type="hidden" name="unit_filter" value="{{ $selectedUnit ?? 'all' }}">
            </form>
            @endforeach
        </div>
    </div>
    @endif

    <!-- TAB: VIDEO YOUTUBE -->
    @if($activeTab === 'video')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-base text-slate-900">🎥 Tambah Video Youtube Baru</h3>
            <form action="{{ route('admin.cms.content.add') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                @csrf
                <input type="hidden" name="module" value="video">
                <div>
                    <label class="font-extrabold text-slate-800 block mb-1">Judul Video</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs">
                </div>
                <div>
                    <label class="font-extrabold text-slate-800 block mb-1">Youtube ID (Contoh: Q-vZ49vP1_c)</label>
                    <input type="text" name="youtube_id" placeholder="Contoh: Q-vZ49vP1_c atau 8yp0GZL27fU" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="font-extrabold text-slate-800 block mb-1">Kategori</label>
                        <input type="text" name="category" value="Dokumentasi" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs">
                    </div>
                    <div>
                        <label class="font-extrabold text-slate-800 block mb-1">Durasi</label>
                        <input type="text" name="duration" value="05:00" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs">
                    </div>
                </div>
                <div>
                    <label class="font-extrabold text-slate-800 block mb-1">📁 Upload / Pilih File Thumbnail Video</label>
                    <input type="file" name="thumbnail_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 text-xs font-semibold file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-purple-600 file:text-white mb-2 cursor-pointer">
                    <input type="text" name="thumbnail" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs" value="/images/mockup_desktop_1.png" placeholder="atau tempelkan URL gambar...">
                </div>
                <div>
                    <label class="font-extrabold text-slate-800 block mb-1">Deskripsi Singkat</label>
                    <textarea name="desc" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs"></textarea>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-purple-700 text-white font-black text-xs hover:bg-purple-800 shadow-md transition-all">Simpan Video Baru</button>
            </form>
        </div>

        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-base text-slate-900 border-b border-slate-200 pb-3">Daftar Video Profil &amp; Dokumentasi ({{ count($videoList) }})</h3>
            <form action="{{ route('admin.cms.content.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="video">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[600px] overflow-y-auto pr-2">
                    @foreach($videoList as $idx => $vid)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-black text-xs bg-purple-700 text-white px-2.5 py-1 rounded-lg uppercase shadow-xs">Video #{{ $idx+1 }}</span>
                            <button type="button" @click="confirmDeleteSingle('delete-video-{{ $idx }}', '{{ addslashes($vid['title']) }}')" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold cursor-pointer">🗑️ Hapus</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <label class="font-extrabold text-slate-800 block mb-1">Judul Video</label>
                                <input type="text" name="items[{{ $idx }}][title]" value="{{ $vid['title'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="font-extrabold text-slate-800 block mb-1">Kategori</label>
                                    <input type="text" name="items[{{ $idx }}][category]" value="{{ $vid['category'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white">
                                </div>
                                <div>
                                    <label class="font-extrabold text-slate-800 block mb-1">Durasi</label>
                                    <input type="text" name="items[{{ $idx }}][duration]" value="{{ $vid['duration'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white">
                                </div>
                            </div>
                            <div>
                                <label class="font-extrabold text-slate-800 block mb-1">Youtube Video ID</label>
                                <input type="text" name="items[{{ $idx }}][youtube_id]" value="{{ $vid['youtube_id'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 text-xs bg-white">
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-200 space-y-2">
                                <label class="font-extrabold text-slate-800 block">📁 Pilih File Thumbnail Baru (Atau Biarkan Gambar Saat Ini)</label>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $vid['thumbnail'] }}" class="w-16 h-12 object-cover rounded-xl border border-slate-300 shrink-0 shadow-xs" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                                    <div class="space-y-1 w-full">
                                        <input type="file" name="items[{{ $idx }}][thumbnail_file]" accept="image/*" class="w-full text-xs font-semibold file:mr-2 file:py-1 file:px-2.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-purple-600 file:text-white hover:file:bg-purple-700 cursor-pointer">
                                        <input type="text" name="items[{{ $idx }}][thumbnail]" value="{{ $vid['thumbnail'] }}" class="w-full px-2.5 py-1 rounded-lg border border-slate-200 text-slate-600 font-mono text-[11px]" placeholder="Path/URL thumbnail...">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="font-extrabold text-slate-800 block mb-1">Deskripsi</label>
                                <textarea name="items[{{ $idx }}][desc]" rows="2" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-semibold text-slate-900 text-xs bg-white">{{ $vid['desc'] }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-purple-700 text-white font-black text-xs hover:bg-purple-800 shadow-md transition-all">Simpan Perubahan Video</button>
                </div>
            </form>

            @foreach($videoList as $idx => $vid)
            <form id="delete-video-{{ $idx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="module" value="video">
                <input type="hidden" name="index" value="{{ $idx }}">
            </form>
            @endforeach
        </div>
    </div>
    @endif

    <!-- TAB: AGENDA KEGIATAN -->
    @if($activeTab === 'agenda')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900">📅 Tambah Agenda Baru</h3>
            <form action="{{ route('admin.cms.content.add') }}" method="POST" class="space-y-3 text-xs">
                @csrf
                <input type="hidden" name="module" value="agenda">
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Nama Agenda</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Tanggal</label>
                        <input type="text" name="date_day" placeholder="25" required class="w-full px-2 py-2 rounded-xl border border-slate-300 font-semibold">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Bulan</label>
                        <input type="text" name="date_month" placeholder="AGU" required class="w-full px-2 py-2 rounded-xl border border-slate-300 font-semibold">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Tahun</label>
                        <input type="text" name="year" value="2026" required class="w-full px-2 py-2 rounded-xl border border-slate-300 font-semibold">
                    </div>
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Waktu</label>
                    <input type="text" name="time" value="08.00 WIB - Selesai" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Lokasi</label>
                    <input type="text" name="location" value="Aula SIT Robbani" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Kategori</label>
                    <input type="text" name="category" value="Akademik" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-theme-gradient text-white font-black shadow-md">Simpan Agenda Baru</button>
            </form>
        </div>

        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900 border-b border-slate-200 pb-3">Daftar Agenda Kegiatan ({{ count($agendaList) }})</h3>
            <form action="{{ route('admin.cms.content.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="agenda">
                <div class="space-y-3 max-h-[600px] overflow-y-auto pr-2">
                    @foreach($agendaList as $idx => $ag)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 flex flex-col md:flex-row gap-4 items-center justify-between">
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <div class="w-12 h-12 bg-emerald-600 text-white rounded-xl flex flex-col items-center justify-center font-black shrink-0">
                                <span>{{ $ag['date_day'] }}</span>
                                <span class="text-[9px] uppercase">{{ $ag['date_month'] }}</span>
                            </div>
                            <div class="w-full space-y-1 text-xs">
                                <input type="text" name="items[{{ $idx }}][title]" value="{{ $ag['title'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-bold">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="items[{{ $idx }}][time]" value="{{ $ag['time'] }}" class="w-full px-2 py-1 rounded border border-slate-300">
                                    <input type="text" name="items[{{ $idx }}][location]" value="{{ $ag['location'] }}" class="w-full px-2 py-1 rounded border border-slate-300">
                                </div>
                                <input type="hidden" name="items[{{ $idx }}][date_day]" value="{{ $ag['date_day'] }}">
                                <input type="hidden" name="items[{{ $idx }}][date_month]" value="{{ $ag['date_month'] }}">
                            </div>
                        </div>
                        <button type="button" @click="confirmDeleteSingle('delete-agenda-{{ $idx }}', '{{ addslashes($ag['title']) }}')" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold shrink-0 cursor-pointer">Hapus</button>
                    </div>
                    @endforeach
                </div>
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-black text-xs shadow-md">Simpan Perubahan Agenda</button>
                </div>
            </form>

            @foreach($agendaList as $idx => $ag)
            <form id="delete-agenda-{{ $idx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="module" value="agenda">
                <input type="hidden" name="index" value="{{ $idx }}">
            </form>
            @endforeach
        </div>
    </div>
    @endif

    <!-- TAB: PENGUMUMAN -->
    @if($activeTab === 'announcement')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900">📢 Tambah Pengumuman Baru</h3>
            <form action="{{ route('admin.cms.content.add') }}" method="POST" class="space-y-3 text-xs">
                @csrf
                <input type="hidden" name="module" value="announcement">
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Judul Pengumuman</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Kategori</label>
                        <input type="text" name="category" value="Penting" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Tanggal</label>
                        <input type="text" name="date" value="{{ date('d F Y') }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold">
                    </div>
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Ringkasan Pengumuman</label>
                    <textarea name="summary" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold"></textarea>
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Target Link Target</label>
                    <input type="text" name="link" value="{{ route('school.ppdb') }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-theme-gradient text-white font-black shadow-md">Simpan Pengumuman Baru</button>
            </form>
        </div>

        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900 border-b border-slate-200 pb-3">Daftar Pengumuman ({{ count($announcementList) }})</h3>
            <form action="{{ route('admin.cms.content.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="announcement">
                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                    @foreach($announcementList as $idx => $ann)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="px-2 py-0.5 rounded bg-orange-100 text-orange-800 font-black text-[10px] uppercase">Pengumuman #{{ $idx+1 }}</span>
                            <button type="button" @click="confirmDeleteSingle('delete-ann-{{ $idx }}', '{{ addslashes($ann['title']) }}')" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold cursor-pointer">Hapus</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <input type="text" name="items[{{ $idx }}][title]" value="{{ $ann['title'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold">
                            <div class="grid grid-cols-2 gap-2">
                                <input type="text" name="items[{{ $idx }}][category]" value="{{ $ann['category'] }}" class="w-full px-2.5 py-1.5 rounded-xl border border-slate-300 font-semibold">
                                <input type="text" name="items[{{ $idx }}][date]" value="{{ $ann['date'] }}" class="w-full px-2.5 py-1.5 rounded-xl border border-slate-300 font-semibold">
                            </div>
                            <textarea name="items[{{ $idx }}][summary]" rows="2" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-medium">{{ $ann['summary'] }}</textarea>
                            <input type="text" name="items[{{ $idx }}][link]" value="{{ $ann['link'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-semibold text-slate-600">
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-orange-600 text-white font-black text-xs shadow-md">Simpan Perubahan Pengumuman</button>
                </div>
            </form>

            @foreach($announcementList as $idx => $ann)
            <form id="delete-ann-{{ $idx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="module" value="announcement">
                <input type="hidden" name="index" value="{{ $idx }}">
            </form>
            @endforeach
        </div>
    </div>
    @endif

    <!-- TAB: FASILITAS -->
    @if($activeTab === 'facility')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900">🏢 Tambah Fasilitas Baru</h3>
            <form action="{{ route('admin.cms.content.add') }}" method="POST" class="space-y-3 text-xs">
                @csrf
                <input type="hidden" name="module" value="facility">
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Nama Fasilitas</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Icon Emoji</label>
                    <input type="text" name="icon" value="🏫" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold text-center text-lg">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Deskripsi Fasilitas</label>
                    <textarea name="desc" rows="3" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold"></textarea>
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-theme-gradient text-white font-black shadow-md">Simpan Fasilitas Baru</button>
            </form>
        </div>

        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900 border-b border-slate-200 pb-3">Daftar Sarana &amp; Prasarana ({{ count($facilityList) }})</h3>
            <form action="{{ route('admin.cms.content.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="facility">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[600px] overflow-y-auto pr-2">
                    @foreach($facilityList as $idx => $fac)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-black text-lg">{{ $fac['icon'] }}</span>
                            <button type="button" @click="confirmDeleteSingle('delete-fac-{{ $idx }}', '{{ addslashes($fac['title']) }}')" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold cursor-pointer">Hapus</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <input type="text" name="items[{{ $idx }}][title]" value="{{ $fac['title'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold">
                            <input type="text" name="items[{{ $idx }}][icon]" value="{{ $fac['icon'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-semibold">
                            <textarea name="items[{{ $idx }}][desc]" rows="2" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-medium">{{ $fac['desc'] }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-black text-xs shadow-md">Simpan Perubahan Fasilitas</button>
                </div>
            </form>

            @foreach($facilityList as $idx => $fac)
            <form id="delete-fac-{{ $idx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="module" value="facility">
                <input type="hidden" name="index" value="{{ $idx }}">
            </form>
            @endforeach
        </div>
    </div>
    @endif

    <!-- TAB: GALERI CAROUSEL -->
    @if($activeTab === 'gallery')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900">🖼️ Tambah Foto Galeri Baru</h3>
            <form action="{{ route('admin.cms.content.add') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                @csrf
                <input type="hidden" name="module" value="gallery">
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Judul Foto</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Kategori</label>
                    <input type="text" name="category" value="Kegiatan Kampus" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">📁 Upload / Pilih File Gambar Foto Galeri</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 text-xs font-semibold file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white mb-2 cursor-pointer">
                    <input type="text" name="image" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold text-slate-600" placeholder="atau tempelkan URL gambar...">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Deskripsi Foto</label>
                    <textarea name="desc" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold"></textarea>
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-theme-gradient text-white font-black shadow-md">Simpan Foto Galeri</button>
            </form>
        </div>

        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-base text-slate-900 border-b border-slate-200 pb-3">Daftar Foto Galeri Carousel ({{ count($galleryList) }})</h3>
            <form action="{{ route('admin.cms.content.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="gallery">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[600px] overflow-y-auto pr-2">
                    @foreach($galleryList as $idx => $gal)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-black text-xs bg-emerald-700 text-white px-2.5 py-1 rounded-lg uppercase shadow-xs">Foto #{{ $idx+1 }}</span>
                            <button type="button" @click="confirmDeleteSingle('delete-gal-{{ $idx }}', '{{ addslashes($gal['title']) }}')" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold cursor-pointer">🗑️ Hapus</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <label class="font-extrabold text-slate-800 block mb-1">Judul Foto</label>
                                <input type="text" name="items[{{ $idx }}][title]" value="{{ $gal['title'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900 bg-white">
                            </div>
                            <div>
                                <label class="font-extrabold text-slate-800 block mb-1">Kategori</label>
                                <input type="text" name="items[{{ $idx }}][category]" value="{{ $gal['category'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-bold text-slate-900 bg-white">
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-200 space-y-2">
                                <label class="font-extrabold text-slate-800 block">📁 Pilih File Gambar Baru (Atau Biarkan Gambar Saat Ini)</label>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $gal['image'] }}" class="w-16 h-12 object-cover rounded-xl border border-slate-300 shrink-0 shadow-xs" onerror="this.onerror=null; this.src='/images/logo-robbani-official.png';">
                                    <div class="space-y-1 w-full">
                                        <input type="file" name="items[{{ $idx }}][image_file]" accept="image/*" class="w-full text-xs font-semibold file:mr-2 file:py-1 file:px-2.5 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                                        <input type="text" name="items[{{ $idx }}][image]" value="{{ $gal['image'] }}" class="w-full px-2.5 py-1 rounded-lg border border-slate-200 text-slate-600 font-mono text-[11px]" placeholder="Path/URL gambar...">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="font-extrabold text-slate-800 block mb-1">Deskripsi</label>
                                <textarea name="items[{{ $idx }}][desc]" rows="2" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-semibold text-slate-900 bg-white">{{ $gal['desc'] }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-700 text-white font-black text-xs hover:bg-emerald-800 shadow-md transition-all">Simpan Perubahan Galeri</button>
                </div>
            </form>

            @foreach($galleryList as $idx => $gal)
            <form id="delete-gal-{{ $idx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
                <input type="hidden" name="module" value="gallery">
                <input type="hidden" name="index" value="{{ $idx }}">
            </form>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Global Hidden Bulk Delete Form -->
    <form id="bulk-delete-form" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
        <input type="hidden" name="module" id="bulk-delete-module" value="news">
        <input type="hidden" name="selected_items" id="bulk-delete-items" value="">
        <input type="hidden" name="unit_filter" value="{{ $selectedUnit ?? 'all' }}">
    </form>

</div>

@push('scripts')
<script>
/**
 * SweetAlert2 Single Delete Confirmation
 */
function confirmDeleteSingle(formId, title) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Hapus Konten Ini?',
            text: title ? `"${title}" akan dihapus permanen dari sistem.` : 'Konten yang dihapus tidak dapat dikembalikan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Sekarang!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-3xl shadow-2xl p-6',
                title: 'font-black text-slate-900',
                confirmButton: 'rounded-xl font-black text-xs px-5 py-2.5 shadow-md',
                cancelButton: 'rounded-xl font-bold text-xs px-5 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Sedang memproses penghapusan konten...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                document.getElementById(formId).submit();
            }
        });
    } else {
        if (confirm('Apakah Anda yakin ingin menghapus konten ini?')) {
            document.getElementById(formId).submit();
        }
    }
}

/**
 * SweetAlert2 Bulk Delete Confirmation (Pilih Banyak Checklist)
 */
function confirmDeleteBulk(moduleName, items) {
    if (!items || items.length === 0) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                title: 'Belum Ada Item Dipilih',
                text: 'Silakan centang satu atau beberapa checklist terlebih dahulu.',
                confirmButtonColor: '#059669',
                customClass: {
                    popup: 'rounded-3xl shadow-xl'
                }
            });
        } else {
            alert('Silakan pilih setidaknya satu item.');
        }
        return;
    }

    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: `Hapus ${items.length} Konten Sekaligus?`,
            text: `Sebanyak ${items.length} item yang Anda centang akan dihapus permanen dari sistem.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: `Ya, Hapus ${items.length} Item!`,
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-3xl shadow-2xl p-6',
                title: 'font-black text-slate-900',
                confirmButton: 'rounded-xl font-black text-xs px-5 py-2.5 shadow-md',
                cancelButton: 'rounded-xl font-bold text-xs px-5 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus Konten Terpilih...',
                    text: `Sedang memproses penghapusan massal ${items.length} item...`,
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
                const form = document.getElementById('bulk-delete-form');
                document.getElementById('bulk-delete-module').value = moduleName;
                document.getElementById('bulk-delete-items').value = items.join(',');
                form.submit();
            }
        });
    } else {
        if (confirm(`Apakah Anda yakin ingin menghapus ${items.length} item sekaligus?`)) {
            const form = document.getElementById('bulk-delete-form');
            document.getElementById('bulk-delete-module').value = moduleName;
            document.getElementById('bulk-delete-items').value = items.join(',');
            form.submit();
        }
    }
}
</script>
@endpush
@endsection
