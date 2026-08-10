@extends('admin.layout')

@section('title', 'Kelola Pertanyaan FAQ')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen FAQ (Tanya Jawab)</h1>
        <p class="text-xs text-slate-600 font-medium mt-1">Tambah atau hapus daftar pertanyaan yang sering diajukan pada landing page.</p>
    </div>

    <!-- Add New FAQ Form -->
    <form action="{{ route('admin.faqs.store') }}" method="POST" class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4 max-w-2xl">
        @csrf
        <h3 class="font-extrabold text-sm text-slate-900">+ Tambah FAQ Baru</h3>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Pertanyaan:</label>
            <input type="text" name="question" required placeholder="Contoh: Apakah sistem ini mendukung multi-sekolah?" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Jawaban Lengkap:</label>
            <textarea name="answer" rows="3" required placeholder="Masukkan jawaban..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-medium text-slate-900"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 mb-1">Urutan Sort Order:</label>
            <input type="number" name="sort_order" value="1" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900">
        </div>

        <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow">
            Simpan FAQ
        </button>
    </form>

    <!-- FAQ List Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden max-w-4xl">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 font-bold uppercase">
                <tr>
                    <th class="py-3 px-4">#</th>
                    <th class="py-3 px-4">Pertanyaan</th>
                    <th class="py-3 px-4">Jawaban</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 font-medium">
                @foreach($faqs as $faq)
                <tr class="hover:bg-slate-50">
                    <td class="py-3 px-4 font-bold text-slate-400">{{ $faq->sort_order }}</td>
                    <td class="py-3 px-4 font-bold text-slate-900 max-w-xs">{{ $faq->question }}</td>
                    <td class="py-3 px-4 text-slate-600 max-w-md">{{ $faq->answer }}</td>
                    <td class="py-3 px-4 text-center">
                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Hapus FAQ ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
