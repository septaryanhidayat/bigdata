@extends('admin.layout')

@section('title', 'Antrian Tanda Tangan Elektronik (TTE)')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    <!-- Header Box -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 font-black text-[10px] uppercase border border-purple-200">
                    Otoritas TTE Digital Internal
                </span>
                <span class="w-2 h-2 rounded-full bg-purple-500 animate-ping"></span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1.5">
                ✍️ Antrian & Pengesahan TTE Digital Internal
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5 leading-relaxed">
                Surat terbitan Yayasan disahkan oleh <strong>Ketua Yayasan</strong>, surat terbitan Unit disahkan oleh <strong>Kepala Unit</strong> masing-masing.
            </p>
        </div>

        <button type="button" onclick="openBulkModal()" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white font-black text-xs shadow-md transition-transform active:scale-95 flex items-center justify-center gap-2">
            <span>⚡</span> Bulk Signing (Tanda Tangan Massal)
        </button>
    </div>

    <!-- Security Info Banner -->
    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-purple-900 via-indigo-900 to-slate-900 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center text-xl shrink-0">
                🛡️
            </div>
            <div>
                <h4 class="font-black text-xs text-purple-200">Pengesahan Resmi Berjenjang SIT Robbani</h4>
                <p class="text-[11px] text-slate-300">Surat Yayasan ➔ Ketua Yayasan • Surat Unit (TK/SD/SMP/SMA) ➔ Kepala Unit Sekolah terkait.</p>
            </div>
        </div>
        <span class="px-3 py-1 rounded-full bg-purple-500/30 border border-purple-400/40 text-purple-200 font-bold text-[10px] shrink-0 whitespace-nowrap">
            🔒 SmartEdu Internal QR Sign
        </span>
    </div>

    <!-- Form & Table of Pending Letters -->
    <form id="bulkSignForm" action="{{ route('admin.letters.bulk-sign') }}" method="POST">
        @csrf

        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h3 class="font-black text-base text-slate-900">Daftar Dokumen Menunggu Tanda Tangan</h3>
                    <p class="text-xs text-slate-400 font-medium">Pilih surat untuk penandatanganan mandiri atau massal</p>
                </div>
                <span class="text-xs font-bold text-purple-700 bg-purple-50 px-3 py-1 rounded-full border border-purple-200 w-fit">
                    {{ $pendingLetters->count() }} Dokumen Siap Sah
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-900 text-white font-bold uppercase">
                        <tr>
                            <th class="p-4 w-10">
                                <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" class="rounded border-slate-700 text-purple-600 focus:ring-purple-500">
                            </th>
                            <th class="p-4">Nomor & Kategori Surat</th>
                            <th class="p-4">Perihal & Isi Ringkas</th>
                            <th class="p-4">Penerbit & Otoritas Sah</th>
                            <th class="p-4">Tujuan</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4 text-center">Aksi TTE</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                        @forelse($pendingLetters as $lt)
                        <tr class="hover:bg-purple-50/40">
                            <td class="p-4">
                                <input type="checkbox" name="letter_ids[]" value="{{ $lt->id }}" class="letter-checkbox rounded border-slate-300 text-purple-600 focus:ring-purple-500">
                            </td>
                            <td class="p-4">
                                <span class="font-mono font-black text-purple-800 text-xs sm:text-sm block">{{ $lt->reference_number }}</span>
                                <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $lt->category_label }}</span>
                            </td>
                            <td class="p-4 max-w-xs">
                                <h4 class="font-black text-slate-900 leading-snug">{{ $lt->title }}</h4>
                                <span class="text-[10px] text-slate-500 line-clamp-1 mt-0.5">{{ Str::limit(strip_tags($lt->content), 60) }}</span>
                            </td>
                            <td class="p-4">
                                @if(!$lt->school_id || !$lt->school)
                                    <span class="font-black text-purple-900 block">🏢 Yayasan Generasi Robbani</span>
                                    <span class="text-[10px] text-purple-700 font-bold">👑 Otoritas: Ketua Yayasan</span>
                                @else
                                    <span class="font-black text-slate-900 block">🏫 {{ $lt->school->name }}</span>
                                    <span class="text-[10px] text-emerald-700 font-bold">👨‍💼 Otoritas: Kepala {{ $lt->school->code }}</span>
                                @endif
                            </td>
                            <td class="p-4 text-slate-700">
                                {{ $lt->recipient }}
                            </td>
                            <td class="p-4 font-mono text-slate-600 whitespace-nowrap">
                                {{ $lt->letter_date->format('d M Y') }}
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                    <button type="button" onclick="openSingleSignModal('{{ $lt->id }}', '{{ $lt->reference_number }}', '{{ addslashes($lt->title) }}', '{{ $lt->school_id }}')" class="px-3 py-1.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-black text-xs shadow-xs flex items-center gap-1">
                                        <span>✍️</span> Sahkan TTE
                                    </button>
                                    <a href="{{ route('admin.letters.preview-pdf', $lt->id) }}" target="_blank" class="px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs">
                                        👁️ Draf
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 italic">Tidak ada surat keluar dalam antrian TTE saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Bulk Signing -->
        <div id="bulkPassphraseModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
            <div class="bg-white rounded-3xl p-5 sm:p-8 max-w-md w-full shadow-2xl space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Bulk Signing (TTE Massal)</h3>
                        <p class="text-xs text-purple-700 font-bold mt-0.5">Penandatanganan Dokumen Terpilih Sekaligus</p>
                    </div>
                    <button type="button" onclick="document.getElementById('bulkPassphraseModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
                </div>

                <div class="space-y-4 text-xs font-bold">
                    <div>
                        <label class="block text-slate-700 mb-1">Pilih Pejabat Penandatangan:</label>
                        <select name="signer_employee_id" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                            <optgroup label="👑 Pimpinan Yayasan (Untuk Surat Yayasan)">
                                @foreach($signers->filter(fn($s) => !$s->school_id) as $sgn)
                                <option value="{{ $sgn->id }}" data-school="">👑 {{ $sgn->full_name }} (Ketua Yayasan • NIY: {{ $sgn->nip }})</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="🏫 Kepala Unit Sekolah (Untuk Surat Unit)">
                                @foreach($signers->filter(fn($s) => $s->school_id && $s->role_type == 'HEADMASTER') as $sgn)
                                <option value="{{ $sgn->id }}" data-school="{{ $sgn->school_id }}">🏫 {{ $sgn->full_name }} (Kepala {{ $sgn->school->code }} • NIP: {{ $sgn->nip }})</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="👨‍🏫 Dewan Guru & Pejabat Lainnya">
                                @foreach($signers->filter(fn($s) => $s->school_id && $s->role_type != 'HEADMASTER') as $sgn)
                                <option value="{{ $sgn->id }}" data-school="{{ $sgn->school_id }}">👨‍🏫 {{ $sgn->full_name }} ({{ $sgn->role_type }} • {{ $sgn->school->code }})</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Passphrase Keamanan TTE Internal:</label>
                        <input type="password" name="passphrase" required placeholder="Masukkan passphrase keamanan..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200 text-sm">
                        <span class="text-[10px] text-slate-400 font-medium block mt-1">Masukkan kata sandi pengesahan pimpinan.</span>
                    </div>

                    <div class="p-3 rounded-2xl bg-purple-50 border border-purple-200 text-[11px] text-purple-900 font-medium">
                        🛡️ Semua dokumen yang dicentang akan dibubuhi stempel visual QR Code verifikasi internal secara otomatis.
                    </div>

                    <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" onclick="document.getElementById('bulkPassphraseModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                        <button type="submit" class="px-6 py-2.5 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white font-black shadow-md">Eksekusi TTE Massal ➔</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>

<!-- Modal Single Sign TTE -->
<div id="singleSignModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-5 sm:p-8 max-w-md w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-black text-slate-900">Otorisasi TTE Dokumen</h3>
                <p id="singleSignRef" class="text-xs text-purple-700 font-bold truncate max-w-xs mt-0.5">No Surat</p>
            </div>
            <button onclick="document.getElementById('singleSignModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form id="singleSignForm" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Pejabat Penandatangan:</label>
                <select name="signer_employee_id" id="singleSignerSelect" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <optgroup label="👑 Pimpinan Yayasan (Untuk Surat Yayasan)">
                        @foreach($signers->filter(fn($s) => !$s->school_id) as $sgn)
                        <option value="{{ $sgn->id }}" data-school="">👑 {{ $sgn->full_name }} (Ketua Yayasan • NIY: {{ $sgn->nip }})</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="🏫 Kepala Unit Sekolah (Untuk Surat Unit)">
                        @foreach($signers->filter(fn($s) => $s->school_id && $s->role_type == 'HEADMASTER') as $sgn)
                        <option value="{{ $sgn->id }}" data-school="{{ $sgn->school_id }}">🏫 {{ $sgn->full_name }} (Kepala {{ $sgn->school->code }} • NIP: {{ $sgn->nip }})</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="👨‍🏫 Dewan Guru & Pejabat Lainnya">
                        @foreach($signers->filter(fn($s) => $s->school_id && $s->role_type != 'HEADMASTER') as $sgn)
                        <option value="{{ $sgn->id }}" data-school="{{ $sgn->school_id }}">👨‍🏫 {{ $sgn->full_name }} ({{ $sgn->role_type }} • {{ $sgn->school->code }})</option>
                        @endforeach
                    </optgroup>
                </select>
                <span class="text-[10px] text-slate-400 font-medium block mt-1">Otomatis dicocokkan dengan unit penerbit surat.</span>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Passphrase Keamanan TTE:</label>
                <input type="password" name="passphrase" required placeholder="Masukkan passphrase keamanan..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200 text-sm">
            </div>

            <div class="p-3 rounded-2xl bg-emerald-50 border border-emerald-200 text-[11px] text-emerald-900 font-medium">
                ✓ Dokumen akan langsung disahkan dan QR Code verifikasi internal akan digenerate otomatis.
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('singleSignModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-purple-600 hover:bg-purple-700 text-white font-black shadow-md">Bubuhkan TTE ➔</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSelectAll(master) {
    document.querySelectorAll('.letter-checkbox').forEach(cb => cb.checked = master.checked);
}

function openBulkModal() {
    const checkedBoxes = document.querySelectorAll('.letter-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Silakan centang minimal 1 dokumen yang ingin ditandatangani secara massal!');
        return;
    }
    document.getElementById('bulkPassphraseModal').classList.remove('hidden');
}

function openSingleSignModal(letterId, refNo, title, schoolId) {
    document.getElementById('singleSignForm').action = '/admin/letters/sign/' + letterId;
    document.getElementById('singleSignRef').innerText = refNo + ' • ' + title;
    
    // Auto-select Ketua Yayasan for yayasan letters, or Kepala Unit for school letters
    const select = document.getElementById('singleSignerSelect');
    if (select) {
        for (let i = 0; i < select.options.length; i++) {
            const opt = select.options[i];
            const optSchool = opt.getAttribute('data-school');
            if (!schoolId && (!optSchool || optSchool === '')) {
                select.selectedIndex = i;
                break;
            } else if (schoolId && optSchool === String(schoolId)) {
                select.selectedIndex = i;
                break;
            }
        }
    }

    document.getElementById('singleSignModal').classList.remove('hidden');
}
</script>
@endsection
