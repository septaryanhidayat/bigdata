@extends('admin.layout')

@section('title', 'Manajemen Surat Keluar & Draft')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">

    <!-- Header Box -->
    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-black text-[10px] uppercase border border-blue-200">
                    Buku Registrasi Surat Keluar
                </span>
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight mt-1.5">
                📤 Manajemen Surat Keluar, Multi-Template & Draft
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5 leading-relaxed">
                Pembuatan draf surat resmi, penomoran otomatis hierarkis, pemilihan template dinamis (Undangan, Tugas, Edaran, Keterangan), edit draf, & kirim ke antrian TTE.
            </p>
        </div>

        <button onclick="openCreateModal()" class="w-full sm:w-auto px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center justify-center gap-2">
            <span>➕</span> Buat Surat Keluar Baru
        </button>
    </div>

    <!-- Table of Outgoing Letters (Mobile-Friendly Responsive Cards on small screens, Table on larger) -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden space-y-4">
        <div class="p-5 sm:p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="font-black text-base text-slate-900">Daftar Surat Keluar & Status Pengesahan TTE</h3>
                <p class="text-xs text-slate-400 font-medium">Klik tombol edit untuk mengubah surat yang masih berstatus Draft / Menunggu TTE</p>
            </div>
            <span class="text-xs font-bold text-slate-400">Total: {{ $letters->total() }} Dokumen</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-900 text-white font-bold uppercase">
                    <tr>
                        <th class="p-4">Nomor Surat Resmi</th>
                        <th class="p-4">Perihal & Isi Ringkas</th>
                        <th class="p-4">Penerbit & Tujuan</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Status TTE</th>
                        <th class="p-4 text-center">Aksi Dokumen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-800">
                    @forelse($letters as $lt)
                    <tr class="hover:bg-slate-50">
                        <td class="p-4">
                            <span class="font-mono font-black text-blue-700 text-xs sm:text-sm block">{{ $lt->reference_number }}</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">{{ $lt->category_label }}</span>
                        </td>
                        <td class="p-4 max-w-xs">
                            <h4 class="font-black text-slate-900 leading-snug">{{ $lt->title }}</h4>
                            <span class="text-[10px] text-slate-500 line-clamp-1 mt-0.5">{{ Str::limit(strip_tags($lt->content), 60) }}</span>
                        </td>
                        <td class="p-4">
                            <span class="font-bold text-slate-900 block">{{ $lt->school->name ?? 'Yayasan Robbani' }}</span>
                            <span class="text-[11px] text-slate-600 block mt-0.5">➔ {{ $lt->recipient }}</span>
                        </td>
                        <td class="p-4 font-mono text-slate-600 whitespace-nowrap">
                            {{ $lt->letter_date->format('d M Y') }}
                        </td>
                        <td class="p-4">
                            @if($lt->status === 'SIGNED')
                                <div class="space-y-0.5">
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[9px] block w-fit whitespace-nowrap">
                                        ✓ TTE VALID
                                    </span>
                                    <span class="text-[9px] font-mono text-slate-400 block truncate max-w-[140px]">{{ $lt->digitalSignature->signer->full_name ?? 'Pejabat' }}</span>
                                </div>
                            @elseif($lt->status === 'WAITING_SIGNATURE')
                                <a href="{{ route('admin.letters.tte-queue') }}" class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 font-black text-[9px] hover:bg-purple-200 transition-colors inline-block whitespace-nowrap">
                                    ⏳ Menunggu TTE ➔
                                </a>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-black text-[9px] whitespace-nowrap">
                                    📝 DRAFT
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                @if($lt->status !== 'SIGNED')
                                    <button type="button" onclick="openEditModal({{ json_encode($lt) }})" class="px-2.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-[10px] shadow-xs flex items-center gap-1" title="Edit Isi Surat">
                                        <span>✏️</span> Edit
                                    </button>
                                @endif

                                <a href="{{ route('admin.letters.preview-pdf', $lt->id) }}" target="_blank" class="px-2.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-300 font-black text-[10px] shadow-xs flex items-center gap-1" title="Lihat & Cetak PDF">
                                    <span>🖨️</span> PDF
                                </a>

                                @if($lt->status !== 'SIGNED')
                                    <form action="{{ route('admin.letters.destroy', $lt->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus draft surat ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1.5 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 text-[10px] font-bold" title="Hapus">
                                            🗑️
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400 italic">Belum ada surat keluar terdaftar.</td>
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

