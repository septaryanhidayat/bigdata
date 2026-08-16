@extends('admin.layout')

@section('title', 'Edit Profil & Berkas Pegawai: ' . $employee->full_name)

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header Back Bar (Professional Clean Light Design) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.employees.show', $employee->id) }}" class="w-11 h-11 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 flex items-center justify-center font-black text-lg transition-all border border-slate-200 shadow-xs">
                ←
            </a>
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-[11px] font-black uppercase tracking-wider border border-emerald-200 mb-1">
                    <span>✏️</span> Formulir Pembaruan Data Pegawai
                </div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Biodata &amp; Berkas: {{ $employee->full_name }}</h1>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.employees.show', $employee->id) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-extrabold text-xs border border-slate-300 transition-colors">
                👁️ Lihat Profil
            </a>
            <a href="{{ route('admin.employees.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-xs transition-colors shadow-sm">
                ← Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Flash Messages & Validation Errors -->
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-5 py-4 rounded-2xl font-bold text-xs flex items-center gap-2 shadow-xs">
        <span class="text-base">✓</span> {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-rose-50 border border-rose-300 text-rose-900 p-5 rounded-2xl text-xs space-y-1.5 shadow-xs">
        <div class="font-black flex items-center gap-2 text-rose-800">
            <span>⚠️</span> Terdapat kesalahan input yang perlu diperbaiki:
        </div>
        <ul class="list-disc pl-5 font-semibold text-rose-700 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Edit Form -->
    <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @php
            $currentPhoto = $employee->face_photo_url 
                ? (str_starts_with($employee->face_photo_url, 'http') ? $employee->face_photo_url : asset($employee->face_photo_url) . '?v=' . time()) 
                : ($employee->user && $employee->user->avatar ? (str_starts_with($employee->user->avatar, 'http') ? $employee->user->avatar : asset($employee->user->avatar) . '?v=' . time()) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->full_name) . '&background=059669&color=fff&bold=true&size=200');
        @endphp

        <!-- Card 0: Foto Profil & Biometrik Wajah SDM -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-7 space-y-4">
            <div class="border-b border-slate-100 pb-3.5 flex items-center justify-between">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-sm font-bold border border-pink-100">📷</span>
                    Foto Profil &amp; Sampel Wajah Biometrik (Face ID)
                </h3>
                <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-lg border border-emerald-200">
                    Otomatis Sinkron ke Aplikasi Mobile
                </span>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-6">
                <div class="relative shrink-0">
                    <img id="avatarPreview" 
                         src="{{ $currentPhoto }}" 
                         alt="{{ $employee->full_name }}" 
                         class="w-24 h-24 sm:w-28 sm:h-28 rounded-3xl object-cover border-4 border-slate-200 shadow-md">
                    <div class="absolute -bottom-2 -right-2 bg-emerald-600 text-white text-[10px] font-black px-2 py-0.5 rounded-full border-2 border-white shadow-xs">
                        Aktif
                    </div>
                </div>

                <div class="flex-1 space-y-2 text-center sm:text-left">
                    <label class="block text-xs font-black text-slate-700">Pilih Foto Profil Baru</label>
                    <input type="hidden" name="avatar_base64" id="avatarBase64Input">
                    <input type="file" 
                           name="avatar" 
                           id="avatarInput" 
                           accept="image/*" 
                           onchange="compressAndPreviewAvatar(this)" 
                           class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-slate-900 file:text-white hover:file:bg-slate-800 cursor-pointer">
                    <div id="compressionStatus" class="hidden">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200" id="compressionText">
                            ⚡ Mengompresi foto...
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-500 font-medium">
                        Foto otomatis dikompresi di bawah 50 KB oleh sistem agar penyimpanan ringan dan sinkron instan ke presensi mobile.
                    </p>
                </div>
            </div>
        </div>

        <script>
            function compressAndPreviewAvatar(input) {
                if (input.files && input.files[0]) {
                    const file = input.files[0];
                    const statusDiv = document.getElementById('compressionStatus');
                    const statusText = document.getElementById('compressionText');
                    statusDiv.classList.remove('hidden');
                    statusText.innerHTML = '⏳ Mengompresi ukuran foto ke &lt; 50 KB...';

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = new Image();
                        img.onload = function() {
                            const canvas = document.createElement('canvas');
                            const maxDim = 480;
                            let width = img.width;
                            let height = img.height;

                            if (width > height) {
                                if (width > maxDim) {
                                    height = Math.round((height * maxDim) / width);
                                    width = maxDim;
                                }
                            } else {
                                if (height > maxDim) {
                                    width = Math.round((width * maxDim) / height);
                                    height = maxDim;
                                }
                            }

                            canvas.width = width;
                            canvas.height = height;
                            const ctx = canvas.getContext('2d');
                            ctx.fillStyle = '#ffffff';
                            ctx.fillRect(0, 0, width, height);
                            ctx.drawImage(img, 0, 0, width, height);

                            let quality = 0.75;
                            let compressedData = canvas.toDataURL('image/jpeg', quality);
                            let sizeKb = Math.round((compressedData.length * 3 / 4) / 1024);

                            if (sizeKb > 48) {
                                quality = 0.55;
                                compressedData = canvas.toDataURL('image/jpeg', quality);
                                sizeKb = Math.round((compressedData.length * 3 / 4) / 1024);
                            }

                            document.getElementById('avatarPreview').src = compressedData;
                            document.getElementById('avatarBase64Input').value = compressedData;
                            statusText.innerHTML = '✅ Foto berhasil dioptimasi: <b>' + sizeKb + ' KB</b> (Optimal &lt; 50KB)';
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>

        <!-- Card 1: Identitas Kependudukan & Biodata Pribadi -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-7 space-y-5">
            <div class="border-b border-slate-100 pb-3.5 flex items-center justify-between">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-sm font-bold border border-blue-100">👤</span>
                    1. Identitas Kependudukan &amp; Biodata Pribadi
                </h3>
                <span class="text-[11px] font-bold text-slate-400">Wajib diisi sesuai KTP &amp; KK</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Nama Lengkap &amp; Gelar *</label>
                    <input type="text" 
                           name="full_name" 
                           value="{{ old('full_name', $employee->full_name) }}" 
                           required 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Jenis Kelamin *</label>
                    <select name="gender" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="M" {{ old('gender', $employee->gender) === 'M' ? 'selected' : '' }}>Laki-laki (Ikhwan)</option>
                        <option value="F" {{ old('gender', $employee->gender) === 'F' ? 'selected' : '' }}>Perempuan (Akhwat)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Nomor Induk Pegawai (NIP)</label>
                    <input type="text" 
                           name="nip" 
                           value="{{ old('nip', $employee->nip) }}" 
                           placeholder="Contoh: 198505122026011001" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-mono font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Nomor Induk Kependudukan (NIK KTP)</label>
                    <input type="text" 
                           name="nik" 
                           value="{{ old('nik', $employee->nik) }}" 
                           placeholder="16 Digit NIK KTP" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-mono font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Nomor Kartu Keluarga (No. KK)</label>
                    <input type="text" 
                           name="kk_number" 
                           value="{{ old('kk_number', $employee->kk_number) }}" 
                           placeholder="16 Digit Nomor KK" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-mono font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Tempat Lahir</label>
                    <input type="text" 
                           name="pob" 
                           value="{{ old('pob', $employee->pob ?? 'Palembang') }}" 
                           placeholder="Kota / Kabupaten Lahir" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Tanggal Lahir</label>
                    <input type="date" 
                           name="dob" 
                           value="{{ old('dob', $employee->dob) }}" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Golongan Darah</label>
                    <select name="blood_type" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="A" {{ old('blood_type', $employee->blood_type) === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('blood_type', $employee->blood_type) === 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('blood_type', $employee->blood_type) === 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('blood_type', $employee->blood_type ?? 'O') === 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Status Pernikahan</label>
                    <select name="marital_status" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="Belum Menikah" {{ old('marital_status', $employee->marital_status) === 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah (Lajang)</option>
                        <option value="Menikah" {{ old('marital_status', $employee->marital_status ?? 'Menikah') === 'Menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="Duda/Janda" {{ old('marital_status', $employee->marital_status) === 'Duda/Janda' ? 'selected' : '' }}>Duda / Janda</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Jumlah Tanggungan Anak</label>
                    <input type="number" 
                           name="children_count" 
                           value="{{ old('children_count', $employee->children_count ?? 0) }}" 
                           min="0" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Alamat Domisili Lengkap</label>
                    <textarea name="address" 
                              rows="2" 
                              placeholder="Alamat jalan, RT/RW, Kelurahan, Kecamatan, Kabupaten/Kota" 
                              class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-medium focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">{{ old('address', $employee->address) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Card 2: Penempatan Unit & Status Kepegawaian -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-7 space-y-5">
            <div class="border-b border-slate-100 pb-3.5 flex items-center justify-between">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold border border-emerald-100">💼</span>
                    2. Penempatan Unit &amp; Status Kepegawaian
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Unit Penempatan *</label>
                    <select name="school_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="yayasan" {{ empty($employee->school_id) ? 'selected' : '' }}>🏛️ Yayasan Generasi Robbani (Pusat)</option>
                        @foreach($schools as $sc)
                        <option value="{{ $sc->id }}" {{ (string)$employee->school_id === (string)$sc->id ? 'selected' : '' }}>🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Peran / Jabatan Utama *</label>
                    <select name="role_type" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="TEACHER" {{ old('role_type', $employee->role_type) === 'TEACHER' ? 'selected' : '' }}>👨‍🏫 Tenaga Pendidik (Guru)</option>
                        <option value="HEADMASTER" {{ old('role_type', $employee->role_type) === 'HEADMASTER' ? 'selected' : '' }}>👑 Kepala Unit / Sekolah</option>
                        <option value="STAFF" {{ old('role_type', $employee->role_type) === 'STAFF' ? 'selected' : '' }}>💼 Tenaga Kependidikan (Staf)</option>
                        <option value="STAFF_TU" {{ old('role_type', $employee->role_type) === 'STAFF_TU' ? 'selected' : '' }}>📋 Tata Usaha (TU)</option>
                        <option value="STAFF_KEUANGAN" {{ old('role_type', $employee->role_type) === 'STAFF_KEUANGAN' ? 'selected' : '' }}>💳 Keuangan / Bendahara</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Status Ikatan Kerja *</label>
                    <select name="employment_status" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="TETAP" {{ old('employment_status', $employee->employment_status ?? 'TETAP') === 'TETAP' ? 'selected' : '' }}>Pegawai / Guru Tetap Yayasan (PTY/GTY)</option>
                        <option value="KONTRAK" {{ old('employment_status', $employee->employment_status) === 'KONTRAK' ? 'selected' : '' }}>Pegawai / Guru Kontrak (PKWT/GTT)</option>
                        <option value="HONORER" {{ old('employment_status', $employee->employment_status) === 'HONORER' ? 'selected' : '' }}>Guru Honorer / Pengganti</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Nomor WhatsApp / HP Aktif</label>
                    <input type="text" 
                           name="phone" 
                           value="{{ old('phone', $employee->phone) }}" 
                           placeholder="Contoh: 085267774878" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-mono font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Alamat Email Resmi</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email', $employee->email) }}" 
                           placeholder="nama@sitrobbani.sch.id" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Tanggal Mulai Bergabung</label>
                    <input type="date" 
                           name="join_date" 
                           value="{{ old('join_date', $employee->join_date) }}" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>
            </div>
        </div>

        <!-- Card 3: Riwayat Pendidikan Formal -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-7 space-y-5">
            <div class="border-b border-slate-100 pb-3.5 flex items-center justify-between">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                    <span class="w-8 h-8 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-sm font-bold border border-purple-100">🎓</span>
                    3. Riwayat Pendidikan Formal
                </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Jenjang Pendidikan Terakhir</label>
                    <select name="last_education" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                        <option value="SMA/SMK" {{ old('last_education', $employee->last_education) === 'SMA/SMK' ? 'selected' : '' }}>SMA / SMK / MA</option>
                        <option value="D3" {{ old('last_education', $employee->last_education) === 'D3' ? 'selected' : '' }}>Diploma (D3)</option>
                        <option value="S1" {{ old('last_education', $employee->last_education ?? 'S1') === 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                        <option value="S2" {{ old('last_education', $employee->last_education) === 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                        <option value="S3" {{ old('last_education', $employee->last_education) === 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Jurusan / Program Studi</label>
                    <input type="text" 
                           name="major" 
                           value="{{ old('major', $employee->major) }}" 
                           placeholder="Contoh: Pendidikan Matematika" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Nama Universitas / Institut</label>
                    <input type="text" 
                           name="university" 
                           value="{{ old('university', $employee->university) }}" 
                           placeholder="Contoh: Universitas Sriwijaya" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-700 mb-1.5">Tahun Kelulusan</label>
                    <input type="number" 
                           name="graduation_year" 
                           value="{{ old('graduation_year', $employee->graduation_year) }}" 
                           placeholder="Contoh: 2018" 
                           class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 text-xs font-bold focus:border-emerald-500 focus:bg-white focus:outline-none transition-all shadow-xs">
                </div>
            </div>
        </div>

        <!-- Card 4: Upload 9 Dokumen & Berkas Digital SDM -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-7 space-y-5">
            <div class="border-b border-slate-100 pb-3.5 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-black text-slate-900 flex items-center gap-2.5">
                        <span class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold border border-amber-100">📁</span>
                        4. Unggah 9 Dokumen &amp; Berkas Digital
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5 font-medium">Format: PDF, JPG, JPEG, PNG (Maksimal 5MB per berkas)</p>
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
                <div class="p-4 rounded-2xl border {{ !empty($uf['cur']) ? 'bg-emerald-50/40 border-emerald-200' : 'bg-slate-50 border-slate-200' }} space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-black text-slate-900 flex items-center gap-1.5">
                            <span>{{ $uf['icon'] }}</span> {{ $uf['label'] }}
                        </label>
                        @if(!empty($uf['cur']))
                        <span class="text-[10px] font-black text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-md border border-emerald-200">
                            ✓ Terunggah
                        </span>
                        @endif
                    </div>
                    
                    <input type="file" 
                           name="{{ $uf['name'] }}" 
                           accept=".pdf,.jpg,.jpeg,.png" 
                           class="w-full text-xs text-slate-600 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-slate-200 file:text-slate-800 hover:file:bg-slate-300 cursor-pointer">

                    @if(!empty($uf['cur']))
                    <div class="pt-1 flex items-center gap-2">
                        <a href="{{ asset($uf['cur']) }}" target="_blank" class="text-[11px] font-bold text-emerald-700 hover:underline inline-flex items-center gap-1">
                            👁️ Buka File Dokumen
                        </a>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Sticky Submit Bar -->
        <div class="flex items-center justify-between bg-white p-5 rounded-3xl border border-slate-200 shadow-lg sticky bottom-4 z-20">
            <span class="text-xs text-slate-500 font-medium hidden sm:inline">
                Pastikan data yang Anda masukkan telah sesuai sebelum menyimpan.
            </span>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('admin.employees.show', $employee->id) }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold text-xs border border-slate-300 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition-all shadow-md hover:shadow-emerald-500/25 flex items-center gap-2 cursor-pointer">
                    <span>💾</span> Simpan Seluruh Pembaruan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
