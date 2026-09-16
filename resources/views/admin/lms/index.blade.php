@extends('admin.layout')

@section('title', 'E-Learning LMS & Modul KBM')

@section('content')
<div class="space-y-6">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-black text-[10px] uppercase border border-blue-200">Modul 11: E-Learning LMS</span>
                <span class="w-2 h-2 rounded-full bg-blue-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                💻 E-Learning LMS & Materi Pembelajaran KBM
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Upload materi PDF/Video interaktif, penugasan mandiri siswa, forum diskusi, & Live Class.</p>
        </div>

        <button onclick="document.getElementById('addLmsModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center gap-2">
            <span>+</span> Upload Materi Baru
        </button>
    </div>

    <!-- Grid of LMS Materials -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($materials as $mat)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4 hover:shadow-md transition-all flex flex-col justify-between">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 font-black text-[10px] uppercase">{{ $mat->subject_name }}</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-purple-600 text-white font-black text-[10px]">{{ $mat->type }}</span>
                </div>
                <h3 class="font-black text-slate-900 text-base leading-snug">{{ $mat->title }}</h3>
                <p class="text-xs text-slate-600 font-medium">{{ $mat->description ?? 'Materi pembelajaran e-learning aktif' }}</p>
            </div>

            <div class="space-y-3 pt-3 border-t border-slate-100">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] text-slate-500 font-bold">Unit: {{ $mat->school->name ?? 'Semua Unit' }}</span>
                    <form action="{{ route('admin.lms.destroy', $mat->id) }}" method="POST" onsubmit="return confirm('Hapus materi pembelajaran ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-rose-600 hover:text-rose-700 font-bold text-[11px] p-1">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>

                @if(!empty($mat->file_url) && $mat->file_url !== '#')
                    <a href="{{ $mat->file_url }}" target="_blank" class="w-full py-2 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs font-black flex items-center justify-center gap-1.5 transition-colors">
                        <span>Akses Materi KBM</span> ➔
                    </a>
                @else
                    <span class="block w-full py-2 rounded-xl bg-slate-100 text-slate-500 text-xs font-bold text-center">
                        Materi Penugasan Kelas
                    </span>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 p-12 bg-white rounded-3xl text-center text-slate-400 italic border border-slate-100">
            Belum ada materi E-Learning terunggah. Silakan klik tombol Upload Materi Baru di atas.
        </div>
        @endforelse
    </div>

</div>

<!-- Modal Upload LMS -->
<div id="addLmsModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-md w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Upload Materi Pembelajaran LMS</h3>
            <button onclick="document.getElementById('addLmsModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.lms.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Mata Pelajaran:</label>
                <input type="text" name="subject_name" required placeholder="Contoh: Pendidikan Agama Islam (PAI)" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Judul Materi Pembelajaran:</label>
                <input type="text" name="title" required placeholder="Contoh: Bab 1 Adab & Akhlak Penuntut Ilmu" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Tipe Media Pembelajaran:</label>
                <select name="type" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <option value="PDF">E-Book / Modul PDF</option>
                    <option value="VIDEO">Video Tutorial / Interaktif</option>
                    <option value="ASSIGNMENT">Tugas Mandiri Siswa</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Upload File Dokumen / Video (Opsional):</label>
                <input type="file" name="material_file" accept=".pdf,.doc,.docx,.ppt,.pptx,.mp4,.zip" class="w-full p-2.5 rounded-2xl bg-slate-50 border border-slate-200 file:mr-3 file:py-1 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-900 file:text-white">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Atau Tautan URL Eksternal (YouTube / Drive):</label>
                <input type="url" name="external_url" placeholder="https://youtube.com/watch?v=..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Deskripsi Singkat:</label>
                <textarea name="description" rows="2" placeholder="Ringkasan atau petunjuk belajar bagi siswa..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200"></textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addLmsModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600 font-bold">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Upload Materi</button>
            </div>
        </form>
    </div>
</div>
@endsection
