<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SavingsTransaction;
use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;

class SavingsController extends Controller
{
    /**
     * Modul 5.1: Rekening & Teller Tabungan Siswa
     */
    public function index()
    {
        $schoolId = session('dashboard_school_id', 'all');

        $transactionsQuery = SavingsTransaction::with(['student.school', 'student.classroom']);
        $studentsQuery = Student::whereIn('status', ['ACTIVE', 'AKTIF']);
        $totalSavingsQuery = Student::query();

        if ($schoolId !== 'all') {
            $transactionsQuery->whereHas('student', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
            $studentsQuery->where('school_id', $schoolId);
            $totalSavingsQuery->where('school_id', $schoolId);
        }

        $transactions = $transactionsQuery->latest()->paginate(15);
        $students = $studentsQuery->get();
        if ($students->isEmpty()) {
            $students = ($schoolId !== 'all') ? Student::where('school_id', $schoolId)->get() : Student::all();
        }

        $totalSavings = $totalSavingsQuery->sum('savings_balance');

        return view('admin.savings.index', compact('transactions', 'students', 'totalSavings', 'schoolId'));
    }

    public function storeTransaction(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'transaction_type' => 'required|in:DEPOSIT,WITHDRAWAL',
            'amount' => 'required|numeric|min:1000',
            'notes' => 'nullable|string',
        ]);

        $student = Student::findOrFail($request->student_id);

        if ($request->transaction_type == 'WITHDRAWAL' && $student->savings_balance < $request->amount) {
            return redirect()->back()->with('error', 'Saldo Tabungan Siswa Tidak Mencukupi!');
        }

        if ($request->transaction_type == 'DEPOSIT') {
            $newBalance = $student->savings_balance + $request->amount;
        } else {
            $newBalance = $student->savings_balance - $request->amount;
        }

        $student->update(['savings_balance' => $newBalance]);

        $trx = SavingsTransaction::create([
            'student_id' => $student->id,
            'type' => $request->transaction_type,
            'amount' => $request->amount,
            'balance_after' => $newBalance,
            'description' => $request->notes ?? ($request->transaction_type == 'DEPOSIT' ? 'Setoran Tabungan Teller' : 'Penarikan Tabungan Teller'),
        ]);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'TABUNGAN ' . $request->transaction_type,
                'model_type' => 'SavingsTransaction',
                'model_id' => $trx->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        $typeLabel = $request->transaction_type == 'DEPOSIT' ? 'Setoran' : 'Penarikan';
        return redirect()->back()->with('success', "Transaksi {$typeLabel} Tabungan Berhasil! Saldo Baru: Rp " . number_format($newBalance, 0, ',', '.'));
    }
}
