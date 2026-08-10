@extends('admin.layout')

@section('title', 'Kelola 17 Modul Fitur')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen 17 Modul Produk Digital</h1>
            <p class="text-xs text-slate-600 font-medium mt-1">Tambah, ubah nama, ikon, deskripsi, dan daftar sub-fitur dari modul yang tampil di landing page.</p>
        </div>
        <a href="{{ route('admin.modules.create') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow">
            + Tambah Modul Baru
        </a>
    </div>

    <!-- Modules Table / Grid -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider">
                    <tr>
                        <th class="py-3.5 px-4">Urutan</th>
                        <th class="py-3.5 px-4">Ikon & Judul Modul</th>
                        <th class="py-3.5 px-4">Kategori</th>
                        <th class="py-3.5 px-4">Deskripsi Ringkas</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($modules as $mod)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3.5 px-4 font-bold text-slate-500">#{{ $mod->sort_order }}</td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">{{ $mod->icon }}</span>
                                <div>
                                    <h4 class="font-extrabold text-sm text-slate-900">{{ $mod->title }}</h4>
                                    <span class="text-[10px] text-slate-400">Short: {{ $mod->short_title }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                {{ $mod->category_name }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 max-w-xs">
                            <p class="text-slate-600 line-clamp-2">{{ $mod->short_desc }}</p>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.modules.edit', $mod->id) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 text-slate-800 hover:bg-slate-200 font-bold">
                                    Edit ✏️
                                </a>
                                <form action="{{ route('admin.modules.destroy', $mod->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus modul ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold">
                                        Hapus 🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
