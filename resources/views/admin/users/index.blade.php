@extends('admin.layout')

@section('title', 'Manajemen Akun & Hak Akses Pengguna - SmartEdu SIT Robbani')

@section('content')
<div class="space-y-6" x-data="{ 
    createModalOpen: false, 
    editModalOpen: false, 
    resetModalOpen: false,
    currentUser: { id: null, name: '', email: '', role: '', school_id: '', phone: '', is_active: true, employee_id: '' },
    openEditModal(user) {
        this.currentUser = { ...user };
        this.editModalOpen = true;
    },
    openResetModal(user) {
        this.currentUser = { ...user };
        this.resetModalOpen = true;
    }
}">

    <!-- Top Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 border border-slate-800 p-6 sm:p-8 shadow-2xl">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-black border border-indigo-500/30">
                    <span>👥</span>
                    <span>PUSAT KONTROL & KEAMANAN AKUN</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    Manajemen Akun & Otoritas Role Pengguna
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-2xl font-medium leading-relaxed">
                    Kelola seluruh data pengguna, kredensial login, wewenang peran (RBAC), unit kerja, serta reset password secara terpusat dan aman.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.users.export') }}" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs border border-slate-700 transition-all flex items-center gap-2 shadow-md">
                    <span>📥</span>
                    <span>Ekspor CSV</span>
                </a>
                <button @click="createModalOpen = true" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black text-xs shadow-lg shadow-emerald-500/20 transition-all flex items-center gap-2 hover:scale-[1.02]">
                    <span>➕</span>
                    <span>Tambah Akun Baru</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
    <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold flex items-center gap-3">
        <span class="text-base">✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs font-bold flex items-center gap-3">
        <span class="text-base">⛔</span>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs font-bold space-y-1">
        <div class="flex items-center gap-2 font-black">
            <span>⚠️</span>
            <span>Terdapat kesalahan pada input form:</span>
        </div>
        <ul class="list-disc list-inside pl-4 font-medium">
            @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Metric Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-5 rounded-2xl bg-[#1d1f27] border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-slate-400 text-xs font-bold">
                <span>Total Pengguna</span>
                <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-400">👥</span>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-white">{{ $totalUsers }}</p>
            <p class="text-[10px] text-emerald-400 font-bold flex items-center gap-1">
                <span>●</span> {{ $activeUsers }} Akun Aktif
            </p>
        </div>

        <div class="p-5 rounded-2xl bg-[#1d1f27] border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-slate-400 text-xs font-bold">
                <span>Admin & Yayasan</span>
                <span class="p-2 rounded-xl bg-amber-500/10 text-amber-400">🏛️</span>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-amber-300">{{ $adminCount }}</p>
            <p class="text-[10px] text-slate-400 font-medium">Super Admin & Ketua Yayasan</p>
        </div>

        <div class="p-5 rounded-2xl bg-[#1d1f27] border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-slate-400 text-xs font-bold">
                <span>Kepala & Guru</span>
                <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400">👨‍🏫</span>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-emerald-300">{{ $headmasterCount + $teacherCount }}</p>
            <p class="text-[10px] text-slate-400 font-medium">{{ $headmasterCount }} Kepala Unit, {{ $teacherCount }} Guru</p>
        </div>

        <div class="p-5 rounded-2xl bg-[#1d1f27] border border-slate-800 space-y-2">
            <div class="flex items-center justify-between text-slate-400 text-xs font-bold">
                <span>Staf & Tendik</span>
                <span class="p-2 rounded-xl bg-blue-500/10 text-blue-400">💼</span>
            </div>
            <p class="text-2xl sm:text-3xl font-black text-blue-300">{{ $staffCount }}</p>
            <p class="text-[10px] text-slate-400 font-medium">TU, Keuangan, BK, Perpus, dll</p>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="p-5 rounded-3xl bg-[#1d1f27] border border-slate-800">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            
            <!-- Search -->
            <div class="lg:col-span-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Cari Akun</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau no. HP..." class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500 pl-9">
                    <span class="absolute left-3 top-2.5 text-xs text-slate-500">🔍</span>
                </div>
            </div>

            <!-- Role Filter -->
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Filter Peran / Role</label>
                <select name="role" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    <option value="all">Semua Peran</option>
                    @foreach($roleOptions as $rKey => $rLabel)
                    <option value="{{ $rKey }}" {{ request('role') === $rKey ? 'selected' : '' }}>{{ $rLabel }}</option>
                    @endforeach
                </select>
            </div>

            <!-- School Unit Filter -->
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Unit Kerja</label>
                <select name="school_id" class="w-full px-3 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    <option value="all">Semua Unit</option>
                    <option value="yayasan" {{ request('school_id') === 'yayasan' ? 'selected' : '' }}>🏢 Yayasan (Pusat)</option>
                    @foreach($schools as $sc)
                    <option value="{{ $sc->id }}" {{ request('school_id') == $sc->id ? 'selected' : '' }}>🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Status & Action Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="w-full py-2 px-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs transition-colors flex items-center justify-center gap-1.5 shadow-md">
                    <span>⚡</span> <span>Terapkan</span>
                </button>
                <a href="{{ route('admin.users.index') }}" title="Reset Filter" class="py-2 px-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs transition-colors flex items-center justify-center">
                    <span>↺</span>
                </a>
            </div>

        </form>
    </div>

    <!-- Users Table Card -->
    <div class="rounded-3xl bg-[#1d1f27] border border-slate-800 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-900/90 text-[10px] font-black uppercase text-slate-400 tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="py-3.5 px-4">Pengguna</th>
                        <th class="py-3.5 px-4">Peran / Role</th>
                        <th class="py-3.5 px-4">Unit Kerja</th>
                        <th class="py-3.5 px-4">Pegawai / NIP Terkait</th>
                        <th class="py-3.5 px-4 text-center">Status Akun</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60 font-medium">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-800/30 transition-colors">
                        
                        <!-- User Name & Email -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4f46e5&color=ffffff&bold=true" alt="{{ $user->name }}" class="w-9 h-9 rounded-full border border-slate-700 shrink-0">
                                <div class="overflow-hidden">
                                    <h4 class="font-black text-white text-xs truncate">{{ $user->name }}</h4>
                                    <p class="text-[10px] text-slate-400 truncate">{{ $user->email }}</p>
                                    @if($user->phone)
                                    <p class="text-[9px] text-indigo-400">📞 {{ $user->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Role Badge -->
                        <td class="py-3.5 px-4">
                            <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-extrabold border {{ $user->role_badge_class }}">
                                {{ $user->role_name_label }}
                            </span>
                        </td>

                        <!-- School Unit -->
                        <td class="py-3.5 px-4">
                            @if($user->school)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-emerald-500/10 text-emerald-300 text-[10px] font-bold border border-emerald-500/20">
                                <span>🏫</span>
                                <span>{{ $user->school->name }} ({{ $user->school->code }})</span>
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg bg-amber-500/10 text-amber-300 text-[10px] font-bold border border-amber-500/20">
                                <span>🏢</span>
                                <span>Yayasan Robbani (Semua Unit)</span>
                            </span>
                            @endif
                        </td>

                        <!-- Linked Employee / NIP -->
                        <td class="py-3.5 px-4">
                            @if($user->employee)
                            <div class="text-[10px]">
                                <span class="font-bold text-white">{{ $user->employee->full_name }}</span>
                                <span class="block text-slate-400">NIP: {{ $user->employee->nip ?? '-' }}</span>
                            </div>
                            @else
                            <span class="text-slate-500 text-[10px] italic">Tidak terikat NIP</span>
                            @endif
                        </td>

                        <!-- Status Toggle -->
                        <td class="py-3.5 px-4 text-center">
                            <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" title="Klik untuk ubah status aktif/nonaktif" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black transition-all cursor-pointer {{ $user->is_active ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 hover:bg-emerald-500/30' : 'bg-rose-500/20 text-rose-300 border border-rose-500/30 hover:bg-rose-500/30' }}">
                                    <span>{{ $user->is_active ? '● Aktif' : '○ Nonaktif' }}</span>
                                </button>
                            </form>
                        </td>

                        <!-- Action Buttons -->
                        <td class="py-3.5 px-4 text-right">
                            <div class="inline-flex items-center gap-1.5">
                                
                                <!-- Edit Button -->
                                <button @click="openEditModal({
                                    id: {{ $user->id }},
                                    name: '{{ addslashes($user->name) }}',
                                    email: '{{ addslashes($user->email) }}',
                                    role: '{{ $user->role }}',
                                    school_id: '{{ $user->school_id ?? '' }}',
                                    phone: '{{ addslashes($user->phone ?? '') }}',
                                    is_active: {{ $user->is_active ? 'true' : 'false' }},
                                    employee_id: '{{ $user->employee->id ?? '' }}'
                                })" title="Edit Data Akun" class="p-1.5 rounded-lg bg-slate-800 hover:bg-indigo-600 hover:text-white text-slate-300 transition-colors">
                                    <span>✏️</span>
                                </button>

                                <!-- Reset Password Button -->
                                <button @click="openResetModal({
                                    id: {{ $user->id }},
                                    name: '{{ addslashes($user->name) }}',
                                    email: '{{ addslashes($user->email) }}'
                                })" title="Reset Password Akun" class="p-1.5 rounded-lg bg-slate-800 hover:bg-amber-600 hover:text-white text-slate-300 transition-colors">
                                    <span>🔑</span>
                                </button>

                                <!-- Delete Button -->
                                @if($user->id !== auth()->id() && $user->email !== 'admin@smartedu.test')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ addslashes($user->name) }}? Aksi ini tidak dapat dibatalkan.');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Akun Pengguna" class="p-1.5 rounded-lg bg-slate-800 hover:bg-rose-600 hover:text-white text-slate-300 transition-colors">
                                        <span>🗑️</span>
                                    </button>
                                </form>
                                @endif

                            </div>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500">
                            <span class="text-3xl block mb-2">🔍</span>
                            <span>Tidak ditemukan data akun pengguna yang sesuai dengan filter.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-4 border-t border-slate-800">
            {{ $users->links() }}
        </div>
        @endif
    </div>

    <!-- ================= MODAL TAMBAH AKUN BARU ================= -->
    <div x-show="createModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xs">
        <div @click.away="createModalOpen = false" class="relative w-full max-w-xl rounded-3xl bg-[#1d1f27] border border-slate-800 p-6 sm:p-8 shadow-2xl space-y-6">
            
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div class="space-y-1">
                    <h3 class="text-lg font-black text-white flex items-center gap-2">
                        <span>➕</span> <span>Buat Akun Pengguna Baru</span>
                    </h3>
                    <p class="text-xs text-slate-400">Daftarkan akun login baru dengan peran wewenang spesifik.</p>
                </div>
                <button @click="createModalOpen = false" class="text-slate-400 hover:text-white text-lg">✕</button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" required placeholder="Contoh: Ustadz Fulan, S.Pd" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- Email Login -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Email Login *</label>
                        <input type="email" name="email" required placeholder="fulan@robbani.sch.id" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Password Awal *</label>
                        <input type="text" name="password" required value="Password@123" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- No. HP -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">No. WhatsApp / HP</label>
                        <input type="text" name="phone" placeholder="08123456789" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Role Dropdown -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Peran / Role Pengguna *</label>
                        <select name="role" required class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                            @foreach($roleOptions as $rKey => $rLabel)
                            <option value="{{ $rKey }}">{{ $rLabel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- School Unit Dropdown -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Unit Kerja Sekolah</label>
                        <select name="school_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                            <option value="">🏢 Yayasan (Semua Unit)</option>
                            @foreach($schools as $sc)
                            <option value="{{ $sc->id }}">🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Link to Employee Profile (Optional) -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tautkan ke Data Guru / Pegawai (NIP)</label>
                    <select name="employee_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                        <option value="">-- Tidak Ditautkan / Akun Khusus --</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->full_name }} (NIP: {{ $emp->nip ?? '-' }}) - {{ $emp->school->name ?? 'Yayasan' }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Checkbox Aktif -->
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" id="create_is_active" value="1" checked class="w-4 h-4 rounded-sm bg-slate-900 border-slate-700 text-indigo-600 focus:ring-indigo-500">
                    <label for="create_is_active" class="text-xs font-bold text-white cursor-pointer">Aktifkan akun ini segera setelah dibuat</label>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="createModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-lg">
                        Simpan Akun Baru
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- ================= MODAL EDIT AKUN ================= -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xs">
        <div @click.away="editModalOpen = false" class="relative w-full max-w-xl rounded-3xl bg-[#1d1f27] border border-slate-800 p-6 sm:p-8 shadow-2xl space-y-6">
            
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div class="space-y-1">
                    <h3 class="text-lg font-black text-white flex items-center gap-2">
                        <span>✏️</span> <span>Edit Data Akun Pengguna</span>
                    </h3>
                    <p class="text-xs text-slate-400" x-text="'Perbarui profil dan wewenang untuk: ' + currentUser.name"></p>
                </div>
                <button @click="editModalOpen = false" class="text-slate-400 hover:text-white text-lg">✕</button>
            </div>

            <form :action="'/admin/users/' + currentUser.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Nama Lengkap *</label>
                        <input type="text" name="name" required x-model="currentUser.name" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- Email Login -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Email Login *</label>
                        <input type="email" name="email" required x-model="currentUser.email" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Ganti Password (Opsional) -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Ganti Password (Opsional)</label>
                        <input type="password" name="password" placeholder="Biarkan kosong jika tidak diubah" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    </div>

                    <!-- No. HP -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">No. WhatsApp / HP</label>
                        <input type="text" name="phone" x-model="currentUser.phone" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Role Dropdown -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Peran / Role Pengguna *</label>
                        <select name="role" required x-model="currentUser.role" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                            @foreach($roleOptions as $rKey => $rLabel)
                            <option value="{{ $rKey }}">{{ $rLabel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- School Unit Dropdown -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Unit Kerja Sekolah</label>
                        <select name="school_id" x-model="currentUser.school_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                            <option value="">🏢 Yayasan (Semua Unit)</option>
                            @foreach($schools as $sc)
                            <option value="{{ $sc->id }}">🏫 {{ $sc->name }} ({{ $sc->code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Link to Employee Profile (Optional) -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Tautkan ke Data Guru / Pegawai (NIP)</label>
                    <select name="employee_id" x-model="currentUser.employee_id" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                        <option value="">-- Tidak Ditautkan / Akun Khusus --</option>
                        @foreach($employees as $emp)
                        <option value="{{ $emp->id }}">{{ $emp->full_name }} (NIP: {{ $emp->nip ?? '-' }}) - {{ $emp->school->name ?? 'Yayasan' }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Checkbox Aktif -->
                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" id="edit_is_active" value="1" x-model="currentUser.is_active" class="w-4 h-4 rounded-sm bg-slate-900 border-slate-700 text-indigo-600 focus:ring-indigo-500">
                    <label for="edit_is_active" class="text-xs font-bold text-white cursor-pointer">Status Akun Aktif</label>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
                    <button type="button" @click="editModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-black text-xs shadow-lg">
                        Perbarui Akun
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- ================= MODAL RESET PASSWORD ================= -->
    <div x-show="resetModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-xs">
        <div @click.away="resetModalOpen = false" class="relative w-full max-w-md rounded-3xl bg-[#1d1f27] border border-slate-800 p-6 sm:p-8 shadow-2xl space-y-5">
            
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <h3 class="text-base font-black text-white flex items-center gap-2">
                    <span>🔑</span> <span>Reset Password Akun</span>
                </h3>
                <button @click="resetModalOpen = false" class="text-slate-400 hover:text-white text-lg">✕</button>
            </div>

            <div class="space-y-2 text-xs text-slate-300">
                <p>Anda akan mereset password untuk akun:</p>
                <div class="p-3 rounded-2xl bg-slate-900 border border-slate-800">
                    <p class="font-black text-white" x-text="currentUser.name"></p>
                    <p class="text-slate-400 text-[10px]" x-text="currentUser.email"></p>
                </div>
            </div>

            <form :action="'/admin/users/' + currentUser.id + '/reset-password'" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1">Password Baru</label>
                    <input type="text" name="new_password" required value="Password@123" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-white text-xs font-bold focus:outline-none focus:border-indigo-500">
                    <p class="text-[9px] text-slate-500 mt-1">Default standar sistem: <code class="text-indigo-400">Password@123</code></p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-800">
                    <button type="button" @click="resetModalOpen = false" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-bold text-xs">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-lg">
                        Konfirmasi Reset
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
