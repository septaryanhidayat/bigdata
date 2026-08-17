@extends('admin.layout')

@section('title', '🤖 AI Knowledge Base Trainer')

@section('content')
<div class="p-4 sm:p-6 space-y-6">

    {{-- ═══════════════════════════════════════════════
         HEADER SECTION
    ═══════════════════════════════════════════════ --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-xl shadow-lg">🤖</div>
                <div>
                    <h1 class="text-xl font-black text-slate-900">AI Knowledge Base Trainer</h1>
                    <p class="text-xs text-slate-500 font-semibold">Latih Chatbot Robbani SmartEdu AI dengan dokumen & data sekolah Anda</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            {{-- Status badge --}}
            @php $geminiActive = !empty(env('GEMINI_API_KEY') ?: env('GOOGLE_API_KEY')); @endphp
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-extrabold {{ $geminiActive ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }} border {{ $geminiActive ? 'border-emerald-200' : 'border-amber-200' }}">
                <span class="w-2 h-2 rounded-full {{ $geminiActive ? 'bg-emerald-500 animate-pulse' : 'bg-amber-500' }}"></span>
                {{ $geminiActive ? 'Gemini AI Aktif' : 'Mode Offline (RAG Lokal)' }}
            </span>
            <button id="btnAutoSync" onclick="doAutoSync()" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-blue-600 to-violet-600 hover:from-blue-700 hover:to-violet-700 text-white font-extrabold text-xs shadow-lg hover:shadow-blue-500/30 transition-all hover:scale-105 active:scale-95">
                <span id="syncIcon">🔄</span>
                <span id="syncText">Auto-Sync Website</span>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 text-sm font-semibold">
        <span class="text-lg">✅</span> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-2xl text-red-800 text-sm font-semibold">
        <span class="text-lg">❌</span> {{ session('error') }}
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════
         STATS CARDS (HIGH-CONTRAST & CRYSTAL CLEAR)
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white border-2 border-violet-200 rounded-2xl p-4.5 shadow-sm col-span-1 hover:border-violet-500 transition-all">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-black uppercase text-violet-700 tracking-wider">Total Dokumen</span>
                <span class="w-8 h-8 rounded-xl bg-violet-100 text-violet-700 flex items-center justify-center text-sm font-bold">📚</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $totalDocs }}</div>
            <div class="text-[11px] font-bold text-slate-500 mt-1">Knowledge Base Aktif</div>
        </div>
        <div class="bg-white border-2 border-emerald-200 rounded-2xl p-4.5 shadow-sm col-span-1 hover:border-emerald-500 transition-all">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-black uppercase text-emerald-700 tracking-wider">Dokumen Aktif</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm font-bold">✅</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $activeDocs }}</div>
            <div class="text-[11px] font-bold text-slate-500 mt-1">Siap Digunakan AI</div>
        </div>
        <div class="bg-white border-2 border-blue-200 rounded-2xl p-4.5 shadow-sm col-span-1 hover:border-blue-500 transition-all">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-black uppercase text-blue-700 tracking-wider">File Diupload</span>
                <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold">📁</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $uploadedCount }}</div>
            <div class="text-[11px] font-bold text-slate-500 mt-1">PDF / Word / Excel / TXT</div>
        </div>
        <div class="bg-white border-2 border-cyan-200 rounded-2xl p-4.5 shadow-sm col-span-1 hover:border-cyan-500 transition-all">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-black uppercase text-cyan-700 tracking-wider">Data Website</span>
                <span class="w-8 h-8 rounded-xl bg-cyan-100 text-cyan-700 flex items-center justify-center text-sm font-bold">🌐</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $websiteDataCount }}</div>
            <div class="text-[11px] font-bold text-slate-500 mt-1">Berita, Artikel, FAQ, Unit</div>
        </div>
        <div class="bg-white border-2 border-amber-200 rounded-2xl p-4.5 shadow-sm col-span-2 lg:col-span-1 hover:border-amber-500 transition-all">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-black uppercase text-amber-700 tracking-wider">Total Kata</span>
                <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm font-bold">🔤</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ number_format($totalWords) }}</div>
            <div class="text-[11px] font-bold text-slate-500 mt-1">{{ $lastSync ? 'Sync: '.($lastSync->diffForHumans()) : 'Knowledge Base Siap' }}</div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════
         MAIN 2-COLUMN GRID
    ═══════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- LEFT COLUMN: Upload + Manual + Test ──────────────── --}}
        <div class="xl:col-span-1 space-y-6">

            {{-- ── Upload File ── --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-blue-100 flex items-center justify-center text-base">📁</div>
                    <div>
                        <h2 class="font-black text-slate-900 text-sm">Upload Dokumen</h2>
                        <p class="text-[11px] text-slate-500">PDF, Word (.docx), Excel (.xlsx), TXT — maks. 20MB</p>
                    </div>
                </div>
                <div class="p-5">
                    <form action="{{ route('admin.ai-trainer.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        {{-- Drag & Drop Zone --}}
                        <div id="dropZone" class="relative border-2 border-dashed border-slate-300 hover:border-violet-400 rounded-2xl p-6 text-center transition-colors cursor-pointer mb-4 group"
                             onclick="document.getElementById('fileInput').click()">
                            <input type="file" name="file" id="fileInput" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" onchange="onFileSelect(this)">
                            <div id="dropZoneDefault">
                                <div class="text-4xl mb-2">📂</div>
                                <p class="text-sm font-bold text-slate-600 group-hover:text-violet-600 transition-colors">Klik atau seret file ke sini</p>
                                <p class="text-[11px] text-slate-400 mt-1">PDF · DOCX · XLSX · TXT (maks 20 MB)</p>
                            </div>
                            <div id="dropZoneSelected" class="hidden">
                                <div class="text-4xl mb-2">✅</div>
                                <p class="text-sm font-black text-emerald-600" id="selectedFileName"></p>
                                <p class="text-[11px] text-slate-400 mt-1" id="selectedFileSize"></p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 mb-1">Judul Dokumen <span class="text-slate-400 font-normal">(opsional, otomatis dari nama file)</span></label>
                                <input type="text" name="title" placeholder="Contoh: Panduan SPMB 2026" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400">
                            </div>
                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 mb-1">Kategori Dokumen <span class="text-red-500">*</span></label>
                                <select name="category" required class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400 bg-white">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $key => $label)
                                        @if($key !== 'website_data')
                                        <option value="{{ $key }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" id="btnUpload" class="w-full py-3 rounded-xl bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-black text-sm shadow-lg hover:shadow-violet-500/30 transition-all hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
                                <span>⬆️</span> Upload & Proses Dokumen
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── Manual Input ── --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center text-base">✍️</div>
                    <div>
                        <h2 class="font-black text-slate-900 text-sm">Input Manual</h2>
                        <p class="text-[11px] text-slate-500">Ketik informasi penting langsung ke knowledge base</p>
                    </div>
                </div>
                <div class="p-5">
                    <form action="{{ route('admin.ai-trainer.store') }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 mb-1">Judul / Topik <span class="text-red-500">*</span></label>
                                <input type="text" name="title" required placeholder="Contoh: Tata Tertib Siswa SMPIT" class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400">
                            </div>
                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                                <select name="category" required class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 bg-white">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($categories as $key => $label)
                                        @if($key !== 'website_data')
                                        <option value="{{ $key }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-extrabold text-slate-700 mb-1">Konten / Isi Pengetahuan <span class="text-red-500">*</span></label>
                                <textarea name="content" required rows="6" placeholder="Tulis informasi di sini... Misalnya: SOP izin tidak masuk sekolah, biaya SPP per unit, syarat masuk PPDB, program tahfidz, dsb."
                                    class="w-full border border-slate-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-400 resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black text-sm shadow-lg transition-all hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
                                <span>💾</span> Simpan ke Knowledge Base
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── Test Chat Panel ── --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-violet-100 flex items-center justify-center text-base">💬</div>
                    <div>
                        <h2 class="font-black text-slate-900 text-sm">Uji Coba Chatbot AI</h2>
                        <p class="text-[11px] text-slate-500">Test respons AI dari panel admin</p>
                    </div>
                </div>
                <div class="p-5">
                    <div id="chatMessages" class="space-y-3 mb-4 max-h-60 overflow-y-auto pr-1">
                        <div class="flex gap-2">
                            <div class="w-7 h-7 rounded-xl bg-violet-600 text-white flex items-center justify-center text-xs shrink-0">🤖</div>
                            <div class="bg-slate-100 rounded-2xl rounded-tl-none px-4 py-2.5 text-xs text-slate-700 font-medium max-w-xs">
                                Assalamu'alaikum! Saya siap diuji. Ketik pertanyaan tentang sekolah untuk melihat respons AI.
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <input type="text" id="testChatInput" placeholder="Ketik pertanyaan uji..." class="flex-1 border border-slate-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-violet-400" onkeypress="if(event.key==='Enter')sendTestChat()">
                        <button onclick="sendTestChat()" class="px-4 py-2 rounded-xl bg-violet-600 hover:bg-violet-700 text-white font-bold text-sm transition-colors">
                            ➤
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT COLUMN: Knowledge Base Table ─────────────── --}}
        <div class="xl:col-span-2 space-y-4">

            {{-- ── Category Summary Pills ── --}}
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.ai-trainer.index') }}" class="px-3 py-1.5 rounded-full text-xs font-extrabold {{ !$category ? 'bg-violet-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-violet-400' }} transition-all">
                    🗂️ Semua ({{ $totalDocs }})
                </a>
                @foreach($categories as $key => $label)
                <a href="{{ route('admin.ai-trainer.index', ['category' => $key]) }}" class="px-3 py-1.5 rounded-full text-xs font-extrabold {{ $category === $key ? 'bg-violet-600 text-white shadow-md' : 'bg-white text-slate-600 border border-slate-200 hover:border-violet-400' }} transition-all">
                    {{ $label }} ({{ $categoryStats[$key] ?? 0 }})
                </a>
                @endforeach
            </div>

            {{-- ── Search Bar + Bulk Delete ── --}}
            <div class="flex gap-3 items-center">
                <form method="GET" action="{{ route('admin.ai-trainer.index') }}" class="flex-1">
                    <input type="hidden" name="category" value="{{ $category }}">
                    <div class="flex items-center bg-white border border-slate-200 rounded-xl px-3 py-2 gap-2">
                        <span class="text-slate-400 text-sm">🔍</span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul, kategori, atau ringkasan..."
                            class="flex-1 bg-transparent border-none text-sm focus:outline-none text-slate-700">
                        @if($search)
                        <a href="{{ route('admin.ai-trainer.index', ['category' => $category]) }}" class="text-slate-400 hover:text-red-500 text-xs font-bold">✕</a>
                        @endif
                    </div>
                </form>
                <button id="btnBulkDelete" onclick="bulkDelete()" class="hidden px-3 py-2 rounded-xl bg-red-100 hover:bg-red-200 text-red-700 font-extrabold text-xs border border-red-200 transition-colors gap-1 items-center">
                    🗑️ <span id="bulkCount">0</span> Hapus
                </button>
            </div>

            {{-- ── Knowledge Base Table ── --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                @if($knowledgeBases->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-4 py-3 text-left">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)" class="rounded text-violet-600">
                                </th>
                                <th class="px-4 py-3 text-left font-black text-slate-600 uppercase tracking-wide">Dokumen / Judul</th>
                                <th class="px-4 py-3 text-left font-black text-slate-600 uppercase tracking-wide hidden md:table-cell">Kategori</th>
                                <th class="px-4 py-3 text-center font-black text-slate-600 uppercase tracking-wide hidden lg:table-cell">Kata</th>
                                <th class="px-4 py-3 text-center font-black text-slate-600 uppercase tracking-wide">Status</th>
                                <th class="px-4 py-3 text-center font-black text-slate-600 uppercase tracking-wide">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($knowledgeBases as $kb)
                            <tr class="hover:bg-slate-50 transition-colors group" data-id="{{ $kb->id }}">
                                <td class="px-4 py-3">
                                    <input type="checkbox" class="row-checkbox rounded text-violet-600" value="{{ $kb->id }}" onchange="updateBulkDelete()">
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-start gap-2.5">
                                        <div class="w-8 h-8 rounded-xl shrink-0 flex items-center justify-center text-base
                                            {{ $kb->source_type === 'pdf' ? 'bg-red-100' :
                                               ($kb->source_type === 'docx' || $kb->source_type === 'doc' ? 'bg-blue-100' :
                                               ($kb->source_type === 'xlsx' || $kb->source_type === 'xls' ? 'bg-emerald-100' :
                                               ($kb->source_type === 'website_data' ? 'bg-cyan-100' : 'bg-slate-100'))) }}">
                                            {{ $kb->source_type === 'pdf' ? '📄' :
                                               ($kb->source_type === 'docx' || $kb->source_type === 'doc' ? '📝' :
                                               ($kb->source_type === 'xlsx' || $kb->source_type === 'xls' ? '📊' :
                                               ($kb->source_type === 'website_data' ? '🌐' : '✍️'))) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-extrabold text-slate-900 truncate max-w-[200px] lg:max-w-[280px]" title="{{ $kb->title }}">{{ $kb->title }}</p>
                                            <p class="text-slate-400 mt-0.5 line-clamp-1 font-medium">{{ Str::limit($kb->summary, 60) }}</p>
                                            @if($kb->uploaded_by)
                                            <p class="text-[10px] text-slate-400 mt-0.5">oleh: {{ $kb->uploaded_by }} · {{ $kb->processed_at?->format('d/m/Y H:i') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 hidden md:table-cell">
                                    <span class="px-2 py-1 rounded-full text-[10px] font-extrabold {{ $kb->category_color }}">
                                        {{ $kb->category_label }}
                                    </span>
                                    @if($kb->file_name)
                                    <p class="text-[10px] text-slate-400 mt-1 truncate max-w-[100px]" title="{{ $kb->file_name }}">{{ $kb->file_name }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center text-slate-600 font-bold hidden lg:table-cell">
                                    {{ number_format($kb->word_count ?? 0) }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button onclick="toggleDoc({{ $kb->id }}, this)"
                                        class="relative inline-flex items-center w-10 h-5 rounded-full transition-colors duration-200 {{ $kb->is_active ? 'bg-emerald-500' : 'bg-slate-300' }}"
                                        title="{{ $kb->is_active ? 'Klik untuk nonaktifkan' : 'Klik untuk aktifkan' }}">
                                        <span class="absolute left-0.5 w-4 h-4 rounded-full bg-white shadow-sm transform transition-transform duration-200 {{ $kb->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button onclick="confirmDelete({{ $kb->id }}, '{{ addslashes($kb->title) }}')" class="w-7 h-7 rounded-lg bg-red-100 hover:bg-red-200 text-red-600 font-bold transition-colors flex items-center justify-center mx-auto" title="Hapus">🗑️</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($knowledgeBases->hasPages())
                <div class="px-4 py-3 border-t border-slate-100 flex items-center justify-between">
                    <p class="text-xs text-slate-500">Menampilkan {{ $knowledgeBases->firstItem() }}-{{ $knowledgeBases->lastItem() }} dari {{ $knowledgeBases->total() }} dokumen</p>
                    <div class="flex gap-1">
                        @if($knowledgeBases->onFirstPage())
                            <span class="px-3 py-1.5 rounded-lg text-xs text-slate-400 cursor-not-allowed">← Sebelumnya</span>
                        @else
                            <a href="{{ $knowledgeBases->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition-colors">← Sebelumnya</a>
                        @endif
                        @if($knowledgeBases->hasMorePages())
                            <a href="{{ $knowledgeBases->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs bg-violet-600 hover:bg-violet-700 text-white font-semibold transition-colors">Selanjutnya →</a>
                        @else
                            <span class="px-3 py-1.5 rounded-lg text-xs text-slate-400 cursor-not-allowed">Selanjutnya →</span>
                        @endif
                    </div>
                </div>
                @endif

                @else
                {{-- Empty State --}}
                <div class="text-center py-16 px-4">
                    <div class="text-6xl mb-4">🤖</div>
                    <h3 class="font-black text-slate-800 text-lg mb-2">Knowledge Base Masih Kosong</h3>
                    <p class="text-slate-500 text-sm mb-6">Upload dokumen atau klik "Auto-Sync Website" untuk mulai melatih AI chatbot Anda.</p>
                    <button onclick="doAutoSync()" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-violet-600 text-white font-extrabold text-sm shadow-lg hover:shadow-blue-500/30 transition-all hover:scale-105">
                        🔄 Auto-Sync Data Website Sekarang
                    </button>
                </div>
                @endif
            </div>

            {{-- ── Auto-Sync Info Card ── --}}
            <div class="bg-gradient-to-br from-blue-50 to-violet-50 border border-blue-200/60 rounded-2xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg shrink-0">🔄</div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm mb-1">Tentang Auto-Sync Website</h3>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Tombol <strong>Auto-Sync Website</strong> akan mensinkronisasi semua data berita, artikel, FAQ, profil unit,
                            informasi kontak, dan pengaturan utama website ke dalam knowledge base AI secara otomatis.
                            Lakukan sync ulang setiap kali ada perubahan besar pada konten website agar chatbot selalu up-to-date.
                        </p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach(['🗞️ Berita', '📝 Artikel', '❓ FAQ', '🏫 Profil Unit', '⚙️ Data Kontak'] as $item)
                            <span class="px-2 py-1 rounded-lg bg-white border border-blue-200 text-blue-700 text-[10px] font-extrabold">{{ $item }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════
     HIDDEN DELETE FORM
═══════════════════════════════════════════════ --}}
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
// ── File Upload Drop Zone ───────────────────────────────────────────────────
function onFileSelect(input) {
    if (!input.files[0]) return;
    const file = input.files[0];
    document.getElementById('dropZoneDefault').classList.add('hidden');
    document.getElementById('dropZoneSelected').classList.remove('hidden');
    document.getElementById('selectedFileName').textContent = file.name;
    const size = file.size < 1048576
        ? (file.size / 1024).toFixed(1) + ' KB'
        : (file.size / 1048576).toFixed(2) + ' MB';
    document.getElementById('selectedFileSize').textContent = size;
}

const dropZone = document.getElementById('dropZone');
if (dropZone) {
    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-violet-500', 'bg-violet-50'); });
    dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-violet-500', 'bg-violet-50'); });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('border-violet-500', 'bg-violet-50');
        const fileInput = document.getElementById('fileInput');
        fileInput.files = e.dataTransfer.files;
        onFileSelect(fileInput);
    });
}

// ── Upload Form Loading State ───────────────────────────────────────────────
document.getElementById('uploadForm')?.addEventListener('submit', function() {
    const btn = document.getElementById('btnUpload');
    btn.innerHTML = '<svg class="animate-spin w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg> Memproses...';
    btn.disabled = true;
});

// ── Auto-Sync ───────────────────────────────────────────────────────────────
async function doAutoSync() {
    const btn = document.getElementById('btnAutoSync');
    const icon = document.getElementById('syncIcon');
    const text = document.getElementById('syncText');

    icon.textContent = '⏳';
    text.textContent = 'Menyinkronkan...';
    btn.disabled = true;

    try {
        const res = await fetch('{{ route("admin.ai-trainer.auto-sync") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        });
        const data = await res.json();

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Auto-Sync Selesai! ✅',
                html: `<p class="mb-3">${data.message}</p><ul class="text-left text-sm space-y-1">${data.details.map(d => `<li>${d}</li>`).join('')}</ul>`,
                confirmButtonText: 'Oke, Muat Ulang',
                confirmButtonColor: '#7c3aed',
            }).then(() => location.reload());
        } else {
            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
        }
    } catch (err) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal terhubung ke server.' });
    } finally {
        icon.textContent = '🔄';
        text.textContent = 'Auto-Sync Website';
        btn.disabled = false;
    }
}

// ── Toggle Active ───────────────────────────────────────────────────────────
async function toggleDoc(id, btn) {
    try {
        const res = await fetch(`/admin/ai-trainer/${id}/toggle`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        });
        const data = await res.json();
        if (data.success) {
            btn.classList.toggle('bg-emerald-500', data.is_active);
            btn.classList.toggle('bg-slate-300', !data.is_active);
            const dot = btn.querySelector('span');
            dot.classList.toggle('translate-x-5', data.is_active);
            dot.classList.toggle('translate-x-0', !data.is_active);
        }
    } catch (e) {
        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal mengubah status.' });
    }
}

// ── Delete ──────────────────────────────────────────────────────────────────
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Hapus Dokumen?',
        html: `<p class="text-sm text-slate-600">Dokumen <strong>"${title}"</strong> akan dihapus permanen dari Knowledge Base AI.</p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '🗑️ Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
    }).then(result => {
        if (result.isConfirmed) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/ai-trainer/${id}`;
            form.submit();
        }
    });
}

