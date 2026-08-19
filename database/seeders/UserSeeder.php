<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\School;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $tkit = School::where('code', 'TKIT')->first();
        $sdit = School::where('code', 'SDIT')->first();
        $smpit = School::where('code', 'SMPIT')->first();
        $smait = School::where('code', 'SMAIT')->first();

        $defaultPassword = Hash::make('Password@123');
        $superAdminPassword = Hash::make('p4l3mb4ng');

        $users = [
            // 1. Super Admin IT (Akses Penuh)
            [
                'email' => 'admin@smartedu.test',
                'name' => 'Super Admin SmartEdu IT',
                'role' => User::ROLE_SUPER_ADMIN,
                'school_id' => null,
                'password' => $superAdminPassword,
                'nip' => null,
            ],
            // 2. Ketua Yayasan Generasi Robbani
            [
                'email' => 'ketua.yayasan@robbani.sch.id',
                'name' => 'Ustadz H. Mukhtarom, Lc., M.H.I',
                'role' => User::ROLE_YAYASAN_CHAIRMAN,
                'school_id' => null,
                'password' => $defaultPassword,
                'nip' => '197808122010011001',
            ],
            // 3. Kepala KB / TKIT Robbani
            [
                'email' => 'kepala.tkit@robbani.sch.id',
                'name' => 'Ustadzah Eliyana, S.Pd',
                'role' => User::ROLE_HEADMASTER,
                'school_id' => $tkit?->id,
                'password' => $defaultPassword,
                'nip' => '198204152012012001',
            ],
            // 4. Kepala SDIT Robbani
            [
                'email' => 'kepala.sdit@robbani.sch.id',
                'name' => 'Ustadz Ahmad Fauzi, S.Pd.I, M.Pd',
                'role' => User::ROLE_HEADMASTER,
                'school_id' => $sdit?->id,
                'password' => $defaultPassword,
                'nip' => '198406122014011002',
            ],
            // 5. Kepala SMPIT Robbani
            [
                'email' => 'kepala.smpit@robbani.sch.id',
                'name' => 'Ustadzah Tia Wulandari, S.Pd',
                'role' => User::ROLE_HEADMASTER,
                'school_id' => $smpit?->id,
                'password' => $defaultPassword,
                'nip' => '198609202016012003',
            ],
            // 6. Kepala SMAIT Robbani
            [
                'email' => 'kepala.smait@robbani.sch.id',
                'name' => 'Ustadz Drs. H. Ridwan, M.Ag',
                'role' => User::ROLE_HEADMASTER,
                'school_id' => $smait?->id,
                'password' => $defaultPassword,
                'nip' => '198003102011011004',
            ],
            // 7. Staf Tata Usaha (TU)
            [
                'email' => 'tu@robbani.sch.id',
                'name' => 'Budi Santoso, S.Kom (Tata Usaha)',
                'role' => User::ROLE_STAFF_TU,
                'school_id' => $smpit?->id,
                'password' => $defaultPassword,
                'nip' => '199501012026011010',
            ],
            // 8. Staf Keuangan / Bendahara
            [
                'email' => 'keuangan@robbani.sch.id',
                'name' => 'Dewi Safitri, A.Md (Bendahara)',
                'role' => User::ROLE_STAFF_KEUANGAN,
                'school_id' => $sdit?->id,
                'password' => $defaultPassword,
                'nip' => '199703142026012012',
            ],
            // 9. Dewan Guru (Pendidik)
            [
                'email' => 'guru@robbani.sch.id',
                'name' => 'Ustadz Rizky, S.Pd.I (Guru)',
                'role' => User::ROLE_TEACHER,
                'school_id' => $smpit?->id,
                'password' => $defaultPassword,
                'nip' => '198505122026011001',
            ],
            // 10. Guru BK (Bimbingan Konseling)
            [
                'email' => 'bk@robbani.sch.id',
                'name' => 'Ustadzah Fitriana, S.Si (Guru BK)',
                'role' => User::ROLE_GURU_BK,
                'school_id' => $sdit?->id,
                'password' => $defaultPassword,
                'nip' => '199003202026011003',
            ],
            // 11. Pembina Asrama / Musyrif Boarding
            [
                'email' => 'musyrif@robbani.sch.id',
                'name' => 'Ustadz Syamsul Arifin, Lc (Musyrif)',
                'role' => User::ROLE_MUSYRIF_ASRAMA,
                'school_id' => $sdit?->id,
                'password' => $defaultPassword,
                'nip' => '199102122026012005',
            ],
            // 12. Petugas Perpustakaan (Pustakawan)
            [
                'email' => 'perpus@robbani.sch.id',
                'name' => 'Ustadzah Maryam Al-Zahra (Pustakawan)',
                'role' => User::ROLE_PETUGAS_PERPUS,
                'school_id' => $smpit?->id,
                'password' => $defaultPassword,
                'nip' => '199306182026012006',
            ],
            // 13. Petugas / Kasir Kantin RFID
            [
                'email' => 'kantin@robbani.sch.id',
                'name' => 'Herman Syahputra (Kasir Kantin)',
                'role' => User::ROLE_PETUGAS_KANTIN,
                'school_id' => $smpit?->id,
                'password' => $defaultPassword,
                'nip' => '199208082026011011',
            ],
            // 14. Panitia PPDB & CBT
            [
                'email' => 'ppdb@robbani.sch.id',
                'name' => 'Ustadz Youssef, S.Kom (Panitia PPDB)',
                'role' => User::ROLE_PANITIA_PPDB,
                'school_id' => $smpit?->id,
                'password' => $defaultPassword,
                'nip' => '199605052026011009',
            ],
            // 15. Petugas Sarana & Prasarana (Sarpras)
            [
                'email' => 'sarpras@robbani.sch.id',
                'name' => 'Ustadz Drs. Abdullah, S.Pd (Sarpras)',
                'role' => User::ROLE_PETUGAS_SARPRAS,
                'school_id' => $smait?->id,
                'password' => $defaultPassword,
                'nip' => '198711042026011004',
            ],
            // 16. Humas Yayasan (Kelola Website Utama & Semua Web Unit)
            [
                'email' => 'humas@sitrobbani.sch.id',
                'name' => 'Humas Yayasan SIT Robbani',
                'role' => User::ROLE_HUMAS,
                'school_id' => null,
                'password' => Hash::make('p4l3mb4ng'),
                'nip' => null,
            ],
            // 17. Admin Web Unit TKIT
            [
                'email' => 'tk@sitrobbani.sch.id',
                'name' => 'Admin Web TKIT Robbani',
                'role' => User::ROLE_ADMIN_WEB_UNIT,
                'school_id' => $tkit?->id,
                'password' => Hash::make('p4l3mb4ng'),
                'nip' => null,
            ],
            // 18. Admin Web Unit SDIT
            [
                'email' => 'sd@sitrobbani.sch.id',
                'name' => 'Admin Web SDIT Robbani',
                'role' => User::ROLE_ADMIN_WEB_UNIT,
                'school_id' => $sdit?->id,
                'password' => Hash::make('p4l3mb4ng'),
                'nip' => null,
            ],
            // 19. Admin Web Unit SMPIT
            [
                'email' => 'smp@sitrobbani.sch.id',
                'name' => 'Admin Web SMPIT Robbani',
                'role' => User::ROLE_ADMIN_WEB_UNIT,
                'school_id' => $smpit?->id,
                'password' => Hash::make('p4l3mb4ng'),
                'nip' => null,
            ],
        ];

        foreach ($users as $u) {
            $user = User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'role' => $u['role'],
                    'school_id' => $u['school_id'],
                    'password' => $u['password'],
                ]
            );

            // Connect to employee table if NIP is present
            if (!empty($u['nip'])) {
                Employee::where('nip', $u['nip'])->update(['user_id' => $user->id]);
            }
        }
    }
}
