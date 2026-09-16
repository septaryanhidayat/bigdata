<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SppBill;
use App\Models\SppPayment;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\Student;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    /**
     * Modul 4.1: Daftar Tagihan SPP Siswa & Kasir Payment
     */
    public function sppBills()
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();

        $billsQuery = SppBill::with(['student.school', 'student.classroom', 'payments']);
        $studentsQuery = Student::whereIn('status', ['ACTIVE', 'AKTIF']);

        if ($schoolId) {
            $billsQuery->where('school_id', $schoolId);
            $studentsQuery->where('school_id', $schoolId);
        }

        $bills = $billsQuery->latest()->paginate(15);
        $students = $studentsQuery->get();

        return view('admin.finance.spp_bills', compact('bills', 'students', 'schoolId'));
    }

    public function storeSppBill(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $student = Student::findOrFail($request->student_id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $student->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Siswa ini bukan dari unit sekolah Anda.');
        }

        $monthPeriod = $request->month_period;
        if (!$monthPeriod) {
            $month = $request->month ?? date('F');
            $year = $request->year ?? date('Y');
            $monthPeriod = "{$month} {$year}";
        }

        $academicYear = AcademicYear::where('is_active', true)->first() ?? AcademicYear::first();
        $academicYearId = $request->academic_year_id ?? ($academicYear ? $academicYear->id : 1);

        SppBill::create([
            'school_id' => $student->school_id ?? 1,
            'student_id' => $student->id,
            'academic_year_id' => $academicYearId,
            'month_period' => $monthPeriod,
            'amount' => $request->amount,
            'discount_amount' => $request->discount_amount ?? 0,
            'paid_amount' => 0,
            'status' => 'UNPAID',
            'due_date' => $request->due_date ?? now()->endOfMonth()->toDateString(),
        ]);

        return redirect()->back()->with('success', '✓ Tagihan SPP Siswa Berhasil Dibuat!');
    }

    /**
     * Bayar Kasir SPP & Generasi Kwitansi (Atomic & IDOR Protected)
     */
    public function paySpp(Request $request, $billId)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();

        try {
            $result = DB::transaction(function () use ($billId, $schoolId) {
                $bill = SppBill::where('id', $billId)->lockForUpdate()->firstOrFail();

                // IDOR verification: Check school authorization
                if ($schoolId && $bill->school_id != $schoolId) {
                    throw new \Exception('Akses ditolak: Anda tidak memiliki wewenang untuk menagih SPP di unit sekolah ini.');
                }

                if ($bill->status === 'PAID') {
                    throw new \Exception('Tagihan SPP ini sudah dinyatakan LUNAS!');
                }

                $receiptNo = 'KW-SPP-' . date('Ymd') . '-' . str_pad($bill->id, 4, '0', STR_PAD_LEFT);

                $payment = SppPayment::create([
                    'spp_bill_id' => $bill->id,
                    'receipt_number' => $receiptNo,
                    'amount_paid' => $bill->amount,
                    'paid_at' => now(),
                    'payment_method' => 'CASH',
                    'notes' => 'Pembayaran SPP via Kasir Sekolah',
                ]);

                $bill->update([
                    'status' => 'PAID',
                    'paid_amount' => $bill->amount,
                ]);

                // Auto Record to Accounting Journal (Jurnal Otomatis)
                $kasCoa = ChartOfAccount::where('code', '101')->orWhere('code', '1001-KAS')->first();
                if ($kasCoa) {
                    JournalEntry::create([
                        'school_id' => $bill->school_id ?? 1,
                        'account_id' => $kasCoa->id,
                        'date' => now()->toDateString(),
                        'reference_number' => $receiptNo,
                        'description' => "Penerimaan SPP {$bill->month_period} - " . ($bill->student->full_name ?? 'Siswa'),
                        'debit' => $bill->amount,
                        'credit' => 0,
                    ]);
                    $kasCoa->increment('current_balance', $bill->amount);
                }

                try {
                    AuditLog::create([
                        'user_id' => auth()->id() ?? 1,
                        'action' => 'BAYAR SPP',
                        'model_type' => 'SppPayment',
                        'model_id' => $payment->id,
                        'ip_address' => request()->ip(),
                    ]);
                } catch (\Throwable $e) {}

                return $receiptNo;
            });

            return redirect()->back()->with('success', "✓ Pembayaran SPP Berhasil Diproses! Nomor Kwitansi: {$result}");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function printReceipt($paymentId)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $payment = SppPayment::with(['sppBill.student.school', 'sppBill.student.classroom', 'sppBill.academicYear'])->findOrFail($paymentId);

        // IDOR Protection on receipt print
        if ($schoolId && $payment->sppBill && $payment->sppBill->school_id != $schoolId) {
            abort(403, 'Akses ditolak: Kwitansi ini milik unit sekolah lain.');
        }

        return view('admin.finance.receipt_pdf', compact('payment'));
    }

    /**
     * Modul 4.2: Chart of Accounts (COA) & Jurnal Akuntansi
     */
    public function coa()
    {
        $coas = ChartOfAccount::orderBy('code', 'asc')->get();
        return view('admin.finance.coa', compact('coas'));
    }

    public function storeCoa(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:chart_of_accounts,code',
            'name' => 'required|string',
            'type' => 'required|in:ASSET,LIABILITY,EQUITY,REVENUE,EXPENSE',
        ]);

        ChartOfAccount::create([
            'code' => $request->code,
            'name' => $request->name,
            'type' => $request->type,
            'current_balance' => $request->initial_balance ?? 0,
        ]);

        return redirect()->back()->with('success', '✓ Akun COA Baru Berhasil Ditambahkan!');
    }
}