// ── Bulk Delete ─────────────────────────────────────────────────────────────
function toggleSelectAll(cb) {
    document.querySelectorAll('.row-checkbox').forEach(c => c.checked = cb.checked);
    updateBulkDelete();
}

function updateBulkDelete() {
    const checked = document.querySelectorAll('.row-checkbox:checked');
    const btn = document.getElementById('btnBulkDelete');
    document.getElementById('bulkCount').textContent = checked.length;
    btn.style.display = checked.length > 0 ? 'inline-flex' : 'none';
}

async function bulkDelete() {
    const checked = document.querySelectorAll('.row-checkbox:checked');
    if (checked.length === 0) return;
    const ids = Array.from(checked).map(c => parseInt(c.value));

    const result = await Swal.fire({
        title: `Hapus ${ids.length} Dokumen?`,
        text: 'Semua dokumen yang dipilih akan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '🗑️ Ya, Hapus Semua',
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

// ── Test Chat ───────────────────────────────────────────────────────────────
async function sendTestChat() {
    const input = document.getElementById('testChatInput');
    const msg = input.value.trim();
    if (!msg) return;

    const chatBox = document.getElementById('chatMessages');

    // Append user bubble
    chatBox.innerHTML += `<div class="flex gap-2 justify-end">
        <div class="bg-violet-600 rounded-2xl rounded-tr-none px-4 py-2.5 text-xs text-white font-medium max-w-xs">${msg}</div>
        <div class="w-7 h-7 rounded-xl bg-slate-200 flex items-center justify-center text-xs shrink-0">👤</div>
    </div>`;
    input.value = '';
    chatBox.scrollTop = chatBox.scrollHeight;

    // Loading bubble
    const loadingId = 'loading-' + Date.now();
    chatBox.innerHTML += `<div id="${loadingId}" class="flex gap-2">
        <div class="w-7 h-7 rounded-xl bg-violet-600 text-white flex items-center justify-center text-xs shrink-0">🤖</div>
        <div class="bg-slate-100 rounded-2xl rounded-tl-none px-4 py-2.5 text-xs text-slate-500 font-medium max-w-xs flex items-center gap-2">
            <span class="animate-spin">⏳</span> Memproses...
        </div>
    </div>`;
    chatBox.scrollTop = chatBox.scrollHeight;

    try {
        const res = await fetch('{{ route("admin.ai-trainer.test-chat") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ message: msg }),
        });
        const data = await res.json();
        document.getElementById(loadingId)?.remove();

        const formatted = (data.answer || 'Tidak ada respons.')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>');

        chatBox.innerHTML += `<div class="flex gap-2">
            <div class="w-7 h-7 rounded-xl bg-violet-600 text-white flex items-center justify-center text-xs shrink-0">🤖</div>
            <div class="bg-slate-100 rounded-2xl rounded-tl-none px-4 py-2.5 text-xs text-slate-700 font-medium max-w-xs leading-relaxed">${formatted}</div>
        </div>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    } catch (e) {
        document.getElementById(loadingId)?.remove();
        chatBox.innerHTML += `<div class="flex gap-2">
            <div class="w-7 h-7 rounded-xl bg-red-400 text-white flex items-center justify-center text-xs shrink-0">⚠️</div>
            <div class="bg-red-50 rounded-2xl rounded-tl-none px-4 py-2.5 text-xs text-red-600 font-medium max-w-xs">Error koneksi ke server.</div>
        </div>`;
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}
</script>
@endpush
