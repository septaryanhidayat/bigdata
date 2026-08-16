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
        $schoolId = $request->input('school_id');
        $search = trim((string)$request->input('search'));
        $roleType = $request->input('role_type');
        $status = $request->input('employment_status');
        $dossierStatus = $request->input('dossier_status');
        $faceStatus = $request->input('face_status');
        $perPage = $request->input('per_page', 25);

        $query = Employee::with('school');

        // 1. Filter Unit Sekolah / Yayasan
        if ($schoolId !== null && $schoolId !== '' && $schoolId !== 'all') {
            if ($schoolId === 'yayasan' || $schoolId === '0') {
                $query->whereNull('school_id');
            } else {
                $query->where('school_id', $schoolId);
            }
        }

        // 2. Filter Pencarian Cepat
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('major', 'like', "%{$search}%")
                  ->orWhere('university', 'like', "%{$search}%");
            });
        }

        // 3. Filter Peran / Jabatan
        if (!empty($roleType) && $roleType !== 'all') {
            if ($roleType === 'GURU') {
                $query->whereIn('role_type', ['TEACHER', 'HEADMASTER']);
            } else {
                $query->where('role_type', $roleType);
            }
        }

        // 4. Filter Status Kepegawaian
        if (!empty($status) && $status !== 'all') {
            $query->where('employment_status', $status);
        }

        // 5. Filter Kelengkapan Berkas
        if ($dossierStatus === 'complete') {
            $query->whereNotNull('file_ktp')
                  ->whereNotNull('file_kk')
                  ->whereNotNull('file_ijazah');
        } elseif ($dossierStatus === 'incomplete') {
            $query->where(function ($q) {
                $q->whereNull('file_ktp')
                  ->orWhereNull('file_kk')
                  ->orWhereNull('file_ijazah');
            });
        }

        // 6. Filter Status Face ID
        if ($faceStatus === 'registered') {
            $query->whereNotNull('face_registered_at');
        } elseif ($faceStatus === 'unregistered') {
            $query->whereNull('face_registered_at');
        }

        // 7. Pagination Size
        $perPageInt = 25;
        if ($perPage === 'all' || (int)$perPage >= 10000 || (int)$perPage === -1) {
            $perPageInt = 10000;
        } elseif (in_array((int)$perPage, [15, 25, 50, 100, 500, 1000])) {
            $perPageInt = (int)$perPage;
        }

        $employees = $query->orderBy('full_name', 'asc')->paginate($perPageInt)->withQueryString();
        $schools = School::orderBy('id', 'asc')->get();

        // Metrics Summary (Global Across All SDM)
        $totalEmployees = Employee::count();
        $totalTeachers = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER'])->count();
        $totalStaff = Employee::where('role_type', 'STAFF')->count();
        $completeDossierCount = Employee::whereNotNull('file_ktp')
            ->whereNotNull('file_kk')
            ->whereNotNull('file_ijazah')
            ->count();
        $enrolledFaceCount = Employee::whereNotNull('face_registered_at')->count();
        $enrolledFaces = $enrolledFaceCount;

        return view('admin.employees.index', compact(
            'employees',
            'schools',
            'schoolId',
            'search',
            'roleType',
            'status',
            'dossierStatus',
            'faceStatus',
            'perPage',
            'totalEmployees',
            'totalTeachers',
            'totalStaff',
            'completeDossierCount',
            'enrolledFaceCount',
            'enrolledFaces'
        ));
    }

    /**
     * Tampilkan Detail Dossier & Curriculum Vitae Pegawai
     */
    public function show($id)
    {
        $employee = Employee::with(['school', 'user'])->findOrFail($id);

        $attendanceLogs = DB::table('employee_attendance_logs')
            ->where('employee_id', $id)
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        $dossierFiles = [
            ['title' => 'Scan KTP', 'field' => 'file_ktp', 'icon' => '🪪', 'val' => $employee->file_ktp],
            ['title' => 'Scan Kartu Keluarga (KK)', 'field' => 'file_kk', 'icon' => '👨‍👩‍👧', 'val' => $employee->file_kk],
            ['title' => 'Ijazah & Transkrip Nilai', 'field' => 'file_ijazah', 'icon' => '🎓', 'val' => $employee->file_ijazah],
            ['title' => 'Surat Lamaran Kerja', 'field' => 'file_surat_lamaran', 'icon' => '✉️', 'val' => $employee->file_surat_lamaran],
            ['title' => 'SK / Kontrak Kerja (PKWT/PTY)', 'field' => 'file_kontrak_kerja', 'icon' => '📜', 'val' => $employee->file_kontrak_kerja],
            ['title' => 'Sertifikat Pendidik / Pelatihan', 'field' => 'file_sertifikat', 'icon' => '🎖️', 'val' => $employee->file_sertifikat],
            ['title' => 'Piagam Prestasi & Penghargaan', 'field' => 'file_prestasi', 'icon' => '🏆', 'val' => $employee->file_prestasi],
            ['title' => 'Kartu NPWP', 'field' => 'file_npwp', 'icon' => '💼', 'val' => $employee->file_npwp],
            ['title' => 'Kartu BPJS Kesehatan / TK', 'field' => 'file_bpjs', 'icon' => '🏥', 'val' => $employee->file_bpjs],
        ];

        $uploadedCount = 0;
        foreach ($dossierFiles as $f) {
            if (!empty($f['val'])) $uploadedCount++;
        }

        $recentAttendances = $attendanceLogs;

        return view('admin.employees.show', compact('employee', 'attendanceLogs', 'recentAttendances', 'dossierFiles', 'uploadedCount'));
    }

    /**
     * Formulir Edit Lengkap Data Pribadi & Upload Berkas Dossier
     */
    public function edit($id)
    {
        $employee = Employee::with(['school', 'user'])->findOrFail($id);
        $schools = School::all();

        return view('admin.employees.edit', compact('employee', 'schools'));
    }

    /**
     * Simpan Pembaruan Data Dossier & Berkas Dokumen SDM
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $request->validate([
            'full_name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nik' => 'nullable|string|max:30',
            'kk_number' => 'nullable|string|max:30',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'role_type' => 'required|string',
            'employment_status' => 'nullable|string',
            'last_education' => 'nullable|string',
            'major' => 'nullable|string|max:255',
            'university' => 'nullable|string|max:255',
            'graduation_year' => 'nullable|string|max:10',
            'join_date' => 'nullable|date',
            'notes' => 'nullable|string',
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

        $updateData = [
            'full_name' => $request->full_name,
            'nip' => $request->nip,
            'nik' => $request->nik,
            'gender' => $request->gender ?? $employee->gender ?? 'M',
            'kk_number' => $request->kk_number,
            'school_id' => ($request->school_id === 'yayasan' || empty($request->school_id)) ? null : $request->school_id,
            'role_type' => $request->role_type ?? $employee->role_type ?? 'TEACHER',
            'employment_status' => $request->employment_status ?? $employee->employment_status ?? 'TETAP',
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'pob' => $request->pob,
            'dob' => $request->dob,
            'religion' => $request->religion ?? $employee->religion ?? 'Islam',
            'blood_type' => $request->blood_type ?? $employee->blood_type ?? '-',
            'marital_status' => $request->marital_status ?? $employee->marital_status ?? 'MENIKAH',
            'children_count' => (int) ($request->children_count ?? $employee->children_count ?? 0),
            'last_education' => $request->last_education ?? $employee->last_education ?? 'S1',
            'major' => $request->major,
            'university' => $request->university,
            'graduation_year' => $request->graduation_year,
            'join_date' => $request->join_date,
            'notes' => $request->notes,
        ];

        // Handle 9 Digital File Dossier Uploads
        $fileFields = [
            'file_ktp', 'file_kk', 'file_ijazah', 'file_surat_lamaran', 
            'file_kontrak_kerja', 'file_sertifikat', 'file_prestasi', 
            'file_npwp', 'file_bpjs'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = $field . '_emp_' . $employee->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('uploads/dossier', $filename, 'public');
                $updateData[$field] = '/storage/' . $path;
            }
        }

        // Handle Foto Profil & Biometrik Wajah
        if ($request->hasFile('avatar') || $request->hasFile('face_photo') || $request->hasFile('photo')) {
            $photoFile = $request->file('avatar') ?? $request->file('face_photo') ?? $request->file('photo');
            $uploadDir = public_path('uploads/faces');
            if (!file_exists($uploadDir)) {
                @mkdir($uploadDir, 0777, true);
            }
            $ext = $photoFile->getClientOriginalExtension() ?: 'jpg';
            $filename = 'face_employee_' . $employee->id . '_' . time() . '.' . $ext;
            $photoFile->move($uploadDir, $filename);
            $photoUrl = '/uploads/faces/' . $filename;
            $updateData['face_photo_url'] = $photoUrl;
            $updateData['face_registered_at'] = now();
        }

        $employee->update($updateData);
        $employee->refresh();

        // Sync with users table if account linked
        $user = $employee->user_id ? User::find($employee->user_id) : User::where('email', $employee->email)->first();
        if ($user) {
            $userData = [
                'name' => $request->full_name,
                'school_id' => $updateData['school_id'],
            ];
            if ($request->filled('email')) $userData['email'] = $request->email;
            if ($request->filled('phone')) $userData['phone'] = $request->phone;
            if (isset($updateData['face_photo_url'])) {
                $userData['avatar'] = $updateData['face_photo_url'];
            }
            $user->update($userData);

            if (!$employee->user_id) {
                $employee->update(['user_id' => $user->id]);
            }
        }

        return redirect()->route('admin.employees.show', $employee->id)
            ->with('success', "✓ Data Induk & E-Berkas SDM untuk {$employee->full_name} berhasil diperbarui!");
    }
}
