<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\School;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Tampilkan Halaman Utama Manajemen Akun Pengguna
     */
    public function index(Request $request)
    {
        $query = User::with(['school', 'employee']);

        // Search filter
        if ($request->filled('search')) {
            $s = trim($request->search);
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('phone', 'like', "%{$s}%");
            });
        }

        // Role filter
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $authUser = auth()->user();
        if ($authUser && $authUser->school_id && !$authUser->isSuperAdmin() && !$authUser->isYayasan()) {
            $query->where('school_id', $authUser->school_id);
        } elseif ($request->filled('school_id') && $request->school_id !== 'all') {
            if ($request->school_id === 'yayasan') {
                $query->whereNull('school_id');
            } else {
                $query->where('school_id', $request->school_id);
            }
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active' ? 1 : 0);
        }

        $allUsers = $query->orderBy('role')->latest('id')->get();
        $users = $query->orderBy('role')->latest('id')->paginate(500);

        // Stats Summary
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $adminCount = User::whereIn('role', [User::ROLE_SUPER_ADMIN, User::ROLE_YAYASAN_CHAIRMAN])->count();
        $headmasterCount = User::where('role', User::ROLE_HEADMASTER)->count();
        $teacherCount = User::where('role', User::ROLE_TEACHER)->count();
        $staffCount = User::whereIn('role', [
            User::ROLE_STAFF_TU, User::ROLE_STAFF_KEUANGAN, User::ROLE_GURU_BK,
            User::ROLE_MUSYRIF_ASRAMA, User::ROLE_PETUGAS_PERPUS, User::ROLE_PETUGAS_KANTIN,
            User::ROLE_PANITIA_PPDB, User::ROLE_PETUGAS_SARPRAS
        ])->count();

        $schools = School::all();
        $employees = Employee::where('is_active', true)->orderBy('full_name')->get();

        $roleOptions = [
            User::ROLE_SUPER_ADMIN => '👑 Super Admin IT',
            User::ROLE_YAYASAN_CHAIRMAN => '🏛️ Ketua Yayasan',
            User::ROLE_HUMAS => '📢 Humas Yayasan',
            User::ROLE_ADMIN_WEB_UNIT => '🌐 Admin Web Unit',
            User::ROLE_HEADMASTER => '🏫 Kepala Sekolah',
            User::ROLE_STAFF_TU => '📋 Tata Usaha (TU)',
            User::ROLE_STAFF_KEUANGAN => '💰 Bendahara / Keuangan',
            User::ROLE_TEACHER => '👨‍🏫 Dewan Guru',
            User::ROLE_GURU_BK => '👥 Guru BK (Konseling)',
            User::ROLE_MUSYRIF_ASRAMA => '🕌 Pembina Asrama / Musyrif',
            User::ROLE_PETUGAS_PERPUS => '📚 Pustakawan',
            User::ROLE_PETUGAS_KANTIN => '🍽️ Kasir Kantin RFID',
            User::ROLE_PANITIA_PPDB => '🎯 Panitia PPDB & CBT',
            User::ROLE_PETUGAS_SARPRAS => '🏢 Pengelola Sarpras & Aset',
        ];

        return view('admin.users.index', compact(
            'users', 'allUsers', 'totalUsers', 'activeUsers', 'adminCount',
            'headmasterCount', 'teacherCount', 'staffCount',
            'schools', 'employees', 'roleOptions'
        ));
    }

    /**
     * Simpan Akun Pengguna Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'school_id' => 'nullable|exists:schools,id',
            'phone' => 'nullable|string|max:30',
            'is_active' => 'nullable',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'school_id' => in_array($validated['role'], [User::ROLE_SUPER_ADMIN, User::ROLE_YAYASAN_CHAIRMAN, User::ROLE_HUMAS]) ? null : ($validated['school_id'] ?: null),
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        if ($request->filled('employee_id')) {
            $emp = Employee::find($request->employee_id);
            if ($emp) {
                $emp->user_id = $user->id;
                $emp->save();
            }
        }

        return redirect()->route('admin.users.index')->with('success', "✓ Akun pengguna '{$user->name}' ({$user->email}) berhasil dibuat!");
    }

    /**
     * Update Data Akun Pengguna
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:6',
            'role' => 'required|string',
            'school_id' => 'nullable|exists:schools,id',
            'phone' => 'nullable|string|max:30',
            'is_active' => 'nullable',
            'employee_id' => 'nullable|exists:employees,id',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'school_id' => in_array($validated['role'], [User::ROLE_SUPER_ADMIN, User::ROLE_YAYASAN_CHAIRMAN, User::ROLE_HUMAS]) ? null : ($validated['school_id'] ?: null),
            'phone' => $validated['phone'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        if ($request->filled('employee_id')) {
            Employee::where('user_id', $user->id)->update(['user_id' => null]);
            $emp = Employee::find($request->employee_id);
            if ($emp) {
                $emp->user_id = $user->id;
                $emp->save();
            }
        }

        return redirect()->route('admin.users.index')->with('success', "✓ Data akun '{$user->name}' berhasil diperbarui!");
    }

    /**
     * Reset Password Cepat ke Default (Password@123) atau Password Baru
     */
    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $newPass = $request->input('new_password', 'Password@123');

        $user->update([
            'password' => Hash::make($newPass),
        ]);

        return redirect()->back()->with('success', "✓ Password untuk akun '{$user->name}' ({$user->email}) berhasil direset menjadi: {$newPass}");
    }

    /**
     * Toggle Status Aktif / Nonaktifkan Akun
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', '⛔ Anda tidak dapat menonaktifkan akun yang sedang Anda gunakan saat ini!');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusStr = $user->is_active ? 'Diaktifkan' : 'Dinonaktifkan';
        return redirect()->back()->with('success', "✓ Akun '{$user->name}' berhasil {$statusStr}!");
    }

    /**
     * Hapus Akun Pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', '⛔ Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif login!');
        }

        if ($user->email === 'admin@smartedu.test') {
            return redirect()->back()->with('error', '⛔ Akun Master Super Admin Utama tidak boleh dihapus demi keamanan sistem!');
        }

        $userName = $user->name;
        $userEmail = $user->email;

        // Unlink employee if linked
        Employee::where('user_id', $user->id)->update(['user_id' => null]);

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "✓ Akun '{$userName}' ({$userEmail}) berhasil dihapus dari sistem!");
    }

    /**
     * Ekspor Rekap Akun Pengguna ke Format CSV
     */
    public function export()
    {
        $users = User::with('school')->get();
        $filename = 'export_user_accounts_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Nama Lengkap', 'Email', 'Role / Peran', 'Unit Sekolah', 'No. HP', 'Status', 'Terdaftar Pada']);

            foreach ($users as $u) {
                fputcsv($file, [
                    $u->id,
                    $u->name,
                    $u->email,
                    $u->role_name_label,
                    $u->school->name ?? 'Yayasan (Semua Unit)',
                    $u->phone ?? '-',
                    $u->is_active ? 'AKTIF' : 'NONAKTIF',
                    $u->created_at->format('d/m/Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
