<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CanteenOutlet;
use App\Models\CanteenProduct;
use App\Models\CanteenTransaction;
use App\Models\Student;
use App\Models\School;
use Illuminate\Http\Request;

class CanteenController extends Controller
{
    /**
     * Modul 6.1: POS Kantin & NFC/RFID Tap Checkout Terminal
     */
    public function index()
    {
        $outlets = CanteenOutlet::withCount('products')->get();
        $products = CanteenProduct::with('outlet')->get();
        $transactions = CanteenTransaction::with(['outlet', 'student'])->latest()->paginate(15);
        $students = Student::where('status', 'AKTIF')->get();

        return view('admin.canteen.index', compact('outlets', 'products', 'transactions', 'students'));
    }

    public function storeOutlet(Request $request)
    {
        $validated = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string',
            'owner_name' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        CanteenOutlet::create($validated);

        return redirect()->back()->with('success', 'Outlet Kantin Baru Berhasil Ditambahkan!');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:canteen_outlets,id',
            'name' => 'required|string',
            'price' => 'required|numeric|min:500',
            'stock' => 'required|integer',
        ]);

        CanteenProduct::create([
            'canteen_outlet_id' => $request->outlet_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Produk Kantin Berhasil Ditambahkan!');
    }

    /**
     * Checkout POS Kasir Kantin Tap RFID Siswa
     */
    public function checkoutPos(Request $request)
    {
        $request->validate([
            'rfid_tag' => 'required|string',
            'outlet_id' => 'required|exists:canteen_outlets,id',
            'total_amount' => 'required|numeric|min:500',
        ]);

        $student = Student::where('rfid_tag', $request->rfid_tag)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Kartu RFID Siswa Tidak Dikenali!');
        }

        // Check daily limit
        $todayTotal = CanteenTransaction::where('student_id', $student->id)
            ->whereDate('created_at', date('Y-m-d'))
            ->sum('total_amount');

        if (($todayTotal + $request->total_amount) > $student->canteen_daily_limit) {
            return redirect()->back()->with('error', "Transaksi Gagal! Melampaui limit harian kantin (Maks Rp " . number_format($student->canteen_daily_limit, 0, ',', '.') . "/hari).");
        }

        // Check student balance
        if ($student->savings_balance < $request->total_amount) {
            return redirect()->back()->with('error', "Transaksi Gagal! Saldo cashless siswa tidak mencukupi (Saldo: Rp " . number_format($student->savings_balance, 0, ',', '.') . ").");
        }

        // Deduct balance
        $student->decrement('savings_balance', $request->total_amount);

        $invoiceNo = 'POS-' . date('YmdHis') . '-' . rand(100, 999);

        CanteenTransaction::create([
            'canteen_outlet_id' => $request->outlet_id,
            'student_id' => $student->id,
            'invoice_number' => $invoiceNo,
            'total_amount' => $request->total_amount,
            'rfid_tag_used' => $request->rfid_tag,
        ]);

        return redirect()->back()->with('success', "Transaksi POS Kantin Berhasil! Invoice: {$invoiceNo}, Siswa: {$student->full_name}, Sisa Saldo: Rp " . number_format($student->savings_balance, 0, ',', '.'));
    }
}
