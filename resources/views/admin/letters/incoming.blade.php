@extends('admin.layout')

@section('title', 'Manajemen Surat Masuk')

@section('content')
<div class="space-y-6">

    <!-- Header Box -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase border border-emerald-200">
                    Buku Agenda Surat Masuk
                </span>
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                📥 Manajemen Surat Masuk & Registrasi Agenda
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Pencatatan surat eksternal, upload scan dokumen PDF, indeks keamanan, & disposisi kilat ke pimpinan unit.
            </p>
        </div>

        <button onclick="document.getElementById('addIncomingModal').classList.remove('hidden')" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center gap-2">
            <span>➕</span> Catat Surat Masuk Baru
        </button>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.letters.incoming') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="flex-1 w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Surat, No. Agenda, Pengirim, atau Perihal..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold focus:outline-none">
            </div>

            <div class="w-full sm:w-48">
                <select name="security_level" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold">
                    <option value="">Semua Tingkat Keamanan</option>
                    <option value="BIASA" {{ request('security_level') == 'BIASA' ? 'selected' : '' }}>BIASA</option>
                    <option value="SEGERA" {{ request('security_level') == 'SEGERA' ? 'selected' : '' }}>SEGERA</option>
                    <option value="KILAT" {{ request('security_level') == 'KILAT' ? 'selected' : '' }}>KILAT</option>
                    <option value="RAHASIA" {{ request('security_level') == 'RAHASIA' ? 'selected' : '' }}>RAHASIA</option>
                </select>
            </div>

            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-slate-900 text-white font-extrabold text-xs">
                🔍 Filter Data
            </button>
        </form>
    </div>

    <!-- Table of Incoming Letters -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-black text-base text-slate-900">Buku Register Surat Masuk Terdaftar</h3>
            <span class="text-xs font-bold text-slate-400">Total: {{ $letters->total() }} Dokumen</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-4">No. Agenda & Tgl Terima</th>
                        <th class="p-4">Nomor & Tanggal Surat</th>
                        <th class="p-4">Pengirim / Instansi Asal</th>
                        <th class="p-4">Perihal / Isi Ringkas</th>
                        <th class="p-4">Keamanan</th>
                        <th class="p-4">Disposisi Pimpinan</th>
                        <th class="p-4">Berkas & Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($letters as $lt)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4">
                            <span class="font-mono font-black text-emerald-700 text-sm block">{{ $lt->agenda_number }}</span>
                            <span class="text-[10px] text-slate-400">Terima: {{ $lt->received_date ? $lt->received_date->format('d/m/Y') : '-' }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-mono font-bold text-slate-900 block">{{ $lt->reference_number }}</span>
                            <span class="text-[10px] text-slate-400 font-medium">Tgl: {{ $lt->letter_date->format('d F Y') }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">{{ $lt->sender }}</span>
                            <span class="text-[10px] text-emerald-800 font-bold block">{{ $lt->school->name ?? 'Yayasan Robbani' }}</span>
                        </td>
                        <td class="p-4 max-w-xs">
                            <h4 class="font-black text-slate-900 leading-snug">{{ $lt->title }}</h4>
                            @if($lt->content)
                                <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5">{{ Str::limit($lt->content, 60) }}</p>
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-black border {{ $lt->security_badge_class }}">
                                {{ $lt->security_level }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($lt->dispositions->count() > 0)
                                <div class="space-y-1">
                                    @foreach($lt->dispositions as $disp)
                                    <span class="inline-block px-2 py-0.5 rounded bg-amber-50 border border-amber-200 text-amber-900 font-bold text-[9px]">
                                        ➔ {{ $disp->toEmployee->full_name ?? 'Staf' }} ({{ $disp->status }})
                                    </span>
                                    @endforeach
                                </div>
                            @else
                                <button onclick="openDispositionModal('{{ $lt->id }}', '{{ addslashes($lt->title) }}', '{{ $lt->reference_number }}')" class="px-3 py-1 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-[10px] shadow-xs">
                                    + Disposisikan
                                </button>
                            @endif
                        </td>
                        <td class="p-4 flex items-center gap-1.5">
                            @if($lt->file_url)
                                <a href="{{ $lt->file_url }}" target="_blank" class="px-2.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[10px] flex items-center gap-1 shadow-xs">
                                    <span>📎</span> Scan
                                </a>
                            @endif
                            <a href="{{ route('admin.letters.preview-pdf', $lt->id) }}" target="_blank" class="px-2.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-300 font-black text-[10px] flex items-center gap-1 shadow-xs">
                                <span>🖨️</span> PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-400 italic">Belum ada surat masuk terdaftar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $letters->links() }}
        </div>
    </div>

</div>

<!-- Modal Catat Surat Masuk -->
<div id="addIncomingModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-2xl w-full shadow-2xl space-y-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-black text-slate-900">Registrasi Surat Masuk Baru</h3>
                <p class="text-xs text-slate-500 font-medium">Buku Agenda Persuratan SIT Robbani</p>
            </div>
            <button onclick="document.getElementById('addIncomingModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.letters.incoming.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs font-bold">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 mb-1">Unit Tujuan:</label>
                    <select name="school_id" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <option value="">🏢 Yayasan Generasi Robbani (Semua Unit)</option>
                        @foreach($schools as $sc)
                        <option value="{{ $sc->id }}">🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">Kategori Surat:</label>
                    <select name="letter_category" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <option value="SURAT_EDARAN">Surat Edaran (SE)</option>
                        <option value="UNDANGAN">Surat Undangan Dinas</option>
                        <option value="SURAT_TUGAS">Surat Tugas</option>
                        <option value="NOTA_DINAS">Nota Dinas</option>
                        <option value="SURAT_KEPUTUSAN">Surat Keputusan</option>
                        <option value="LAINNYA">Lainnya / Permohonan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 mb-1">Nomor Surat Asal:</label>
                    <input type="text" name="reference_number" required placeholder="Contoh: 420/128/Disdik/2026" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">Instansi / Pengirim Asal:</label>
                    <input type="text" name="sender" required placeholder="Contoh: Dinas Pendidikan Kab. Ogan Ilir" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-700 mb-1">Tanggal Surat:</label>
                    <input type="date" name="letter_date" required value="{{ date('Y-m-d') }}" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">Tanggal Diterima:</label>
                    <input type="date" name="received_date" required value="{{ date('Y-m-d') }}" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">Tingkat Keamanan:</label>
                    <select name="security_level" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <option value="BIASA">BIASA (Standar)</option>
                        <option value="SEGERA">SEGERA (Perlu Respon)</option>
                        <option value="KILAT">KILAT (Penting/Urgent)</option>
                        <option value="RAHASIA">RAHASIA (Pimpinan)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Perihal / Judul Surat:</label>
                <input type="text" name="title" required placeholder="Contoh: Undangan Rapat Koordinasi Kurikulum Merdeka & ANBK 2026" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Ringkasan / Isi Pokok Surat:</label>
                <textarea name="content" rows="2" placeholder="Catatan ringkas isi surat..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200"></textarea>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Unggah Berkas Scan / Dokumen Asli (PDF/JPG):</label>
                <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <!-- Optional Direct Disposition -->
            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 space-y-3">
                <span class="block text-xs font-black text-amber-900 uppercase">⚡ Disposisi Langsung (Opsional)</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-slate-700 mb-1">Tujuan Disposisi Staf/Guru:</label>
                        <select name="disposition_to" class="w-full p-2.5 rounded-xl bg-white border border-slate-200">
                            <option value="">-- Pilih Staf Penerima --</option>
                            @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->role_type }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Instruksi Disposisi:</label>
                        <select name="disposition_instruction" class="w-full p-2.5 rounded-xl bg-white border border-slate-200">
                            <option value="Tindak Lanjuti Segera">Tindak Lanjuti Segera</option>
                            <option value="Pelajari & Berikan Tanggapan">Pelajari & Berikan Tanggapan</option>
                            <option value="Hadir Mewakili Sekolah">Hadir Mewakili Sekolah</option>
                            <option value="Siapkan Data & Bahan Laporan">Siapkan Data & Bahan Laporan</option>
                            <option value="Arsipkan & Simpan">Arsipkan & Simpan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addIncomingModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Simpan Surat Masuk ➔</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Delegasi Disposisi Cepat -->
<div id="dispositionModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-black text-slate-900">Lembar Disposisi Pimpinan</h3>
                <p id="dispLetterTitle" class="text-xs text-amber-700 font-bold truncate max-w-sm mt-0.5">Surat Dinas</p>
            </div>
            <button onclick="document.getElementById('dispositionModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.letters.dispositions.store') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <input type="hidden" name="letter_id" id="dispLetterId">

            <div>
                <label class="block text-slate-700 mb-1">Teruskan / Disposisikan Kepada:</label>
                <select name="to_employee_id" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    @foreach($employees as $emp)
                    <option value="{{ $emp->id }}">{{ $emp->full_name }} ({{ $emp->role_type }} • {{ $emp->school->code ?? '-' }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Arahan / Instruksi Pimpinan:</label>
                <select name="instruction" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <option value="Tindak Lanjuti Segera">⚡ Tindak Lanjuti Segera</option>
                    <option value="Pelajari & Buat Rekomendasi">🔍 Pelajari & Buat Rekomendasi</option>
                    <option value="Hadir / Wakili Acara Dinas">👥 Hadir / Wakili Acara Dinas</option>
                    <option value="Koordinasikan dengan Dewan Guru">🗣️ Koordinasikan dengan Dewan Guru</option>
                    <option value="Siapkan Dokumen & Berkas">📁 Siapkan Dokumen & Berkas</option>
                    <option value="Arsipkan untuk Bahan Evaluasi">🗄️ Arsipkan untuk Bahan Evaluasi</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Catatan Khusus Pimpinan:</label>
                <textarea name="notes" rows="2" placeholder="Catatan tambahan arahan pimpinan..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200"></textarea>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Batas Waktu Penyelesaian (Due Date):</label>
                <input type="date" name="due_date" value="{{ date('Y-m-d', strtotime('+3 days')) }}" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('dispositionModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black shadow-md">Terbitkan Disposisi ➔</button>
            </div>
        </form>
    </div>
</div>

<script>
function openDispositionModal(letterId, title, refNo) {
    document.getElementById('dispLetterId').value = letterId;
    document.getElementById('dispLetterTitle').innerText = 'No: ' + refNo + ' • ' + title;
    document.getElementById('dispositionModal').classList.remove('hidden');
}
</script>
@endsection
