<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class EmployeeDossierController extends Controller
{
    /**
     * Daftar Lengkap Database & E-Berkas SDM Guru & Karyawan
     */
    public function index(Request $request)
    {
        $schoolId = $request->input('school_id', session('selected_school_id', 'all'));
        $search = $request->input('search');
        $roleType = $request->input('role_type');
        $status = $request->input('employment_status');

        $query = Employee::with('school');

        if ($schoolId && $schoolId !== 'all') {
            $query->where('school_id', $schoolId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($roleType) {
            $query->where('role_type', $roleType);
        }

        if ($status) {
            $query->where('employment_status', $status);
        }

        $employees = $query->orderBy('id', 'desc')->paginate(15)->withQueryString();
        $schools = School::all();

        // Metrics Summary
        $totalEmployees = Employee::count();
        $totalTeachers = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER'])->count();
        $totalStaff = Employee::where('role_type', 'STAFF')->count();
        $completeDossierCount = Employee::whereNotNull('file_ktp')
            ->whereNotNull('file_kk')
            ->whereNotNull('file_ijazah')
            ->count();

        return view('admin.employees.index', compact(
            'employees',
            'schools',
            'schoolId',
            'search',
            'roleType',
            'status',
            'totalEmployees',
            'totalTeachers',
            'totalStaff',
            'completeDossierCount'
        ));
    }

    /**
     * Tampilkan Profil & Berkas Lengkap Pegawai
     */
    public function show($id)
    {
        $employee = Employee::with('school')->findOrFail($id);

        // Riwayat Presensi Terakhir
        $recentAttendances = [];
        if (Schema::hasTable('employee_attendance_logs')) {
            $recentAttendances = DB::table('employee_attendance_logs')
                ->where('employee_id', $employee->id)
                ->orderBy('date', 'desc')
                ->limit(10)
                ->get();
        }

        return view('admin.employees.show', compact('employee', 'recentAttendances'));
    }

    /**
     * Form Edit Data & Upload Berkas Lengkap SDM
     */
    public function edit($id)
    {
        $employee = Employee::with('school')->findOrFail($id);
        $schools = School::all();

        return view('admin.employees.edit', compact('employee', 'schools'));
    }

    /**
     * Simpan Perubahan Profil & Unggah Dokumen SDM
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:30',
            'kk_number' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'phone' => 'nullable|string|max:30',
            'school_id' => 'required|exists:schools,id',
            'role_type' => 'required|string',
            'employment_status' => 'required|string',
            'pob' => 'nullable|string|max:100',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:M,F',
            'blood_type' => 'nullable|string|max:5',
            'marital_status' => 'nullable|string|max:30',
            'children_count' => 'nullable|integer',
            'last_education' => 'nullable|string|max:50',
            'major' => 'nullable|string|max:150',
            'university' => 'nullable|string|max:150',
            'graduation_year' => 'nullable|string|max:10',
            'join_date' => 'nullable|date',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            
            // Upload Dokumen Berkas
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_surat_lamaran' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_kontrak_kerja' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_prestasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_bpjs' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only([
            'school_id', 'nip', 'nik', 'kk_number', 'full_name', 'title_prefix', 'title_suffix',
            'gender', 'pob', 'dob', 'religion', 'blood_type', 'marital_status', 'children_count',
            'phone', 'email', 'address', 'role_type', 'employment_status', 'last_education',
            'major', 'university', 'graduation_year', 'join_date', 'notes'
        ]);

        // Proses Unggah Berkas Digital SDM
        $documentFields = [
            'file_ktp', 'file_kk', 'file_ijazah', 'file_surat_lamaran', 
            'file_kontrak_kerja', 'file_sertifikat', 'file_prestasi', 'file_npwp', 'file_bpjs'
        ];

        foreach ($documentFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = "sdm_{$employee->id}_{$field}_" . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/sdm_dossier', $filename, 'public');
                $data[$field] = '/storage/' . $path;
            }
        }

        $employee->update($data);

        // Sinkronisasi dengan User jika terhubung
        if ($employee->user_id) {
            $user = User::find($employee->user_id);
            if ($user) {
                $user->name = $employee->full_name;
                if ($employee->email) $user->email = $employee->email;
                $user->save();
            }
        }

        return redirect()->route('admin.employees.show', $employee->id)
            ->with('success', '✓ Biodata & Berkas Digital Pegawai Berhasil Diperbarui!');
    }
}
