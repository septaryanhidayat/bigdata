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
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Modul 4.1: Daftar Tagihan SPP Siswa & Kasir Payment
     */
    public function sppBills()
    {
        $schoolId = session('dashboard_school_id', 'all');

        $billsQuery = SppBill::with(['student.school', 'student.classroom', 'payments']);
        $studentsQuery = Student::whereIn('status', ['ACTIVE', 'AKTIF']);

        if ($schoolId !== 'all') {
            $billsQuery->where('school_id', $schoolId);
            $studentsQuery->where('school_id', $schoolId);
        }

        $bills = $billsQuery->latest()->paginate(15);
        $students = $studentsQuery->get();
        if ($students->isEmpty()) {
            $students = ($schoolId !== 'all') ? Student::where('school_id', $schoolId)->get() : Student::all();
        }

        return view('admin.finance.spp_bills', compact('bills', 'students', 'schoolId'));
    }

    public function storeSppBill(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $student = Student::find($request->student_id);
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

        return redirect()->back()->with('success', 'Tagihan SPP Siswa Berhasil Dibuat!');
    }

    /**
     * Bayar Kasir SPP & Generasi Kwitansi
     */
    public function paySpp(Request $request, $billId)
    {
        $bill = SppBill::findOrFail($billId);

        if ($bill->status === 'PAID') {
            return redirect()->back()->with('error', 'Tagihan SPP ini sudah LUNAS!');
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
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'BAYAR SPP',
                'model_type' => 'SppPayment',
                'model_id' => $payment->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', "Pembayaran SPP Berhasil! Kwitansi: {$receiptNo}");
    }

    public function printReceipt($paymentId)
    {
        $payment = SppPayment::with(['sppBill.student.school', 'sppBill.student.classroom', 'sppBill.academicYear'])->findOrFail($paymentId);
        return view('admin.finance.receipt_pdf', compact('payment'));
    }

    /**
     * Modul 4.2: Chart of Accounts (COA) & Jurnal Akuntansi
     */
    public function coa()
    {
        $coas = ChartOfAccount::orderBy('code', 'asc')->get();
        $journals = JournalEntry::with(['coa', 'account'])->latest()->paginate(15);
        $schools = School::all();

        return view('admin.finance.coa', compact('coas', 'journals', 'schools'));
    }

    public function storeCoa(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'code' => 'required|string|unique:chart_of_accounts,code',
            'name' => 'required|string',
            'type' => 'required|in:ASSET,LIABILITY,EQUITY,REVENUE,EXPENSE',
            'balance' => 'nullable|numeric',
        ]);

        ChartOfAccount::create([
            'school_id' => $validated['school_id'],
            'code' => $validated['code'],
            'name' => $validated['name'],
            'type' => $validated['type'],
            'current_balance' => $validated['balance'] ?? 0,
        ]);

        return redirect()->back()->with('success', 'Akun COA Baru Berhasil Ditambahkan!');
    }
}