<!-- Modal Buat Surat Keluar Baru (Multi-Template) -->
<div id="addOutgoingModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-5 sm:p-8 max-w-3xl w-full shadow-2xl space-y-6 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-black text-slate-900">Buat Surat Keluar Resmi Baru</h3>
                <p class="text-xs text-slate-500 font-medium">Pilih template otomatis atau susun surat dinas kustom</p>
            </div>
            <button onclick="document.getElementById('addOutgoingModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold text-base p-1">✕</button>
        </div>

        <form action="{{ route('admin.letters.outgoing.store') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            
            <!-- Template Selector Preset -->
            <div class="p-4 rounded-2xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 space-y-2">
                <label class="block text-blue-950 font-black uppercase text-[11px]">📋 Pilih Format Template Surat Dinas:</label>
                <select id="selectLetterCategory" onchange="applyTemplatePreset(this.value, 'create')" class="w-full p-3 rounded-xl bg-white border border-blue-300 text-xs font-black text-slate-900 focus:ring-2 focus:ring-blue-500">
                    <option value="SURAT_EDARAN_LIBUR">📢 1. Surat Edaran Libur / Pemberitahuan KBM (Format Biasa)</option>
                    <option value="SURAT_UNDANGAN_RAPAT">✉️ 2. Surat Undangan Rapat / Kajian (Hari, Tanggal, Waktu, Tempat, Pembicara)</option>
                    <option value="SURAT_TUGAS_PELATIHAN">📜 3. Surat Tugas Dinas / Pelatihan / Lomba Guru (Nama, NIP, Kegiatan, Lokasi)</option>
                    <option value="SURAT_KETERANGAN_SISWA">🎓 4. Surat Keterangan Siswa Aktif Belajar (Nama Siswa, NISN, Kelas)</option>
                    <option value="SURAT_KETERANGAN_BAIK">⭐ 5. Surat Keterangan Berkelakuan Baik Siswa</option>
                    <option value="SURAT_PANGGILAN_ORTU">👥 6. Surat Panggilan Orang Tua / Konseling BK (Hari, Pukul, Ruangan, Guru BK)</option>
                    <option value="NOTA_DINAS_INTERNAL">📝 7. Nota Dinas Internal Antar-Unit (Kepada, Dari, Perihal)</option>
                    <option value="SURAT_KEPUTUSAN">🏛️ 8. Surat Keputusan (SK) Kepala Sekolah / Yayasan</option>
                    <option value="SURAT_PERMOHONAN_IZIN">🤝 9. Surat Permohonan Izin Tempat / Kerjasama Eksternal</option>
                </select>
            </div>

            <input type="hidden" name="letter_category" id="createLetterCategory" value="SURAT_EDARAN">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 mb-1">Unit Penerbit Surat:</label>
                    <select name="school_id" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <option value="">🏢 Yayasan Generasi Robbani (Pusat)</option>
                        @foreach($schools as $sc)
                        <option value="{{ $sc->id }}">🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">Tujuan / Penerima Surat:</label>
                    <input type="text" name="recipient" id="createRecipient" required placeholder="Contoh: Seluruh Orang Tua / Wali Siswa" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-slate-700 mb-1">Perihal / Judul Surat:</label>
                    <input type="text" name="title" id="createTitle" required placeholder="Judul perihal surat..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">Tanggal Surat:</label>
                    <input type="date" name="letter_date" required value="{{ date('Y-m-d') }}" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 mb-1">Sifat / Tingkat Keamanan:</label>
                    <select name="security_level" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <option value="BIASA">BIASA (Edaran Umum)</option>
                        <option value="SEGERA">SEGERA (Perlu Respon)</option>
                        <option value="KILAT">KILAT (Penting/Urgent)</option>
                        <option value="RAHASIA">RAHASIA (Internal Pimpinan)</option>
                    </select>
                </div>
                <div class="flex items-center text-[11px] text-slate-500 font-normal pt-4">
                    💡 Isi surat di bawah dapat Anda edit dan sesuaikan dengan data sebenarnya.
                </div>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Isi / Narasi Lengkap Surat:</label>
                <textarea name="content" id="createContent" rows="10" required class="w-full p-4 rounded-2xl bg-slate-50 border border-slate-200 font-mono text-xs leading-relaxed text-slate-900"></textarea>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addOutgoingModal').classList.add('hidden')" class="w-full sm:w-auto px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" name="action_type" value="SAVE_DRAFT" class="flex-1 sm:flex-none px-5 py-2.5 rounded-2xl bg-slate-200 text-slate-800 font-bold hover:bg-slate-300 transition-colors">Simpan Draft</button>
                    <button type="submit" name="action_type" value="SUBMIT_TTE" class="flex-1 sm:flex-none px-6 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Terbitkan & Ajukan TTE ➔</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Draft Surat Keluar -->
