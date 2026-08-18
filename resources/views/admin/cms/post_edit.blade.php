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
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Kategori / Label Unit</label>
                        <select name="category" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white">
                            @php
                                $currentCategory = old('category', $post['category'] ?? '');
                                $categories = [
                                    'Berita SDIT', 'Artikel SDIT', 'Prestasi SDIT',
                                    'Berita SMPIT', 'Artikel SMPIT', 'Prestasi SMPIT',
                                    'Berita SMAIT', 'Artikel SMAIT', 'Prestasi SMAIT',
                                    'Berita TKIT', 'Artikel TKIT', 'Pentas Seni TKIT',
                                    'Berita Yayasan', 'Artikel Edukasi', 'Kajian & Opini', 'Pengumuman Resmi'
                                ];
                            @endphp
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ $currentCategory === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(!$userUnit)
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 mb-1">Target Unit Sekolah</label>
                        <select name="unit" class="w-full text-xs font-bold px-3 py-2.5 rounded-xl border border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 bg-white">
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
