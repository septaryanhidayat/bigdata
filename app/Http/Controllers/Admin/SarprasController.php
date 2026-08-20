<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SarprasAsset;
use App\Models\School;
use Illuminate\Http\Request;

class SarprasController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $assetsQuery = SarprasAsset::with('school');

        if ($schoolId) {
            $assetsQuery->where('school_id', $schoolId);
        }

        $assets = $assetsQuery->latest()->get();

        if ($assets->isEmpty()) {
            $schoolObj = $schoolId ? School::find($schoolId) : null;
            $unitName = $schoolObj?->code ?? 'Sekolah';

            $samples = [
                ['name' => 'PC Lab Komputer i7 16GB', 'code' => 'AST-LAB-001', 'category' => 'ELEKTRONIK', 'qty' => 30, 'loc' => "Lab Komputer {$unitName}", 'cost' => 12500000],
                ['name' => 'Proyektor Epson 4K HD', 'code' => 'AST-PRJ-002', 'category' => 'ELEKTRONIK', 'qty' => 12, 'loc' => "Ruang Aula Utama {$unitName}", 'cost' => 8900000],
                ['name' => 'Meja Kursi Siswa Ergonomis', 'code' => 'AST-MJ-003', 'category' => 'MEBEL', 'qty' => 120, 'loc' => "Gedung {$unitName} Rombel A-D", 'cost' => 450000],
            ];

            foreach ($samples as $s) {
                $targetSchoolId = $schoolId ? $schoolId : (School::first()?->id ?? 1);
                $assetCode = $s['code'] . '-S' . $targetSchoolId;

                SarprasAsset::firstOrCreate(
                    ['asset_code' => $assetCode],
                    [
                        'school_id' => $targetSchoolId,
                        'name' => $s['name'],
                        'category' => $s['category'],
                        'quantity' => $s['qty'],
                        'location' => $s['loc'],
                        'condition' => 'GOOD',
                        'purchase_cost' => $s['cost'],
                    ]
                );
            }
            $assets = $assetsQuery->latest()->get();
        }

        $totalAssetValue = $assets->sum(function($a) { return $a->purchase_cost * $a->quantity; });

        return view('admin.sarpras.index', compact('assets', 'totalAssetValue', 'schoolId'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user && $user->school_id ? $user->school_id : ($request->school_id ?? (School::first()?->id ?? 1));

        $validated = $request->validate([
            'name' => 'required|string',
            'asset_code' => 'required|string|unique:sarpras_assets,asset_code',
            'category' => 'required|string',
            'quantity' => 'required|integer',
            'location' => 'required|string',
            'purchase_cost' => 'required|numeric',
        ]);

        $schoolId = session('dashboard_school_id', 'all');
        $validated['school_id'] = ($schoolId !== 'all') ? $schoolId : School::first()?->id;

        $asset = SarprasAsset::create($validated);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'INPUT ASET SARPRAS',
                'model_type' => 'SarprasAsset',
                'model_id' => $asset->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Aset Sarpras Baru Berhasil Ditambahkan!');
    }
}
