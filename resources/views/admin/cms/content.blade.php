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
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Form Tambah Berita Baru -->
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                <span>➕</span> <span>Tambah Berita Baru</span>
            </h3>
            <form action="{{ route('admin.cms.content.add') }}" method="POST" enctype="multipart/form-data" class="space-y-3 text-xs">
                @csrf
                <input type="hidden" name="module" value="news">
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Judul Berita</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:border-emerald-500 font-semibold" placeholder="Judul berita...">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Kategori</label>
                        <input type="text" name="category" value="Berita" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Tanggal</label>
                        <input type="text" name="date" value="{{ date('d F Y') }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold">
                    </div>
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Penulis</label>
                    <input type="text" name="author" value="Humas SIT Robbani" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">📁 Upload / Pilih File Gambar Berita</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 text-xs font-semibold file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white mb-2">
                    <input type="text" name="image" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 font-semibold text-slate-600" placeholder="atau tempelkan URL gambar...">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Ringkasan (Excerpt)</label>
                    <textarea name="excerpt" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold"></textarea>
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Isi Berita Lengkap</label>
                    <textarea name="content" rows="4" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold"></textarea>
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-theme-gradient text-white font-black shadow-md hover:opacity-90">Simpan Berita Baru</button>
            </form>
        </div>

        <!-- List Berita Existing -->
        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900 flex items-center justify-between border-b border-slate-200 pb-3">
                <span>Daftar Berita Ditampilkan ({{ count($newsList) }})</span>
                <span class="text-[10px] text-slate-400 font-semibold">Gunakan form di kiri untuk menambah</span>
            </h3>
            
            <form action="{{ route('admin.cms.content.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="news">
                
                <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                    @foreach($newsList as $idx => $news)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase">
                                #{{ $idx+1 }} {{ $idx === 0 ? '🏆 HEADLINE NEWS' : 'BERITA #' . ($idx+1) }}
                            </span>
                            <button type="submit" form="delete-news-{{ $idx }}" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold">🗑️ Hapus</button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs">
                            <div>
                                <label class="font-bold text-slate-600 block mb-1">Judul</label>
                                <input type="text" name="items[{{ $idx }}][title]" value="{{ $news['title'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold text-slate-900">
                                <input type="hidden" name="items[{{ $idx }}][slug]" value="{{ $news['slug'] ?? \Illuminate\Support\Str::slug($news['title']) }}">
                            </div>
                            <div>
                                <label class="font-bold text-slate-600 block mb-1">Kategori &amp; Tanggal</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="text" name="items[{{ $idx }}][category]" value="{{ $news['category'] }}" class="w-full px-2.5 py-2 rounded-xl border border-slate-300 font-semibold">
                                    <input type="text" name="items[{{ $idx }}][date]" value="{{ $news['date'] }}" class="w-full px-2.5 py-2 rounded-xl border border-slate-300 font-semibold">
                                </div>
                            </div>
                            <div>
                                <label class="font-bold text-slate-600 block mb-1">URL Gambar</label>
                                <input type="text" name="items[{{ $idx }}][image]" value="{{ $news['image'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold">
                            </div>
                            <div>
                                <label class="font-bold text-slate-600 block mb-1">Penulis</label>
                                <input type="text" name="items[{{ $idx }}][author]" value="{{ $news['author'] ?? 'Humas SIT Robbani' }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold">
                            </div>
                            <div class="md:col-span-2">
                                <label class="font-bold text-slate-600 block mb-1">Ringkasan</label>
                                <textarea name="items[{{ $idx }}][excerpt]" rows="2" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-medium">{{ $news['excerpt'] }}</textarea>
                                <input type="hidden" name="items[{{ $idx }}][content]" value="{{ $news['content'] ?? $news['excerpt'] }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-black text-xs hover:bg-emerald-700 shadow-md">Simpan Perubahan Berita</button>
                </div>
            </form>

            @foreach($newsList as $idx => $news)
            <form id="delete-news-{{ $idx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="module" value="news">
                <input type="hidden" name="index" value="{{ $idx }}">
            </form>
            @endforeach
        </div>
    </div>
    @endif

    <!-- TAB: VIDEO YOUTUBE -->
    @if($activeTab === 'video')
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900">🎥 Tambah Video Youtube Baru</h3>
            <form action="{{ route('admin.cms.content.add') }}" method="POST" class="space-y-3 text-xs">
                @csrf
                <input type="hidden" name="module" value="video">
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Judul Video</label>
                    <input type="text" name="title" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Youtube ID (misal: dQw4w9WgXcQ)</label>
                    <input type="text" name="youtube_id" value="dQw4w9WgXcQ" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Kategori</label>
                        <input type="text" name="category" value="Dokumentasi" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 block mb-1">Durasi</label>
                        <input type="text" name="duration" value="05:00" required class="w-full px-3 py-2 rounded-xl border border-slate-300 font-semibold">
                    </div>
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Thumbnail Gambar</label>
                    <input type="url" name="thumbnail" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold" value="https://sitrobbani.sch.id/wp-content/uploads/2022/01/WEB-SIT-2.png">
                </div>
                <div>
                    <label class="font-bold text-slate-700 block mb-1">Deskripsi Singkat</label>
                    <textarea name="desc" rows="2" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-semibold"></textarea>
                </div>
                <button type="submit" class="w-full py-2.5 rounded-xl bg-theme-gradient text-white font-black shadow-md">Simpan Video Baru</button>
            </form>
        </div>

        <div class="lg:col-span-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="font-black text-sm text-slate-900 border-b border-slate-200 pb-3">Daftar Video Profil &amp; Dokumentasi ({{ count($videoList) }})</h3>
            <form action="{{ route('admin.cms.content.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="video">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[600px] overflow-y-auto pr-2">
                    @foreach($videoList as $idx => $vid)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-black text-[10px] bg-purple-100 text-purple-800 px-2 py-0.5 rounded uppercase">Video #{{ $idx+1 }}</span>
                            <button type="submit" form="delete-video-{{ $idx }}" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold">Hapus</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <label class="font-bold text-slate-600 block mb-1">Judul Video</label>
                                <input type="text" name="items[{{ $idx }}][title]" value="{{ $vid['title'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="font-bold text-slate-600 block mb-1">Kategori</label>
                                    <input type="text" name="items[{{ $idx }}][category]" value="{{ $vid['category'] }}" class="w-full px-2.5 py-1.5 rounded-xl border border-slate-300 font-semibold">
                                </div>
                                <div>
                                    <label class="font-bold text-slate-600 block mb-1">Durasi</label>
                                    <input type="text" name="items[{{ $idx }}][duration]" value="{{ $vid['duration'] }}" class="w-full px-2.5 py-1.5 rounded-xl border border-slate-300 font-semibold">
                                </div>
                            </div>
                            <div>
                                <label class="font-bold text-slate-600 block mb-1">Youtube ID / Thumbnail</label>
                                <input type="text" name="items[{{ $idx }}][youtube_id]" value="{{ $vid['youtube_id'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-semibold mb-1">
                                <input type="text" name="items[{{ $idx }}][thumbnail]" value="{{ $vid['thumbnail'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-semibold">
                            </div>
                            <div>
                                <label class="font-bold text-slate-600 block mb-1">Deskripsi</label>
                                <textarea name="items[{{ $idx }}][desc]" rows="2" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-medium">{{ $vid['desc'] }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 text-white font-black text-xs hover:bg-purple-700 shadow-md">Simpan Perubahan Video</button>
                </div>
            </form>

            @foreach($videoList as $idx => $vid)
            <form id="delete-video-{{ $idx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
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
                        <button type="submit" form="delete-agenda-{{ $idx }}" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold shrink-0">Hapus</button>
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
                            <button type="submit" form="delete-ann-{{ $idx }}" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold">Hapus</button>
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
                            <button type="submit" form="delete-fac-{{ $idx }}" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold">Hapus</button>
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
                    <input type="file" name="image_file" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-slate-300 bg-slate-50 text-xs font-semibold file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-600 file:text-white mb-2">
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
            <h3 class="font-black text-sm text-slate-900 border-b border-slate-200 pb-3">Daftar Foto Galeri Carousel ({{ count($galleryList) }})</h3>
            <form action="{{ route('admin.cms.content.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="module" value="gallery">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[600px] overflow-y-auto pr-2">
                    @foreach($galleryList as $idx => $gal)
                    <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="font-black text-[10px] bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded uppercase">Foto #{{ $idx+1 }}</span>
                            <button type="submit" form="delete-gal-{{ $idx }}" class="px-3 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-xs font-bold">Hapus</button>
                        </div>
                        <div class="space-y-2 text-xs">
                            <input type="text" name="items[{{ $idx }}][title]" value="{{ $gal['title'] }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 font-bold">
                            <input type="text" name="items[{{ $idx }}][category]" value="{{ $gal['category'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-semibold">
                            <input type="text" name="items[{{ $idx }}][image]" value="{{ $gal['image'] }}" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-semibold">
                            <textarea name="items[{{ $idx }}][desc]" rows="2" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 font-medium">{{ $gal['desc'] }}</textarea>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="pt-4 border-t border-slate-200 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-black text-xs shadow-md">Simpan Perubahan Galeri</button>
                </div>
            </form>

            @foreach($galleryList as $idx => $gal)
            <form id="delete-gal-{{ $idx }}" action="{{ route('admin.cms.content.delete') }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="module" value="gallery">
                <input type="hidden" name="index" value="{{ $idx }}">
            </form>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
