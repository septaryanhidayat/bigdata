@extends('admin.layout')

@section('title', 'CBT Computer Based Test')

@section('content')
<div class="space-y-6">

    <!-- Top Header Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 font-black text-[10px] uppercase border border-purple-200">Modul 12: CBT Exam Engine</span>
                <span class="w-2 h-2 rounded-full bg-purple-500 animate-ping"></span>
            </div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight mt-1">
                📝 Computer Based Test (CBT Ujian Online)
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Manajemen bank soal multi-type, jadwal ujian online, proctoring, & auto-scoring e-rapor.</p>
        </div>

        <button onclick="document.getElementById('addCbtModal').classList.remove('hidden')" class="px-4 py-2.5 rounded-2xl bg-theme-gradient text-white font-black text-xs shadow-md hover:opacity-95 transition-transform active:scale-95 flex items-center gap-2">
            <span>+</span> Buat Paket Ujian CBT
        </button>
    </div>

    <!-- Grid of CBT Exam Packages -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($exams as $ex)
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4 hover:shadow-md transition-all flex flex-col justify-between">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-700 font-black text-[10px] uppercase">{{ $ex->subject_name }}</span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500 text-white font-black text-[10px]">ACTIVE</span>
                </div>
                <h3 class="font-black text-slate-900 text-base leading-snug">{{ $ex->title }}</h3>
                <p class="text-xs text-slate-500 font-medium">Unit: {{ $ex->school->name ?? 'Semua Unit' }}</p>
            </div>

            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100 grid grid-cols-2 gap-2 text-xs font-bold text-slate-700">
                <div>
                    <span class="text-[10px] text-slate-400 block uppercase">Durasi</span>
                    <span>⏱️ {{ $ex->duration_minutes }} Menit</span>
                </div>
                <div>
                    <span class="text-[10px] text-slate-400 block uppercase">Jumlah Soal</span>
                    <span>❓ {{ $ex->total_questions }} Soal PG</span>
                </div>
            </div>

            <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                <span class="text-[10px] text-emerald-600 font-extrabold">● Proctoring Active</span>
                <button onclick="openBankSoalModal('{{ $ex->id }}', '{{ $ex->title }}')" class="px-3 py-1.5 rounded-xl bg-slate-900 text-white text-xs font-black hover:bg-slate-800">Kelola Bank Soal ➔</button>
            </div>
        </div>
        @empty
        <div class="col-span-3 p-8 bg-white rounded-3xl text-center text-slate-400 italic border border-slate-100">
            Belum ada paket ujian CBT terbuat.
        </div>
        @endforelse
    </div>

</div>

<!-- Modal Bank Soal Generator -->
<div id="bankSoalModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-lg w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="text-lg font-black text-slate-900">Kelola Bank Soal Ujian</h3>
                <span id="bankSoalTitle" class="text-xs text-purple-700 font-bold block">Paket Ujian CBT</span>
            </div>
            <button onclick="document.getElementById('bankSoalModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.cbt.questions.store') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <input type="hidden" name="cbt_exam_id" id="modalExamId">

            <div>
                <label class="block text-slate-700 mb-1">Pertanyaan / Soal Ujian:</label>
                <textarea name="question_text" rows="3" required placeholder="Tuliskan soal pilihan ganda di sini..." class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-slate-700 mb-1">Pilihan A:</label>
                    <input type="text" name="option_a" required placeholder="Jawaban A" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">Pilihan B:</label>
                    <input type="text" name="option_b" required placeholder="Jawaban B" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Kunci Jawaban Benar:</label>
                <select name="correct_answer" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                    <option value="A">Opsi A (Jawaban A)</option>
                    <option value="B">Opsi B (Jawaban B)</option>
                    <option value="C">Opsi C</option>
                    <option value="D">Opsi D</option>
                </select>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('bankSoalModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">+ Tambahkan ke Bank Soal</button>
            </div>
        </form>
    </div>
</div>

<script>
function openBankSoalModal(examId, examTitle) {
    document.getElementById('modalExamId').value = examId;
    document.getElementById('bankSoalTitle').innerText = 'Paket: ' + examTitle;
    document.getElementById('bankSoalModal').classList.remove('hidden');
}
</script>

<!-- Modal Create CBT Exam -->
<div id="addCbtModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4">
    <div class="bg-white rounded-3xl p-6 md:p-8 max-w-md w-full shadow-2xl space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="text-lg font-black text-slate-900">Buat Paket Ujian CBT</h3>
            <button onclick="document.getElementById('addCbtModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold">✕</button>
        </div>

        <form action="{{ route('admin.cbt.store') }}" method="POST" class="space-y-4 text-xs font-bold">
            @csrf
            <div>
                <label class="block text-slate-700 mb-1">Judul Paket Ujian:</label>
                <input type="text" name="title" placeholder="Contoh: UTS Matematika 2026" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div>
                <label class="block text-slate-700 mb-1">Mata Pelajaran:</label>
                <input type="text" name="subject_name" value="Matematika" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-slate-700 mb-1">Durasi (Menit):</label>
                    <input type="number" name="duration_minutes" value="90" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
                <div>
                    <label class="block text-slate-700 mb-1">Total Soal:</label>
                    <input type="number" name="total_questions" value="30" class="w-full p-3 rounded-2xl bg-slate-50 border border-slate-200">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="document.getElementById('addCbtModal').classList.add('hidden')" class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-600">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-2xl bg-theme-gradient text-white font-black shadow-md">Simpan CBT Exam</button>
            </div>
        </form>
    </div>
</div>
@endsection
