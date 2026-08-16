@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 1: Sub-Modul 1 & 9</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Multi-Sekolah & Profil Yayasan</h1>
            <p class="text-xs text-slate-500 font-medium">Kelola banyak unit sekolah dalam 1 instalasi Siakad, edit data profil unit, warna brand, & logo (auto WebP <50KB).</p>
        </div>
    </div>

    <!-- Active School Switcher Box -->
    <div class="bg-gradient-to-r from-emerald-900 to-slate-900 text-white p-6 rounded-2xl border border-emerald-800 shadow-lg space-y-4">
        <div class="flex items-center justify-between">
            <span class="text-xs font-bold text-emerald-300 uppercase tracking-wider">Unit Sekolah Aktif Sesi Ini</span>
            <span class="px-2.5 py-0.5 rounded-full bg-emerald-500 text-slate-950 text-[10px] font-black">MULTI-TENANT ACTIVE</span>
        </div>
        
        <form action="{{ route('admin.master.switch-school') }}" method="POST" class="flex items-center gap-3">
            @csrf
            <select name="school_id" class="flex-1 px-4 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white font-bold text-xs focus:ring-2 focus:ring-emerald-400">
                @foreach($schools as $sc)
                <option value="{{ $sc->id }}" {{ session('active_school_id') == $sc->id ? 'selected' : '' }}>
                    🏛️ {{ $sc->name }} (NPSN: {{ $sc->npsn }})
                </option>
                @endforeach
            </select>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-400 text-slate-950 font-black text-xs hover:bg-amber-300 transition-colors shadow">
                Switch Active School ➔
            </button>
        </form>
    </div>

    <!-- School List Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($schools as $sc)
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    @if($sc->logo_url)
                        <img src="{{ asset($sc->logo_url) }}" alt="Logo {{ $sc->name }}" class="w-10 h-10 object-contain rounded-lg border p-1">
                    @endif
                    <span class="px-3 py-1 rounded-full text-xs font-black text-white" style="background-color: {{ $sc->theme_color }}">
                        {{ $sc->code }}
                    </span>
                </div>
                <span class="text-xs text-slate-400 font-bold">ID: #{{ $sc->id }}</span>
            </div>

            <div>
                <h3 class="text-lg font-black text-slate-900">{{ $sc->name }}</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">NPSN: {{ $sc->npsn ?? '-' }} • Kepsek: {{ $sc->principal_name ?? '-' }}</p>
                <p class="text-xs text-slate-600 mt-2">📍 {{ $sc->address ?? 'Alamat belum diatur' }}</p>
                <p class="text-xs text-slate-500">📞 {{ $sc->phone ?? '-' }} • ✉️ {{ $sc->email ?? '-' }}</p>
            </div>

            <div class="grid grid-cols-3 gap-2 pt-3 border-t border-slate-100 text-center text-xs">
                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Rombel</span>
                    <span class="font-extrabold text-slate-900">{{ $sc->classrooms_count }}</span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Staf Guru</span>
                    <span class="font-extrabold text-slate-900">{{ $sc->employees_count }}</span>
                </div>
                <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-200">
                    <span class="block text-[10px] text-slate-400 font-bold uppercase">Siswa</span>
                    <span class="font-extrabold text-slate-900">{{ $sc->students_count }}</span>
                </div>
            </div>

            <!-- Form Edit Profil Sekolah -->
            <details class="group pt-2 border-t border-slate-100">
                <summary class="cursor-pointer font-extrabold text-xs text-emerald-700 hover:text-emerald-800 flex items-center justify-between">
                    <span>✏️ Edit Profil & Logo Unit Sekolah</span>
                    <span class="text-slate-400 group-open:rotate-180 transition-transform">▼</span>
                </summary>

                <form action="{{ route('admin.master.schools.update', $sc->id) }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-3 text-xs font-bold">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-slate-700 mb-1">Nama Sekolah</label>
                        <input type="text" name="name" value="{{ $sc->name }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-slate-700 mb-1">NPSN</label>
                            <input type="text" name="npsn" value="{{ $sc->npsn }}" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Warna Tema</label>
                            <input type="color" name="theme_color" value="{{ $sc->theme_color }}" class="w-full h-9 rounded-xl border border-slate-300 cursor-pointer">
                        </div>
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Nama Kepala Sekolah</label>
                        <input type="text" name="principal_name" value="{{ $sc->principal_name }}" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>

                    <div>
                        <label class="block text-slate-700 mb-1">Alamat Sekolah</label>
                        <input type="text" name="address" value="{{ $sc->address }}" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-slate-700 mb-1">No HP / Telepon</label>
                            <input type="text" name="phone" value="{{ $sc->phone }}" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                        </div>
                        <div>
                            <label class="block text-slate-700 mb-1">Email Sekolah</label>
                            <input type="email" name="email" value="{{ $sc->email }}" class="w-full px-3 py-2 rounded-xl border border-slate-300">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        <div>
                            <label class="block text-slate-700 mb-1">Unggah Logo Unit (Tengah KOP)</label>
                            <input type="file" name="logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-800">
                            @if($sc->logo_url)
                                <div class="mt-1 flex items-center gap-1.5 text-[10px] text-emerald-700">
                                    <span>✓ Logo terpasang:</span>
                                    <img src="{{ asset($sc->logo_url) }}" class="w-6 h-6 object-contain border p-0.5 rounded">
                                </div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-slate-700 mb-1">Unggah Banner KOP Surat (Opsional)</label>
                            <input type="file" name="kop_letterhead" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-100 file:text-blue-800">
                            @if($sc->kop_image_url)
                                <div class="mt-1 flex items-center gap-1.5 text-[10px] text-blue-700">
                                    <span>✓ KOP terpasang:</span>
                                    <a href="{{ asset($sc->kop_image_url) }}" target="_blank" class="underline font-mono">Lihat Banner</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2.5 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition-colors shadow">
                        Simpan Perubahan Unit Sekolah ➔
                    </button>
                </form>
            </details>
        </div>
        @endforeach
    </div>

    <!-- Form Add Unit Sekolah -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="font-black text-base text-slate-900">➕ Tambah Unit Sekolah Yayasan Baru</h3>

        <form action="{{ route('admin.master.schools.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Kode Unit (Misal: SDIT, SMPIT)</label>
                <input type="text" name="code" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="SMPIT">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Nama Lengkap Sekolah</label>
                <input type="text" name="name" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="SMP Islam Terpadu Robbani">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">NPSN Sekolah</label>
                <input type="text" name="npsn" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="20198033">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Nama Kepala Sekolah</label>
                <input type="text" name="principal_name" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300" placeholder="Ustadz Sri Nurhidayat, M.Pd">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Warna Tema Brand (Hex Code)</label>
                <input type="color" name="theme_color" value="#059669" class="w-full h-10 rounded-xl border border-slate-300 cursor-pointer">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Logo Sekolah (Auto WebP <50KB)</label>
                <input type="file" name="logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-emerald-100 file:text-emerald-800">
            </div>

            <div class="md:col-span-2">
                <label class="block text-slate-700 mb-1">Upload Banner KOP Surat Resmi Unit (Opsional)</label>
                <input type="file" name="kop_letterhead" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-100 file:text-blue-800">
                <span class="text-[10px] text-slate-400 font-normal">Jika diunggah, gambar banner KOP ini akan langsung digunakan pada bagian atas setiap cetak PDF surat dinas.</span>
            </div>

            <div class="md:col-span-2 pt-2">
                <button type="submit" class="px-6 py-3 rounded-xl bg-emerald-600 text-white font-extrabold hover:bg-emerald-700 transition-colors shadow">
                    Simpan Unit Sekolah Baru ➔
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
