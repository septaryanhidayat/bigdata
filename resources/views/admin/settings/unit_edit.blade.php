@extends('admin.layout')

@section('title', 'Edit Profil & Struktur Web Unit ' . strtoupper($cleanCode))

@section('content')
@php
    $teachersList = isset($unitData['teachers']) && is_array($unitData['teachers']) ? $unitData['teachers'] : [];
    $programsList = isset($unitData['programs']) && is_array($unitData['programs']) ? $unitData['programs'] : [];
    $facilitiesList = isset($unitData['facilities']) && is_array($unitData['facilities']) ? $unitData['facilities'] : [];
    $ekskulList = isset($unitData['ekskul']) && is_array($unitData['ekskul']) ? $unitData['ekskul'] : [];
@endphp

<div class="max-w-5xl space-y-6" x-data="{
    teachers: {{ json_encode($teachersList) }},
    programs: {{ json_encode($programsList) }},
    facilities: {{ json_encode($facilitiesList) }},
    ekskul: {{ json_encode($ekskulList) }},
    
    addTeacher() {
        this.teachers.push({ name: '', role: 'Guru / Pendidik', photo: '/images/mockup_mobile_1.png', bio: '' });
    },
    removeTeacher(index) {
        this.teachers.splice(index, 1);
    },
    addProgram() {
        this.programs.push({ title: '', icon: '📖', desc: '' });
    },
    removeProgram(index) {
        this.programs.splice(index, 1);
    },
    addFacility() {
        this.facilities.push({ title: '', badge: 'Fasilitas Unit', icon: '🏫', desc: '', image: '/images/mockup_desktop_1.png' });
    },
    removeFacility(index) {
        this.facilities.splice(index, 1);
    },
    addEkskul() {
        this.ekskul.push({ title: '', badge: 'Ekstrakurikuler', icon: '⭐', desc: '', image: '/images/mockup_desktop_2.png' });
    },
    removeEkskul(index) {
        this.ekskul.splice(index, 1);
    }
}">
    
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.settings.units') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">← Kembali ke Daftar Unit</a>
                <span class="text-slate-300">•</span>
                <span class="px-2.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase">PROFIL WEB UNIT {{ strtoupper($cleanCode) }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Kelola Profil Mandiri &amp; Struktur Web Unit {{ strtoupper($cleanCode) }}</h1>
            <p class="text-xs text-slate-600 font-medium mt-1">Perbarui data profil, dewan guru, hero banner, program unggulan, fasilitas, dan statistik web unit ini secara mandiri.</p>
        </div>
        <a href="{{ route('school.unit', $cleanCode) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md flex items-center gap-1.5 shrink-0">
            <span>Lihat Tampilan Web Unit</span> ➔
        </a>
    </div>

    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-100 border border-emerald-300 text-emerald-900 text-xs font-bold flex items-center gap-3">
        <span class="text-base">✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.settings.units.update', $cleanCode) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs space-y-8">
        @csrf

        <!-- Section 1: Data Identitas Utama Unit -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                <span>🏛️</span> <span>1. Identitas Utama &amp; Kontak Unit</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Resmi Unit Sekolah *</label>
                    <input type="text" name="name" value="{{ old('name', $unitData['name'] ?? ($schoolObj->name ?? 'SDIT Robbani Ogan Ilir')) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">NPSN Unit *</label>
                    <input type="text" name="npsn" value="{{ old('npsn', $unitData['npsn'] ?? ($schoolObj->npsn ?? '69985678')) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Akreditasi</label>
                    <input type="text" name="akreditasi" value="{{ old('akreditasi', $unitData['akreditasi'] ?? 'Terakreditasi B') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Slogan / Tagline Khas Unit</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $unitData['tagline'] ?? 'Mencetak Generasi Qur\'ani & Berkarakter Karimah') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi &amp; Profil Singkat Unit *</label>
                <textarea name="description" rows="3" class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('description', $unitData['description'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Section 2: Banner Hero & Visual Unit -->
        <div class="space-y-4 pb-6 border-b border-slate-200 bg-slate-50/80 p-5 rounded-2xl border border-slate-200">
            <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                <span>🎨</span> <span>2. Kustomisasi Visual Banner Hero Unit</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Hero BG -->
                <div class="space-y-3 p-4 bg-white rounded-xl border border-slate-200 shadow-xs">
                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">🏛️ Gambar Latar Belakang Hero (Gedung / Masjid):</label>
                    <div class="h-32 rounded-xl overflow-hidden border border-slate-200 bg-slate-900 relative flex items-center justify-center">
                        @if(!empty($unitData['hero_bg_image']))
                            <img src="{{ $unitData['hero_bg_image'] }}" alt="Hero Background Preview" class="w-full h-full object-cover opacity-75">
                        @else
                            <div class="text-center p-3 text-slate-400 text-xs">
                                <span class="text-2xl block mb-1">🕌</span>
                                <span>Default Theme Gradient</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Upload Foto Baru (Gedung/Masjid):</label>
                        <input type="file" name="hero_bg_file" accept="image/*" class="w-full text-xs text-slate-600 border border-slate-300 rounded-xl p-2 bg-slate-50">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">atau Tempelkan URL Gambar Custom:</label>
                        <input type="text" name="hero_bg_image" value="{{ old('hero_bg_image', $unitData['hero_bg_image'] ?? '') }}" placeholder="e.g. /uploads/cms/masjid_sdit.jpg" class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                </div>

                <!-- Hero Main Photo -->
                <div class="space-y-3 p-4 bg-white rounded-xl border border-slate-200 shadow-xs">
                    <label class="block text-xs font-black text-slate-800 uppercase tracking-wider">🎓 Foto Utama Banner Hero (Siswa Berprestasi / Visual):</label>
                    <div class="h-32 rounded-xl overflow-hidden border border-slate-200 bg-slate-900 relative flex items-center justify-center">
                        @if(!empty($unitData['hero_image']))
                            <img src="{{ $unitData['hero_image'] }}" alt="Hero Main Image Preview" class="w-full h-full object-cover">
                        @else
                            <div class="text-center p-3 text-slate-400 text-xs">
                                <span class="text-2xl block mb-1">📸</span>
                                <span>Foto Default Unit {{ strtoupper($cleanCode) }}</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Upload Foto Utama Baru:</label>
                        <input type="file" name="hero_image_file" accept="image/*" class="w-full text-xs text-slate-600 border border-slate-300 rounded-xl p-2 bg-slate-50">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">atau Tempelkan URL Gambar Custom:</label>
                        <input type="text" name="hero_image" value="{{ old('hero_image', $unitData['hero_image'] ?? '') }}" placeholder="e.g. /uploads/cms/siswa_sdit.jpg" class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Kepala Sekolah & Sambutan -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                <span>👤</span> <span>3. Kepala Sekolah &amp; Sambutan Resmi</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kepala Sekolah &amp; Gelar *</label>
                    <input type="text" name="principal_name" value="{{ old('principal_name', $unitData['principal_name'] ?? ($schoolObj->principal_name ?? 'Ustadzah Tia Wulandari, S.Pd')) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan Resmi</label>
                    <input type="text" name="principal_title" value="{{ old('principal_title', $unitData['principal_title'] ?? ('Kepala Sekolah ' . strtoupper($cleanCode) . ' Robbani Ogan Ilir')) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Foto Kepala Sekolah (Pilih File Foto Baru)</label>
                <div class="flex items-center gap-4">
                    @if(isset($unitData['principal_photo']))
                    <img src="{{ $unitData['principal_photo'] }}" alt="Foto Kepsek" class="w-12 h-12 rounded-full object-cover border border-slate-200">
                    @endif
                    <input type="file" name="principal_photo" accept="image/*" class="text-xs text-slate-600 border border-slate-300 rounded-xl p-2 w-full">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Teks Sambutan Kepala Sekolah *</label>
                <textarea name="principal_greeting" rows="3" class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('principal_greeting', $unitData['principal_greeting'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Section 4: Visi & Misi Unit -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                <span>🎯</span> <span>4. Visi &amp; Misi Unit</span>
            </h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kalimat Visi Unit *</label>
                <textarea name="vision" rows="2" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('vision', $unitData['vision'] ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Poin-Poin Misi Unit (Satu kalimat per baris)</label>
                <textarea name="missions_text" rows="4" class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Menanamkan aqidah islami sejak dini...&#10;Menerapkan Kurikulum Merdeka...&#10;Mengembangkan sains &amp; koding...">{{ old('missions_text', isset($unitData['missions']) && is_array($unitData['missions']) ? implode("\n", $unitData['missions']) : '') }}</textarea>
            </div>
        </div>

        <!-- Section 5: DEWAN GURU & TENAGA PENDIDIK UNIT (PENUH PENGATURAN GURU) -->
        <div class="space-y-4 pb-6 border-b border-slate-200 bg-slate-50/80 p-5 rounded-2xl border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                        <span>👨‍🏫</span> <span>5. Dewan Guru &amp; Tenaga Pendidik Unit {{ strtoupper($cleanCode) }}</span>
                    </h3>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola daftar foto, nama, serta jabatan guru/staf yang tampil di halaman web unit ini.</p>
                </div>
                <button type="button" @click="addTeacher()" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-xs flex items-center gap-1.5 cursor-pointer">
                    <span>➕ Tambah Guru Baru</span>
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(teacher, index) in teachers" :key="index">
                    <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-xs space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                            <span class="text-xs font-black text-emerald-900 uppercase" x-text="'Guru / Tendik #' + (index + 1)"></span>
                            <button type="button" @click="removeTeacher(index)" class="text-xs text-rose-600 hover:text-rose-800 font-bold flex items-center gap-1 cursor-pointer">
                                <span>🗑️ Hapus Guru</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Lengkap &amp; Gelar *</label>
                                <input type="text" :name="'teachers[' + index + '][name]'" x-model="teacher.name" required placeholder="Contoh: Ustadzah Adelia, S.Pd" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Jabatan / Guru Mapel *</label>
                                <input type="text" :name="'teachers[' + index + '][role]'" x-model="teacher.role" required placeholder="Contoh: Guru Matematika / Wali Kelas" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Foto Guru (Upload / URL)</label>
                                <div class="flex items-center gap-2">
                                    <template x-if="teacher.photo">
                                        <img :src="teacher.photo" class="w-8 h-8 rounded-full object-cover border border-slate-300 shrink-0">
                                    </template>
                                    <input type="file" :name="'teacher_photo_' + index" accept="image/*" class="w-full text-[10px] text-slate-600 border border-slate-300 rounded-xl p-1 bg-slate-50">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Section 6: PROGRAM UNGGULAN KHAS UNIT -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                        <span>⭐</span> <span>6. Program Unggulan Khas Unit {{ strtoupper($cleanCode) }}</span>
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Kelola 4 program unggulan yang menjadi ciri khas unit sekolah ini.</p>
                </div>
                <button type="button" @click="addProgram()" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-xs border border-slate-300 flex items-center gap-1.5 cursor-pointer">
                    <span>➕ Tambah Program</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(prog, index) in programs" :key="index">
                    <div class="p-4 rounded-2xl bg-white border border-slate-200 space-y-2 shadow-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-slate-800" x-text="'Program Unggulan #' + (index + 1)"></span>
                            <button type="button" @click="removeProgram(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" :name="'programs[' + index + '][icon]'" x-model="prog.icon" placeholder="Icon (📖)" class="w-16 text-center text-xs font-black rounded-xl border-slate-300">
                            <input type="text" :name="'programs[' + index + '][title]'" x-model="prog.title" placeholder="Judul Program (Tahfidz Al-Qur'an)" class="w-full text-xs font-black rounded-xl border-slate-300">
                        </div>
                        <textarea :name="'programs[' + index + '][desc]'" x-model="prog.desc" rows="2" placeholder="Deskripsi singkat program unggulan..." class="w-full text-xs font-medium rounded-xl border-slate-300"></textarea>
                    </div>
                </template>
            </div>
        </div>

        <!-- Section 7: FASILITAS KHAS UNIT -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                        <span>🏫</span> <span>7. Fasilitas Khas Unit {{ strtoupper($cleanCode) }}</span>
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Kelola fasilitas fisik &amp; sarana penunjang yang ditampilkan di web unit.</p>
                </div>
                <button type="button" @click="addFacility()" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-xs border border-slate-300 flex items-center gap-1.5 cursor-pointer">
                    <span>➕ Tambah Fasilitas</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(fac, index) in facilities" :key="index">
                    <div class="p-4 rounded-2xl bg-white border border-slate-200 space-y-2 shadow-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-slate-800" x-text="'Fasilitas #' + (index + 1)"></span>
                            <button type="button" @click="removeFacility(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <input type="text" :name="'facilities[' + index + '][icon]'" x-model="fac.icon" placeholder="Icon (🏫)" class="text-center text-xs font-black rounded-xl border-slate-300">
                            <input type="text" :name="'facilities[' + index + '][badge]'" x-model="fac.badge" placeholder="Badge (Ruang Kelas)" class="col-span-2 text-xs font-bold rounded-xl border-slate-300">
                        </div>
                        <input type="text" :name="'facilities[' + index + '][title]'" x-model="fac.title" placeholder="Nama Fasilitas (Ruang Kelas AC)" class="w-full text-xs font-black rounded-xl border-slate-300">
                        <textarea :name="'facilities[' + index + '][desc]'" x-model="fac.desc" rows="2" placeholder="Deskripsi fasilitas..." class="w-full text-xs font-medium rounded-xl border-slate-300"></textarea>
                    </div>
                </template>
            </div>
        </div>

        <!-- Section 8: EKSTRAKURIKULER & LIFE SKILL -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                        <span>🏹</span> <span>8. Ekstrakurikuler &amp; Life Skill Unit {{ strtoupper($cleanCode) }}</span>
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">Kelola pilihan kegiatan ekskul yang dapat diikuti siswa.</p>
                </div>
                <button type="button" @click="addEkskul()" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-black text-xs border border-slate-300 flex items-center gap-1.5 cursor-pointer">
                    <span>➕ Tambah Ekskul</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(eks, index) in ekskul" :key="index">
                    <div class="p-4 rounded-2xl bg-white border border-slate-200 space-y-2 shadow-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-slate-800" x-text="'Ekskul #' + (index + 1)"></span>
                            <button type="button" @click="removeEkskul(index)" class="text-xs text-rose-600 font-bold">🗑️ Hapus</button>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <input type="text" :name="'ekskul[' + index + '][icon]'" x-model="eks.icon" placeholder="Icon (🏹)" class="text-center text-xs font-black rounded-xl border-slate-300">
                            <input type="text" :name="'ekskul[' + index + '][badge]'" x-model="eks.badge" placeholder="Badge (Sunnah)" class="col-span-2 text-xs font-bold rounded-xl border-slate-300">
                        </div>
                        <input type="text" :name="'ekskul[' + index + '][title]'" x-model="eks.title" placeholder="Nama Ekskul (Memanah / Archery)" class="w-full text-xs font-black rounded-xl border-slate-300">
                        <textarea :name="'ekskul[' + index + '][desc]'" x-model="eks.desc" rows="2" placeholder="Deskripsi ekskul..." class="w-full text-xs font-medium rounded-xl border-slate-300"></textarea>
                    </div>
                </template>
            </div>
        </div>

        <!-- Section 9: Statistik Key Metrics Unit -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                <span>📊</span> <span>9. Statistik &amp; Capaian Unit</span>
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Siswa</label>
                    <input type="number" name="students_count" value="{{ old('students_count', $unitData['students_count'] ?? 450) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Guru/Tendik</label>
                    <input type="number" name="employees_count" value="{{ old('employees_count', $unitData['employees_count'] ?? 38) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Rombel</label>
                    <input type="number" name="classrooms_count" value="{{ old('classrooms_count', $unitData['classrooms_count'] ?? 18) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Target Hafalan</label>
                    <input type="text" name="target_hafalan" value="{{ old('target_hafalan', $unitData['target_hafalan'] ?? '3 - 5 Juz Mutqin') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Telepon / WhatsApp Admin Unit</label>
                <input type="text" name="phone" value="{{ old('phone', $unitData['phone'] ?? '0811747472') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.settings.units') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black shadow-md flex items-center gap-1.5 cursor-pointer">
                <span>💾 Simpan Seluruh Struktur &amp; Profil Web Unit {{ strtoupper($cleanCode) }}</span>
            </button>
        </div>

    </form>
</div>
@endsection
