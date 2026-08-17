@extends('admin.layout')

@section('title', '🤖 AI Knowledge Base Trainer Studio')

@section('content')
<div class="p-4 sm:p-6 lg:p-8 space-y-8 max-w-[1600px] mx-auto">

    {{-- ═══════════════════════════════════════════════════════════════════════
         1. HERO HEADER: AI COMMAND CENTER STUDIO
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-[#0f172a] to-[#1e1b4b] border border-slate-800 p-6 sm:p-8 text-white shadow-2xl">
        {{-- Futuristic ambient glow dots --}}
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-violet-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-600/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-violet-600 to-fuchsia-600 flex items-center justify-center text-2xl shadow-lg shadow-violet-500/30 ring-4 ring-violet-500/20">
                        🤖
                    </div>
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h1 class="text-2xl sm:text-3xl font-black tracking-tight text-white font-headline">AI Knowledge Studio</h1>
                            <span class="px-2.5 py-0.5 rounded-full bg-violet-500/20 border border-violet-400/30 text-violet-300 text-[10px] font-black uppercase tracking-wider">
                                RAG v2.5 Engine
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-400 font-medium">Pusat pelatihan kecerdasan buatan &amp; knowledge base interaktif SIT Robbani</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Status Engine Chip --}}
                @php $geminiActive = !empty(env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY')); @endphp
                <div class="flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-slate-800/90 border border-slate-700/80 shadow-inner">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $geminiActive ? 'bg-emerald-400' : 'bg-cyan-400' }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 {{ $geminiActive ? 'bg-emerald-500' : 'bg-cyan-500' }}"></span>
                    </span>
                    <span class="text-xs font-bold text-slate-200">
                        {{ $geminiActive ? 'Gemini AI Pro Cloud' : 'Neural RAG Local (Fast)' }}
                    </span>
                </div>

                {{-- Auto-Sync Button --}}
                <button id="btnAutoSync" onclick="doAutoSync()" class="inline-flex items-center gap-2.5 px-5 py-2.5 rounded-2xl bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 hover:from-violet-500 hover:to-blue-500 text-white font-black text-xs shadow-xl shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:scale-[1.02] active:scale-95 transition-all border border-violet-400/30 cursor-pointer">
                    <span id="syncIcon" class="text-sm">⚡</span>
                    <span id="syncText">Auto-Sync Data Website</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="flex items-center gap-3 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl text-emerald-800 text-sm font-bold shadow-sm">
        <span class="text-lg">✅</span> <span>{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 p-4 bg-red-500/10 border border-red-500/30 rounded-2xl text-red-800 text-sm font-bold shadow-sm">
        <span class="text-lg">❌</span> <span>{{ session('error') }}</span>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════════
         2. HIGH-CONTRAST METRIC STATS CARDS
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-5">
        
        {{-- Stat 1 --}}
        <div class="bg-white border-2 border-slate-200 hover:border-violet-500 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black uppercase tracking-wider text-slate-500 group-hover:text-violet-600 transition-colors">Total Dokumen</span>
                <div class="w-10 h-10 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-lg font-bold group-hover:scale-110 transition-transform">
                    📚
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ $totalDocs }}</div>
                <div class="text-[11px] font-bold text-slate-600 mt-0.5">Basis Pengetahuan AI</div>
            </div>
        </div>

        {{-- Stat 2 --}}
        <div class="bg-white border-2 border-slate-200 hover:border-emerald-500 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black uppercase tracking-wider text-slate-500 group-hover:text-emerald-600 transition-colors">Dokumen Aktif</span>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg font-bold group-hover:scale-110 transition-transform">
                    ✨
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ $activeDocs }}</div>
                <div class="text-[11px] font-bold text-emerald-700 mt-0.5">Digunakan Secara Live</div>
            </div>
        </div>

        {{-- Stat 3 --}}
        <div class="bg-white border-2 border-slate-200 hover:border-blue-500 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black uppercase tracking-wider text-slate-500 group-hover:text-blue-600 transition-colors">File Diunggah</span>
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold group-hover:scale-110 transition-transform">
                    📂
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ $uploadedCount }}</div>
                <div class="text-[11px] font-bold text-slate-600 mt-0.5">PDF · Word · Excel · TXT</div>
            </div>
        </div>

        {{-- Stat 4 --}}
        <div class="bg-white border-2 border-slate-200 hover:border-cyan-500 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black uppercase tracking-wider text-slate-500 group-hover:text-cyan-600 transition-colors">Data Website</span>
                <div class="w-10 h-10 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-lg font-bold group-hover:scale-110 transition-transform">
                    🌐
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ $websiteDataCount }}</div>
                <div class="text-[11px] font-bold text-slate-600 mt-0.5">Berita, Artikel, FAQ, Unit</div>
            </div>
        </div>

        {{-- Stat 5 --}}
        <div class="bg-white border-2 border-slate-200 hover:border-amber-500 rounded-3xl p-5 shadow-sm hover:shadow-xl transition-all group flex flex-col justify-between col-span-2 lg:col-span-1">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-black uppercase tracking-wider text-slate-500 group-hover:text-amber-600 transition-colors">Total Kata</span>
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg font-bold group-hover:scale-110 transition-transform">
                    🔤
                </div>
            </div>
            <div class="mt-3">
                <div class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">{{ number_format($totalWords) }}</div>
                <div class="text-[11px] font-bold text-slate-600 mt-0.5">{{ $lastSync ? 'Sync: '.$lastSync->diffForHumans() : 'Knowledge Siap' }}</div>
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════════════
         3. MAIN 2-COLUMN STUDIO WORKSPACE
    ═══════════════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">

        {{-- ── LEFT PANEL: INGESTION & INTERACTIVE CHAT TESTER (5 Cols) ─────── --}}
        <div class="xl:col-span-5 space-y-6">

            {{-- INTERACTIVE AI TEST CHAT STUDIO (TOP LEFT FOR MAXIMUM VISIBILITY) --}}
            <div class="bg-white border-2 border-slate-200 rounded-3xl shadow-xl overflow-hidden flex flex-col">
                {{-- Chat Header --}}
                <div class="px-6 py-4 bg-gradient-to-r from-slate-900 to-indigo-950 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-violet-600/80 border border-violet-400/40 flex items-center justify-center text-base shadow-md">
                            💬
                        </div>
                        <div>
                            <h2 class="text-sm font-black text-white">Uji Coba Chatbot AI</h2>
                            <p class="text-[11px] text-violet-300 font-medium">Streaming Neural Response Tester</p>
                        </div>
                    </div>
                    <button onclick="clearTestChat()" title="Bersihkan Chat" class="px-3 py-1 rounded-xl bg-white/10 hover:bg-white/20 text-slate-300 text-xs font-bold transition-all flex items-center gap-1">
                        <span>🧹</span> <span class="hidden sm:inline">Clear</span>
                    </button>
                </div>

                {{-- Quick Prompt Suggestions --}}
                <div class="px-5 py-2.5 bg-slate-50 border-b border-slate-200/80 flex items-center gap-2 overflow-x-auto text-[11px] no-scrollbar">
                    <span class="text-slate-400 font-bold shrink-0">Contoh:</span>
                    <button onclick="quickAsk('Siapa kepala sekolah TK dan SD?')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-violet-400 hover:text-violet-700 text-slate-600 font-semibold shrink-0 transition-colors">
                        🎓 Kepala Sekolah
                    </button>
                    <button onclick="quickAsk('Bagaimana cara daftar PPDB dan syaratnya?')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-violet-400 hover:text-violet-700 text-slate-600 font-semibold shrink-0 transition-colors">
                        📝 Syarat PPDB
                    </button>
                    <button onclick="quickAsk('Berapa biaya SPP dan cara bayarnya?')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-violet-400 hover:text-violet-700 text-slate-600 font-semibold shrink-0 transition-colors">
                        💳 Info SPP
                    </button>
                    <button onclick="quickAsk('Target hafalan tahfidz di SMPIT')" class="px-2.5 py-1 rounded-lg bg-white border border-slate-200 hover:border-violet-400 hover:text-violet-700 text-slate-600 font-semibold shrink-0 transition-colors">
                        📖 Target Tahfidz
                    </button>
                </div>

                {{-- Chat Message Stream Area --}}
                <div class="p-5 flex-1 min-h-[320px] max-h-[420px] overflow-y-auto space-y-4 bg-slate-50/50" id="chatMessages">
                    {{-- Welcome bubble --}}
                    <div class="flex gap-3 items-start">
                        <div class="w-8 h-8 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-600 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                            🤖
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-none p-4 text-xs sm:text-sm text-slate-800 font-medium max-w-[85%] shadow-xs leading-relaxed space-y-1">
                            <p class="font-bold text-violet-700">Assalamu'alaikum!</p>
                            <p>Saya asisten AI resmi SIT Robbani. Silakan ketik pertanyaan atau klik salah satu topik di atas untuk menguji respon pintar saya.</p>
                        </div>
                    </div>
                </div>

                {{-- Chat Input Bar --}}
                <div class="p-4 bg-white border-t border-slate-200">
                    <form onsubmit="event.preventDefault(); sendTestChat();" class="flex items-center gap-2">
                        <input type="text" id="testChatInput" placeholder="Ketik pertanyaan uji (misal: kepala tk, syarat ppdb, spp)..." class="flex-1 bg-slate-100 border border-slate-200 rounded-2xl px-4 py-3 text-xs sm:text-sm font-medium text-slate-800 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:bg-white transition-all">
                        <button type="submit" id="btnSendTest" class="px-5 py-3 rounded-2xl bg-gradient-to-r from-violet-600 to-indigo-600 hover:from-violet-700 hover:to-indigo-700 text-white font-black text-xs sm:text-sm shadow-md hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-1.5 shrink-0 cursor-pointer">
                            <span>Kirim</span>
                            <span class="text-xs">➔</span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- UPLOAD DOKUMEN PANEL --}}
            <div class="bg-white border-2 border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold">
                            📂
                        </div>
                        <div>
                            <h2 class="font-black text-slate-900 text-sm">Upload Dokumen Knowledge</h2>
                            <p class="text-[11px] text-slate-500">PDF, DOCX, XLSX, TXT (maks. 20MB)</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.ai-trainer.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        {{-- Drag & Drop Area --}}
                        <div id="dropZone" class="relative border-2 border-dashed border-slate-300 hover:border-violet-500 bg-slate-50/70 hover:bg-violet-50/30 rounded-3xl p-6 text-center transition-all cursor-pointer mb-5 group" onclick="document.getElementById('fileInput').click()">
                            <input type="file" name="file" id="fileInput" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" onchange="onFileSelect(this)">
                            <div id="dropZoneDefault">
                                <div class="w-14 h-14 mx-auto rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center text-2xl mb-2 group-hover:scale-110 transition-transform">
                                    ☁️
                                </div>
                                <p class="text-sm font-bold text-slate-700 group-hover:text-violet-700 transition-colors">Klik atau Seret Dokumen ke Sini</p>
                                <p class="text-[11px] text-slate-400 mt-1">Mendukung file SOP, Panduan SPMB, Kurikulum &amp; Dokumen Sekolah</p>
                            </div>
                            <div id="dropZoneSelected" class="hidden">
                                <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-2 animate-bounce">
                                    📄
                                </div>
                                <p class="text-sm font-black text-emerald-700" id="selectedFileName"></p>
                                <p class="text-[11px] text-slate-500 mt-1" id="selectedFileSize"></p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">Judul Dokumen <span class="text-slate-400 font-normal lowercase">(opsional)</span></label>
                                <input type="text" name="title" placeholder="Contoh: Brosur & Panduan SPMB 2026" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2.5 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-violet-500 focus:bg-white transition-all">
                            </div>

                            <div>
                                <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">Kategori Dokumen <span class="text-red-500">*</span></label>
                                <select name="category" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2.5 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-violet-500 focus:bg-white transition-all">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $key => $label)
                                        @if($key !== 'website_data')
                                        <option value="{{ $key }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" id="btnUpload" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-black text-xs sm:text-sm shadow-md hover:shadow-lg transition-all hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                                <span>⬆️</span> <span>Upload &amp; Latih Dokumen</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- INPUT MANUAL KNOWLEDGE PANEL --}}
            <div class="bg-white border-2 border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold">
                            ✍️
                        </div>
                        <div>
                            <h2 class="font-black text-slate-900 text-sm">Input Manual Pengetahuan</h2>
                            <p class="text-[11px] text-slate-500">Tulis informasi kustom langsung ke AI</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.ai-trainer.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">Topik / Judul <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required placeholder="Contoh: Tata Tertib Izin Masuk Sekolah SMPIT" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2.5 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                            <select name="category" required class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-2.5 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $key => $label)
                                    @if($key !== 'website_data')
                                    <option value="{{ $key }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-1.5">Konten Pengetahuan <span class="text-red-500">*</span></label>
                            <textarea name="content" required rows="5" placeholder="Tulis instruksi atau informasi penting di sini... (Misal: Alur pengajuan surat izin, aturan seragam harian, kuota beasiswa tahfidz, dll.)" class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-xs sm:text-sm shadow-md hover:shadow-lg transition-all hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 cursor-pointer">
                            <span>💾</span> <span>Simpan ke Knowledge Base</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- ── RIGHT PANEL: KNOWLEDGE BASE DOCUMENT REPOSITORY (7 Cols) ────── --}}
        <div class="xl:col-span-7 space-y-6">

            <div class="bg-white border-2 border-slate-200 rounded-3xl shadow-sm overflow-hidden">
                
                {{-- Top Filter Tabs Ribbon --}}
                <div class="p-6 border-b border-slate-100 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-base font-black text-slate-900 font-headline">Daftar Dokumen Knowledge Base</h2>
                            <p class="text-xs text-slate-500 font-medium">Kelola sumber data yang dibaca oleh asisten AI saat menjawab pengguna</p>
                        </div>

                        {{-- Bulk Delete Button --}}
                        <button id="btnBulkDelete" onclick="bulkDelete()" class="hidden items-center gap-1.5 px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-md transition-all">
                            <span>🗑️</span> <span>Hapus Terpilih</span>
                        </button>
                    </div>

                    {{-- Category Tabs --}}
                    <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-slate-100">
                        <button onclick="filterCategory('all')" class="cat-tab active px-3.5 py-1.5 rounded-xl text-xs font-extrabold bg-violet-600 text-white shadow-sm transition-all" data-category="all">
                            Semua ({{ $totalDocs }})
                        </button>
                        @foreach($categories as $key => $label)
                        @php $cnt = $categoryStats[$key] ?? 0; @endphp
                        <button onclick="filterCategory('{{ $key }}')" class="cat-tab px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-600 transition-all" data-category="{{ $key }}">
                            {{ $label }} ({{ $cnt }})
                        </button>
                        @endforeach
                    </div>

                    {{-- Search Box --}}
                    <div class="relative">
                        <input type="text" id="searchDocInput" oninput="searchDocs(this.value)" placeholder="Cari judul, kategori, atau isi dokumen..." class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-4 py-2.5 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-violet-500 focus:bg-white transition-all">
                        <span class="absolute left-4 top-3 text-slate-400 text-sm">🔍</span>
                    </div>
                </div>

                {{-- Document List / Table --}}
                <div class="divide-y divide-slate-100 overflow-x-auto max-h-[800px] overflow-y-auto" id="docListContainer">
                    @forelse($knowledgeBases as $doc)
                    <div class="doc-row p-5 hover:bg-slate-50/80 transition-colors flex items-start justify-between gap-4" data-category="{{ $doc->category }}" data-title="{{ strtolower($doc->title) }}" data-id="{{ $doc->id }}">
                        
                        <div class="flex items-start gap-3.5 flex-1 min-w-0">
                            {{-- Checkbox --}}
                            <input type="checkbox" value="{{ $doc->id }}" class="row-checkbox mt-1 w-4 h-4 rounded text-violet-600 focus:ring-violet-500 cursor-pointer" onchange="updateBulkDeleteBtn()">

                            {{-- Source Icon --}}
                            <div class="w-10 h-10 rounded-2xl bg-slate-100 text-slate-700 flex items-center justify-center text-lg shrink-0 mt-0.5 border border-slate-200">
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
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $doc->category_color }}">
                                        {{ $doc->category_label }}
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $doc->summary ?? Str::limit($doc->raw_content, 120) }}
                                </p>
                                <div class="flex flex-wrap items-center gap-3 text-[11px] font-semibold text-slate-400 pt-1">
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
                                <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                            </label>

                            {{-- Delete Button --}}
                            <button onclick="deleteDoc({{ $doc->id }}, '{{ addslashes($doc->title) }}')" title="Hapus Dokumen" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-red-50 text-slate-400 hover:text-red-600 flex items-center justify-center transition-colors">
                                🗑️
                            </button>
                        </div>

                    </div>
                    @empty
                    <div class="p-12 text-center text-slate-400 space-y-2">
                        <div class="text-4xl">📭</div>
                        <p class="font-bold text-slate-600">Belum ada dokumen knowledge base.</p>
                        <p class="text-xs text-slate-400">Silakan upload dokumen atau klik tombol Auto-Sync Data Website di atas.</p>
                    </div>
                    @endforelse
                </div>

            </div>

            {{-- Auto-Sync Explanatory Banner --}}
            <div class="bg-gradient-to-r from-slate-900 to-indigo-950 rounded-3xl p-6 text-white border border-slate-800 flex items-start gap-4 shadow-xl">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600/30 border border-indigo-400/30 flex items-center justify-center text-2xl shrink-0">
                    🔄
                </div>
                <div class="space-y-1 text-xs">
                    <h4 class="text-sm font-black text-white">Tentang Auto-Sync Website</h4>
                    <p class="text-slate-300 leading-relaxed">
                        Tombol <strong>Auto-Sync Data Website</strong> akan secara otomatis memindai dan memperbarui data berita terbaru, artikel islami, tanya jawab FAQ, profil unit TKIT, SDIT, SMPIT, SMAIT, serta informasi kontak resmi ke dalam otak AI. Lakukan sinkronisasi setiap kali ada pembaruan konten besar di website.
                    </p>
                </div>
            </div>

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
            b.className = 'cat-tab active px-3.5 py-1.5 rounded-xl text-xs font-extrabold bg-violet-600 text-white shadow-sm transition-all';
        } else {
            b.className = 'cat-tab px-3.5 py-1.5 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-600 transition-all';
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
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
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
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        });
        const data = await res.json();

        icon.classList.remove('animate-spin');
        btn.disabled = false;
        text.textContent = 'Auto-Sync Data Website';

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Auto-Sync Berhasil!',
                html: `<div class="text-left text-xs space-y-1.5 pt-2">${data.details.map(d => `<div>${d}</div>`).join('')}</div>`,
                confirmButtonText: 'Selesai & Muat Ulang',
                confirmButtonColor: '#7c3aed',
            }).then(() => location.reload());
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal Sync', text: data.message });
        }
    } catch (e) {
        icon.classList.remove('animate-spin');
        btn.disabled = false;
        text.textContent = 'Auto-Sync Data Website';
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
            <div class="w-8 h-8 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-600 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                🤖
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-none p-4 text-xs sm:text-sm text-slate-800 font-medium max-w-[85%] shadow-xs leading-relaxed space-y-1">
                <p class="font-bold text-violet-700">Assalamu'alaikum!</p>
                <p>Riwayat percakapan telah dibersihkan. Silakan tanyakan hal baru seputar SIT Robbani.</p>
            </div>
        </div>
    `;
}

async function sendTestChat() {
    const input = document.getElementById('testChatInput');
    const msg = input.value.trim();
    if (!msg) return;

    const chatBox = document.getElementById('chatMessages');

    // 1. Append User Bubble
    chatBox.innerHTML += `
        <div class="flex gap-2.5 justify-end items-end">
            <div class="bg-gradient-to-r from-violet-600 to-indigo-600 text-white rounded-2xl rounded-br-none px-4 py-3 text-xs sm:text-sm font-medium max-w-[80%] shadow-md leading-relaxed">
                ${escapeHtml(msg)}
            </div>
            <div class="w-7 h-7 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center text-xs shrink-0 font-bold">
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
            <div class="w-8 h-8 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-600 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md animate-pulse">
                🤖
            </div>
            <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-none px-4 py-3 text-xs text-slate-500 font-medium shadow-xs flex items-center gap-2">
                <span class="inline-flex h-2 w-2 rounded-full bg-violet-600 animate-ping"></span>
                <span>Robbani AI sedang berpikir...</span>
            </div>
        </div>
    `;
    chatBox.scrollTop = chatBox.scrollHeight;

    try {
        const res = await fetch('{{ route("admin.ai-trainer.test-chat") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ message: msg }),
        });
        const data = await res.json();
        document.getElementById(loadingId)?.remove();

        const answerText = data.answer || 'Mohon maaf, tidak ada respon yang dapat diberikan.';
        
        // 3. Create AI Bubble Container for Typing Effect
        const bubbleId = 'ai-bubble-' + Date.now();
        chatBox.innerHTML += `
            <div class="flex gap-3 items-start">
                <div class="w-8 h-8 rounded-2xl bg-gradient-to-tr from-violet-600 to-indigo-600 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                    🤖
                </div>
                <div class="bg-white border border-slate-200 rounded-2xl rounded-tl-none p-4 text-xs sm:text-sm text-slate-800 font-medium max-w-[85%] shadow-xs leading-relaxed" id="${bubbleId}">
                    <span class="typing-cursor font-mono font-bold text-violet-600 animate-pulse">▋</span>
                </div>
            </div>
        `;
        chatBox.scrollTop = chatBox.scrollHeight;

        // 4. Stream typing character by character or word by word
        await streamTypewriter(bubbleId, answerText, chatBox);

    } catch (e) {
        document.getElementById(loadingId)?.remove();
        chatBox.innerHTML += `
            <div class="flex gap-3 items-start">
                <div class="w-8 h-8 rounded-2xl bg-red-500 text-white flex items-center justify-center text-sm font-bold shrink-0 shadow-md">
                    ⚠️
                </div>
                <div class="bg-red-50 border border-red-200 rounded-2xl rounded-tl-none p-3.5 text-xs text-red-700 font-medium max-w-[85%]">
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
        const speed = 12; // ms per character

        function typeNext() {
            if (currentIdx < fullText.length) {
                currentIdx += Math.min(2, fullText.length - currentIdx); // 1-2 chars per tick
                const currentChunk = fullText.slice(0, currentIdx);
                el.innerHTML = formatMarkdown(currentChunk) + '<span class="inline-block w-1.5 h-3.5 bg-violet-600 ml-0.5 animate-pulse"></span>';
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
        .replace(/\*\*(.*?)\*\*/g, '<strong class="font-extrabold text-slate-900">$1</strong>')
        .replace(/\*(.*?)\*/g, '<em class="italic">$1</em>')
        .replace(/\n/g, '<br>')
        .replace(/(•|\-)\s(.*?)<br>/g, '<div class="flex items-start gap-1.5 my-0.5"><span class="text-violet-600 font-bold shrink-0">•</span><span>$2</span></div>');
}

function escapeHtml(text) {
    const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
    return String(text).replace(/[&<>"']/g, m => map[m]);
}
</script>
@endpush
