@extends('admin.layout')

@section('title', 'Edit Profil Unit ' . strtoupper($cleanCode))

@section('content')
<div class="max-w-4xl space-y-6">
    
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.settings.units') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800">← Kembali ke Daftar Unit</a>
                <span class="text-slate-300">•</span>
                <span class="px-2.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-black text-[10px] uppercase">UNIT {{ strtoupper($cleanCode) }}</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Edit Profil Mandiri Unit {{ strtoupper($cleanCode) }}</h1>
            <p class="text-xs text-slate-600 font-medium mt-1">Perbarui data profil, foto & sambutan kepala sekolah, visi misi, serta statistik khusus unit ini secara mandiri.</p>
        </div>
        <a href="{{ route('school.unit', $cleanCode) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md flex items-center gap-1.5">
            <span>Lihat Tampilan Web Unit</span> ➔
        </a>
    </div>

    <form action="{{ route('admin.settings.units.update', $cleanCode) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        @csrf

        <!-- Section 1: Data Identitas Unit -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                <span>🏛️</span> <span>Identitas Utama Unit</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Resmi Unit Sekolah</label>
                    <input type="text" name="name" value="{{ old('name', $unitData['name'] ?? ($schoolObj->name ?? 'SDIT Robbani Ogan Ilir')) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">NPSN</label>
                    <input type="text" name="npsn" value="{{ old('npsn', $unitData['npsn'] ?? ($schoolObj->npsn ?? '69985678')) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Status Akreditasi</label>
                    <input type="text" name="akreditasi" value="{{ old('akreditasi', $unitData['akreditasi'] ?? 'Terakreditasi A (Unggul)') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Slogan / Tagline Khas Unit</label>
                    <input type="text" name="tagline" value="{{ old('tagline', $unitData['tagline'] ?? 'Mencetak Generasi Qur\'ani, Berkarakter Karimah, & Cerdas Sains') }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Deskripsi &amp; Profil Singkat Unit</label>
                <textarea name="description" rows="3" class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('description', $unitData['description'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Section 2: Kepala Sekolah & Sambutan -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                <span>👤</span> <span>Kepala Sekolah &amp; Sambutan</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Nama Kepala Sekolah &amp; Gelar</label>
                    <input type="text" name="principal_name" value="{{ old('principal_name', $unitData['principal_name'] ?? ($schoolObj->principal_name ?? 'Ustadz H. Ahmad Fauzi, S.Pd.I, M.Pd')) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Jabatan Resmi</label>
                    <input type="text" name="principal_title" value="{{ old('principal_title', $unitData['principal_title'] ?? ('Kepala Sekolah ' . strtoupper($cleanCode) . ' Robbani Ogan Ilir')) }}" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Foto Kepala Sekolah (Pilih File Foto)</label>
                <div class="flex items-center gap-4">
                    @if(isset($unitData['principal_photo']))
                    <img src="{{ $unitData['principal_photo'] }}" alt="Foto Kepsek" class="w-12 h-12 rounded-full object-cover border border-slate-200">
                    @endif
                    <input type="file" name="principal_photo" accept="image/*" class="text-xs text-slate-600 border border-slate-300 rounded-xl p-2 w-full">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Teks Sambutan Kepala Sekolah</label>
                <textarea name="principal_greeting" rows="3" class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('principal_greeting', $unitData['principal_greeting'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Section 3: Visi & Misi Unit -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                <span>🎯</span> <span>Visi &amp; Misi Unit</span>
            </h3>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Kalimat Visi Unit</label>
                <textarea name="vision" rows="2" class="w-full text-xs font-semibold rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>{{ old('vision', $unitData['vision'] ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Poin-Poin Misi Unit (Satu kalimat per baris)</label>
                <textarea name="missions_text" rows="4" class="w-full text-xs font-medium rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Menanamkan aqidah islami sejak dini...&#10;Menerapkan Kurikulum Merdeka...&#10;Mengembangkan sains &amp; koding...">{{ old('missions_text', isset($unitData['missions']) && is_array($unitData['missions']) ? implode("\n", $unitData['missions']) : '') }}</textarea>
            </div>
        </div>

        <!-- Section 4: Statistik Key Metrics Unit -->
        <div class="space-y-4 pb-6 border-b border-slate-200">
            <h3 class="text-sm font-black text-emerald-900 uppercase tracking-wider flex items-center gap-2">
                <span>📊</span> <span>Statistik &amp; Capaian Unit</span>
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
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black shadow-md flex items-center gap-1.5">
                <span>💾 Simpan Perubahan Profil Unit {{ strtoupper($cleanCode) }}</span>
            </button>
        </div>

    </form>
</div>
@endsection
