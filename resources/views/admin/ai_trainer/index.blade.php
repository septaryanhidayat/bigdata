@extends('admin.layout')

@section('title', '🤖 AI Knowledge Base Trainer Studio')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 space-y-8 max-w-[1600px] mx-auto">

    {{-- ═══════════════════════════════════════════════════════════════════════
         1. HERO HEADER: AI COMMAND CENTER (MENGIKUTI WARNA GLOBAL TEMA ADMIN)
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-3xl bg-theme-gradient text-white p-6 sm:p-8 shadow-xl border border-white/20">
        {{-- Ambient ambient lighting overlay --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-black/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-3.5">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 flex items-center justify-center text-3xl shadow-lg shrink-0">
                        🤖
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2.5">
                            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white font-headline">AI Knowledge Studio</h1>
                            <span class="px-3 py-0.5 rounded-full bg-white/25 border border-white/40 text-white text-[10px] font-black uppercase tracking-wider shadow-sm">
                                RAG v2.5 Neural Engine
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-white/90 font-medium mt-0.5">Pusat pelatihan kecerdasan buatan &amp; knowledge base interaktif SIT Robbani</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Status Engine Chip --}}
                @php $geminiActive = !empty(env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY')); @endphp
                <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-black/30 backdrop-blur-md border border-white/20 shadow-inner">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $geminiActive ? 'bg-emerald-300' : 'bg-cyan-300' }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $geminiActive ? 'bg-emerald-400' : 'bg-cyan-400' }}"></span>
                    </span>
                    <span class="text-xs font-bold text-white">
                        {{ $geminiActive ? 'Gemini AI Cloud Aktif' : 'Neural RAG Local (Fast)' }}
                    </span>
                </div>

                {{-- Auto-Sync Button --}}
                <button id="btnAutoSync" onclick="doAutoSync()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-white text-slate-900 hover:bg-slate-100 font-black text-xs shadow-lg hover:scale-105 active:scale-95 transition-all border border-white/80 cursor-pointer">
                    <span id="syncIcon" class="text-sm">⚡</span>
                    <span id="syncText">Auto-Sync Website</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="flex items-center gap-3 p-4 bg-emerald-50 border-2 border-emerald-500 rounded-2xl text-emerald-950 text-sm font-bold shadow-sm">
        <span class="text-lg">✅</span> <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 p-4 bg-red-50 border-2 border-red-500 rounded-2xl text-red-950 text-sm font-bold shadow-sm">
        <span class="text-lg">❌</span> <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════════
         2. KARTU METRIK KONTRAS TINGGI (SOLID WHITE CARDS + WARNA TEMA GLOBAL)
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-5">
        
        {{-- Card 1: Total Dokumen --}}
        <div class="bg-white border-2 border-slate-200 hover:border-slate-400 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider text-slate-600">Total Dokumen</span>
                <div class="w-10 h-10 rounded-2xl bg-theme-light text-theme-accent flex items-center justify-center text-lg font-bold border border-slate-200 shadow-xs group-hover:scale-110 transition-transform">
                    📚
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight font-headline">{{ $totalDocs }}</div>
                <div class="text-xs font-bold text-slate-500 mt-0.5">Basis Pengetahuan AI</div>
            </div>
        </div>

        {{-- Card 2: Dokumen Aktif --}}
        <div class="bg-white border-2 border-slate-200 hover:border-slate-400 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider text-emerald-800">Dokumen Aktif</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-lg font-bold border border-emerald-200 shadow-xs group-hover:scale-110 transition-transform">
                    ✨
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight font-headline">{{ $activeDocs }}</div>
                <div class="text-xs font-bold text-emerald-700 mt-0.5">Live Digunakan AI</div>
            </div>
        </div>

        {{-- Card 3: File Diupload --}}
        <div class="bg-white border-2 border-slate-200 hover:border-slate-400 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider text-blue-800">File Diupload</span>
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-lg font-bold border border-blue-200 shadow-xs group-hover:scale-110 transition-transform">
                    📂
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight font-headline">{{ $uploadedCount }}</div>
                <div class="text-xs font-bold text-slate-500 mt-0.5">PDF · Word · Excel · TXT</div>
            </div>
        </div>

        {{-- Card 4: Data Website --}}
        <div class="bg-white border-2 border-slate-200 hover:border-slate-400 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between relative overflow-hidden">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider text-cyan-800">Data Website</span>
                <div class="w-10 h-10 rounded-2xl bg-cyan-50 text-cyan-700 flex items-center justify-center text-lg font-bold border border-cyan-200 shadow-xs group-hover:scale-110 transition-transform">
                    🌐
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight font-headline">{{ $websiteDataCount }}</div>
                <div class="text-xs font-bold text-slate-500 mt-0.5">Berita, Artikel, FAQ, Unit</div>
            </div>
        </div>

        {{-- Card 5: Total Kata --}}
        <div class="bg-white border-2 border-slate-200 hover:border-slate-400 rounded-3xl p-5 shadow-sm hover:shadow-md transition-all group flex flex-col justify-between relative overflow-hidden col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black uppercase tracking-wider text-amber-800">Total Kata</span>
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center text-lg font-bold border border-amber-200 shadow-xs group-hover:scale-110 transition-transform">
                    🔤
                </div>
            </div>
            <div class="mt-4">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight font-headline">{{ number_format($totalWords) }}</div>
                <div class="text-xs font-bold text-slate-500 mt-0.5">{{ $lastSync ? 'Sync: '.$lastSync->diffForHumans() : 'Knowledge Siap' }}</div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         3. RUANG KERJA UTAMA 2 KOLOM
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">

        {{-- ── PANEL KIRI: UJI COBA CHATBOT & INPUT KNOWLEDGE (5 Kolom) ──────── --}}
        <div class="xl:col-span-5 space-y-6">

            {{-- 1. CHATBOT AI TESTER (MENGIKUTI WARNA TEMA GLOBAL & KONTRAS TINGGI) --}}
            <div class="bg-white border-2 border-slate-200 rounded-3xl shadow-lg overflow-hidden flex flex-col">
                {{-- Chat Header --}}
                <div class="px-6 py-4 bg-theme-gradient text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white/20 border border-white/30 flex items-center justify-center text-base shadow-sm">
                            💬
                        </div>
                        <div>
                            <h2 class="text-sm font-black text-white">Uji Coba Chatbot AI</h2>
                            <p class="text-[11px] text-white/80 font-medium">Streaming Neural Response Tester</p>
                        </div>
                    </div>
                    <button onclick="clearTestChat()" title="Bersihkan Chat" class="px-3 py-1 rounded-xl bg-white/20 hover:bg-white/30 text-white text-xs font-bold transition-all flex items-center gap-1 cursor-pointer">
                        <span>🧹</span> <span class="hidden sm:inline">Clear</span>
                    </button>
                </div>

                {{-- Quick Prompt Suggestions --}}
                <div class="px-5 py-3 bg-slate-50 border-b border-slate-200 flex items-center gap-2 overflow-x-auto text-[11px] no-scrollbar">
                    <span class="text-slate-500 font-extrabold shrink-0">Contoh:</span>
                    <button onclick="quickAsk('Siapa kepala sekolah TK, SD, dan SMP?')" class="px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-900 hover:text-white text-slate-800 font-bold shrink-0 transition-all cursor-pointer">
                        🎓 Kepala Sekolah
                    </button>
                    <button onclick="quickAsk('Bagaimana cara daftar SPMB dan syaratnya?')" class="px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-900 hover:text-white text-slate-800 font-bold shrink-0 transition-all cursor-pointer">
                        📝 Syarat SPMB
                    </button>
                    <button onclick="quickAsk('Berapa biaya SPP dan cara bayarnya?')" class="px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-900 hover:text-white text-slate-800 font-bold shrink-0 transition-all cursor-pointer">
                        💳 Info SPP
                    </button>
                    <button onclick="quickAsk('Target hafalan tahfidz di SMPIT')" class="px-3 py-1.5 rounded-xl bg-slate-200 hover:bg-slate-900 hover:text-white text-slate-800 font-bold shrink-0 transition-all cursor-pointer">
                        📖 Target Tahfidz
                    </button>
                </div>

                {{-- Chat Message Stream Area --}}
                <div class="p-5 flex-1 min-h-[320px] max-h-[420px] overflow-y-auto space-y-4 bg-slate-100/70" id="chatMessages">
                    {{-- Welcome bubble --}}
                    <div class="flex gap-3 items-start">
                        <div class="w-8 h-8 rounded-2xl bg-theme-accent text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                            🤖
                        </div>
                        <div class="bg-white border-2 border-slate-200 rounded-2xl rounded-tl-none p-4 text-xs sm:text-sm text-slate-900 font-medium max-w-[85%] shadow-sm leading-relaxed space-y-1">
                            <p class="font-black text-slate-900">Assalamu'alaikum!</p>
                            <p class="text-slate-700">Saya asisten AI resmi SIT Robbani. Silakan ketik pertanyaan atau klik salah satu topik di atas untuk menguji respon pintar saya.</p>
                        </div>
                    </div>
                </div>

                {{-- Chat Input Bar --}}
                <div class="p-4 bg-white border-t-2 border-slate-200">
                    <form onsubmit="event.preventDefault(); sendTestChat();" class="flex items-center gap-2">
                        <input type="text" id="testChatInput" placeholder="Ketik pertanyaan uji (misal: kepala tk, syarat spmb, spp)..." class="flex-1 bg-slate-50 border-2 border-slate-300 rounded-2xl px-4 py-3 text-xs sm:text-sm font-semibold text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
                        <button type="submit" id="btnSendTest" class="px-5 py-3 rounded-2xl bg-theme-accent text-white hover:opacity-90 font-black text-xs sm:text-sm shadow-md hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-1.5 shrink-0 cursor-pointer">
                            <span>Kirim</span>
                            <span class="text-xs">➔</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- 2. UPLOAD DOKUMEN PANEL --}}
            <div class="bg-white border-2 border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-800 text-white flex items-center justify-center text-base font-bold shadow-sm">
                            📂
                        </div>
                        <div>
                            <h2 class="font-black text-slate-900 text-sm">Upload Dokumen Knowledge</h2>
                            <p class="text-[11px] text-slate-500 font-semibold">PDF, DOCX, XLSX, TXT (maks. 20MB)</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.ai-trainer.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        {{-- Drag & Drop Area --}}
                        <div id="dropZone" class="relative border-2 border-dashed border-slate-300 hover:border-slate-800 bg-slate-50 hover:bg-slate-100/80 rounded-3xl p-6 text-center transition-all cursor-pointer mb-5 group" onclick="document.getElementById('fileInput').click()">
                            <input type="file" name="file" id="fileInput" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" onchange="onFileSelect(this)">
                            <div id="dropZoneDefault">
                                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-200 text-slate-700 flex items-center justify-center text-2xl mb-2 group-hover:scale-110 transition-transform shadow-xs">
                                    ☁️
                                </div>
                                <p class="text-sm font-bold text-slate-900 group-hover:text-slate-950 transition-colors">Klik atau Seret Dokumen ke Sini</p>
                                <p class="text-xs text-slate-500 mt-1">Mendukung file SOP, Panduan SPMB, Kurikulum &amp; Dokumen Sekolah</p>
                            </div>
                            <div id="dropZoneSelected" class="hidden">
                                <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-100 text-emerald-800 flex items-center justify-center text-2xl mb-2 animate-bounce">
                                    📄
                                </div>
                                <p class="text-sm font-black text-emerald-800" id="selectedFileName"></p>
                                <p class="text-xs text-slate-600 mt-1" id="selectedFileSize"></p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1.5">Judul Dokumen <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                                <input type="text" name="title" placeholder="Contoh: Brosur & Panduan SPMB 2026" class="w-full bg-slate-50 border-2 border-slate-200 rounded-2xl px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1.5">Kategori Dokumen <span class="text-red-500">*</span></label>
                                <select name="category" required class="w-full bg-slate-50 border-2 border-slate-200 rounded-2xl px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $key => $label)
                                        @if($key !== 'website_data')
                                        <option value="{{ $key }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" id="btnUpload" class="w-full py-3.5 rounded-2xl bg-slate-900 hover:bg-black text-white font-black text-xs sm:text-sm shadow-md hover:shadow-lg transition-all hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                                <span>⬆️</span> <span>Upload &amp; Latih Dokumen</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- 3. INPUT MANUAL KNOWLEDGE PANEL --}}
            <div class="bg-white border-2 border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-slate-800 text-white flex items-center justify-center text-base font-bold shadow-sm">
                            ✍️
                        </div>
                        <div>
                            <h2 class="font-black text-slate-900 text-sm">Input Manual Pengetahuan</h2>
                            <p class="text-[11px] text-slate-500 font-semibold">Tulis informasi kustom langsung ke AI</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.ai-trainer.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1.5">Topik / Judul <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required placeholder="Contoh: Tata Tertib Izin Masuk Sekolah SMPIT" class="w-full bg-slate-50 border-2 border-slate-200 rounded-2xl px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" required class="w-full bg-slate-50 border-2 border-slate-200 rounded-2xl px-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $key => $label)
                                    @if($key !== 'website_data')
                                    <option value="{{ $key }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-800 mb-1.5">Konten Pengetahuan <span class="text-red-500">*</span></label>
                            <textarea name="content" required rows="5" placeholder="Tulis instruksi atau informasi penting di sini... (Misal: Alur pengajuan surat izin, aturan seragam harian, kuota beasiswa tahfidz, dll.)" class="w-full bg-slate-50 border-2 border-slate-200 rounded-2xl p-4 text-xs sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-2xl bg-slate-900 hover:bg-black text-white font-black text-xs sm:text-sm shadow-md hover:shadow-lg transition-all hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                            <span>💾</span> <span>Simpan ke Knowledge Base</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- ── PANEL KANAN: REPOSITORI DOKUMEN KNOWLEDGE BASE (7 Kolom) ─────── --}}
        <div class="xl:col-span-7 space-y-6">

            <div class="bg-white border-2 border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                
                {{-- Top Filter Tabs Ribbon --}}
                <div class="p-6 border-b border-slate-200 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-base font-black text-slate-900 font-headline">Daftar Dokumen Knowledge Base</h2>
                            <p class="text-xs text-slate-600 font-medium">Kelola sumber data yang dibaca oleh asisten AI saat menjawab pengguna</p>
                        </div>

                        {{-- Bulk Delete Button --}}
                        <button id="btnBulkDelete" onclick="bulkDelete()" class="hidden items-center gap-1.5 px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md transition-all cursor-pointer">
                            <span>🗑️</span> <span>Hapus Terpilih</span>
                        </button>
                    </div>

                    {{-- Category Tabs --}}
                    <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-slate-200">
                        <button onclick="filterCategory('all')" class="cat-tab active px-3.5 py-1.5 rounded-xl text-xs font-black bg-slate-900 text-white shadow-sm transition-all cursor-pointer" data-category="all">
                            Semua ({{ $totalDocs }})
                        </button>
                        @foreach($categories as $key => $label)
                        @php $cnt = $categoryStats[$key] ?? 0; @endphp
                        <button onclick="filterCategory('{{ $key }}')" class="cat-tab px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-all cursor-pointer" data-category="{{ $key }}">
                            {{ $label }} ({{ $cnt }})
                        </button>
                        @endforeach
                    </div>

                    {{-- Search Box --}}
                    <div class="relative">
                        <input type="text" id="searchDocInput" oninput="searchDocs(this.value)" placeholder="Cari judul, kategori, atau isi dokumen..." class="w-full bg-slate-50 border-2 border-slate-200 rounded-2xl pl-11 pr-4 py-2.5 text-xs sm:text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition-all">
                        <span class="absolute left-4 top-3 text-slate-400 text-sm">🔍</span>
                    </div>
                </div>

                {{-- Document List / Table --}}
                <div class="divide-y divide-slate-100 overflow-x-auto max-h-[800px] overflow-y-auto" id="docListContainer">
                    @forelse($knowledgeBases as $doc)
                    <div class="doc-row p-5 hover:bg-slate-50 transition-colors flex items-start justify-between gap-4" data-category="{{ $doc->category }}" data-title="{{ strtolower($doc->title) }}" data-id="{{ $doc->id }}">
                        
                        <div class="flex items-start gap-3.5 flex-1 min-w-0">
                            {{-- Checkbox --}}
                            <input type="checkbox" value="{{ $doc->id }}" class="row-checkbox mt-1 w-4 h-4 rounded text-slate-900 focus:ring-slate-900 cursor-pointer" onchange="updateBulkDeleteBtn()">

                            {{-- Source Icon --}}
                            <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center text-lg shrink-0 mt-0.5 border border-slate-200">
                                @if($doc->source_type === 'pdf') 📕
                                @elseif($doc->source_type === 'word') 📘
                                @elseif($doc->source_type === 'excel') 📗
                                @elseif($doc->source_type === 'website_data') 🌐
                                @else 📄
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="space-y-1 min-w-0 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-xs sm:text-sm font-black text-slate-900 truncate">{{ $doc->title }}</h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase {{ $doc->category_color }}">
                                        {{ $doc->category_label }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-700 line-clamp-2 leading-relaxed font-medium">
                                    {{ $doc->summary ?? Str::limit($doc->raw_content, 120) }}
                                </p>
                                <div class="flex flex-wrap items-center gap-3 text-[11px] font-bold text-slate-500 pt-1">
                                    <span>🔤 {{ number_format($doc->word_count) }} kata</span>
                                    <span>•</span>
                                    <span>👤 {{ $doc->uploaded_by ?? 'System' }}</span>
                                    <span>•</span>
                                    <span>🕒 {{ $doc->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-3 shrink-0">
                            {{-- Active Toggle Switch --}}
                            <label class="relative inline-flex items-center cursor-pointer" title="Aktifkan / Nonaktifkan Dokumen">
                                <input type="checkbox" onchange="toggleDoc({{ $doc->id }})" class="sr-only peer" {{ $doc->is_active ? 'checked' : '' }}>
                                <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-600"></div>
                            </label>

                            {{-- Delete Button --}}
                            <button onclick="deleteDoc({{ $doc->id }}, '{{ addslashes($doc->title) }}')" title="Hapus Dokumen" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-red-50 text-slate-500 hover:text-red-600 flex items-center justify-center transition-colors cursor-pointer">
                                🗑️
                            </button>
                        </div>

                    </div>
                    @empty
                    <div class="p-12 text-center text-slate-500 space-y-2">
                        <div class="text-4xl">📭</div>
                        <p class="font-black text-slate-800">Belum ada dokumen knowledge base.</p>
                        <p class="text-xs text-slate-500">Silakan upload dokumen atau klik tombol Auto-Sync Website di atas.</p>
                    </div>
                    @endforelse
                </div>

            </div>

            {{-- Auto-Sync Explanatory Banner --}}
            <div class="bg-slate-900 rounded-3xl p-6 text-white border border-slate-800 flex items-start gap-4 shadow-xl">
                <div class="w-12 h-12 rounded-2xl bg-white/15 border border-white/20 flex items-center justify-center text-2xl shrink-0">
                    🔄
                </div>
                <div class="space-y-1 text-xs">
                    <h4 class="text-sm font-black text-white">Tentang Auto-Sync Website</h4>
                    <p class="text-slate-300 leading-relaxed font-medium">
                        Tombol <strong>Auto-Sync Website</strong> akan secara otomatis memindai dan memperbarui data berita terbaru, artikel islami, tanya jawab FAQ, profil unit TKIT, SDIT, SMPIT, SMAIT, serta informasi kontak resmi ke dalam otak AI. Lakukan sinkronisasi setiap kali ada pembaruan konten besar di website.
                    </p>
                </div>
            </div>

        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         4. GOOGLE GEMINI AI MULTI-FEATURE HUB & LIVE SUITE
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="bg-white border-2 border-slate-200 hover:border-slate-300 rounded-3xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
            <div class="flex items-center gap-3.5">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-2xl shadow-md">
                    ✨
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-900">Google Gemini AI Multi-Feature Studio</h3>
                    <p class="text-xs font-bold text-slate-500">Suite Otomasi & Kecerdasan Buatan Terintegrasi SIT Robbani Ogan Ilir</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-[11px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">
                    Gemini 2.0 / 1.5 Flash
                </span>
                <span class="px-3 py-1 rounded-full text-[11px] font-black bg-cyan-100 text-cyan-800 border border-cyan-300">
                    Live Server Ready
                </span>
            </div>
        </div>

        {{-- Hub Navigation Tabs --}}
        <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-3" id="aiHubTabs">
            <button onclick="switchAiTab('tab-ping')" id="btn-tab-ping" class="ai-hub-tab px-4 py-2 rounded-xl text-xs font-black bg-slate-900 text-white shadow-sm transition-all cursor-pointer">
                📡 Tes Koneksi API
            </button>
            <button onclick="switchAiTab('tab-article')" id="btn-tab-article" class="ai-hub-tab px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-all cursor-pointer">
                ✍️ Generator Berita & Artikel
            </button>
            <button onclick="switchAiTab('tab-spmb')" id="btn-tab-spmb" class="ai-hub-tab px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-all cursor-pointer">
                🎯 Analisis Calon Santri SPMB
            </button>
            <button onclick="switchAiTab('tab-whatsapp')" id="btn-tab-whatsapp" class="ai-hub-tab px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-all cursor-pointer">
                💬 WhatsApp Auto-Responder
            </button>
            <button onclick="switchAiTab('tab-quiz')" id="btn-tab-quiz" class="ai-hub-tab px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-all cursor-pointer">
                📝 Generator Soal CBT / Kuis
            </button>
        </div>

        {{-- TAB 1: Tes Koneksi API --}}
        <div id="tab-ping" class="ai-tab-panel space-y-4">
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h4 class="text-sm font-black text-slate-900">Uji Roundtrip Google Gemini AI</h4>
                        <p class="text-xs text-slate-600">Periksa ketersediaan kuota, latensi respon milidetik, dan model aktif di cloud.</p>
                    </div>
                    <button onclick="runAiPing()" id="btnRunPing" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
                        <span>⚡ Uji Koneksi Sekarang</span>
                    </button>
                </div>
                <div id="pingResultBox" class="hidden p-4 rounded-xl border text-xs font-medium space-y-1"></div>
            </div>
            <div class="p-4 rounded-2xl bg-amber-50/70 border border-amber-200 text-xs text-amber-900 space-y-1">
                <div class="font-black text-amber-950 flex items-center gap-1.5">
                    <span>💡</span> <span>Petunjuk Konfigurasi Kunci API (GEMINI_API_KEY):</span>
                </div>
                <p>Kunci API didapatkan secara gratis dari <a href="https://aistudio.google.com" target="_blank" class="underline font-bold text-amber-900 hover:text-black">Google AI Studio &rarr;</a>. Masukkan ke file <code>.env</code> di root hosting: <code>GEMINI_API_KEY=AIzaSy...</code> lalu jalankan <code>php artisan config:clear</code>.</p>
            </div>
        </div>

        {{-- TAB 2: Generator Berita & Artikel --}}
        <div id="tab-article" class="ai-tab-panel hidden space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2 space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Topik / Rangkuman Peristiwa Berita *</label>
                    <input type="text" id="aiArticleTopic" placeholder="Contoh: Santri SDIT Robbani Borong Medali Emas Olimpiade Sains Nasional 2026" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Kategori Publikasi</label>
                    <select id="aiArticleCat" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-800">
                        <option value="Berita Prestasi">Berita Prestasi</option>
                        <option value="Kegiatan Sekolah">Kegiatan Sekolah</option>
                        <option value="Artikel Edukasi">Artikel Edukasi</option>
                        <option value="Pengumuman Resmi">Pengumuman Resmi</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-end">
                <button onclick="runGenerateArticle()" id="btnGenArticle" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black text-xs shadow-md hover:scale-105 active:scale-95 transition-all flex items-center gap-2 cursor-pointer">
                    <span>✨ Tulis Draf Berita dengan AI</span>
                </button>
            </div>
            <div id="aiArticleResult" class="hidden p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <span class="text-xs font-black text-emerald-800 uppercase tracking-wider">Hasil Draf Berita Siap Terbit</span>
                    <button onclick="copyArticleContent()" class="text-xs font-bold text-slate-600 hover:text-emerald-700 px-3 py-1 rounded-lg bg-white border border-slate-200 cursor-pointer">📋 Salin Teks</button>
                </div>
                <div id="aiArticleTitle" class="text-base font-black text-slate-900 font-headline"></div>
                <div id="aiArticleExcerpt" class="text-xs text-slate-600 italic bg-amber-50 p-2.5 rounded-lg border border-amber-200"></div>
                <div id="aiArticleBody" class="prose prose-sm max-w-none text-xs text-slate-800 leading-relaxed space-y-2"></div>
                <div id="aiArticleTags" class="flex flex-wrap gap-1.5 pt-2"></div>
            </div>
        </div>

        {{-- TAB 3: Analisis Calon Santri SPMB --}}
        <div id="tab-spmb" class="ai-tab-panel hidden space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Nama Calon Siswa *</label>
                    <input type="text" id="aiSpmbName" placeholder="Contoh: Muhammad Fatih Robbani" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Jenjang Pilihan</label>
                    <select id="aiSpmbUnit" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-800">
                        <option value="KB / TKIT Robbani">KB / TKIT Robbani</option>
                        <option value="SDIT Robbani">SDIT Robbani</option>
                        <option value="SMPIT Robbani" selected>SMPIT Robbani</option>
                        <option value="SMAIT Robbani">SMAIT Robbani</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Asal Sekolah</label>
                    <input type="text" id="aiSpmbPrev" placeholder="Contoh: SDIT Robbani / MIN 1 Ogan Ilir" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Minat / Bakat / Prestasi</label>
                    <input type="text" id="aiSpmbTalents" placeholder="Contoh: Hafal Juz 30, Suka Robotik & Menggambar" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
            </div>
            <div class="flex items-center justify-end">
                <button onclick="runAnalyzeSpmb()" id="btnAnalyzeSpmb" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black text-xs shadow-md hover:scale-105 active:scale-95 transition-all flex items-center gap-2 cursor-pointer">
                    <span>🎯 Analisis Profil Calon Santri</span>
                </button>
            </div>
            <div id="aiSpmbResult" class="hidden p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4"></div>
        </div>

        {{-- TAB 4: WhatsApp Auto-Responder --}}
        <div id="tab-whatsapp" class="ai-tab-panel hidden space-y-4">
            <div class="space-y-1.5">
                <label class="text-xs font-black text-slate-700">Simulasikan Pertanyaan Masuk dari Calon Wali Santri *</label>
                <textarea id="aiWaInput" rows="2" placeholder="Contoh: Assalamu'alaikum admin, pendaftaran untuk SMPIT gelombang 1 sampai tanggal berapa dan berapa rincian biayanya?" class="w-full p-3.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:ring-2 focus:ring-emerald-500"></textarea>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="text-[11px] text-slate-500 flex items-center gap-1.5">
                    <span>🔗</span> <span>Webhook Endpoint Aktif: <code>/api/webhook/whatsapp</code></span>
                </div>
                <button onclick="runSimulateWa()" id="btnSimulateWa" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer shrink-0">
                    <span>💬 Simulasikan Balasan WhatsApp AI</span>
                </button>
            </div>
            <div id="aiWaResult" class="hidden p-5 rounded-2xl bg-emerald-50/70 border border-emerald-200 space-y-2.5">
                <div class="text-xs font-black text-emerald-950 flex items-center gap-1.5">
                    <span>📱</span> <span>Preview Balasan WhatsApp Otomatis:</span>
                </div>
                <div id="aiWaBubble" class="bg-white p-4 rounded-2xl border border-emerald-300 text-xs text-slate-800 leading-relaxed font-sans whitespace-pre-wrap shadow-xs"></div>
            </div>
        </div>

        {{-- TAB 5: Generator Soal CBT / Kuis --}}
        <div id="tab-quiz" class="ai-tab-panel hidden space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Mata Pelajaran *</label>
                    <input type="text" id="aiQuizSubject" placeholder="Contoh: PAI & Budi Pekerti" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Topik / Kompetensi *</label>
                    <input type="text" id="aiQuizTopic" placeholder="Contoh: Zakat Fitrah & Zakat Mal" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Jenjang Siswa</label>
                    <select id="aiQuizGrade" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-800">
                        <option value="SD Kelas 5-6">SD (Kelas 5-6)</option>
                        <option value="SMP Kelas 7-9" selected>SMP (Kelas 7-9)</option>
                        <option value="SMA Kelas 10-12">SMA (Kelas 10-12)</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-black text-slate-700">Jumlah Soal</label>
                    <select id="aiQuizCount" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs font-bold text-slate-800">
                        <option value="3">3 Butir Soal</option>
                        <option value="5" selected>5 Butir Soal</option>
                        <option value="10">10 Butir Soal</option>
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-end">
                <button onclick="runGenerateQuiz()" id="btnGenerateQuiz" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-black text-xs shadow-md hover:scale-105 active:scale-95 transition-all flex items-center gap-2 cursor-pointer">
                    <span>📝 Buat Bank Soal Pilihan Ganda</span>
                </button>
            </div>
            <div id="aiQuizResult" class="hidden p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-4"></div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
// ── File Drop Zone Handlers ──────────────────────────────────────────────────
function onFileSelect(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        document.getElementById('dropZoneDefault').classList.add('hidden');
        document.getElementById('dropZoneSelected').classList.remove('hidden');
        document.getElementById('selectedFileName').textContent = file.name;
        document.getElementById('selectedFileSize').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB · ' + file.name.split('.').pop().toUpperCase();
    }
}

// ── Category Filtering ───────────────────────────────────────────────────────
function filterCategory(cat) {
    document.querySelectorAll('.cat-tab').forEach(b => {
        if (b.dataset.category === cat) {
            b.className = 'cat-tab active px-3.5 py-1.5 rounded-xl text-xs font-black bg-slate-900 text-white shadow-sm transition-all cursor-pointer';
        } else {
            b.className = 'cat-tab px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-all cursor-pointer';
        }
    });

    document.querySelectorAll('.doc-row').forEach(row => {
        if (cat === 'all' || row.dataset.category === cat) {
            row.style.display = 'flex';
        } else {
            row.style.display = 'none';
        }
    });
}

// ── Search in Documents ─────────────────────────────────────────────────────
function searchDocs(query) {
    const q = query.toLowerCase().trim();
    document.querySelectorAll('.doc-row').forEach(row => {
        const title = row.dataset.title || '';
        const cat = row.dataset.category || '';
        const text = row.innerText.toLowerCase();
        if (!q || title.includes(q) || cat.includes(q) || text.includes(q)) {
            row.style.display = 'flex';
        } else {
            row.style.display = 'none';
        }
    });
}

// ── Toggle Active State ─────────────────────────────────────────────────────
async function toggleDoc(id) {
    try {
        const res = await fetch(`/admin/ai-trainer/${id}/toggle`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        });
        const data = await res.json();
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: data.is_active ? 'Dokumen Diaktifkan' : 'Dokumen Dinonaktifkan',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Gagal mengubah status dokumen' });
    }
}

// ── Delete Single Document ──────────────────────────────────────────────────
async function deleteDoc(id, title) {
    const result = await Swal.fire({
        title: 'Hapus Dokumen?',
        text: `Dokumen "${title}" akan dihapus dari basis pengetahuan AI.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '🗑️ Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
    });

    if (!result.isConfirmed) return;

    try {
        const res = await fetch(`/admin/ai-trainer/${id}`, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        });
        const data = await res.json();
        if (data.success) {
            Swal.fire({ icon: 'success', title: 'Terhapus', text: data.message, timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghapus dokumen.' });
    }
}

// ── Bulk Delete ─────────────────────────────────────────────────────────────
function updateBulkDeleteBtn() {
    const checked = document.querySelectorAll('.row-checkbox:checked');
    const btn = document.getElementById('btnBulkDelete');
    if (checked.length > 0) {
        btn.classList.remove('hidden');
        btn.classList.add('inline-flex');
        btn.querySelector('span:last-child').textContent = `Hapus (${checked.length}) Terpilih`;
    } else {
        btn.classList.add('hidden');
        btn.classList.remove('inline-flex');
    }
}

async function bulkDelete() {
    const checked = document.querySelectorAll('.row-checkbox:checked');
    if (checked.length === 0) return;
    const ids = Array.from(checked).map(c => parseInt(c.value));

    const result = await Swal.fire({
        title: `Hapus ${ids.length} Dokumen?`,
        text: 'Semua dokumen yang dipilih akan dihapus permanen dari sistem.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '🗑️ Hapus Semua Terpilih',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
    });

    if (!result.isConfirmed) return;

    try {
        const res = await fetch('{{ route("admin.ai-trainer.bulk-delete") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ ids }),
        });
        const data = await res.json();
        if (data.success) {
            Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 1800, showConfirmButton: false })
                .then(() => location.reload());
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghapus dokumen.' });
    }
}

// ── Auto Sync Trigger ───────────────────────────────────────────────────────
async function doAutoSync() {
    const btn = document.getElementById('btnAutoSync');
    const icon = document.getElementById('syncIcon');
    const text = document.getElementById('syncText');

    icon.classList.add('animate-spin');
    text.textContent = 'Menyinkronkan data...';
    btn.disabled = true;

    try {
        const res = await fetch('{{ route("admin.ai-trainer.auto-sync") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        });
        const data = await res.json();

        icon.classList.remove('animate-spin');
        btn.disabled = false;
        text.textContent = 'Auto-Sync Website';

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Auto-Sync Berhasil!',
                html: `<div class="text-left text-xs space-y-1.5 pt-2">${data.details.map(d => `<div>${d}</div>`).join('')}</div>`,
                confirmButtonText: 'Selesai & Muat Ulang',
                confirmButtonColor: '#0f172a',
            }).then(() => location.reload());
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal Sync', text: data.message });
        }
    } catch (e) {
        icon.classList.remove('animate-spin');
        btn.disabled = false;
        text.textContent = 'Auto-Sync Website';
        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghubungi server untuk sinkronisasi.' });
    }
}

// ── Test Chat with Real-Time Streaming Typewriter Animation ─────────────────
function quickAsk(text) {
    const input = document.getElementById('testChatInput');
    input.value = text;
    sendTestChat();
}

function clearTestChat() {
    const chatBox = document.getElementById('chatMessages');
    chatBox.innerHTML = `
        <div class="flex gap-3 items-start">
            <div class="w-8 h-8 rounded-2xl bg-theme-accent text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                🤖
            </div>
            <div class="bg-white border-2 border-slate-200 rounded-2xl rounded-tl-none p-4 text-xs sm:text-sm text-slate-900 font-medium max-w-[85%] shadow-sm leading-relaxed space-y-1">
                <p class="font-black text-slate-900">Assalamu'alaikum!</p>
                <p class="text-slate-700">Riwayat percakapan telah dibersihkan. Silakan tanyakan hal baru seputar SIT Robbani.</p>
            </div>
        </div>
    `;
}

async function sendTestChat() {
    const input = document.getElementById('testChatInput');
    const msg = input.value.trim();
    if (!msg) return;

    const chatBox = document.getElementById('chatMessages');

    // 1. Append User Bubble (Dynamic Global Theme Accent)
    chatBox.innerHTML += `
        <div class="flex gap-2.5 justify-end items-end">
            <div class="bg-theme-gradient text-white rounded-2xl rounded-br-none px-4 py-3 text-xs sm:text-sm font-bold max-w-[80%] shadow-md leading-relaxed">
                ${escapeHtml(msg)}
            </div>
            <div class="w-7 h-7 rounded-xl bg-slate-300 text-slate-800 flex items-center justify-center text-xs shrink-0 font-black">
                👤
            </div>
        </div>
    `;
    input.value = '';
    chatBox.scrollTop = chatBox.scrollHeight;

    // 2. Append Loading / Thinking Indicator
    const loadingId = 'loading-' + Date.now();
    chatBox.innerHTML += `
        <div id="${loadingId}" class="flex gap-3 items-start">
            <div class="w-8 h-8 rounded-2xl bg-theme-accent text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md animate-pulse">
                🤖
            </div>
            <div class="bg-white border-2 border-slate-200 rounded-2xl rounded-tl-none px-4 py-3 text-xs text-slate-600 font-bold shadow-xs flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-slate-800 animate-ping"></span>
                <span>Robbani AI sedang mengetik...</span>
            </div>
        </div>
    `;
    chatBox.scrollTop = chatBox.scrollHeight;

    try {
        const res = await fetch('{{ route("admin.ai-trainer.test-chat") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ message: msg }),
        });
        const data = await res.json();
        document.getElementById(loadingId)?.remove();

        const answerText = data.answer || 'Mohon maaf, tidak ada respon yang dapat diberikan.';
        
        // 3. Create AI Bubble Container for Typing Effect (High Contrast Pure White Card with Deep Dark Slate Text)
        const bubbleId = 'ai-bubble-' + Date.now();
        chatBox.innerHTML += `
            <div class="flex gap-3 items-start">
                <div class="w-8 h-8 rounded-2xl bg-theme-accent text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                    🤖
                </div>
                <div class="bg-white border-2 border-slate-300 rounded-2xl rounded-tl-none p-4 text-xs sm:text-sm text-slate-900 font-medium max-w-[85%] shadow-sm leading-relaxed" id="${bubbleId}">
                    <span class="typing-cursor font-mono font-bold text-slate-900 animate-pulse">▋</span>
                </div>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;

        // 4. Stream typing character by character
        await streamTypewriter(bubbleId, answerText, chatBox);

    } catch (e) {
        document.getElementById(loadingId)?.remove();
        chatBox.innerHTML += `
            <div class="flex gap-3 items-start">
                <div class="w-8 h-8 rounded-2xl bg-red-600 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                    ⚠️
                </div>
                <div class="bg-red-50 border-2 border-red-300 rounded-2xl rounded-tl-none p-3.5 text-xs text-red-900 font-bold max-w-[85%]">
                    Terjadi kendala koneksi ke server saat memproses jawaban AI.
                </div>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}

// ── Streaming Typewriter Animation Engine ────────────────────────────────────
function streamTypewriter(elementId, fullText, scrollContainer) {
    return new Promise((resolve) => {
        const el = document.getElementById(elementId);
        if (!el) { resolve(); return; }

        let currentIdx = 0;
        const speed = 12; // ms per tick

        function typeNext() {
            if (currentIdx < fullText.length) {
                currentIdx += Math.min(2, fullText.length - currentIdx); // 1-2 chars per tick
                const currentChunk = fullText.slice(0, currentIdx);
                el.innerHTML = formatMarkdown(currentChunk) + '<span class="inline-block w-1.5 h-3.5 bg-slate-900 ml-0.5 animate-pulse"></span>';
                scrollContainer.scrollTop = scrollContainer.scrollHeight;
                setTimeout(typeNext, speed);
            } else {
                // Done typing: clean final formatted markdown
                el.innerHTML = formatMarkdown(fullText);
                scrollContainer.scrollTop = scrollContainer.scrollHeight;
                resolve();
            }
        }

        typeNext();
    });
}

function formatMarkdown(text) {
    return escapeHtml(text)
        .replace(/\*\*(.*?)\*\*/g, '<strong class="font-black text-slate-950">$1</strong>')
        .replace(/\*(.*?)\*/g, '<em class="italic">$1</em>')
        .replace(/\n/g, '<br>')
        .replace(/(•|\-)\s(.*?)<br>/g, '<div class="flex items-start gap-1.5 my-1"><span class="text-slate-900 font-black shrink-0">•</span><span class="text-slate-800">$2</span></div>');
}

function escapeHtml(text) {
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return String(text).replace(/[&<>"']/g, m => map[m]);
}

// ── Google Gemini AI Multi-Feature Studio Handlers ───────────────────────────
function switchAiTab(tabId) {
    document.querySelectorAll('.ai-tab-panel').forEach(p => p.classList.add('hidden'));
    document.querySelectorAll('.ai-hub-tab').forEach(b => {
        b.className = 'ai-hub-tab px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition-all cursor-pointer';
    });
    const panel = document.getElementById(tabId);
    const btn = document.getElementById('btn-' + tabId);
    if (panel) panel.classList.remove('hidden');
    if (btn) btn.className = 'ai-hub-tab px-4 py-2 rounded-xl text-xs font-black bg-slate-900 text-white shadow-sm transition-all cursor-pointer';
}

async function runAiPing() {
    const btn = document.getElementById('btnRunPing');
    const box = document.getElementById('pingResultBox');
    btn.disabled = true;
    btn.innerHTML = '<span>⏳ Menghubungi Gemini Cloud...</span>';
    box.className = 'p-4 rounded-xl border border-slate-200 bg-white text-xs space-y-1 block';
    box.innerHTML = '<span class="text-slate-500 font-bold">Mengirim paket uji roundtrip ke Google AI Studio...</span>';

    try {
        const res = await fetch('{{ route("admin.ai-hub.test-connection") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        });
        const data = await res.json();
        if (data.success) {
            box.className = 'p-4 rounded-xl border-2 border-emerald-500 bg-emerald-50 text-emerald-950 text-xs space-y-1.5 block shadow-xs';
            box.innerHTML = `
                <div class="font-black text-emerald-900 flex items-center gap-1.5">
                    <span>✅</span> <span>Koneksi Google Gemini AI Berhasil!</span>
                </div>
                <div class="text-xs font-semibold text-emerald-800">
                    Model: <strong>${data.model}</strong> · Latensi: <strong>${data.latency_ms} ms</strong>
                </div>
                <div class="text-[11px] text-emerald-700 italic">${data.message}</div>
            `;
        } else {
            box.className = 'p-4 rounded-xl border-2 border-red-500 bg-red-50 text-red-950 text-xs space-y-1.5 block shadow-xs';
            box.innerHTML = `
                <div class="font-black text-red-900 flex items-center gap-1.5">
                    <span>❌</span> <span>Koneksi Gagal / API Key Belum Diisi</span>
                </div>
                <div class="text-xs text-red-800">${data.message}</div>
            `;
        }
    } catch (e) {
        box.className = 'p-4 rounded-xl border-2 border-red-500 bg-red-50 text-red-950 text-xs block';
        box.innerHTML = '❌ Gagal terhubung ke endpoint internal server.';
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<span>⚡ Uji Koneksi Sekarang</span>';
    }
}

async function runGenerateArticle() {
    const topic = document.getElementById('aiArticleTopic').value.trim();
    const cat = document.getElementById('aiArticleCat').value;
    const btn = document.getElementById('btnGenArticle');
    const resultBox = document.getElementById('aiArticleResult');

    if (!topic) {
        Swal.fire({ icon: 'warning', title: 'Topik Wajib Diisi', text: 'Ketik topik atau peristiwa yang ingin dibuatkan naskah berita.' });
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span>✨ Menulis Draf Berita (Gemini AI)...</span>';
    resultBox.classList.add('hidden');

    try {
        const res = await fetch('{{ route("admin.ai-hub.generate-article") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ topic, category: cat, tone: 'islami_inspiratif' })
        });
        const data = await res.json();
        if (data.success && data.data) {
            const d = data.data;
            document.getElementById('aiArticleTitle').innerText = d.title || 'Naskah Berita';
            document.getElementById('aiArticleExcerpt').innerText = d.excerpt || '';
            document.getElementById('aiArticleBody').innerHTML = d.content || '';
            const tagsBox = document.getElementById('aiArticleTags');
            tagsBox.innerHTML = '';
            (d.tags || ['SIT Robbani', cat]).forEach(t => {
                tagsBox.innerHTML += `<span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-slate-200 text-slate-800">#${t}</span>`;
            });
            resultBox.classList.remove('hidden');
            resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal Membuat Artikel', text: data.message || 'Pastikan API key telah aktif.' });
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Terjadi Kendala Jaringan' });
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<span>✨ Tulis Draf Berita dengan AI</span>';
    }
}

function copyArticleContent() {
    const title = document.getElementById('aiArticleTitle').innerText;
    const body = document.getElementById('aiArticleBody').innerText;
    navigator.clipboard.writeText(`${title}\n\n${body}`);
    Swal.fire({ icon: 'success', title: 'Naskah Berita Disalin ke Clipboard!', toast: true, position: 'top-end', timer: 2000, showConfirmButton: false });
}

async function runAnalyzeSpmb() {
    const name = document.getElementById('aiSpmbName').value.trim();
    const unit = document.getElementById('aiSpmbUnit').value;
    const prev = document.getElementById('aiSpmbPrev').value.trim();
    const talents = document.getElementById('aiSpmbTalents').value.trim();
    const btn = document.getElementById('btnAnalyzeSpmb');
    const resultBox = document.getElementById('aiSpmbResult');

    if (!name) {
        Swal.fire({ icon: 'warning', title: 'Nama Calon Siswa Wajib Diisi' });
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span>🎯 Menganalisis Potensi Ananda...</span>';
    resultBox.classList.add('hidden');

    try {
        const res = await fetch('{{ route("admin.ai-hub.analyze-spmb") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ name, unit, previous_school: prev, talents })
        });
        const data = await res.json();
        if (data.success && data.data) {
            const d = data.data;
            resultBox.innerHTML = `
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-200 pb-3">
                    <div>
                        <h4 class="text-sm font-black text-slate-900">Analisis Calon Santri: ${escapeHtml(name)}</h4>
                        <p class="text-xs text-slate-500">${unit} · Asal: ${escapeHtml(prev || '-')}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-500">Skor Kesiapan:</span>
                        <span class="px-3.5 py-1.5 rounded-2xl bg-emerald-600 text-white font-black text-sm shadow-xs">${d.readiness_score || 88}/100</span>
                    </div>
                </div>
                <div class="space-y-1">
                    <span class="text-xs font-black text-slate-700 uppercase">Ringkasan Karakter & Potensi:</span>
                    <p class="text-xs text-slate-800 leading-relaxed">${escapeHtml(d.student_summary || '-')}</p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div class="p-3.5 rounded-xl bg-white border border-slate-200 space-y-1">
                        <span class="text-[11px] font-black text-emerald-800 uppercase block">⭐ Kekuatan Utama:</span>
                        <ul class="text-xs text-slate-700 list-disc list-inside space-y-0.5">
                            ${(d.strengths || []).map(s => `<li>${escapeHtml(s)}</li>`).join('')}
                        </ul>
                    </div>
                    <div class="p-3.5 rounded-xl bg-white border border-slate-200 space-y-1">
                        <span class="text-[11px] font-black text-cyan-800 uppercase block">🚀 Rekomendasi Program / Ekskul:</span>
                        <ul class="text-xs text-slate-700 list-disc list-inside space-y-0.5">
                            ${(d.recommended_programs || []).map(p => `<li>${escapeHtml(p)}</li>`).join('')}
                        </ul>
                    </div>
                </div>
                <div class="p-3.5 rounded-xl bg-amber-50 border border-amber-200 space-y-1">
                    <span class="text-[11px] font-black text-amber-900 uppercase block">🎙️ Catatan & Panduan Wawancara:</span>
                    <p class="text-xs text-amber-950 font-medium">${escapeHtml(d.interview_notes || '-')}</p>
                </div>
                <div class="p-3.5 rounded-xl bg-emerald-50/80 border border-emerald-300 space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-black text-emerald-900 uppercase">💬 Sambutan Hangat untuk WhatsApp Orang Tua:</span>
                        <button onclick="navigator.clipboard.writeText(\`${escapeHtml(d.parent_welcome_msg || '')}\`); Swal.fire({ icon: 'success', title: 'Pesan WA Disalin!', toast: true, position: 'top-end', timer: 2000, showConfirmButton: false });" class="text-[10px] font-black px-2 py-0.5 rounded bg-white text-emerald-800 border border-emerald-300 cursor-pointer">Salin WA</button>
                    </div>
                    <p class="text-xs text-emerald-950 font-sans whitespace-pre-wrap">${escapeHtml(d.parent_welcome_msg || '-')}</p>
                </div>
            `;
            resultBox.classList.remove('hidden');
            resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal Menganalisis Profil' });
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Terjadi Gangguan Jaringan' });
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<span>🎯 Analisis Profil Calon Santri</span>';
    }
}

async function runSimulateWa() {
    const message = document.getElementById('aiWaInput').value.trim();
    const btn = document.getElementById('btnSimulateWa');
    const resultBox = document.getElementById('aiWaResult');
    const bubble = document.getElementById('aiWaBubble');

    if (!message) {
        Swal.fire({ icon: 'warning', title: 'Tuliskan Pertanyaan' });
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span>💬 Memproses Balasan AI...</span>';
    resultBox.classList.add('hidden');

    try {
        const res = await fetch('{{ route("admin.ai-hub.whatsapp-simulate") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ message })
        });
        const data = await res.json();
        if (data.success) {
            bubble.innerText = data.ai_reply || 'Tidak ada balasan.';
            resultBox.classList.remove('hidden');
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal Memproses WhatsApp Bot' });
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Gangguan Jaringan' });
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<span>💬 Simulasikan Balasan WhatsApp AI</span>';
    }
}

async function runGenerateQuiz() {
    const subject = document.getElementById('aiQuizSubject').value.trim();
    const topic = document.getElementById('aiQuizTopic').value.trim();
    const grade = document.getElementById('aiQuizGrade').value;
    const count = document.getElementById('aiQuizCount').value;
    const btn = document.getElementById('btnGenerateQuiz');
    const resultBox = document.getElementById('aiQuizResult');

    if (!subject || !topic) {
        Swal.fire({ icon: 'warning', title: 'Mata Pelajaran & Topik Wajib Diisi' });
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span>📝 Menyusun Soal dengan AI...</span>';
    resultBox.classList.add('hidden');

    try {
        const res = await fetch('{{ route("admin.ai-hub.generate-quiz") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ subject, topic, grade, count })
        });
        const data = await res.json();
        if (data.success && data.data && data.data.questions) {
            const qs = data.data.questions;
            let html = `
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <div>
                        <h4 class="text-sm font-black text-slate-900">Bank Soal: ${escapeHtml(subject)} (${escapeHtml(topic)})</h4>
                        <p class="text-xs text-slate-500">${grade} · ${qs.length} Butir Soal</p>
                    </div>
                </div>
                <div class="space-y-4">
            `;
            qs.forEach((q, idx) => {
                html += `
                    <div class="p-4 rounded-xl bg-white border border-slate-200 space-y-2">
                        <div class="text-xs font-black text-slate-900 leading-snug">${idx + 1}. ${escapeHtml(q.question)}</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs font-semibold text-slate-700 pt-1">
                            ${Object.entries(q.options || {}).map(([key, val]) => `
                                <div class="p-2 rounded-lg border ${key === q.correct_answer ? 'border-emerald-500 bg-emerald-50 text-emerald-950 font-black' : 'border-slate-200 bg-slate-50'}">
                                    <span class="mr-1">${key}.</span> ${escapeHtml(val)} ${key === q.correct_answer ? '✅' : ''}
                                </div>
                            `).join('')}
                        </div>
                        <div class="text-[11px] text-slate-600 bg-slate-50 p-2 rounded-lg border border-slate-100">
                            <strong>Pembahasan:</strong> ${escapeHtml(q.explanation || '-')}
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            resultBox.innerHTML = html;
            resultBox.classList.remove('hidden');
            resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal Menyusun Bank Soal' });
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Gangguan Jaringan' });
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<span>📝 Buat Bank Soal Pilihan Ganda</span>';
    }
}
</script>
@endpush
