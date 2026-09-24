@extends('admin.layout')

@section('title', 'Manajemen PPDB Online')

@section('content')
<div class="space-y-6" x-data="ppdbAdminManager()">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-cyan-100 text-cyan-800 font-black text-[10px] uppercase border border-cyan-300">
                    Modul 13: SPMB / PPDB Manager & SmartEdu
                </span>
                <span class="w-2 h-2 rounded-full bg-cyan-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                📋 Pengelolaan Pendaftaran PPDB / SPMB Online
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">
                Kelola pendaftar online & offline (walk-in), verifikasi berkas (Akta, KK, KTP), bukti bayar, kelulusan, serta sinkronisasi otomatis ke Master Data Siswa & SPP SmartEdu.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="button" @click="openCreateModal()" class="px-4 py-2.5 rounded-2xl bg-emerald-700 text-white font-black text-xs shadow-md hover:bg-emerald-800 flex items-center gap-1.5 transition-all">
                <span>➕</span> Pendaftar Baru (Offline)
            </button>
            <a href="{{ route('admin.ppdb-admin.export', request()->query()) }}" class="px-4 py-2.5 rounded-2xl bg-blue-600 text-white font-black text-xs shadow-md hover:bg-blue-700 flex items-center gap-1.5 transition-all">
                <span>📥</span> Export CSV / Excel
            </a>
            <a href="{{ route('admin.settings.spmb') }}" class="px-4 py-2.5 rounded-2xl bg-amber-400 text-slate-950 font-black text-xs shadow-md hover:bg-amber-300 flex items-center gap-1.5 transition-all">
                <span>⚙️</span> CMS SPMB
            </a>
            <a href="{{ route('school.spmb') }}" target="_blank" class="px-4 py-2.5 rounded-2xl bg-slate-900 text-amber-300 font-black text-xs shadow-md hover:bg-slate-800 flex items-center gap-1.5 transition-all">
                <span>🌐</span> Landing Page ↗
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-900 font-bold text-xs flex items-center gap-2">
        <span class="text-base">✓</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-300 text-rose-900 font-bold text-xs flex items-center gap-2">
        <span class="text-base">⛔</span>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- 4 Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-1">
            <span class="text-[10px] font-black uppercase text-slate-400">Total Pendaftar</span>
            <div class="text-2xl font-black text-slate-900">{{ number_format($totalCount) }}</div>
            <span class="text-[10px] text-slate-500 font-semibold block">Semua Jalur & Unit</span>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-amber-200 shadow-sm space-y-1">
            <span class="text-[10px] font-black uppercase text-amber-600">Verifikasi Berkas</span>
            <div class="text-2xl font-black text-amber-600">{{ number_format($pendingCount) }}</div>
            <span class="text-[10px] text-amber-700/80 font-semibold block">Menunggu Konfirmasi</span>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-emerald-200 shadow-sm space-y-1">
            <span class="text-[10px] font-black uppercase text-emerald-700">Diterima / Lulus</span>
            <div class="text-2xl font-black text-emerald-700">{{ number_format($passedCount) }}</div>
            <span class="text-[10px] text-emerald-600 font-semibold block">Otomatis Masuk SmartEdu</span>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-rose-200 shadow-sm space-y-1">
            <span class="text-[10px] font-black uppercase text-rose-600">Ditolak / Batal</span>
            <div class="text-2xl font-black text-rose-600">{{ number_format($rejectedCount) }}</div>
            <span class="text-[10px] text-rose-500 font-semibold block">Tidak Memenuhi Syarat</span>
        </div>

        <div class="bg-gradient-to-br from-emerald-900 to-emerald-950 p-5 rounded-3xl text-white shadow-sm space-y-1 col-span-2 lg:col-span-1">
            <span class="text-[10px] font-black uppercase text-emerald-300">Biaya Terkumpul</span>
            <div class="text-xl font-black text-amber-300 font-mono">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            <span class="text-[10px] text-emerald-200 font-medium block">Formulir Pendaftaran</span>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm">
        <form action="{{ route('admin.ppdb-admin.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">
            <div>
                <label class="block font-bold text-slate-700 mb-1">Cari Data:</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama / No. Reg / WA / Ortu..." class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 font-medium focus:outline-none focus:ring-2 focus:ring-emerald-600">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Unit Sekolah:</label>
                @if($isGlobalAdmin)
                <select name="school_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    <option value="all">Semua Unit Sekolah</option>
                    @foreach($schools as $sch)
                    <option value="{{ $sch->id }}" {{ request('school_id') == $sch->id ? 'selected' : '' }}>
                        {{ $sch->name }} ({{ $sch->code }})
                    </option>
                    @endforeach
                </select>
                @else
                <input type="text" readonly value="{{ auth()->user()->school?->name ?? 'Unit Anda' }}" class="w-full px-3 py-2 rounded-xl bg-slate-100 border border-slate-300 text-slate-500 font-bold cursor-not-allowed">
                @endif
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Status Kelulusan:</label>
                <select name="status" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    <option value="all">Semua Status</option>
                    <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>⏳ Verifikasi Berkas (Pending)</option>
                    <option value="DOCUMENT_VERIFIED" {{ request('status') === 'DOCUMENT_VERIFIED' ? 'selected' : '' }}>📄 Berkas Lengkap</option>
                    <option value="PASSED" {{ request('status') === 'PASSED' ? 'selected' : '' }}>✓ DITERIMA / LULUS</option>
                    <option value="REJECTED" {{ request('status') === 'REJECTED' ? 'selected' : '' }}>❌ DITOLAK</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Status Pembayaran:</label>
                <select name="fee_paid" class="w-full px-3 py-2 rounded-xl bg-slate-50 border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    <option value="all">Semua Pembayaran</option>
                    <option value="1" {{ request('fee_paid') === '1' ? 'selected' : '' }}>✓ LUNAS</option>
                    <option value="0" {{ request('fee_paid') === '0' ? 'selected' : '' }}>⏳ BELUM LUNAS</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black text-xs shadow-md transition-colors w-full">
                    🔍 Filter
                </button>
                <a href="{{ route('admin.ppdb-admin.index') }}" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition-colors" title="Reset Filter">
                    🔄
                </a>
            </div>
        </form>
    </div>

    <!-- Table of Registrations -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
            <div>
                <h3 class="font-black text-base text-slate-900">Daftar Calon Peserta Didik Baru (PPDB 2026/2027)</h3>
                <p class="text-xs text-slate-500 font-medium">Klik tombol 👁️ Detail untuk mengecek dokumen Akta, KK, KTP, dan bukti pembayaran.</p>
            </div>
            <span class="text-xs font-black px-3 py-1 rounded-full bg-slate-100 text-slate-700">
                Menampilkan {{ count($registrations) }} Calon Siswa
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 text-slate-700 font-black border-b border-slate-200 uppercase">
                    <tr>
                        <th class="p-4">No. Registrasi</th>
                        <th class="p-4">Calon Siswa</th>
                        <th class="p-4">Unit Target</th>
                        <th class="p-4">Orang Tua & WhatsApp</th>
                        <th class="p-4">Sekolah Asal</th>
                        <th class="p-4">Biaya Formulir</th>
                        <th class="p-4">Status & Integrasi</th>
                        <th class="p-4 text-center">Aksi (CRUD)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 font-medium text-slate-800">
                    @forelse($registrations as $reg)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="p-4 font-mono font-bold text-slate-900">
                            <span class="block">{{ $reg->registration_number }}</span>
                            <span class="text-[10px] text-slate-400 font-sans block mt-0.5">{{ $reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '-' }}</span>
                        </td>
                        <td class="p-4">
                            <strong class="font-black text-slate-900 text-sm block">{{ $reg->full_name }}</strong>
                            <span class="text-[10px] text-slate-500 block">
                                NISN: {{ $reg->details_json['nisn'] ?? '-' }} | NIK: {{ $reg->details_json['nik_siswa'] ?? '-' }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase block w-fit">
                                {{ $reg->school?->code ?? $reg->target_level }}
                            </span>
                            <span class="text-[10px] text-slate-500 block mt-1">
                                {{ $reg->school?->name ?? $reg->target_level }}
                            </span>
                        </td>
                        <td class="p-4 space-y-0.5">
                            <span class="font-bold text-slate-900 block">{{ $reg->parent_name }}</span>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reg->phone_number) }}" target="_blank" class="text-[11px] font-bold text-emerald-700 hover:text-emerald-800 inline-flex items-center gap-1">
                                <span>💬</span> {{ $reg->phone_number }}
                            </a>
                        </td>
                        <td class="p-4 font-semibold text-slate-600">
                            {{ $reg->previous_school ?: '-' }}
                        </td>
                        <td class="p-4">
                            <div class="font-mono font-black text-slate-900">
                                Rp {{ number_format($reg->registration_fee, 0, ',', '.') }}
                            </div>
                            @if($reg->fee_paid)
                                <span class="text-[9px] bg-emerald-100 text-emerald-800 font-black px-2 py-0.5 rounded-full inline-block mt-0.5 border border-emerald-300">
                                    ✓ LUNAS
                                </span>
                            @else
                                <span class="text-[9px] bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded-full inline-block mt-0.5 border border-amber-300">
                                    ⏳ BELUM LUNAS
                                </span>
                            @endif
                        </td>
                        <td class="p-4 space-y-1">
                            @if($reg->status == 'PASSED')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-600 text-white font-black text-[10px] inline-block shadow-xs">
                                    ✓ DITERIMA / LULUS
                                </span>
                                <div class="text-[10px] text-emerald-700 font-bold flex items-center gap-1">
                                    <span>🎓</span>
                                    <a href="{{ route('admin.master.students') }}" class="underline hover:text-emerald-900">
                                        Data Siswa SmartEdu
                                    </a>
                                </div>
                            @elseif($reg->status == 'PENDING')
                                <span class="px-2.5 py-1 rounded-full bg-amber-500 text-white font-black text-[10px] inline-block shadow-xs">
                                    ⏳ VERIFIKASI BERKAS
                                </span>
                            @elseif($reg->status == 'DOCUMENT_VERIFIED')
                                <span class="px-2.5 py-1 rounded-full bg-blue-600 text-white font-black text-[10px] inline-block shadow-xs">
                                    📄 BERKAS VALID
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-rose-600 text-white font-black text-[10px] inline-block shadow-xs">
                                    ❌ DITOLAK
                                </span>
                            @endif
                        </td>
                        <td class="p-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <button type="button" @click="viewDetail({{ $reg->id }})" title="Lihat Berkas & Detail Lengkap" class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition-colors">
                                    👁️
                                </button>
                                <button type="button" @click="openEditModal({{ $reg->id }})" title="Edit Data Calon Siswa" class="p-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs transition-colors">
                                    ✏️
                                </button>
                                <a href="{{ route('admin.ppdb-admin.download-pdf', $reg->id) }}" target="_blank" title="Cetak Formulir Bukti PDF" class="p-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-900 font-bold text-xs transition-colors">
                                    🖨️
                                </a>
                                <form action="{{ route('admin.ppdb-admin.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pendaftaran calon siswa {{ addslashes($reg->full_name) }}? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Data Calon Siswa" class="p-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition-colors">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-12 text-center text-slate-400 italic">
                            <span class="text-3xl block mb-2">📋</span>
                            Belum ada calon peserta didik baru terdaftar sesuai kriteria filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL 1: TAMBAH PENDAFTAR OFFLINE / WALK-IN -->
    <div x-show="showCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200 transform transition-all" @click.away="showCreateModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-black text-lg text-slate-900">➕ Pendaftaran Calon Siswa Baru (Offline / Walk-in)</h3>
                    <p class="text-xs text-slate-500 font-medium">Input langsung data calon siswa yang mendaftar ke kantor TU / Panitia sekolah.</p>
                </div>
                <button type="button" @click="showCreateModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>
            </div>

            <form action="{{ route('admin.ppdb-admin.store') }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Unit Sekolah Target <span class="text-rose-500">*</span>:</label>
                        <select name="school_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            @foreach($schools as $sch)
                            <option value="{{ $sch->id }}" {{ $schoolId == $sch->id ? 'selected' : '' }}>
                                {{ $sch->name }} ({{ $sch->code }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Siswa <span class="text-rose-500">*</span>:</label>
                        <input type="text" name="full_name" required placeholder="Nama lengkap sesuai akta" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jenis Kelamin:</label>
                        <select name="gender" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-medium focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="M">Laki-laki</option>
                            <option value="F">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">NISN (Jika Ada):</label>
                        <input type="text" name="nisn" placeholder="Nomor Induk Siswa Nasional" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Orang Tua / Ayah <span class="text-rose-500">*</span>:</label>
                        <input type="text" name="parent_name" required placeholder="Nama ayah / wali murid" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor WhatsApp Ortu <span class="text-rose-500">*</span>:</label>
                        <input type="text" name="phone_number" required placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Sekolah Asal:</label>
                        <input type="text" name="previous_school" placeholder="Nama sekolah asal / TK asal" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Biaya Formulir Pendaftaran (Rp) <span class="text-rose-500">*</span>:</label>
                        <input type="number" name="registration_fee" value="450000" step="10000" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Status Kelulusan Awal:</label>
                        <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="PENDING">⏳ Verifikasi Berkas (Pending)</option>
                            <option value="DOCUMENT_VERIFIED">📄 Berkas Lengkap</option>
                            <option value="PASSED">✓ DITERIMA / LULUS (Auto-Provision SmartEdu)</option>
                        </select>
                    </div>

                    <div class="flex items-center pt-6">
                        <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-slate-800">
                            <input type="checkbox" name="fee_paid" value="1" checked class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500">
                            <span>Biaya Formulir Sudah Lunas</span>
                        </label>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">Alamat Tempat Tinggal:</label>
                        <textarea name="address" rows="2" placeholder="Alamat lengkap calon siswa" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600"></textarea>
                    </div>
                </div>

                <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-950 text-[11px] leading-relaxed">
                    <strong>💡 Integrasi Pintar SmartEdu:</strong> Jika status disetel <strong>DITERIMA / LULUS (PASSED)</strong>, calon siswa otomatis terdaftar ke Master Data Siswa SmartEdu, dialokasikan kelas, dihubungkan dengan data wali, serta dibuatkan tagihan SPP awal.
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" @click="showCreateModal = false" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black shadow-md">
                        Simpan Calon Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: DETAIL DATA LENGKAP & BERKAS CALON SISWA (READ) -->
    <div x-show="showDetailModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200 transform transition-all" @click.away="showDetailModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-emerald-100 text-emerald-800" x-text="detailData.registration_number"></span>
                    <h3 class="font-black text-xl text-slate-900 mt-1" x-text="detailData.full_name"></h3>
                    <p class="text-xs text-slate-500 font-medium" x-text="'Target: ' + (detailData.school_name || detailData.target_level) + ' | Terdaftar: ' + detailData.created_at"></p>
                </div>
                <button type="button" @click="showDetailModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>
            </div>

            <div class="space-y-6 max-h-[70vh] overflow-y-auto pr-1 text-xs">
                <!-- Status & SmartEdu Integration Alert -->
                <div class="p-4 rounded-2xl border flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3" :class="detailData.status === 'PASSED' ? 'bg-emerald-50 border-emerald-300 text-emerald-950' : 'bg-slate-50 border-slate-200 text-slate-800'">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-black text-xs uppercase" x-text="'Status: ' + detailData.status"></span>
                            <span x-show="detailData.fee_paid" class="px-2 py-0.5 rounded-full bg-emerald-200 text-emerald-900 font-bold text-[9px]">LUNAS</span>
                        </div>
                        <p class="text-[11px] mt-0.5" x-show="detailData.is_integrated">
                            ✓ <strong>Tersinkronisasi ke SmartEdu:</strong> Calon siswa telah memiliki data induk siswa (NIS: <span x-text="detailData.student_nis"></span>).
                        </p>
                    </div>
                    <a :href="detailData.pdf_url" target="_blank" class="px-4 py-2 rounded-xl bg-slate-900 text-amber-300 font-black text-xs shadow-md hover:bg-slate-800 flex items-center gap-1.5 shrink-0">
                        <span>🖨️</span> Cetak PDF F-SPMB
                    </a>
                </div>

                <!-- 1. IDENTITAS PESERTA DIDIK -->
                <div class="space-y-3">
                    <h4 class="font-black text-xs text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-1.5">
                        👤 Identitas Calon Siswa
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <div>
                            <span class="text-slate-400 block text-[10px]">Nama Lengkap:</span>
                            <strong class="text-slate-900 font-bold" x-text="detailData.full_name"></strong>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">Nama Panggilan:</span>
                            <span class="text-slate-800 font-semibold" x-text="detailData.details?.nama_panggilan || '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">NISN / NIK:</span>
                            <span class="text-slate-800 font-mono" x-text="(detailData.details?.nisn || '-') + ' / ' + (detailData.details?.nik_siswa || '-')"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">Jenis Kelamin:</span>
                            <span class="text-slate-800 font-semibold" x-text="detailData.details?.jenis_kelamin || '-'"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">Tempat, Tgl Lahir:</span>
                            <span class="text-slate-800 font-semibold" x-text="(detailData.details?.tempat_lahir || '-') + ', ' + (detailData.details?.tanggal_lahir || '-')"></span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px]">Sekolah Asal:</span>
                            <span class="text-slate-800 font-semibold" x-text="detailData.previous_school || '-'"></span>
                        </div>
                        <div class="col-span-2 sm:col-span-3">
                            <span class="text-slate-400 block text-[10px]">Alamat Lengkap:</span>
                            <span class="text-slate-800" x-text="detailData.details?.alamat || '-'"></span>
                        </div>
                    </div>
                </div>

                <!-- 2. DATA ORANG TUA / WALI -->
                <div class="space-y-3">
                    <h4 class="font-black text-xs text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-1.5">
                        👨‍👩‍👧 Data Orang Tua / Wali
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-1.5">
                            <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 font-black text-[9px] uppercase">Data Ayah Kandung</span>
                            <div class="text-slate-900 font-bold" x-text="detailData.details?.nama_ayah || detailData.parent_name"></div>
                            <div class="text-slate-600">Pekerjaan: <span x-text="detailData.details?.pekerjaan_ayah || '-'"></span></div>
                            <div class="text-slate-600">Instansi: <span x-text="detailData.details?.instansi_ayah || '-'"></span></div>
                            <div class="text-emerald-700 font-bold">No. HP: <span x-text="detailData.details?.no_hp_ayah || detailData.phone_number"></span></div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-1.5">
                            <span class="px-2 py-0.5 rounded-full bg-pink-100 text-pink-800 font-black text-[9px] uppercase">Data Ibu Kandung</span>
                            <div class="text-slate-900 font-bold" x-text="detailData.details?.nama_ibu || '-'"></div>
                            <div class="text-slate-600">Pekerjaan: <span x-text="detailData.details?.pekerjaan_ibu || '-'"></span></div>
                            <div class="text-slate-600">Instansi: <span x-text="detailData.details?.instansi_ibu || '-'"></span></div>
                            <div class="text-emerald-700 font-bold">No. HP: <span x-text="detailData.details?.no_hp_ibu || '-'"></span></div>
                        </div>
                    </div>
                </div>

                <!-- 3. BERKAS DOKUMEN YANG DIUPLOAD -->
                <div class="space-y-3">
                    <h4 class="font-black text-xs text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-1.5">
                        📁 Berkas Dokumen Calon Siswa (Foto, KK, KTP, Akta, Bukti Bayar)
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <!-- Akta Kelahiran -->
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-900">1. Akta Kelahiran</span>
                                <span x-show="detailData.uploaded_docs?.akta_kelahiran" class="text-emerald-600 font-bold text-[10px]">✓ Ada</span>
                                <span x-show="!detailData.uploaded_docs?.akta_kelahiran" class="text-slate-400 text-[10px]">Belum Ada</span>
                            </div>
                            <template x-if="detailData.uploaded_docs?.akta_kelahiran">
                                <a :href="detailData.uploaded_docs.akta_kelahiran" target="_blank" class="block w-full py-2 text-center rounded-xl bg-emerald-700 text-white font-bold hover:bg-emerald-800 shadow-xs">
                                    🔍 Buka Akta Kelahiran ↗
                                </a>
                            </template>
                        </div>

                        <!-- Kartu Keluarga -->
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-900">2. Kartu Keluarga (KK)</span>
                                <span x-show="detailData.uploaded_docs?.kartu_keluarga" class="text-emerald-600 font-bold text-[10px]">✓ Ada</span>
                                <span x-show="!detailData.uploaded_docs?.kartu_keluarga" class="text-slate-400 text-[10px]">Belum Ada</span>
                            </div>
                            <template x-if="detailData.uploaded_docs?.kartu_keluarga">
                                <a :href="detailData.uploaded_docs.kartu_keluarga" target="_blank" class="block w-full py-2 text-center rounded-xl bg-emerald-700 text-white font-bold hover:bg-emerald-800 shadow-xs">
                                    🔍 Buka Kartu Keluarga ↗
                                </a>
                            </template>
                        </div>

                        <!-- KTP Orang Tua -->
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-900">3. KTP Orang Tua</span>
                                <span x-show="detailData.uploaded_docs?.ktp_ortu" class="text-emerald-600 font-bold text-[10px]">✓ Ada</span>
                                <span x-show="!detailData.uploaded_docs?.ktp_ortu" class="text-slate-400 text-[10px]">Belum Ada</span>
                            </div>
                            <template x-if="detailData.uploaded_docs?.ktp_ortu">
                                <a :href="detailData.uploaded_docs.ktp_ortu" target="_blank" class="block w-full py-2 text-center rounded-xl bg-emerald-700 text-white font-bold hover:bg-emerald-800 shadow-xs">
                                    🔍 Buka KTP Ortu ↗
                                </a>
                            </template>
                        </div>

                        <!-- Pas Foto -->
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-900">4. Pas Foto Anak</span>
                                <span x-show="detailData.uploaded_docs?.pas_foto" class="text-emerald-600 font-bold text-[10px]">✓ Ada</span>
                                <span x-show="!detailData.uploaded_docs?.pas_foto" class="text-slate-400 text-[10px]">Belum Ada</span>
                            </div>
                            <template x-if="detailData.uploaded_docs?.pas_foto">
                                <a :href="detailData.uploaded_docs.pas_foto" target="_blank" class="block w-full py-2 text-center rounded-xl bg-emerald-700 text-white font-bold hover:bg-emerald-800 shadow-xs">
                                    🔍 Buka Pas Foto ↗
                                </a>
                            </template>
                        </div>

                        <!-- Bukti Transfer -->
                        <div class="p-3.5 rounded-2xl border border-slate-200 bg-slate-50 space-y-2 sm:col-span-2">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-900">5. Bukti Transfer Pembayaran</span>
                                <span x-show="detailData.uploaded_docs?.bukti_transfer" class="text-emerald-600 font-bold text-[10px]">✓ Ada Bukti</span>
                                <span x-show="!detailData.uploaded_docs?.bukti_transfer" class="text-slate-400 text-[10px]">Belum Ada Bukti</span>
                            </div>
                            <template x-if="detailData.uploaded_docs?.bukti_transfer">
                                <a :href="detailData.uploaded_docs.bukti_transfer" target="_blank" class="block w-full py-2 text-center rounded-xl bg-cyan-700 text-white font-bold hover:bg-cyan-800 shadow-xs">
                                    💳 Buka Bukti Pembayaran Transfer ↗
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                <button type="button" @click="showDetailModal = false" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 3: EDIT DATA & STATUS CALON SISWA (UPDATE) -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-6 shadow-2xl border border-slate-200 transform transition-all" @click.away="showEditModal = false">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-black text-lg text-slate-900">✏️ Edit Data & Status Calon Siswa</h3>
                    <p class="text-xs text-slate-500 font-medium" x-text="editForm.registration_number"></p>
                </div>
                <button type="button" @click="showEditModal = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">✕</button>
            </div>

            <form :action="'/admin/ppdb-admin/' + editForm.id" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')

                <div class="space-y-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Siswa:</label>
                        <input type="text" name="full_name" x-model="editForm.full_name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Nama Orang Tua / Ayah:</label>
                            <input type="text" name="parent_name" x-model="editForm.parent_name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Nomor WhatsApp:</label>
                            <input type="text" name="phone_number" x-model="editForm.phone_number" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Sekolah Asal:</label>
                        <input type="text" name="previous_school" x-model="editForm.previous_school" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Biaya Formulir (Rp):</label>
                            <input type="number" name="registration_fee" x-model="editForm.registration_fee" step="10000" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        </div>
                        <div class="flex items-center pt-5">
                            <label class="inline-flex items-center gap-2 cursor-pointer font-bold text-slate-800">
                                <input type="checkbox" name="fee_paid" value="1" :checked="editForm.fee_paid" @change="editForm.fee_paid = $event.target.checked" class="w-4 h-4 rounded text-emerald-600 focus:ring-emerald-500">
                                <span>Status Biaya LUNAS</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Status Kelulusan Siswa:</label>
                        <select name="status" x-model="editForm.status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 font-black focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="PENDING">⏳ Verifikasi Berkas (Pending)</option>
                            <option value="DOCUMENT_VERIFIED">📄 Berkas Lengkap & Valid</option>
                            <option value="PASSED">✓ DITERIMA / LULUS (Sinkron ke Master Data Siswa)</option>
                            <option value="REJECTED">❌ DITOLAK / BATAL</option>
                        </select>
                    </div>

                    <div x-show="editForm.status === 'PASSED'" class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-950 text-[11px] leading-relaxed">
                        ✓ <strong>Otomatisasi Sistem:</strong> Mengubah status menjadi <strong>PASSED</strong> akan otomatis membuat akun siswa di Master Data Siswa SmartEdu, mengaitkan wali murid, dan menerbitkan tagihan SPP.
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                    <button type="button" @click="showEditModal = false" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-700 hover:bg-emerald-800 text-white font-black shadow-md">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function ppdbAdminManager() {
    return {
        showCreateModal: false,
        showDetailModal: false,
        showEditModal: false,
        detailData: {},
        editForm: {
            id: '',
            registration_number: '',
            full_name: '',
            parent_name: '',
            phone_number: '',
            previous_school: '',
            registration_fee: 450000,
            fee_paid: false,
            status: 'PENDING'
        },

        openCreateModal() {
            this.showCreateModal = true;
        },

        async viewDetail(id) {
            try {
                const res = await fetch(`/admin/ppdb-admin/${id}/detail`);
                if (!res.ok) throw new Error('Gagal memuat data');
                this.detailData = await res.json();
                this.showDetailModal = true;
            } catch(e) {
                alert('Gagal memuat detail calon siswa. ' + e.message);
            }
        },

        async openEditModal(id) {
            try {
                const res = await fetch(`/admin/ppdb-admin/${id}/detail`);
                if (!res.ok) throw new Error('Gagal memuat data');
                const data = await res.json();
                this.editForm = {
                    id: data.id,
                    registration_number: data.registration_number,
                    full_name: data.full_name,
                    parent_name: data.parent_name,
                    phone_number: data.phone_number,
                    previous_school: data.previous_school,
                    registration_fee: data.registration_fee,
                    fee_paid: data.fee_paid,
                    status: data.status
                };
                this.showEditModal = true;
            } catch(e) {
                alert('Gagal membuka form edit. ' + e.message);
            }
        }
    }
}
</script>
@endsection