<div id="editOutgoingModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-5 sm:p-8 max-w-3xl w-full shadow-2xl space-y-6 max-h-[92vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-black text-slate-900">Edit Draf Surat Keluar</h3>
                <p id="editRefNumber" class="text-xs text-blue-700 font-bold font-mono mt-0.5">Nomor Surat</p>
            </div>
            <button onclick="document.getElementById('editOutgoingModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold text-base p-1">✕</button>
        </div>

        <form id="editOutgoingForm" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 mb-1">Unit Penerbit:</label>
                    <select name="school_id" id="editSchoolId" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                        <option value="">🏢 Yayasan Generasi Robbani (Pusat)</option>
                        @foreach($schools as $sc)
                        <option value="{{ $sc->id }}">🏫 {{ $sc->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">Tujuan / Penerima:</label>
                    <input type="text" name="recipient" id="editRecipient" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-slate-700 mb-1">Perihal / Judul Surat:</label>
                    <input type="text" name="title" id="editTitle" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>

                <div>
                    <label class="block text-slate-700 mb-1">Tanggal Surat:</label>
                    <input type="date" name="letter_date" id="editLetterDate" required class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Sifat / Tingkat Keamanan:</label>
                <select name="security_level" id="editSecurityLevel" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <option value="BIASA">BIASA</option>
                    <option value="SEGERA">SEGERA</option>
                    <option value="KILAT">KILAT</option>
                    <option value="RAHASIA">RAHASIA</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Isi / Narasi Surat:</label>
                <textarea name="content" id="editContent" rows="10" required class="w-full p-4 rounded-2xl bg-slate-50 border border-slate-200 font-mono text-xs leading-relaxed text-slate-900"></textarea>
            </div>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('editOutgoingModal').classList.add('hidden')" class="w-full sm:w-auto px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <button type="submit" name="action_type" value="SAVE_DRAFT" class="flex-1 sm:flex-none px-5 py-2.5 rounded-2xl bg-slate-200 text-slate-800 font-bold hover:bg-slate-300">Simpan Perubahan</button>
                    <button type="submit" name="action_type" value="SUBMIT_TTE" class="flex-1 sm:flex-none px-6 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Simpan & Ajukan TTE ➔</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
const templatePresets = {
    SURAT_EDARAN_LIBUR: {
        category: 'SURAT_EDARAN',
        recipient: 'Seluruh Orang Tua / Wali Siswa SIT Robbani',
        title: 'Pemberitahuan Libur Awal Ramadhan 1447 H',
        content: `Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\nSehubungan dengan datangnya bulan suci Ramadhan 1447 H, kami memberitahukan kepada seluruh orang tua/wali siswa bahwa kegiatan belajar mengajar (KBM) akan diliburkan mulai tanggal 1 s/d 5 Ramadhan.\n\nDemikian surat edaran ini kami sampaikan, atas perhatian dan kerjasama Bapak/Ibu kami ucapkan terima kasih.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.`
    },
    SURAT_UNDANGAN_RAPAT: {
        category: 'UNDANGAN',
        recipient: 'Bapak/Ibu Orang Tua / Wali Santri Kelas 7 & 8',
        title: 'Undangan Rapat Pleno Parenting & Sosialisasi Program JSIT',
        content: `Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\nDengan hormat, kami mengundang Bapak/Ibu untuk menghadiri agenda Rapat Pleno dan Sosialisasi Program Sekolah yang insya Allah akan dilaksanakan pada:\n\nHari / Tanggal : Sabtu, 22 Agustus 2026\nWaktu / Pukul  : 08.30 WIB s.d Selesai\nTempat         : Aula Utama Yayasan Generasi Robbani\nAgenda         : Sosialisasi Kurikulum JSIT & Evaluasi Tahfidz\nPembicara      : Ustadz Dr. H. Ahmad Fauzi, M.Pd.I\n\nMengingat pentingnya agenda tersebut, kami sangat mengharapkan kehadiran Bapak/Ibu tepat pada waktunya.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.`
    },
    SURAT_TUGAS_PELATIHAN: {
        category: 'SURAT_TUGAS',
        recipient: 'Ustadz Rizky, S.Pd.I',
        title: 'Surat Tugas Mengikuti Pelatihan Penguatan Kurikulum Merdeka & ANBK',
        content: `Yang bertanda tangan di bawah ini Kepala Sekolah Islam Terpadu Robbani menugaskan kepada:\n\nNama           : Ustadz Rizky, S.Pd.I\nNIP            : 198505122026011001\nJabatan        : Guru Pembina Akademik & Kurikulum\n\nUntuk menghadiri dan mengikuti kegiatan Pelatihan Penguatan Asesmen Nasional Berbasis Komputer (ANBK) yang diselenggarakan pada:\n\nHari / Tanggal : Rabu s.d Kamis, 19 - 20 Agustus 2026\nWaktu          : 08.00 WIB s.d Selesai\nTempat         : Gedung Pertemuan Dinas Pendidikan Kab. Ogan Ilir\n\nDemikian surat tugas ini dibuat agar dapat dilaksanakan dengan penuh amanah dan tanggung jawab.`
    },
    SURAT_KETERANGAN_SISWA: {
        category: 'SURAT_KETERANGAN',
        recipient: 'Orang Tua / Wali Siswa Yang Bersangkutan',
        title: 'Surat Keterangan Aktif Belajar Siswa',
        content: `Yang bertanda tangan di bawah ini Kepala Sekolah Islam Terpadu Robbani menerangkan bahwa:\n\nNama Siswa     : Fatih Abdullah Prasetyo\nNIS / NISN     : 20267001 / 0061234567\nTempat/Tgl Lahir: Palembang, 12 Mei 2013\nKelas / Rombel : 7-Umar bin Khattab\n\nAdalah benar siswa yang terdaftar aktif mengikuti kegiatan belajar mengajar pada Sekolah Islam Terpadu Robbani Tahun Ajaran 2026/2027.\n\nSurat keterangan ini diterbitkan untuk keperluan kelengkapan administrasi beasiswa / pendaftaran dinas.\n\nDemikian surat keterangan ini kami buat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.`
    },
    SURAT_KETERANGAN_BAIK: {
        category: 'SURAT_KETERANGAN',
        recipient: 'Pihak Yang Berkepentingan',
        title: 'Surat Keterangan Berkelakuan Baik Siswa',
        content: `Yang bertanda tangan di bawah ini Kepala Sekolah Islam Terpadu Robbani menerangkan dengan sebenarnya bahwa:\n\nNama Siswa     : Aisyah Humaira\nNIS / NISN     : 20267002 / 0061234568\nKelas          : 7-Umar bin Khattab\n\nBerdasarkan data catatan Bimbingan Konseling (BK) dan Ketertiban Sekolah, siswa tersebut berkelakuan baik, rajin beribadah, dan tidak pernah terlibat pelanggaran tata tertib sekolah.\n\nDemikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.`
    },
    SURAT_PANGGILAN_ORTU: {
        category: 'SURAT_PANGGILAN',
        recipient: 'Orang Tua / Wali dari Siswa: Muhammad Rayhan',
        title: 'Surat Undangan Konseling Orang Tua Siswa',
        content: `Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\nSemoga Bapak/Ibu senantiasa dalam limpahan rahmat Allah SWT. Sehubungan dengan perkembangan belajar dan pembinaan ananda Muhammad Rayhan (Kelas 7-Umar), kami mengharapkan kehadiran Bapak/Ibu di sekolah pada:\n\nHari / Tanggal : Selasa, 25 Agustus 2026\nPukul          : 09.00 WIB\nTempat         : Ruang Bimbingan Konseling (BK) Lt. 1\nMenemui        : Ustadzah Fitriana, S.Si (Guru BK & Wali Kelas)\n\nAtas kehadiran dan kerjasama Bapak/Ibu demi kemajuan ananda, kami ucapkan terima kasih.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.`
    },
    NOTA_DINAS_INTERNAL: {
        category: 'NOTA_DINAS',
        recipient: 'Seluruh Kepala Unit & Koordinator Bidang Yayasan',
        title: 'Nota Dinas: Persiapan Rencana Kerja & Anggaran Sekolah (RKAS) 2027',
        content: `KEPADA YTH : Seluruh Kepala Unit Sekolah & Koordinator Bidang\nDARI       : Ketua Yayasan Generasi Robbani\nPERIHAL    : Penyusunan Draf RKAS Tahun 2027\n\nSehubungan dengan evaluasi program kerja tahun berjalan, dimohon setiap unit sekolah (TKIT, SDIT, SMPIT, SMAIT) untuk segera menyusun draf RKAS dan laporan serapan anggaran paling lambat tanggal 30 Agustus 2026.\n\nDemikian nota dinas ini disampaikan untuk dikoordinasikan dengan sebaik-baiknya.`
    },
    SURAT_KEPUTUSAN: {
        category: 'SURAT_KEPUTUSAN',
        recipient: 'Dewan Guru & Staf Yang Bersangkutan',
        title: 'Surat Keputusan Kepala Sekolah tentang Pembagian Tugas Mengajar Tahun Ajaran 2026/2027',
        content: `KEPUTUSAN KEPALA SEKOLAH ISLAM TERPADU ROBBANI\nNomor: 010/SK/SIT-ROBBANI/VII/2026\n\nTENTANG:\nPEMBAGIAN TUGAS GURU DALAM PROSES BELAJAR MENGAJAR TAHUN AJARAN 2026/2027\n\nMENIMBANG:\nBahwa demi kelancaran pelaksanaan kegiatan belajar mengajar di lingkungan SIT Robbani, dipandang perlu menetapkan pembagian tugas guru.\n\nMENGINGAT:\n1. Undang-Undang Nomor 20 Tahun 2003 tentang Sistem Pendidikan Nasional.\n2. Kurikulum Merdeka dan Standar Mutu Kekhasan JSIT Indonesia.\n\nMEMUTUSKAN:\nMenetapkan daftar pembagian tugas mengajar guru sebagaimana terlampir dalam keputusan ini.\n\nDitetapkan di : Indralaya\nPada tanggal  : 15 Juli 2026`
    },
    SURAT_PERMOHONAN_IZIN: {
        category: 'LAINNYA',
        recipient: 'Pimpinan Pengelola Gedung Serbaguna Indralaya',
        title: 'Permohonan Izin Pemakaian Gedung Acara Wisuda & Haflah Akhirussanah',
        content: `Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\nDengan hormat, dalam rangka menyelenggarakan kegiatan Haflah Akhirussanah & Wisuda Tahfidz Al-Qur'an Santri SIT Robbani, kami bermaksud mengajukan permohonan pemakaian Gedung Serbaguna pada:\n\nHari / Tanggal : Ahad, 13 September 2026\nWaktu          : 07.30 s.d 13.00 WIB\nJumlah Peserta : 400 Orang (Santri & Wali Santri)\n\nDemikian permohonan ini kami sampaikan, besar harapan kami permohonan ini dapat disetujui. Atas perhatian Bapak/Ibu kami haturkan jazakumullah khairan katsiran.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.`
    }
};

function openCreateModal() {
    applyTemplatePreset('SURAT_EDARAN_LIBUR', 'create');
    document.getElementById('addOutgoingModal').classList.remove('hidden');
}

function applyTemplatePreset(key, mode) {
    const tpl = templatePresets[key];
    if (!tpl) return;

    if (mode === 'create') {
        document.getElementById('createLetterCategory').value = tpl.category;
        document.getElementById('createRecipient').value = tpl.recipient;
        document.getElementById('createTitle').value = tpl.title;
        document.getElementById('createContent').value = tpl.content;
    }
}

function openEditModal(letter) {
    document.getElementById('editOutgoingForm').action = '/admin/letters/outgoing/' + letter.id + '/update';
    document.getElementById('editRefNumber').innerText = 'No: ' + letter.reference_number;
    document.getElementById('editSchoolId').value = letter.school_id || '';
    document.getElementById('editRecipient').value = letter.recipient || '';
    document.getElementById('editTitle').value = letter.title || '';
    document.getElementById('editLetterDate').value = letter.letter_date ? letter.letter_date.split('T')[0] : '';
    document.getElementById('editSecurityLevel').value = letter.security_level || 'BIASA';
    document.getElementById('editContent').value = letter.content || '';
    document.getElementById('editOutgoingModal').classList.remove('hidden');
}
</script>
@endsection
