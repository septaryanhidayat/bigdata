<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CanteenOutlet;
use App\Models\CanteenProduct;
use App\Models\CanteenTransaction;
use App\Models\Student;
use App\Models\School;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CanteenController extends Controller
{
    /**
     * Modul 6.1: POS Kantin & NFC/RFID Tap Checkout Terminal
     */
    public function index()
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();

        $outletsQuery = CanteenOutlet::withCount('products');
        $productsQuery = CanteenProduct::with('outlet');
        $transactionsQuery = CanteenTransaction::with(['outlet', 'student']);
        $studentsQuery = Student::whereIn('status', ['ACTIVE', 'AKTIF']);

        if ($schoolId) {
            $outletsQuery->where('school_id', $schoolId);
            $productsQuery->whereHas('outlet', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
            $transactionsQuery->whereHas('outlet', function($q) use ($schoolId) {
                $q->where('school_id', $schoolId);
            });
            $studentsQuery->where('school_id', $schoolId);
        }

        $outlets = $outletsQuery->get();
        $products = $productsQuery->get();
        $transactions = $transactionsQuery->latest()->paginate(15);
        $students = $studentsQuery->get();
        $schools = School::all();

        return view('admin.canteen.index', compact('outlets', 'products', 'transactions', 'students', 'schools', 'schoolId'));
    }

    public function storeOutlet(Request $request)
    {
        $request->validate([
            'school_id' => 'required|exists:schools,id',
            'name' => 'required|string',
            'owner_name' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $request->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Unit sekolah tidak sesuai hak akses Anda.');
        }

        CanteenOutlet::create([
            'school_id' => $request->school_id,
            'name' => $request->name,
            'owner_name' => $request->owner_name ?: 'Pengelola Outlet',
            'phone' => $request->phone,
            'commission_rate' => 5.00,
        ]);

        return redirect()->back()->with('success', '✓ Outlet Kantin Baru Berhasil Ditambahkan!');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'outlet_id' => 'required|exists:canteen_outlets,id',
            'name' => 'required|string',
            'price' => 'required|numeric|min:500',
            'stock' => 'required|integer',
        ]);

        $outlet = CanteenOutlet::findOrFail($request->outlet_id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $outlet->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Outlet ini bukan milik unit sekolah Anda.');
        }

        CanteenProduct::create([
            'canteen_outlet_id' => $request->outlet_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category ?? 'MAKANAN',
        ]);

        return redirect()->back()->with('success', '✓ Produk Kantin Berhasil Ditambahkan!');
    }

    public function destroyProduct($id)
    {
        $product = CanteenProduct::with('outlet')->findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $product->outlet && $product->outlet->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak berwenang menghapus produk ini.');
        }

        $product->delete();
        return redirect()->back()->with('success', '✓ Produk kantin berhasil dihapus.');
    }

    public function destroyOutlet($id)
    {
        $outlet = CanteenOutlet::findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $outlet->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak berwenang menghapus outlet ini.');
        }

        $outlet->delete();
        return redirect()->back()->with('success', '✓ Outlet kantin berhasil dihapus.');
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

        $outlet = CanteenOutlet::findOrFail($request->outlet_id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $outlet->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Outlet tidak terdaftar di unit sekolah Anda.');
        }

        try {
            $result = DB::transaction(function () use ($request, $outlet) {
                $student = Student::where('rfid_tag', trim($request->rfid_tag))->lockForUpdate()->first();

                if (!$student) {
                    throw new \Exception("Kartu RFID '" . $request->rfid_tag . "' tidak terdaftar pada sistem siswa aktif.");
                }

                // Check daily limit
                $todayTotal = CanteenTransaction::where('student_id', $student->id)
                    ->whereDate('created_at', date('Y-m-d'))
                    ->sum('total_amount');

                $dailyLimit = $student->canteen_daily_limit ?? 50000;

                if (($todayTotal + $request->total_amount) > $dailyLimit) {
                    throw new \Exception("Transaksi Gagal! Melampaui limit harian kantin (Maks Rp " . number_format($dailyLimit, 0, ',', '.') . "/hari). Sisa limit hari ini: Rp " . number_format(max(0, $dailyLimit - $todayTotal), 0, ',', '.'));
                }

                // Total available balance (canteen balance or savings balance)
                $hasCanteenBalance = ($student->canteen_balance >= $request->total_amount);
                $hasSavingsBalance = ($student->savings_balance >= $request->total_amount);

                if (!$hasCanteenBalance && !$hasSavingsBalance) {
                    throw new \Exception("Saldo tidak mencukupi! Saldo Kantin: Rp " . number_format($student->canteen_balance, 0, ',', '.') . ", Saldo Tabungan: Rp " . number_format($student->savings_balance, 0, ',', '.') . ". Total belanja: Rp " . number_format($request->total_amount, 0, ',', '.') . ". Silakan lakukan top-up terlebih dahulu di Teller Tabungan.");
                }

                if ($hasCanteenBalance) {
                    $student->canteen_balance -= $request->total_amount;
                    $remaining = $student->canteen_balance;
                    $source = 'Saldo Kantin';
                } else {
                    $student->savings_balance -= $request->total_amount;
                    $remaining = $student->savings_balance;
                    $source = 'Saldo Tabungan';
                }

                $student->save();

                $invoiceNo = 'POS-' . date('YmdHis') . '-' . rand(100, 999);

                $posTrx = CanteenTransaction::create([
                    'canteen_outlet_id' => $outlet->id,
                    'student_id' => $student->id,
                    'invoice_number' => $invoiceNo,
                    'total_amount' => $request->total_amount,
                    'rfid_tag_used' => $request->rfid_tag,
                ]);

                try {
                    AuditLog::create([
                        'user_id' => auth()->id() ?? 1,
                        'action' => 'POS KANTIN',
                        'model_type' => 'CanteenTransaction',
                        'model_id' => $posTrx->id,
                        'ip_address' => request()->ip(),
                    ]);
                } catch (\Throwable $e) {}

                return [
                    'invoice' => $invoiceNo,
                    'student' => $student,
                    'remaining' => $remaining,
                    'source' => $source,
                ];
            });

            return redirect()->back()->with('success', "✓ Transaksi POS Kantin Berhasil! [{$result['invoice']}] Siswa: {$result['student']->full_name}, Debit: {$result['source']}, Sisa Saldo: Rp " . number_format($result['remaining'], 0, ',', '.'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
