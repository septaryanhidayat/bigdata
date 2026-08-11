<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SppBill;
use App\Models\SppPayment;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    /**
     * Modul 4.1: Daftar Tagihan SPP Siswa & Kasir Payment
     */
    public function sppBills()
    {
        $bills = SppBill::with(['student.school', 'student.classroom'])->latest()->paginate(15);
        $students = Student::where('status', 'AKTIF')->get();

        return view('admin.finance.spp_bills', compact('bills', 'students'));
    }

    public function storeSppBill(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'month' => 'required|string',
            'year' => 'required|integer',
            'amount' => 'required|numeric|min:0',
        ]);

        $student = Student::find($request->student_id);
        $validated['school_id'] = $student->school_id;
        $validated['status'] = 'UNPAID';

        SppBill::create($validated);

        return redirect()->back()->with('success', 'Tagihan SPP Siswa Berhasil Dibuat!');
    }

    /**
     * Bayar Kasir SPP & Generasi Kwitansi
     */
    public function paySpp(Request $request, $billId)
    {
        $bill = SppBill::findOrFail($billId);

        if ($bill->status == 'PAID') {
            return redirect()->back()->with('error', 'Tagihan SPP ini sudah LUNAS!');
        }

        $receiptNo = 'KW-SPP-' . date('Ymd') . '-' . str_pad($bill->id, 4, '0', STR_PAD_LEFT);

        SppPayment::create([
            'spp_bill_id' => $bill->id,
            'receipt_no' => $receiptNo,
            'amount_paid' => $bill->amount,
            'payment_date' => date('Y-m-d'),
            'payment_method' => 'CASH_KASIR',
            'notes' => 'Pembayaran SPP via Kasir Sekolah',
        ]);

        $bill->update(['status' => 'PAID']);

        // Auto Record to Accounting Journal (Jurnal Otomatis)
        $kasCoa = ChartOfAccount::where('code', '101')->first();
        if ($kasCoa) {
            JournalEntry::create([
                'school_id' => $bill->school_id,
                'coa_id' => $kasCoa->id,
                'transaction_date' => date('Y-m-d'),
                'reference_no' => $receiptNo,
                'description' => "Penerimaan SPP {$bill->month} {$bill->year} - " . ($bill->student->full_name ?? 'Siswa'),
                'debit' => $bill->amount,
                'credit' => 0,
            ]);
            $kasCoa->increment('balance', $bill->amount);
        }

        return redirect()->back()->with('success', "Pembayaran SPP Berhasil! Kwitansi: {$receiptNo}");
    }

    public function printReceipt($paymentId)
    {
        $payment = SppPayment::with(['sppBill.student.school', 'sppBill.student.classroom'])->findOrFail($paymentId);
        return view('admin.finance.receipt_pdf', compact('payment'));
    }

    /**
     * Modul 4.2: Chart of Accounts (COA) & Jurnal Akuntansi
     */
    public function coa()
    {
        $coas = ChartOfAccount::orderBy('code', 'asc')->get();
        $journals = JournalEntry::with('coa')->latest()->paginate(15);
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
            'balance' => 'required|numeric',
        ]);

        ChartOfAccount::create($validated);

        return redirect()->back()->with('success', 'Akun COA Baru Berhasil Ditambahkan!');
    }
}
