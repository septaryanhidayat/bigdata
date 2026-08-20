@extends('admin.layout')

@section('title', 'Manajemen Akun & Hak Akses Pengguna - SmartEdu SIT Robbani')

@section('content')
@php
    $rawUserList = isset($allUsers) ? $allUsers : $users;
    $usersJson = $rawUserList->map(function($u) {
        return [
            'id' => $u->id,
            'name' => $u->name,
            'email' => $u->email,
            'role' => $u->role,
            'role_label' => $u->role_name_label,
            'school_id' => $u->school_id,
            'school_name' => $u->school->name ?? 'Yayasan Robbani (Semua Unit)',
            'phone' => $u->phone ?? '-',
            'is_active' => (bool)$u->is_active,
            'employee_name' => $u->employee->full_name ?? null,
            'employee_nip' => $u->employee->nip ?? null,
            'created_at' => $u->created_at ? $u->created_at->format('d/m/Y') : '-',
        ];
    })->values();
@endphp

<div class="space-y-6" x-data="{ 
    createModalOpen: false, 
    editModalOpen: false, 
    resetModalOpen: false,
    perPage: 25,
    currentPage: 1,
    searchQuery: '',
    roleFilter: 'all',
    schoolFilter: 'all',
    allData: {{ json_encode($usersJson) }},
    currentUser: { id: null, name: '', email: '', role: '', school_id: '', phone: '', is_active: true, employee_id: '' },
    
    get filteredData() {
        return this.allData.filter(u => {
            const matchesSearch = !this.searchQuery || 
                u.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                u.email.toLowerCase().includes(this.searchQuery.toLowerCase()) || 
                (u.phone && u.phone.includes(this.searchQuery));
            
            const matchesRole = this.roleFilter === 'all' || u.role === this.roleFilter;
            const matchesSchool = this.schoolFilter === 'all' || 
                (this.schoolFilter === 'yayasan' ? !u.school_id : String(u.school_id) === String(this.schoolFilter));
            
            return matchesSearch && matchesRole && matchesSchool;
        });
    },

    get paginatedData() {
        if (this.perPage === 'all') return this.filteredData;
        const limit = parseInt(this.perPage);
        const start = (this.currentPage - 1) * limit;
        return this.filteredData.slice(start, start + limit);
    },

    get totalPages() {
        if (this.perPage === 'all') return 1;
        return Math.ceil(this.filteredData.length / parseInt(this.perPage)) || 1;
    },

    openEditModal(user) {
        this.currentUser = { ...user };
        this.editModalOpen = true;
    },
    openResetModal(user) {
        this.currentUser = { ...user };
        this.resetModalOpen = true;
    }
}">

    <!-- Top Header Banner (Pure Light Mode) -->
    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1.5">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black border border-emerald-300">
                <span>👥</span>
                <span>PUSAT KONTROL &amp; KEAMANAN AKUN</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Manajemen Akun &amp; Otoritas Role Pengguna
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 max-w-2xl font-medium leading-relaxed">
                Kelola data pengguna, kredensial login, wewenang peran (RBAC), unit kerja, serta reset password secara terpusat dan aman.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.users.export') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs border border-slate-300 transition-all flex items-center gap-2 shadow-xs">
                <span>📥</span>
                <span>Ekspor CSV</span>
            </a>
            <button @click="createModalOpen = true" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black text-xs shadow-md transition-all flex items-center gap-2 cursor-pointer">
                <span>➕</span>
                <span>Tambah Akun Baru</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-100 border border-emerald-300 text-emerald-900 text-xs font-bold flex items-center gap-3">
        <span class="text-base">✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 rounded-2xl bg-rose-100 border border-rose-300 text-rose-900 text-xs font-bold flex items-center gap-3">
        <span class="text-base">⛔</span>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Metric Summary Cards (Pure Light Mode) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs space-y-1">
            <span class="text-slate-500 text-[11px] font-bold block uppercase tracking-wider">Total Akun Terdaftar</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900" x-text="allData.length"></span>
                <span class="text-[10px] font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full border border-emerald-300">Aktif</span>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs space-y-1">
            <span class="text-slate-500 text-[11px] font-bold block uppercase tracking-wider">Pimpinan &amp; Admin</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900">{{ $adminCount }}</span>
                <span class="text-[10px] font-extrabold text-purple-800 bg-purple-100 px-2 py-0.5 rounded-full border border-purple-300">Super Admin &amp; Yayasan</span>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs space-y-1">
            <span class="text-slate-500 text-[11px] font-bold block uppercase tracking-wider">Kepsek &amp; Guru</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900">{{ $headmasterCount + $teacherCount }}</span>
                <span class="text-[10px] font-extrabold text-blue-800 bg-blue-100 px-2 py-0.5 rounded-full border border-blue-300">Pengajar</span>
            </div>
        </div>

        <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs space-y-1">
            <span class="text-slate-500 text-[11px] font-bold block uppercase tracking-wider">Staf &amp; Tendik</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900">{{ $staffCount }}</span>
                <span class="text-[10px] font-extrabold text-amber-800 bg-amber-100 px-2 py-0.5 rounded-full border border-amber-300">TU, Keuangan, BK, dll</span>
            </div>
        </div>
    </div>

    <!-- Filter Bar & Dynamic Rows-Per-Page Selector -->
    <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs space-y-4">
        <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
            
            <!-- Live Search Input -->
            <div class="relative flex-1">
                <span class="absolute left-3.5 top-3 text-slate-400 text-sm">🔍</span>
                <input type="text" x-model="searchQuery" @input="currentPage = 1" placeholder="Cari nama pengguna, email, atau no. telepon..." class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-xs font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:bg-white">
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <!-- Filter Peran -->
                <select x-model="roleFilter" @change="currentPage = 1" class="px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    <option value="all">Semua Peran (Role)</option>
                    @foreach($roleOptions as $roleKey => $roleLabel)
                        <option value="{{ $roleKey }}">{{ $roleLabel }}</option>
                    @endforeach
                </select>

                <!-- Filter Unit Kerja -->
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isYayasan())
                <select x-model="schoolFilter" @change="currentPage = 1" class="px-3.5 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    <option value="all">Semua Unit Kerja</option>
                    <option value="yayasan">Yayasan Robbani (Semua Unit)</option>
                    @foreach($schools as $sc)
                        <option value="{{ $sc->id }}">{{ $sc->name }}</option>
                    @endforeach
                </select>
                @endif

                <!-- ROWS PER PAGE SELECTOR (25, 50, 100, 500, ALL) - ZERO PAGE RELOAD -->
                <div class="flex items-center gap-2 border-l border-slate-300 pl-3">
                    <label class="text-xs font-black text-slate-700 whitespace-nowrap">Tampilkan:</label>
                    <select x-model="perPage" @change="currentPage = 1" class="px-3 py-2.5 rounded-xl bg-emerald-50 border border-emerald-300 text-xs font-black text-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-600 cursor-pointer">
                        <option value="25">25 Baris</option>
                        <option value="50">50 Baris</option>
                        <option value="100">100 Baris</option>
                        <option value="500">500 Baris</option>
                        <option value="all">Semua Data</option>
                    </select>
                </div>
            </div>

        </div>
    </div>

    <!-- Main Data Table (Pure Light Mode) -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-100/90 text-slate-700 font-black border-b border-slate-200">
                        <th class="py-3.5 px-4 w-12 text-center">#</th>
                        <th class="py-3.5 px-4">PENGGUNA</th>
                        <th class="py-3.5 px-4">PERAN / ROLE</th>
                        <th class="py-3.5 px-4">UNIT KERJA</th>
                        <th class="py-3.5 px-4">PEGAWAI TERKAIT</th>
                        <th class="py-3.5 px-4 text-center">STATUS AKUN</th>
                        <th class="py-3.5 px-4 text-center w-28">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-800 font-medium">
                    <template x-for="(user, index) in paginatedData" :key="user.id">
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <!-- Number -->
                            <td class="py-3.5 px-4 text-center text-slate-500 font-bold" x-text="(perPage === 'all' ? 0 : (currentPage - 1) * parseInt(perPage)) + index + 1"></td>
                            
                            <!-- Pengguna Info -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-900 border border-emerald-300 font-black flex items-center justify-center text-xs shrink-0" x-text="user.name.substring(0, 2).toUpperCase()"></div>
                                    <div>
                                        <span class="font-black text-slate-900 block text-xs" x-text="user.name"></span>
                                        <span class="text-[11px] text-slate-500 font-semibold block" x-text="user.email"></span>
                                        <span class="text-[10px] text-slate-400 block" x-text="'📱 ' + user.phone"></span>
                                    </div>
                                </div>
                            </td>

                            <!-- Role Badge -->
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black inline-block border" 
                                      :class="{
                                          'bg-purple-100 text-purple-900 border-purple-300': user.role === 'SUPER_ADMIN' || user.role === 'YAYASAN_CHAIRMAN',
                                          'bg-blue-100 text-blue-900 border-blue-300': user.role === 'HEADMASTER',
                                          'bg-emerald-100 text-emerald-900 border-emerald-300': user.role === 'TEACHER',
                                          'bg-amber-100 text-amber-900 border-amber-300': user.role !== 'SUPER_ADMIN' &amp;&amp; user.role !== 'YAYASAN_CHAIRMAN' &amp;&amp; user.role !== 'HEADMASTER' &amp;&amp; user.role !== 'TEACHER'
                                      }"
                                      x-text="user.role_label">
                                </span>
                            </td>

                            <!-- Unit Kerja -->
                            <td class="py-3.5 px-4">
                                <span class="font-extrabold text-slate-800 text-[11px]" x-text="user.school_name"></span>
                            </td>

                            <!-- Pegawai Terkait -->
                            <td class="py-3.5 px-4">
                                <template x-if="user.employee_name">
                                    <div>
                                        <span class="font-bold text-slate-900 block" x-text="user.employee_name"></span>
                                        <span class="text-[10px] text-slate-500 block" x-text="'NIP: ' + (user.employee_nip || '-')"></span>
                                    </div>
                                </template>
                                <template x-if="!user.employee_name">
                                    <span class="text-slate-400 italic text-[11px]">- Tidak Terikat Pegawai -</span>
                                </template>
                            </td>

                            <!-- Status Akun -->
                            <td class="py-3.5 px-4 text-center">
                                <template x-if="user.is_active">
                                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 text-[10px] font-black inline-block">✓ Aktif</span>
                                </template>
                                <template x-if="!user.is_active">
                                    <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 border border-rose-300 text-[10px] font-black inline-block">✕ Non-Aktif</span>
                                </template>
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button @click="openEditModal(user)" title="Edit Akun" class="p-1.5 rounded-lg bg-slate-100 hover:bg-emerald-100 text-slate-700 hover:text-emerald-900 border border-slate-300 transition-colors cursor-pointer">
                                        ✏️
                                    </button>
                                    <button @click="openResetModal(user)" title="Reset Password" class="p-1.5 rounded-lg bg-slate-100 hover:bg-amber-100 text-slate-700 hover:text-amber-900 border border-slate-300 transition-colors cursor-pointer">
                                        🔑
                                    </button>
                                    <form :action="'/admin/users/' + user.id" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Akun" class="p-1.5 rounded-lg bg-slate-100 hover:bg-rose-100 text-slate-700 hover:text-rose-900 border border-slate-300 transition-colors cursor-pointer">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </template>

                    <!-- Empty State -->
                    <template x-if="filteredData.length === 0">
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-500 font-bold">
                                🔍 Tidak ada akun pengguna yang sesuai dengan kriteria pencarian atau filter.
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Dynamic Pagination Controls (Zero Page Reload) -->
        <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <span class="text-slate-600 font-semibold">
                Menampilkan <strong x-text="paginatedData.length"></strong> dari <strong x-text="filteredData.length"></strong> total akun pengguna.
            </span>

            <template x-if="perPage !== 'all' &amp;&amp; totalPages > 1">
                <div class="flex items-center gap-1">
                    <button @click="currentPage = Math.max(1, currentPage - 1)" :disabled="currentPage === 1" class="px-3 py-1.5 rounded-lg bg-white border border-slate-300 font-bold text-slate-700 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed">
                        ❮ Prev
                    </button>
                    <span class="px-3 py-1.5 font-black text-slate-900" x-text="'Halaman ' + currentPage + ' dari ' + totalPages"></span>
                    <button @click="currentPage = Math.min(totalPages, currentPage + 1)" :disabled="currentPage === totalPages" class="px-3 py-1.5 rounded-lg bg-white border border-slate-300 font-bold text-slate-700 hover:bg-slate-100 disabled:opacity-40 disabled:cursor-not-allowed">
                        Next ❯
                    </button>
                </div>
            </template>
        </div>
    </div>

    <!-- MODAL 1: Tambah Akun Baru -->
    <div x-show="createModalOpen" x-cloak class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="createModalOpen = false" class="bg-white rounded-3xl border border-slate-300 w-full max-w-lg p-6 sm:p-8 space-y-6 shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                    <span>➕</span> <span>Tambah Akun Pengguna Baru</span>
                </h3>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-slate-700 font-black text-lg">✕</button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4 text-xs font-semibold">
                @csrf
                <div class="space-y-1">
                    <label class="block font-black text-slate-800">Nama Lengkap Pengguna *</label>
                    <input type="text" name="name" required placeholder="Contoh: Ustadz Ahmad Fauzi, S.Pd" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block font-black text-slate-800">Alamat Email *</label>
                        <input type="email" name="email" required placeholder="email@sitrobbani.sch.id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div class="space-y-1">
                        <label class="block font-black text-slate-800">Password Login *</label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block font-black text-slate-800">Peran / Otoritas Role *</label>
                        <select name="role" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            @foreach($roleOptions as $roleKey => $roleLabel)
                                <option value="{{ $roleKey }}">{{ $roleLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block font-black text-slate-800">Unit Kerja Sekolah</label>
                        <select name="school_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="">🏢 Yayasan Robbani (Semua Unit)</option>
                            @foreach($schools as $sc)
                                <option value="{{ $sc->id }}">🏫 {{ $sc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block font-black text-slate-800">Tautkan ke Data Pegawai / SDM (Opsional)</label>
                    <select name="employee_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-semibold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                        <option value="">- Tanpa Tautan Pegawai -</option>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}">{{ $emp->full_name }} (NIP: {{ $emp->nip ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black shadow-md">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: Edit Akun -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="editModalOpen = false" class="bg-white rounded-3xl border border-slate-300 w-full max-w-lg p-6 sm:p-8 space-y-6 shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                    <span>✏️</span> <span>Edit Data Akun Pengguna</span>
                </h3>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-slate-700 font-black text-lg">✕</button>
            </div>

            <form :action="'/admin/users/' + currentUser.id" method="POST" class="space-y-4 text-xs font-semibold">
                @csrf
                @method('PUT')
                <div class="space-y-1">
                    <label class="block font-black text-slate-800">Nama Lengkap *</label>
                    <input type="text" name="name" x-model="currentUser.name" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block font-black text-slate-800">Email *</label>
                        <input type="email" name="email" x-model="currentUser.email" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                    </div>
                    <div class="space-y-1">
                        <label class="block font-black text-slate-800">Peran / Role *</label>
                        <select name="role" x-model="currentUser.role" required class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            @foreach($roleOptions as $roleKey => $roleLabel)
                                <option value="{{ $roleKey }}">{{ $roleLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block font-black text-slate-800">Unit Kerja Sekolah</label>
                        <select name="school_id" x-model="currentUser.school_id" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option value="">🏢 Yayasan Robbani (Semua Unit)</option>
                            @foreach($schools as $sc)
                                <option value="{{ $sc->id }}">🏫 {{ $sc->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="block font-black text-slate-800">Status Akun</label>
                        <select name="is_active" x-model="currentUser.is_active" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600">
                            <option :value="true">✓ Aktif</option>
                            <option :value="false">✕ Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black shadow-md">Perbarui Akun</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: Reset Password -->
    <div x-show="resetModalOpen" x-cloak class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="resetModalOpen = false" class="bg-white rounded-3xl border border-slate-300 w-full max-w-md p-6 sm:p-8 space-y-5 shadow-2xl">
            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🔑</span> <span>Reset Password Pengguna</span>
                </h3>
                <button @click="resetModalOpen = false" class="text-slate-400 hover:text-slate-700 font-black text-lg">✕</button>
            </div>

            <form :action="'/admin/users/' + currentUser.id + '/reset-password'" method="POST" class="space-y-4 text-xs font-semibold">
                @csrf
                <p class="text-slate-600">
                    Setel ulang kata sandi login untuk pengguna <strong class="text-slate-900" x-text="currentUser.name"></strong> (<span x-text="currentUser.email"></span>).
                </p>

                <div class="space-y-1">
                    <label class="block font-black text-slate-800">Password Baru *</label>
                    <input type="password" name="new_password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">
                    <button type="button" @click="resetModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-black shadow-md">Reset Password</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
