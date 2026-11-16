@extends('admin.layout')

@section('title', ($isNew ? 'Tambah Berita / Artikel Baru' : 'Edit Berita / Artikel') . ' — CMS Robbani')

@section('content')
<!-- Include Quill.js WYSIWYG Editor Styles and Scripts -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<div class="max-w-5xl mx-auto space-y-6">

    <!-- Header Navigation & Title -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('admin.cms.content', ['tab' => 'news']) }}" class="text-xs font-bold text-slate-500 hover:text-emerald-700 transition-colors flex items-center gap-1">
                    <span>← Kembali ke Daftar Berita &amp; Artikel</span>
                </a>
                <span class="text-slate-300">•</span>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase">
                    {{ $isNew ? '✨ Mode Buat Konten Baru' : '✏️ Mode Edit Konten' }}
                </span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                {{ $isNew ? 'Tulis Berita / Artikel Baru' : 'Edit Konten: ' . \Illuminate\Support\Str::limit($post['title'] ?? '', 45) }}
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Tulis dan atur format konten artikel secara mudah dengan visual editor tanpa memerlukan koding HTML.</p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('admin.cms.content', ['tab' => 'news']) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-all">
                Batal
            </a>
            <button type="button" onclick="document.getElementById('postEditorForm').requestSubmit()" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition-all flex items-center gap-2 cursor-pointer">
                <span>💾 Simpan {{ $isNew ? 'Post Baru' : 'Perubahan' }}</span>
            </button>
        </div>
    </div>

    <!-- Main Editor Form -->
    <form id="postEditorForm" action="{{ route('admin.cms.post.save') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <input type="hidden" name="is_new" value="{{ $isNew ? '1' : '0' }}">
        <input type="hidden" name="index" value="{{ $index }}">
        <input type="hidden" name="original_slug" value="{{ $post['slug'] ?? '' }}">
        <input type="hidden" name="original_title" value="{{ $post['title'] ?? '' }}">
        <input type="hidden" name="existing_image" value="{{ $post['image'] ?? '/images/mockup_desktop_1.png' }}">
        <input type="hidden" name="content" id="hiddenContentInput">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left Column: Title & Rich Text Content Editor (8 Cols) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Judul Utama Post -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Judul Berita / Artikel <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $post['title'] ?? '') }}" required placeholder="Ketik judul artikel yang menarik di sini..." class="w-full text-base sm:text-lg font-black px-4 py-3 rounded-2xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-slate-900 placeholder:text-slate-400 placeholder:font-bold">
                    <span class="text-[11px] text-slate-400 font-medium block">Slug URL otomatis dibuat dari judul.</span>
                </div>

                <!-- Rich Text Editor Container (Quill Visual Editor) -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Isi Konten Berita / Artikel <span class="text-rose-500">*</span></label>
                        <span class="text-[11px] bg-emerald-50 text-emerald-700 font-bold px-2.5 py-1 rounded-lg border border-emerald-200">
                            ✨ Visual Editor (WordPress Style)
                        </span>
                    </div>

                    <!-- Quill Toolbar Customization Wrapper -->
                    <div class="border border-slate-300 rounded-2xl overflow-hidden shadow-inner">
                        <div id="quillEditor" class="min-h-[380px] text-sm text-slate-800 leading-relaxed font-sans bg-white">
                            {!! old('content', $post['content'] ?? '') !!}
                        </div>
                    </div>
                    <span class="text-[11px] text-slate-400 font-medium block">Gunakan toolbar visual di atas untuk menebalkan teks (Bold), miring (Italic), garis bawah (Underline), meratakan paragraf, atau membuat daftar (Bullet list).</span>
                </div>

                <!-- Excerpt / Ringkasan -->
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">Ringkasan / Excerpt Cuplikan Berita</label>
                    <textarea name="excerpt" rows="3" placeholder="Ketik cuplikan singkat berita (opsional, jika kosong akan diambil dari paragraf pertama konten)..." class="w-full text-xs font-medium px-4 py-3 rounded-2xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-slate-800">{{ old('excerpt', $post['excerpt'] ?? '') }}</textarea>
                </div>
            </div>

            <!-- Right Column: Settings, Category, Image & Meta (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Publishing Options Card -->
                <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                    <h3 class="text-xs font-black uppercase text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>⚙️</span> <span>Pengaturan Publikasi</span>
                    </h3>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-[11px] font-black text-slate-700 uppercase">Kategori / Label Unit</label>
                            <span id="unitBadgeIndicator" class="text-[9px] font-black px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 border border-slate-200">
                                Global / Unit
                            </span>
                        </div>
                        <select name="category" id="categorySelect" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white">
                            @php
                                $currentCategory = old('category', $post['category'] ?? '');
                            @endphp
                            <optgroup label="🧸 KATEGORI KHUSUS KB/TKIT (Hanya Tampil di Unit TKIT)">
                                <option value="Khusus TKIT - Berita" {{ $currentCategory === 'Khusus TKIT - Berita' ? 'selected' : '' }}>Khusus TKIT - Berita</option>
                                <option value="Khusus TKIT - Artikel" {{ $currentCategory === 'Khusus TKIT - Artikel' ? 'selected' : '' }}>Khusus TKIT - Artikel</option>
                                <option value="Khusus TKIT - Prestasi Cilik" {{ $currentCategory === 'Khusus TKIT - Prestasi Cilik' ? 'selected' : '' }}>Khusus TKIT - Prestasi Cilik</option>
                                <option value="Khusus TKIT - Parenting & Kegiatan" {{ $currentCategory === 'Khusus TKIT - Parenting & Kegiatan' ? 'selected' : '' }}>Khusus TKIT - Parenting & Kegiatan</option>
                                <option value="Berita TKIT" {{ $currentCategory === 'Berita TKIT' ? 'selected' : '' }}>Berita TKIT</option>
                                <option value="Artikel TKIT" {{ $currentCategory === 'Artikel TKIT' ? 'selected' : '' }}>Artikel TKIT</option>
                                <option value="Pentas Seni TKIT" {{ $currentCategory === 'Pentas Seni TKIT' ? 'selected' : '' }}>Pentas Seni TKIT</option>
                            </optgroup>
                            <optgroup label="🏫 KATEGORI KHUSUS SDIT (Hanya Tampil di Unit SDIT)">
                                <option value="Khusus SDIT - Berita" {{ $currentCategory === 'Khusus SDIT - Berita' ? 'selected' : '' }}>Khusus SDIT - Berita</option>
                                <option value="Khusus SDIT - Artikel" {{ $currentCategory === 'Khusus SDIT - Artikel' ? 'selected' : '' }}>Khusus SDIT - Artikel</option>
                                <option value="Khusus SDIT - Prestasi Siswa" {{ $currentCategory === 'Khusus SDIT - Prestasi Siswa' ? 'selected' : '' }}>Khusus SDIT - Prestasi Siswa</option>
                                <option value="Khusus SDIT - Kegiatan Siswa" {{ $currentCategory === 'Khusus SDIT - Kegiatan Siswa' ? 'selected' : '' }}>Khusus SDIT - Kegiatan Siswa</option>
                                <option value="Berita SDIT" {{ $currentCategory === 'Berita SDIT' ? 'selected' : '' }}>Berita SDIT</option>
                                <option value="Artikel SDIT" {{ $currentCategory === 'Artikel SDIT' ? 'selected' : '' }}>Artikel SDIT</option>
                                <option value="Prestasi SDIT" {{ $currentCategory === 'Prestasi SDIT' ? 'selected' : '' }}>Prestasi SDIT</option>
                            </optgroup>
                            <optgroup label="📚 KATEGORI KHUSUS SMPIT (Hanya Tampil di Unit SMPIT)">
                                <option value="Khusus SMPIT - Berita" {{ $currentCategory === 'Khusus SMPIT - Berita' ? 'selected' : '' }}>Khusus SMPIT - Berita</option>
                                <option value="Khusus SMPIT - Artikel" {{ $currentCategory === 'Khusus SMPIT - Artikel' ? 'selected' : '' }}>Khusus SMPIT - Artikel</option>
                                <option value="Khusus SMPIT - Prestasi Siswa" {{ $currentCategory === 'Khusus SMPIT - Prestasi Siswa' ? 'selected' : '' }}>Khusus SMPIT - Prestasi Siswa</option>
                                <option value="Khusus SMPIT - Boarding & Karakter" {{ $currentCategory === 'Khusus SMPIT - Boarding & Karakter' ? 'selected' : '' }}>Khusus SMPIT - Boarding & Karakter</option>
                                <option value="Berita SMPIT" {{ $currentCategory === 'Berita SMPIT' ? 'selected' : '' }}>Berita SMPIT</option>
                                <option value="Artikel SMPIT" {{ $currentCategory === 'Artikel SMPIT' ? 'selected' : '' }}>Artikel SMPIT</option>
                                <option value="Prestasi SMPIT" {{ $currentCategory === 'Prestasi SMPIT' ? 'selected' : '' }}>Prestasi SMPIT</option>
                            </optgroup>
                            <optgroup label="🎓 KATEGORI KHUSUS SMAIT (Hanya Tampil di Unit SMAIT)">
                                <option value="Khusus SMAIT - Berita" {{ $currentCategory === 'Khusus SMAIT - Berita' ? 'selected' : '' }}>Khusus SMAIT - Berita</option>
                                <option value="Khusus SMAIT - Artikel" {{ $currentCategory === 'Khusus SMAIT - Artikel' ? 'selected' : '' }}>Khusus SMAIT - Artikel</option>
                                <option value="Khusus SMAIT - Prestasi Siswa" {{ $currentCategory === 'Khusus SMAIT - Prestasi Siswa' ? 'selected' : '' }}>Khusus SMAIT - Prestasi Siswa</option>
                                <option value="Khusus SMAIT - Kampus & Karir" {{ $currentCategory === 'Khusus SMAIT - Kampus & Karir' ? 'selected' : '' }}>Khusus SMAIT - Kampus & Karir</option>
                                <option value="Berita SMAIT" {{ $currentCategory === 'Berita SMAIT' ? 'selected' : '' }}>Berita SMAIT</option>
                                <option value="Artikel SMAIT" {{ $currentCategory === 'Artikel SMAIT' ? 'selected' : '' }}>Artikel SMAIT</option>
                                <option value="Prestasi SMAIT" {{ $currentCategory === 'Prestasi SMAIT' ? 'selected' : '' }}>Prestasi SMAIT</option>
                            </optgroup>
                            <optgroup label="🏢 KATEGORI UMUM / YAYASAN (Tampil di Portal Berita & Seluruh Unit)">
                                <option value="Berita Yayasan" {{ $currentCategory === 'Berita Yayasan' ? 'selected' : '' }}>Berita Yayasan</option>
                                <option value="Artikel Edukasi" {{ $currentCategory === 'Artikel Edukasi' ? 'selected' : '' }}>Artikel Edukasi</option>
                                <option value="Kajian & Opini" {{ $currentCategory === 'Kajian & Opini' ? 'selected' : '' }}>Kajian & Opini</option>
                                <option value="Pengumuman Resmi" {{ $currentCategory === 'Pengumuman Resmi' ? 'selected' : '' }}>Pengumuman Resmi</option>
                            </optgroup>
                        </select>
                        <p id="unitScopeInfo" class="text-[10px] text-slate-500 mt-1 font-medium flex items-center gap-1">
                            <span>🔒</span> <span id="unitScopeText">Kategori Khusus Unit memastikan postingan hanya tampil di halaman unit yang dipilih dan terisolasi dari unit lain.</span>
                        </p>
                    </div>

                    @if(!$userUnit)
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Target Unit Sekolah</label>
                        <select name="unit" id="unitSelect" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white">
                            @php $currentUnit = old('unit', $post['unit'] ?? 'yayasan'); @endphp
                            <option value="yayasan" {{ $currentUnit === 'yayasan' ? 'selected' : '' }}>Yayasan (Umum)</option>
                            <option value="sdit" {{ $currentUnit === 'sdit' ? 'selected' : '' }}>SDIT Robbani</option>
                            <option value="smpit" {{ $currentUnit === 'smpit' ? 'selected' : '' }}>SMPIT Robbani</option>
                            <option value="smait" {{ $currentUnit === 'smait' ? 'selected' : '' }}>SMAIT Robbani</option>
                            <option value="tkit" {{ $currentUnit === 'tkit' ? 'selected' : '' }}>KB/TKIT Robbani</option>
                        </select>
                    </div>
                    @endif

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Penulis / Author</label>
                        <input type="text" name="author" value="{{ old('author', $post['author'] ?? 'Humas Robbani') }}" class="w-full text-xs font-semibold px-3 py-2 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Tanggal Rilis / Tampil</label>
                        <input type="text" name="date" value="{{ old('date', $post['date'] ?? date('d F Y')) }}" class="w-full text-xs font-semibold px-3 py-2 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="e.g. 18 Agustus 2026">
                    </div>
                </div>

                <!-- Featured Image Upload Card -->
                <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                    <h3 class="text-xs font-black uppercase text-slate-900 border-b border-slate-100 pb-3 flex items-center gap-2">
                        <span>🖼️</span> <span>Gambar Utama (Featured Image)</span>
                    </h3>

                    <div class="aspect-video rounded-2xl overflow-hidden border border-slate-200 bg-slate-900 relative flex items-center justify-center shadow-inner">
                        <img id="imagePreview" src="{{ asset(!empty($post['image']) ? $post['image'] : '/images/mockup_desktop_1.png') }}" alt="Preview" class="w-full h-full object-cover">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Pilih File Foto Utama:</label>
                        <input type="file" name="image_file" accept="image/*" onchange="previewSelectedImage(this)" class="w-full text-xs text-slate-600 border border-slate-300 rounded-xl p-2 bg-slate-50">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">atau Tempelkan URL Gambar:</label>
                        <input type="text" name="image_url" value="{{ old('image_url', $post['image'] ?? '') }}" placeholder="https://..." class="w-full text-xs font-medium px-3 py-2 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                </div>

                <!-- Action Button Card -->
                <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-xs space-y-3">
                    <button type="submit" class="w-full py-3.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg hover:shadow-emerald-600/30 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <span>💾 Simpan &amp; Terbitkan Post</span>
                    </button>
                    <a href="{{ route('admin.cms.content', ['tab' => 'news']) }}" class="w-full py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs flex items-center justify-center text-center transition-all">
                        Kembali Tanpa Menyimpan
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>

<!-- Script to Initialize Quill Visual Rich Text Editor -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill Editor with full visual formatting toolbar
        var quill = new Quill('#quillEditor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [2, 3, 4, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'align': [] }],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['link'],
                    [{ 'color': [] }, { 'background': [] }],
                    ['clean']
                ]
            },
            placeholder: 'Tuliskan isi berita atau artikel lengkap di sini...'
        });

        // Sync Quill HTML content to hidden input before form submit
        var form = document.getElementById('postEditorForm');
        form.addEventListener('submit', function(e) {
            var html = quill.root.innerHTML;
            if (html === '<p><br></p>') html = '';
            document.getElementById('hiddenContentInput').value = html;
        });

        // Sync Category and Target Unit dynamically
        var categorySelect = document.getElementById('categorySelect');
        var unitSelect = document.getElementById('unitSelect');
        var unitBadgeIndicator = document.getElementById('unitBadgeIndicator');
        var unitScopeText = document.getElementById('unitScopeText');

        function updateUnitFromCategory() {
            if (!categorySelect) return;
            var val = categorySelect.value.toLowerCase();
            var targetUnit = 'yayasan';
            var badgeText = '🏢 Yayasan (Umum)';
            var badgeClass = 'bg-slate-100 text-slate-700 border-slate-300';
            var scopeMsg = 'Postingan ini tampil di beranda utama dan seluruh unit.';

            if (val.includes('tkit') || val.includes('tk it') || val.includes('paud')) {
                targetUnit = 'tkit';
                badgeText = '🧸 Khusus KB/TKIT';
                badgeClass = 'bg-amber-100 text-amber-800 border-amber-300';
                scopeMsg = 'Postingan ini terisolasi dan HANYA tampil di halaman Unit KB/TKIT.';
            } else if (val.includes('sdit') || val.includes('sd it')) {
                targetUnit = 'sdit';
                badgeText = '🎒 Khusus SDIT';
                badgeClass = 'bg-emerald-100 text-emerald-800 border-emerald-300';
                scopeMsg = 'Postingan ini terisolasi dan HANYA tampil di halaman Unit SDIT.';
            } else if (val.includes('smpit') || val.includes('smp it')) {
                targetUnit = 'smpit';
                badgeText = '📚 Khusus SMPIT';
                badgeClass = 'bg-blue-100 text-blue-800 border-blue-300';
                scopeMsg = 'Postingan ini terisolasi dan HANYA tampil di halaman Unit SMPIT.';
            } else if (val.includes('smait') || val.includes('sma it')) {
                targetUnit = 'smait';
                badgeText = '🎓 Khusus SMAIT';
                badgeClass = 'bg-purple-100 text-purple-800 border-purple-300';
                scopeMsg = 'Postingan ini terisolasi dan HANYA tampil di halaman Unit SMAIT.';
            }

            if (unitSelect) {
                unitSelect.value = targetUnit;
            }
            if (unitBadgeIndicator) {
                unitBadgeIndicator.textContent = badgeText;
                unitBadgeIndicator.className = 'text-[9px] font-black px-2 py-0.5 rounded-full border ' + badgeClass;
            }
            if (unitScopeText) {
                unitScopeText.textContent = scopeMsg;
            }
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', updateUnitFromCategory);
            updateUnitFromCategory();
        }
    });

    function previewSelectedImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
