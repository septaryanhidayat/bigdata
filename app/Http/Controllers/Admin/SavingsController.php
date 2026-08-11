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
        $transactions = SavingsTransaction::with(['student.school', 'student.classroom'])->latest()->paginate(15);
        $students = Student::where('status', 'AKTIF')->get();

        $totalSavings = Student::sum('savings_balance');

        return view('admin.savings.index', compact('transactions', 'students', 'totalSavings'));
    }

    public function storeTransaction(Request $request)
    {
        $validated = $request->validate([
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

        SavingsTransaction::create([
            'school_id' => $student->school_id,
            'student_id' => $student->id,
            'transaction_type' => $request->transaction_type,
            'amount' => $request->amount,
            'balance_after' => $newBalance,
            'notes' => $request->notes ?? ($request->transaction_type == 'DEPOSIT' ? 'Setoran Tabungan Teller' : 'Penarikan Tabungan Teller'),
        ]);

        $typeLabel = $request->transaction_type == 'DEPOSIT' ? 'Setoran' : 'Penarikan';
        return redirect()->back()->with('success', "Transaksi {$typeLabel} Tabungan Berhasil! Saldo Baru: Rp " . number_format($newBalance, 0, ',', '.'));
    }
}
