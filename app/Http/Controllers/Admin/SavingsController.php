<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SavingsTransaction;
use App\Models\Student;
use App\Models\School;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SavingsController extends Controller
{
    /**
     * Modul 5.1: Rekening & Teller Tabungan Siswa
     */
    public function index()
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();

        $transactionsQuery = SavingsTransaction::with(['student.school', 'student.classroom']);
        $studentsQuery = Student::whereIn('status', ['ACTIVE', 'AKTIF']);
        $totalSavingsQuery = Student::query();

        if ($schoolId) {
            $transactionsQuery->whereHas('student', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
            $studentsQuery->where('school_id', $schoolId);
            $totalSavingsQuery->where('school_id', $schoolId);
        }

        $transactions = $transactionsQuery->latest()->paginate(15);
        $students = $studentsQuery->get();
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

        $schoolId = auth()->user()?->getEffectiveSchoolId();

        try {
            $result = DB::transaction(function () use ($request, $schoolId) {
                // Lock row for update to eliminate race condition
                $student = Student::where('id', $request->student_id)->lockForUpdate()->firstOrFail();

                // Multi-tenant check
                if ($schoolId && $student->school_id != $schoolId) {
                    throw new \Exception('Akses ditolak: Anda tidak memiliki otoritas atas rekening siswa di unit ini.');
                }

                if ($request->transaction_type === 'WITHDRAWAL') {
                    if ($student->savings_balance < $request->amount) {
                        throw new \Exception("Saldo tabungan tidak mencukupi! Saldo saat ini: Rp " . number_format($student->savings_balance, 0, ',', '.'));
                    }
                    $newBalance = $student->savings_balance - $request->amount;
                } else {
                    $newBalance = $student->savings_balance + $request->amount;
                }

                $student->savings_balance = $newBalance;
                $student->save();

                $trx = SavingsTransaction::create([
                    'student_id' => $student->id,
                    'type' => $request->transaction_type,
                    'amount' => $request->amount,
                    'balance_after' => $newBalance,
                    'description' => $request->notes ?? ($request->transaction_type === 'DEPOSIT' ? 'Setoran Tabungan Teller' : 'Penarikan Tabungan Teller'),
                ]);

                try {
                    AuditLog::create([
                        'user_id' => auth()->id() ?? 1,
                        'action' => 'TABUNGAN ' . $request->transaction_type,
                        'model_type' => 'SavingsTransaction',
                        'model_id' => $trx->id,
                        'ip_address' => request()->ip(),
                    ]);
                } catch (\Throwable $e) {}

                return [
                    'trx' => $trx,
                    'newBalance' => $newBalance,
                    'student' => $student,
                ];
            });

            $typeLabel = $request->transaction_type === 'DEPOSIT' ? 'Setoran' : 'Penarikan';
            return redirect()->back()->with('success', "✓ Transaksi {$typeLabel} Tabungan Berhasil! Siswa: {$result['student']->full_name}, Saldo Baru: Rp " . number_format($result['newBalance'], 0, ',', '.'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
