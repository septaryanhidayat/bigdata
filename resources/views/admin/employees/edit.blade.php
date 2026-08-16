@extends('admin.layout')

@section('title', 'Edit Profil & E-Berkas Pegawai: ' . $employee->full_name)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black uppercase mb-1">
                <span>✏️</span> Formulir Lengkap Bidang SDM
            </div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white">Edit Data Induk &amp; E-Berkas Pegawai</h1>
            <p class="text-xs text-slate-500 font-medium">Lengkapi biodata resmi yayasan dan unggah dokumen pendukung untuk arsip digital SDM.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.employees.show', $employee->id) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs border border-slate-300">
                👁️ Lihat Dossier
            </a>
            <a href="{{ route('admin.employees.index') }}" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Card 1: Biodata Pribadi & Identitas Kependudukan -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="text-lg">👤</span> 1. Identitas Kependudukan &amp; Biodata Pribadi
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Lengkap &amp; Gelar *</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $employee->full_name) }}" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Gelar Depan / Belakang</label>
                    <div class="flex gap-2">
                        <input type="text" name="title_prefix" value="{{ old('title_prefix', $employee->title_prefix) }}" placeholder="Ustdz." class="w-1/2 px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                        <input type="text" name="title_suffix" value="{{ old('title_suffix', $employee->title_suffix) }}" placeholder="S.Pd.I, M.Pd" class="w-1/2 px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" name="nip" value="{{ old('nip', $employee->nip) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-mono font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">NIK KTP (16 Digit)</label>
                    <input type="text" name="nik" value="{{ old('nik', $employee->nik) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-mono font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nomor Kartu Keluarga (KK)</label>
                    <input type="text" name="kk_number" value="{{ old('kk_number', $employee->kk_number) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-mono font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tempat Lahir</label>
                    <input type="text" name="pob" value="{{ old('pob', $employee->pob) }}" placeholder="Contoh: Indralaya, Palembang" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tanggal Lahir</label>
                    <input type="date" name="dob" value="{{ old('dob', $employee->dob) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jenis Kelamin</label>
                    <select name="gender" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                        <option value="M" {{ old('gender', $employee->gender) == 'M' ? 'selected' : '' }}>Laki-laki (Ikhwan)</option>
                        <option value="F" {{ old('gender', $employee->gender) == 'F' ? 'selected' : '' }}>Perempuan (Akhwat)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Status Pernikahan</label>
                    <select name="marital_status" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                        <option value="MARRIED" {{ old('marital_status', $employee->marital_status) == 'MARRIED' ? 'selected' : '' }}>Menikah</option>
                        <option value="SINGLE" {{ old('marital_status', $employee->marital_status) == 'SINGLE' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="WIDOWED" {{ old('marital_status', $employee->marital_status) == 'WIDOWED' ? 'selected' : '' }}>Duda / Janda</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jumlah Anak</label>
                    <input type="number" name="children_count" value="{{ old('children_count', $employee->children_count ?? 0) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Golongan Darah</label>
                    <select name="blood_type" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                        <option value="">- Pilih Golongan Darah -</option>
                        <option value="A" {{ old('blood_type', $employee->blood_type) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('blood_type', $employee->blood_type) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('blood_type', $employee->blood_type) == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('blood_type', $employee->blood_type) == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Card 2: Kontak & Alamat -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="text-lg">📞</span> 2. Kontak &amp; Alamat Domisili
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nomor WhatsApp / HP *</label>
                    <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-bold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Email Resmi Pegawai</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Alamat Lengkap Domisili</label>
                    <textarea name="address" rows="2" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-medium">{{ old('address', $employee->address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 3: Pendidikan & Kepegawaian -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="text-lg">🎓</span> 3. Pendidikan Terakhir &amp; Status Kepegawaian Yayasan
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Unit Penempatan *</label>
                    <select name="school_id" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-bold">
                        @foreach($schools as $s)
                        <option value="{{ $s->id }}" {{ old('school_id', $employee->school_id) == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Peran / Jabatan Utama *</label>
                    <select name="role_type" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-bold">
                        <option value="TEACHER" {{ old('role_type', $employee->role_type) == 'TEACHER' ? 'selected' : '' }}>Guru / Tenaga Pendidik</option>
                        <option value="HEADMASTER" {{ old('role_type', $employee->role_type) == 'HEADMASTER' ? 'selected' : '' }}>Kepala Sekolah</option>
                        <option value="STAFF" {{ old('role_type', $employee->role_type) == 'STAFF' ? 'selected' : '' }}>Staf Karyawan</option>
                        <option value="COUNSELOR" {{ old('role_type', $employee->role_type) == 'COUNSELOR' ? 'selected' : '' }}>Guru BK / Konselor</option>
                        <option value="TREASURER" {{ old('role_type', $employee->role_type) == 'TREASURER' ? 'selected' : '' }}>Bendahara Sekolah</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Status Kepegawaian *</label>
                    <select name="employment_status" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-bold">
                        <option value="PERMANENT" {{ old('employment_status', $employee->employment_status) == 'PERMANENT' ? 'selected' : '' }}>Pegawai Tetap Yayasan (PTY/GTY)</option>
                        <option value="CONTRACT" {{ old('employment_status', $employee->employment_status) == 'CONTRACT' ? 'selected' : '' }}>Pegawai Kontrak (PKWT)</option>
                        <option value="HONORARY" {{ old('employment_status', $employee->employment_status) == 'HONORARY' ? 'selected' : '' }}>Guru Honorer / Magang</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jenjang Pendidikan Terakhir</label>
                    <select name="last_education" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                        <option value="S1" {{ old('last_education', $employee->last_education) == 'S1' ? 'selected' : '' }}>S1 (Sarjana)</option>
                        <option value="S2" {{ old('last_education', $employee->last_education) == 'S2' ? 'selected' : '' }}>S2 (Magister)</option>
                        <option value="S3" {{ old('last_education', $employee->last_education) == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                        <option value="D3" {{ old('last_education', $employee->last_education) == 'D3' ? 'selected' : '' }}>D3 (Diploma)</option>
                        <option value="SMA" {{ old('last_education', $employee->last_education) == 'SMA' ? 'selected' : '' }}>SMA / MA / Pondok</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jurusan / Program Studi</label>
                    <input type="text" name="major" value="{{ old('major', $employee->major) }}" placeholder="Contoh: Pendidikan Agama Islam, Matematika" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Perguruan Tinggi / Kampus</label>
                    <input type="text" name="university" value="{{ old('university', $employee->university) }}" placeholder="Contoh: UIN Raden Fatah, UNSRI" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Tahun Kelulusan</label>
                    <input type="text" name="graduation_year" value="{{ old('graduation_year', $employee->graduation_year) }}" placeholder="Contoh: 2018" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">TMT Mulai Bekerja (Join Date)</label>
                    <input type="date" name="join_date" value="{{ old('join_date', $employee->join_date) }}" class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-semibold">
                </div>
            </div>
        </div>

        <!-- Card 4: Unggah Arsip Dokumen Digital Yayasan (E-Berkas SDM) -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 space-y-5">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-3 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <span class="text-lg">📁</span> 4. E-Berkas &amp; Dokumen Digital Pegawai (PDF / Foto Max 5MB)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Unggah berkas resmi untuk arsip digital SDM yayasan tanpa perlu cek fisik manual lagi.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <!-- 1. KTP -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                            <span>🪪</span> Scan KTP
                        </span>
                        @if($employee->file_ktp)
                        <a href="{{ asset($employee->file_ktp) }}" target="_blank" class="text-[10px] font-bold text-emerald-600 hover:underline">✓ Lihat File</a>
                        @endif
                    </div>
                    <input type="file" name="file_ktp" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-500 file:text-slate-950">
                </div>

                <!-- 2. KK -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                            <span>👨‍👩‍👧</span> Scan Kartu Keluarga
                        </span>
                        @if($employee->file_kk)
                        <a href="{{ asset($employee->file_kk) }}" target="_blank" class="text-[10px] font-bold text-emerald-600 hover:underline">✓ Lihat File</a>
                        @endif
                    </div>
                    <input type="file" name="file_kk" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-500 file:text-slate-950">
                </div>

                <!-- 3. Ijazah -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                            <span>🎓</span> Ijazah &amp; Transkrip
                        </span>
                        @if($employee->file_ijazah)
                        <a href="{{ asset($employee->file_ijazah) }}" target="_blank" class="text-[10px] font-bold text-emerald-600 hover:underline">✓ Lihat File</a>
                        @endif
                    </div>
                    <input type="file" name="file_ijazah" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-500 file:text-slate-950">
                </div>

                <!-- 4. Surat Lamaran -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                            <span>✉️</span> Surat Lamaran Kerja
                        </span>
                        @if($employee->file_surat_lamaran)
                        <a href="{{ asset($employee->file_surat_lamaran) }}" target="_blank" class="text-[10px] font-bold text-emerald-600 hover:underline">✓ Lihat File</a>
                        @endif
                    </div>
                    <input type="file" name="file_surat_lamaran" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-500 file:text-slate-950">
                </div>

                <!-- 5. Kontrak Kerja -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                            <span>📜</span> SK / Kontrak Kerja
                        </span>
                        @if($employee->file_kontrak_kerja)
                        <a href="{{ asset($employee->file_kontrak_kerja) }}" target="_blank" class="text-[10px] font-bold text-emerald-600 hover:underline">✓ Lihat File</a>
                        @endif
                    </div>
                    <input type="file" name="file_kontrak_kerja" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-500 file:text-slate-950">
                </div>

                <!-- 6. Sertifikat Pendidik -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                            <span>🎖️</span> Sertifikat / Pelatihan
                        </span>
                        @if($employee->file_sertifikat)
                        <a href="{{ asset($employee->file_sertifikat) }}" target="_blank" class="text-[10px] font-bold text-emerald-600 hover:underline">✓ Lihat File</a>
                        @endif
                    </div>
                    <input type="file" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-500 file:text-slate-950">
                </div>

                <!-- 7. Piagam Prestasi -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                            <span>🏆</span> Piagam Prestasi &amp; Penghargaan
                        </span>
                        @if($employee->file_prestasi)
                        <a href="{{ asset($employee->file_prestasi) }}" target="_blank" class="text-[10px] font-bold text-emerald-600 hover:underline">✓ Lihat File</a>
                        @endif
                    </div>
                    <input type="file" name="file_prestasi" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-500 file:text-slate-950">
                </div>

                <!-- 8. NPWP -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                            <span>💼</span> Kartu NPWP
                        </span>
                        @if($employee->file_npwp)
                        <a href="{{ asset($employee->file_npwp) }}" target="_blank" class="text-[10px] font-bold text-emerald-600 hover:underline">✓ Lihat File</a>
                        @endif
                    </div>
                    <input type="file" name="file_npwp" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-500 file:text-slate-950">
                </div>

                <!-- 9. BPJS -->
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold text-slate-800 dark:text-white flex items-center gap-1.5">
                            <span>🏥</span> Kartu BPJS Kesehatan/TK
                        </span>
                        @if($employee->file_bpjs)
                        <a href="{{ asset($employee->file_bpjs) }}" target="_blank" class="text-[10px] font-bold text-emerald-600 hover:underline">✓ Lihat File</a>
                        @endif
                    </div>
                    <input type="file" name="file_bpjs" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-emerald-500 file:text-slate-950">
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ route('admin.employees.index') }}" class="px-5 py-3 rounded-2xl bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold text-xs">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs transition-all shadow-lg hover:shadow-emerald-500/25 flex items-center gap-2">
                <span>💾</span> Simpan Seluruh Perubahan Data &amp; Berkas SDM
            </button>
        </div>
    </form>
</div>
@endsection
