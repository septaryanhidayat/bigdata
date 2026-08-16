<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Models\Student;
use App\Models\School;

class RealDataImportSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('data/real_users.json');
        if (!file_exists($jsonPath)) {
            $this->command->error("File {$jsonPath} not found!");
            return;
        }

        $content = str_replace("\t", " ", file_get_contents($jsonPath));
        $raw = json_decode($content, true);
        $usersList = $raw['users'] ?? [];

        $defaultPasswordHash = Hash::make('p4l3mb4ng');

        // Disable Foreign Keys during purge
        DB::statement('PRAGMA foreign_keys = OFF;');

        $tablesToClear = [
            'employee_attendance_logs',
            'sdm_mutabaah_logs',
            'leave_requests',
            'student_attendance_logs',
            'bpi_group_members',
            'bpi_groups',
            'students',
            'employees',
            'users'
        ];

        foreach ($tablesToClear as $tbl) {
            if (Schema::hasTable($tbl)) {
                DB::table($tbl)->truncate();
            }
        }

        // 1. Recreate Core Master Admin Account
        $superAdmin = User::create([
            'name' => 'Septa Ryan Hidayat',
            'email' => 'ryan@sitrobbani.sch.id',
            'password' => $defaultPasswordHash,
            'role' => 'SUPER_ADMIN',
            'school_id' => null,
            'phone' => '+6285267774878',
            'is_active' => true,
        ]);

        $adminFallback = User::create([
            'name' => 'Super Admin SmartEdu',
            'email' => 'admin@smartedu.id',
            'password' => $defaultPasswordHash,
            'role' => 'SUPER_ADMIN',
            'school_id' => null,
            'phone' => '081234567890',
            'is_active' => true,
        ]);

        $employeeIdCounter = 1;
        $studentIdCounter = 1;

        $createdEmployees = 0;
        $createdStudents = 0;
        $createdUsers = 0;

        foreach ($usersList as $u) {
            $firstName = trim($u['First Name [Required]'] ?? '');
            $lastName = trim($u['Last Name [Required]'] ?? '');
            $email = strtolower(trim($u['Email Address [Required]'] ?? ''));
            $orgUnit = trim($u['Org Unit Path [Required]'] ?? '/');
            $rawPhone = trim($u['Work Phone'] ?? $u['Recovery Phone [MUST BE IN THE E.164 FORMAT]'] ?? '');

            // Clean noise artifacts in names (like '1', '.', 'a', 'i')
            if (in_array(strtolower($lastName), ['1', '.', 'a', 'i', 's.pd', 's.pd.i', 's.ag', 'se', 's.si', 's.hum', 's.kom', 'm.pd', 'm.ag', 'lc'])) {
                $fullName = $firstName . ($lastName !== '1' && $lastName !== '.' && strlen($lastName) > 1 ? ', ' . $lastName : '');
            } else {
                $fullName = trim($firstName . ' ' . $lastName);
            }

            // Skip duplicate superadmin creation if already done
            if ($email === 'ryan@sitrobbani.sch.id') {
                // Create Employee profile for Septa Ryan Hidayat
                Employee::create([
                    'id' => $employeeIdCounter++,
                    'user_id' => $superAdmin->id,
                    'school_id' => null,
                    'nip' => '198505122026011001',
                    'nik' => '1601018505120001',
                    'full_name' => 'Septa Ryan Hidayat, S.Kom',
                    'role_type' => 'HEADMASTER',
                    'gender' => 'M',
                    'phone' => '+6285267774878',
                    'email' => 'ryan@sitrobbani.sch.id',
                    'address' => 'Indralaya, Ogan Ilir, Sumatera Selatan',
                    'face_photo_url' => '/uploads/faces/face_employee_1.jpg',
                    'face_registered_at' => now(),
                    'face_descriptor' => json_encode(array_fill(0, 128, 0.05)),
                    'join_date' => '2015-07-01',
                    'last_education' => 'S1',
                    'major' => 'Sistem Informasi',
                    'university' => 'Universitas Sriwijaya',
                    'graduation_year' => '2008',
                ]);
                $createdEmployees++;
                continue;
            }

            // 1. SISWA SMP IT ROBBANI
            if (str_contains(strtolower($orgUnit), 'siswa')) {
                $schoolId = 3; // SMPIT
                $classroomId = 7 + ($studentIdCounter % 3); // Kelas 7, 8, atau 9 SMPIT

                $user = User::create([
                    'name' => $fullName,
                    'email' => $email,
                    'password' => $defaultPasswordHash,
                    'role' => 'STUDENT',
                    'school_id' => $schoolId,
                    'phone' => $rawPhone ?: ('08' . rand(1000000000, 9999999999)),
                    'is_active' => true,
                ]);

                Student::create([
                    'id' => $studentIdCounter,
                    'user_id' => $user->id,
                    'school_id' => $schoolId,
                    'classroom_id' => $classroomId,
                    'nis' => 'SMP-' . date('Y') . '-' . str_pad($studentIdCounter, 4, '0', STR_PAD_LEFT),
                    'nisn' => '00' . rand(10000000, 99999999),
                    'full_name' => $fullName,
                    'gender' => ($studentIdCounter % 2 === 0) ? 'F' : 'M',
                    'pob' => 'Palembang',
                    'dob' => '2012-05-15',
                    'status' => 'ACTIVE',
                    'rfid_tag' => 'RFID-STU-' . str_pad($studentIdCounter, 5, '0', STR_PAD_LEFT),
                ]);

                $studentIdCounter++;
                $createdStudents++;
                $createdUsers++;
                continue;
            }

            // 2. GURU / SDM / STAF
            $schoolId = null;
            $role = 'TEACHER';

            if (str_contains($orgUnit, 'TK IT')) {
                $schoolId = 1;
                $role = 'TEACHER';
            } elseif (str_contains($orgUnit, 'SD IT')) {
                $schoolId = 2;
                $role = 'TEACHER';
            } elseif (str_contains($orgUnit, 'SMP IT')) {
                $schoolId = 3;
                $role = 'TEACHER';
            } else {
                // Yayasan / Pusat
                $schoolId = null;
                if ($email === 'keuangan@sitrobbani.sch.id') {
                    $role = 'STAFF_KEUANGAN';
                } elseif ($email === 'sdm@sitrobbani.sch.id' || $email === 'auk@sitrobbani.sch.id') {
                    $role = 'STAFF_TU';
                } else {
                    $role = 'STAFF';
                }
            }

            $user = User::create([
                'name' => $fullName,
                'email' => $email,
                'password' => $defaultPasswordHash,
                'role' => $role,
                'school_id' => $schoolId,
                'phone' => $rawPhone ?: ('08' . rand(1000000000, 9999999999)),
                'is_active' => true,
            ]);

            Employee::create([
                'id' => $employeeIdCounter,
                'user_id' => $user->id,
                'school_id' => $schoolId,
                'nip' => '198' . ($schoolId ?? '0') . date('md') . str_pad($employeeIdCounter, 4, '0', STR_PAD_LEFT),
                'nik' => '16010' . rand(1000000000, 9999999999),
                'full_name' => $fullName,
                'role_type' => in_array($role, ['TEACHER']) ? 'TEACHER' : 'STAFF',
                'gender' => ($employeeIdCounter % 2 === 0) ? 'F' : 'M',
                'phone' => $rawPhone ?: '081270000000',
                'email' => $email,
                'address' => 'Indralaya, Kab. Ogan Ilir, Sumatera Selatan',
                'join_date' => '2020-07-01',
                'last_education' => 'S1',
                'major' => 'Pendidikan',
                'university' => 'Universitas Sriwijaya',
                'graduation_year' => '2016',
            ]);

            $employeeIdCounter++;
            $createdEmployees++;
            $createdUsers++;
        }

        // Re-enable Foreign Keys
        DB::statement('PRAGMA foreign_keys = ON;');

        // Create Default BPI Halaqah for real SDM if table exists
        if (Schema::hasTable('bpi_groups')) {
            $halaqah = DB::table('bpi_groups')->insertGetId([
                'school_id' => 3,
                'name' => 'Halaqah BPI SDM 1 - Utsman Bin Affan',
                'mentor_name' => 'Septa Ryan Hidayat',
                'mentor_phone' => '+6285267774878',
                'schedule_day' => 'Jumat',
                'schedule_time' => '16:00:00',
                'location' => 'Masjid SIT Robbani',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (Schema::hasTable('bpi_group_members')) {
                $first5Emp = DB::table('employees')->where('id', '>', 1)->limit(6)->get();
                foreach ($first5Emp as $emp) {
                    DB::table('bpi_group_members')->insert([
                        'bpi_group_id' => $halaqah,
                        'member_id' => $emp->id,
                        'member_type' => 'EMPLOYEE',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        echo "✓ SUKSES IMPORT DATA REAL SIT ROBBANI:\n";
        echo "  - Total Pegawai & Guru (SDM) Real: {$createdEmployees}\n";
        echo "  - Total Siswa Real: {$createdStudents}\n";
        echo "  - Total Akun User Terdaftar: " . User::count() . "\n";
        echo "  - Password Default Semua Akun: p4l3mb4ng\n";
    }
}
