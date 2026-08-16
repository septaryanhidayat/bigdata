@extends('admin.layout')

@section('title', 'Edit Profil & Berkas Pegawai: ' . $employee->full_name)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header (Clean Light) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black uppercase mb-1">
                <span>✏️</span> Formulir Pembaruan Data SDM
            </div>
            <h1 class="text-2xl font-black text-slate-900">Edit Data Induk &amp; Berkas Pegawai</h1>
            <p class="text-xs text-slate-500 font-medium">Lengkapi biodata resmi yayasan dan unggah dokumen pendukung untuk arsip digital SDM.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.employees.show', $employee->id) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs border border-slate-300 transition-colors">
                👁️ Lihat Profil
            </a>
            <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition-colors">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Biodata Pribadi & Identitas Kependudukan -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span class="text-lg">👤</span> 1. Identitas Kependudukan &amp; Biodata Pribadi
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $employee->full_name) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Kelamin</label>
                    <select name="gender" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                        <option value="M" {{ old('gender', $employee->gender) === 'M' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="F" {{ old('gender', $employee->gender) === 'F' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" name="nip" value="{{ old('nip', $employee->nip) }}" placeholder="1985..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-mono font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Induk Kependudukan (NIK KTP)</label>
                    <input type="text" name="nik" value="{{ old('nik', $employee->nik) }}" placeholder="16010..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-mono font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Kartu Keluarga (KK)</label>
                    <input type="text" name="kk_number" value="{{ old('kk_number', $employee->kk_number) }}" placeholder="16010..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-mono font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="pob" value="{{ old('pob', $employee->pob) }}" placeholder="Palembang" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="dob" value="{{ old('dob', $employee->dob) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Golongan Darah</label>
                    <select name="blood_type" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                        <option value="A" {{ old('blood_type', $employee->blood_type) === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('blood_type', $employee->blood_type) === 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('blood_type', $employee->blood_type) === 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('blood_type', $employee->blood_type) === 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Pernikahan</label>
                    <select name="marital_status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                        <option value="Belum Menikah" {{ old('marital_status', $employee->marital_status) === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="Menikah" {{ old('marital_status', $employee->marital_status) === 'Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Duda/Janda" {{ old('marital_status', $employee->marital_status) === 'Duda/Janda' ? 'selected' : '' }}>Duda / Janda</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Anak</label>
                    <input type="number" name="children_count" value="{{ old('children_count', $employee->children_count ?? 0) }}" min="0" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold text-slate-700 mb-1">Alamat Domisili Lengkap</label>
                    <textarea name="address" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-medium focus:border-emerald-500 focus:bg-white focus:outline-none">{{ old('address', $employee->address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 2: Penempatan Unit & Status Kepegawaian -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span class="text-lg">💼</span> 2. Penempatan Unit &amp; Status Kepegawaian
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Unit Penempatan *</label>
                    <select name="school_id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                        <option value="yayasan" {{ empty($employee->school_id) ? 'selected' : '' }}>🏛️ Yayasan Pusat</option>
                        @foreach($schools as $sc)
                        <option value="{{ $sc->id }}" {{ (string)$employee->school_id === (string)$sc->id ? 'selected' : '' }}>🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Peran / Jabatan Utama *</label>
                    <select name="role_type" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                        <option value="TEACHER" {{ old('role_type', $employee->role_type) === 'TEACHER' ? 'selected' : '' }}>👨‍🏫 Tenaga Pendidik (Guru)</option>
                        <option value="HEADMASTER" {{ old('role_type', $employee->role_type) === 'HEADMASTER' ? 'selected' : '' }}>👑 Kepala Unit / Sekolah</option>
                        <option value="STAFF" {{ old('role_type', $employee->role_type) === 'STAFF' ? 'selected' : '' }}>💼 Tenaga Kependidikan (Staf)</option>
                        <option value="STAFF_TU" {{ old('role_type', $employee->role_type) === 'STAFF_TU' ? 'selected' : '' }}>📋 Tata Usaha (TU)</option>
                        <option value="STAFF_KEUANGAN" {{ old('role_type', $employee->role_type) === 'STAFF_KEUANGAN' ? 'selected' : '' }}>💳 Keuangan / Bendahara</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Ikatan Kerja</label>
                    <select name="employment_status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                        <option value="TETAP" {{ old('employment_status', $employee->employment_status ?? 'TETAP') === 'TETAP' ? 'selected' : '' }}>Pegawai Tetap Yayasan (PTY)</option>
                        <option value="KONTRAK" {{ old('employment_status', $employee->employment_status) === 'KONTRAK' ? 'selected' : '' }}>Pegawai Kontrak (PKWT)</option>
                        <option value="HONORER" {{ old('employment_status', $employee->employment_status) === 'HONORER' ? 'selected' : '' }}>Guru Honorer / Pengganti</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nomor Telepon / WhatsApp</label>
                    <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" placeholder="08..." class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-mono font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Email Resmi</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}" placeholder="nama@sitrobbani.sch.id" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Mulai Bergabung</label>
                    <input type="date" name="join_date" value="{{ old('join_date', $employee->join_date) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Card 3: Riwayat Pendidikan -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span class="text-lg">🎓</span> 3. Riwayat Pendidikan Formal
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jenjang Pendidikan Terakhir</label>
                    <select name="last_education" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                        <option value="SMA/SMK" {{ old('last_education', $employee->last_education) === 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK / MA</option>
                        <option value="D3" {{ old('last_education', $employee->last_education) === 'D3' ? 'selected' : '' }}>Diploma (D3)</option>
                        <option value="S1" {{ old('last_education', $employee->last_education) === 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                        <option value="S2" {{ old('last_education', $employee->last_education) === 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                        <option value="S3" {{ old('last_education', $employee->last_education) === 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jurusan / Program Studi</label>
                    <input type="text" name="major" value="{{ old('major', $employee->major) }}" placeholder="Pendidikan Agama Islam" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Universitas / Institut</label>
                    <input type="text" name="university" value="{{ old('university', $employee->university) }}" placeholder="Universitas Sriwijaya" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Tahun Kelulusan</label>
                    <input type="number" name="graduation_year" value="{{ old('graduation_year', $employee->graduation_year) }}" placeholder="2018" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none">
                </div>
            </div>
        </div>

        <!-- Card 4: Upload 9 Dokumen & Berkas Digital SDM -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                        <span class="text-lg">📁</span> 4. Unggah 9 Dokumen &amp; Berkas Digital
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Format file yang didukung: PDF, JPG, PNG (Maksimal 5MB per file)</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $uploadFields = [
                        ['label' => 'Scan KTP Asli', 'name' => 'file_ktp', 'icon' => '🪪', 'cur' => $employee->file_ktp],
                        ['label' => 'Scan Kartu Keluarga (KK)', 'name' => 'file_kk', 'icon' => '👨‍👩‍👧', 'cur' => $employee->file_kk],
                        ['label' => 'Ijazah & Transkrip Nilai', 'name' => 'file_ijazah', 'icon' => '🎓', 'cur' => $employee->file_ijazah],
                        ['label' => 'Surat Lamaran Kerja', 'name' => 'file_surat_lamaran', 'icon' => '✉️', 'cur' => $employee->file_surat_lamaran],
                        ['label' => 'SK / Kontrak Kerja (PKWT/PTY)', 'name' => 'file_kontrak_kerja', 'icon' => '📜', 'cur' => $employee->file_kontrak_kerja],
                        ['label' => 'Sertifikat Pendidik / Pelatihan', 'name' => 'file_sertifikat', 'icon' => '🎖️', 'cur' => $employee->file_sertifikat],
                        ['label' => 'Piagam Prestasi / Penghargaan', 'name' => 'file_prestasi', 'icon' => '🏆', 'cur' => $employee->file_prestasi],
                        ['label' => 'Kartu NPWP Pribadi', 'name' => 'file_npwp', 'icon' => '💼', 'cur' => $employee->file_npwp],
                        ['label' => 'Kartu BPJS Kesehatan / Ketenagakerjaan', 'name' => 'file_bpjs', 'icon' => '🏥', 'cur' => $employee->file_bpjs],
                    ];
                @endphp

                @foreach($uploadFields as $uf)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-black text-slate-900 flex items-center gap-1.5">
                            <span>{{ $uf['icon'] }}</span> {{ $uf['label'] }}
                        </label>
                        @if(!empty($uf['cur']))
                        <span class="text-[10px] font-black text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md">
                            ✓ Ada
                        </span>
                        @endif
                    </div>
                    
                    <input type="file" name="{{ $uf['name'] }}" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300">

                    @if(!empty($uf['cur']))
                    <div class="pt-1">
                        <a href="{{ asset($uf['cur']) }}" target="_blank" class="text-[11px] font-bold text-emerald-600 hover:underline">
                            👁️ Lihat Dokumen Terunggah
                        </a>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Submit Bar -->
        <div class="flex items-center justify-end gap-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <a href="{{ route('admin.employees.show', $employee->id) }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-300 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-8 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition-all shadow-md flex items-center gap-2 cursor-pointer">
                <span>💾</span> Simpan Seluruh Pembaruan
            </button>
        </div>
    </form>
</div>
@endsection
