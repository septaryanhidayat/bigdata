<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;
use App\Models\Classroom;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DemoAccountsSeeder extends Seeder
{
    private function createUser(string $email, string $name, string $role, int $schoolId, string $phone = ''): User
    {
        $data = [
            'name' => $name,
            'password' => Hash::make('admin123'),
            'role' => $role,
            'school_id' => $schoolId,
        ];

        if (Schema::hasColumn('users', 'is_active')) {
            $data['is_active'] = true;
        }
        if (Schema::hasColumn('users', 'phone')) {
            $data['phone'] = $phone;
        }

        return User::updateOrCreate(['email' => $email], $data);
    }

    private function createEmployee(string $email, string $fullName, string $prefix, string $suffix, int $schoolId, string $nip, string $phone = ''): Employee
    {
        $data = [
            'school_id' => $schoolId,
            'full_name' => $fullName,
        ];

        if (Schema::hasColumn('employees', 'title_prefix')) $data['title_prefix'] = $prefix;
        if (Schema::hasColumn('employees', 'title_suffix')) $data['title_suffix'] = $suffix;
        if (Schema::hasColumn('employees', 'nip')) $data['nip'] = $nip;
        if (Schema::hasColumn('employees', 'role_type')) $data['role_type'] = 'TEACHER';
        if (Schema::hasColumn('employees', 'employment_status')) $data['employment_status'] = 'TETAP';
        if (Schema::hasColumn('employees', 'is_active')) $data['is_active'] = true;
        if (Schema::hasColumn('employees', 'phone')) $data['phone'] = $phone;

        return Employee::updateOrCreate(['email' => $email], $data);
    }

    public function run(): void
    {
        // 1. Akun Operator SMPIT
        $this->createUser('operator.smpit@sitrobbani.sch.id', 'Ustadzah Fatimah, S.Kom (Operator SMPIT)', User::ROLE_STAFF_TU, 3, '08123456001');

        // 2. Akun Guru & Walas SMPIT (Kelas 7A)
        $empGuruSmpit = $this->createEmployee('guru.smpit@sitrobbani.sch.id', 'Ahmad Fauzi', 'Ustadz', 'S.Pd', 3, '198501012010011005', '08123456002');
        $this->createUser('guru.smpit@sitrobbani.sch.id', 'Ustadz Ahmad Fauzi, S.Pd (Guru & Walas 7A)', User::ROLE_TEACHER, 3, '08123456002');

        // Assign to Classroom 4 (Kelas 7A) as homeroom teacher if exists
        $cls7a = Classroom::find(4);
        if ($cls7a) {
            $cls7a->update(['homeroom_teacher_id' => $empGuruSmpit->id]);
        }

        // 3. Akun Kepala Sekolah SMPIT
        $this->createUser('kepsek.smpit@sitrobbani.sch.id', 'Ustadz Dr. H. Sulaiman, M.Pd (Kepsek SMPIT)', User::ROLE_HEADMASTER, 3, '08123456003');

        // 4. Akun Operator SDIT
        $this->createUser('operator.sdit@sitrobbani.sch.id', 'Ustadzah Maryam, S.Pd (Operator SDIT)', User::ROLE_STAFF_TU, 2, '08123456004');

        // 5. Akun Guru SDIT
        $this->createEmployee('guru.sdit@sitrobbani.sch.id', 'Halimah', 'Ustadzah', 'S.Pd', 2, '198702022011022003', '08123456005');
        $this->createUser('guru.sdit@sitrobbani.sch.id', 'Ustadzah Halimah, S.Pd (Guru SDIT)', User::ROLE_TEACHER, 2, '08123456005');

        // 6. Akun Kepala Sekolah SDIT
        $this->createUser('kepsek.sdit@sitrobbani.sch.id', 'Ustadz Drs. H. Usman, M.Pd.I (Kepsek SDIT)', User::ROLE_HEADMASTER, 2, '08123456006');

        $this->command->info('Akun resmi SDM (Guru, Operator, Kepsek) untuk SMPIT & SDIT berhasil dibuat dengan domain @sitrobbani.sch.id!');
    }
}
