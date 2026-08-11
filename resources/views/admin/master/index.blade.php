@extends('admin.layout')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-extrabold text-[10px] uppercase">Modul 1: Fondasi Utuh</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Modul 1: Master Data & Referensi Akademik</h1>
            <p class="text-xs text-slate-500 font-medium">Fondasi data seluruh sistem Siakad Robbani. Kelola multi-unit sekolah, kurikulum adaptif, rombel, guru, karyawan, & siswa.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('admin.master.schools') }}" class="px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-extrabold text-xs shadow hover:bg-emerald-700 transition-colors">
                🏛️ Kelola Unit Sekolah
            </a>
        </div>
    </div>

    <!-- Active School Context Banner -->
    <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-emerald-900 text-white p-6 rounded-2xl border border-emerald-800 shadow-xl flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="space-y-1">
            <span class="text-[10px] text-amber-300 font-extrabold uppercase tracking-wider block">Sekolah Aktif Sesi Ini (Multi-Tenant Swappable)</span>
            <h3 class="text-xl font-black text-white">{{ $activeSchool->name ?? 'SIT Robbani' }} ({{ $activeSchool->code ?? 'SIT' }})</h3>
            <p class="text-xs text-slate-300 font-medium">NPSN: {{ $activeSchool->npsn ?? '-' }} • Kepsek: {{ $activeSchool->principal_name ?? '-' }}</p>
        </div>

        <form action="{{ route('admin.master.switch-school') }}" method="POST" class="flex items-center gap-2 w-full md:w-auto">
            @csrf
            <select name="school_id" class="px-3.5 py-2 rounded-xl bg-slate-800 border border-slate-700 text-white font-bold text-xs">
                @foreach($schools as $sc)
                    <option value="{{ $sc->id }}" {{ session('active_school_id') == $sc->id ? 'selected' : '' }}>{{ $sc->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 rounded-xl bg-amber-400 text-slate-950 font-black text-xs hover:bg-amber-300">
                Switch ➔
            </button>
        </form>
    </div>

    <!-- 10 Sub-Modules Quick Links Grid -->
    <div class="space-y-4">
        <h3 class="text-base font-black text-slate-900 tracking-tight">Daftar 10 Sub-Modul Master Data & Referensi</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            
            <!-- Sub 1 & 9 -->
            <a href="{{ route('admin.master.schools') }}" class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all space-y-2 block group">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 text-xl flex items-center justify-center font-bold">🏛️</span>
                    <span class="text-[10px] font-black text-emerald-700 uppercase">Sub 1 & 9</span>
                </div>
                <h4 class="font-extrabold text-sm text-slate-900 group-hover:text-emerald-700 transition-colors">Multi-Sekolah & Profil Yayasan</h4>
                <p class="text-xs text-slate-500 leading-relaxed font-normal">Kelola banyak unit sekolah dalam 1 instalasi, profil NPSN, logo, alamat, dan kepala sekolah.</p>
            </a>

            <!-- Sub 3 & 4 -->
            <a href="{{ route('admin.master.curriculums') }}" class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all space-y-2 block group">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-blue-100 text-blue-800 text-xl flex items-center justify-center font-bold">📜</span>
                    <span class="text-[10px] font-black text-blue-700 uppercase">Sub 3 & 4</span>
                </div>
                <h4 class="font-extrabold text-sm text-slate-900 group-hover:text-blue-700 transition-colors">Kurikulum & Tahun Akademik</h4>
                <p class="text-xs text-slate-500 leading-relaxed font-normal">Pengaturan Kurikulum K13, Merdeka, JSIT, semester ganjil/genap, & tanggal efektif.</p>
            </a>

            <!-- Sub 5 -->
            <a href="{{ route('admin.master.classrooms') }}" class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all space-y-2 block group">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-purple-100 text-purple-800 text-xl flex items-center justify-center font-bold">🏫</span>
                    <span class="text-[10px] font-black text-purple-700 uppercase">Sub 5</span>
                </div>
                <h4 class="font-extrabold text-sm text-slate-900 group-hover:text-purple-700 transition-colors">Tingkat & Rombel Kelas</h4>
                <p class="text-xs text-slate-500 leading-relaxed font-normal">Tingkat jenjang, rombel/kelas, kapasitas kuota siswa, & penetapan wali kelas.</p>
            </a>

            <!-- Sub 6 -->
            <a href="{{ route('admin.master.students') }}" class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all space-y-2 block group">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 text-xl flex items-center justify-center font-bold">🎓</span>
                    <span class="text-[10px] font-black text-amber-700 uppercase">Sub 6</span>
                </div>
                <h4 class="font-extrabold text-sm text-slate-900 group-hover:text-amber-700 transition-colors">Data Siswa & Wali Murid</h4>
                <p class="text-xs text-slate-500 leading-relaxed font-normal">CRUD biodata siswa, tag RFID gate, status aktif/lulus/mutasi, & import/export data.</p>
            </a>

            <!-- Sub 7 & 8 -->
            <a href="{{ route('admin.master.teachers') }}" class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all space-y-2 block group">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-teal-100 text-teal-800 text-xl flex items-center justify-center font-bold">👨‍🏫</span>
                    <span class="text-[10px] font-black text-teal-700 uppercase">Sub 7 & 8</span>
                </div>
                <h4 class="font-extrabold text-sm text-slate-900 group-hover:text-teal-700 transition-colors">Guru & Karyawan Non-Guru</h4>
                <p class="text-xs text-slate-500 leading-relaxed font-normal">Data guru pengampu, TU, cleaning service, security, & akun portal login.</p>
            </a>

            <!-- Sub 10 -->
            <a href="{{ route('admin.master.references') }}" class="p-5 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all space-y-2 block group">
                <div class="flex items-center justify-between">
                    <span class="w-10 h-10 rounded-xl bg-rose-100 text-rose-800 text-xl flex items-center justify-center font-bold">📑</span>
                    <span class="text-[10px] font-black text-rose-700 uppercase">Sub 10</span>
                </div>
                <h4 class="font-extrabold text-sm text-slate-900 group-hover:text-rose-700 transition-colors">Referensi Mapel & Ruangan</h4>
                <p class="text-xs text-slate-500 leading-relaxed font-normal">Katalog mata pelajaran (PAI/K13/Merdeka), lab CBT, & ruang kelas.</p>
            </a>

        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 text-center space-y-1">
            <h4 class="text-3xl font-black text-emerald-700">{{ $studentsCount }}</h4>
            <p class="text-xs text-slate-500 font-bold uppercase">Total Siswa Active</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 text-center space-y-1">
            <h4 class="text-3xl font-black text-blue-700">{{ $teachersCount }}</h4>
            <p class="text-xs text-slate-500 font-bold uppercase">Guru & Pendidik</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 text-center space-y-1">
            <h4 class="text-3xl font-black text-purple-700">{{ $classroomsCount }}</h4>
            <p class="text-xs text-slate-500 font-bold uppercase">Rombel Kelas</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-200 text-center space-y-1">
            <h4 class="text-3xl font-black text-amber-700">{{ $schools->count() }}</h4>
            <p class="text-xs text-slate-500 font-bold uppercase">Unit Sekolah Yayasan</p>
        </div>
    </div>
</div>
@endsection
