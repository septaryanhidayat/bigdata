<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SarprasAsset;
use App\Models\School;
use App\Models\AuditLog;
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
        $totalAssetValue = $assets->sum(function($a) { return (float) $a->purchase_cost * (int) $a->quantity; });

        return view('admin.sarpras.index', compact('assets', 'totalAssetValue', 'schoolId'));
    }

    public function store(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'asset_code' => 'required|string|max:100|unique:sarpras_assets,asset_code',
            'category' => 'required|string|max:50',
            'quantity' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'purchase_cost' => 'required|numeric|min:0',
            'condition' => 'nullable|string|in:GOOD,LIGHT_DAMAGE,HEAVY_DAMAGE',
        ]);

        $targetSchoolId = $schoolId ?: ($request->school_id ?? School::first()?->id ?? 1);
        $validated['school_id'] = $targetSchoolId;
        $validated['condition'] = $request->condition ?? 'GOOD';

        $asset = SarprasAsset::create($validated);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'INPUT ASET SARPRAS',
                'model_type' => 'SarprasAsset',
                'model_id' => $asset->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Aset Sarpras Baru Berhasil Ditambahkan!');
    }

    public function destroy($id)
    {
        $asset = SarprasAsset::findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $asset->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak berwenang menghapus aset unit ini.');
        }

        $asset->delete();
        return redirect()->back()->with('success', '✓ Aset Sarpras berhasil dihapus.');
    }
}
