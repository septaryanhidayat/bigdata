<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\Level;
use App\Models\Classroom;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Employee;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\SppBill;
use App\Models\SppPayment;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\SavingsTransaction;
use App\Models\CanteenOutlet;
use App\Models\CanteenProduct;
use App\Models\CanteenTransaction;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Schools
        $sdit = School::updateOrCreate(
            ['code' => 'SDIT'],
            [
                'name' => 'SD Islam Terpadu Robbani',
                'npsn' => '20198032',
                'principal_name' => 'Ustadz Ahmad Fauzi, S.Pd.I, M.Pd',
                'address' => 'Jl. Pendidikan Karakter No. 1, Bandung',
                'phone' => '0812-3456-7890',
                'email' => 'sdit@robbani.sch.id',
                'theme_color' => '#059669',
            ]
        );

        $smpit = School::updateOrCreate(
            ['code' => 'SMPIT'],
            [
                'name' => 'SMP Islam Terpadu Robbani',
                'npsn' => '20198033',
                'principal_name' => 'Ustadzah Sri Nurhidayat, M.Pd',
                'address' => 'Jl. Pendidikan Karakter No. 2, Bandung',
                'phone' => '0812-3456-7891',
                'email' => 'smpit@robbani.sch.id',
                'theme_color' => '#0284c7',
            ]
        );

        $smait = School::updateOrCreate(
            ['code' => 'SMAIT'],
            [
                'name' => 'SMA Islam Terpadu Robbani',
                'npsn' => '20198034',
                'principal_name' => 'Ustadz Drs. H. Ridwan, M.Ag',
                'address' => 'Jl. Pendidikan Karakter No. 3, Bandung',
                'phone' => '0812-3456-7892',
                'email' => 'smait@robbani.sch.id',
                'theme_color' => '#7c3aed',
            ]
        );

        // 2. Academic Years
        $ay = AcademicYear::updateOrCreate(
            ['name' => '2026/2027', 'semester' => 'Ganjil'],
            [
                'curriculum_code' => 'KURIKULUM_MERDEKA_JSIT',
                'is_active' => true,
                'start_date' => '2026-07-15',
                'end_date' => '2026-12-20',
            ]
        );

        // 3. Levels
        $lvlSD1 = Level::updateOrCreate(['school_id' => $sdit->id, 'code' => 'SD1'], ['name' => 'Kelas 1 SD']);
        $lvlSD2 = Level::updateOrCreate(['school_id' => $sdit->id, 'code' => 'SD2'], ['name' => 'Kelas 2 SD']);
        $lvlSMP7 = Level::updateOrCreate(['school_id' => $smpit->id, 'code' => 'SMP7'], ['name' => 'Kelas 7 SMP']);
        $lvlSMP8 = Level::updateOrCreate(['school_id' => $smpit->id, 'code' => 'SMP8'], ['name' => 'Kelas 8 SMP']);
        $lvlSMA10 = Level::updateOrCreate(['school_id' => $smait->id, 'code' => 'SMA10'], ['name' => 'Kelas 10 SMA']);
        $lvlSMA11 = Level::updateOrCreate(['school_id' => $smait->id, 'code' => 'SMA11'], ['name' => 'Kelas 11 SMA']);

        // 4. Employees (12+ Guru & Staf Non-Guru)
        $teachersData = [
            ['nip' => '198505122026011001', 'school' => $smpit, 'name' => 'Ustadz Rizky S.Pd.I', 'role' => 'TEACHER', 'gender' => 'M'],
            ['nip' => '198807152026012002', 'school' => $smpit, 'name' => 'Ustadzah Siti Nurhaliza M.Pd', 'role' => 'TEACHER', 'gender' => 'F'],
            ['nip' => '199003202026011003', 'school' => $sdit, 'name' => 'Ustadzah Fitriana S.Si', 'role' => 'TEACHER', 'gender' => 'F'],
            ['nip' => '198711042026011004', 'school' => $smait, 'name' => 'Ustadz Drs. Abdullah S.Pd', 'role' => 'TEACHER', 'gender' => 'M'],
            ['nip' => '199102122026012005', 'school' => $sdit, 'name' => 'Ustadz Syamsul Arifin Lc', 'role' => 'TEACHER', 'gender' => 'M'],
            ['nip' => '199306182026012006', 'school' => $smpit, 'name' => 'Ustadzah Maryam Al-Zahra', 'role' => 'TEACHER', 'gender' => 'F'],
            ['nip' => '198909092026011007', 'school' => $smait, 'name' => 'Ustadz H. Farhan M.Ag', 'role' => 'TEACHER', 'gender' => 'M'],
            ['nip' => '199401152026012008', 'school' => $sdit, 'name' => 'Ustadzah Khadijah S.Hum', 'role' => 'TEACHER', 'gender' => 'F'],
            ['nip' => '199605052026011009', 'school' => $smpit, 'name' => 'Ustadz Youssef S.Kom', 'role' => 'TEACHER', 'gender' => 'M'],
            ['nip' => '199501012026011010', 'school' => $smpit, 'name' => 'Budi Santoso S.Kom', 'role' => 'STAFF', 'gender' => 'M'],
            ['nip' => '199208082026011011', 'school' => $smpit, 'name' => 'Herman Syahputra', 'role' => 'STAFF', 'gender' => 'M'],
            ['nip' => '199703142026012012', 'school' => $sdit, 'name' => 'Dewi Safitri A.Md', 'role' => 'STAFF', 'gender' => 'F'],
        ];

        $employees = [];
        foreach ($teachersData as $td) {
            $employees[$td['nip']] = Employee::updateOrCreate(
                ['nip' => $td['nip']],
                [
                    'school_id' => $td['school']->id,
                    'full_name' => $td['name'],
                    'role_type' => $td['role'],
                    'gender' => $td['gender'],
                    'phone' => '0813-9999-' . rand(1000, 9999),
                    'email' => strtolower(explode(' ', $td['name'])[0]) . rand(10, 99) . '@robbani.sch.id',
                ]
            );
        }

        // 5. Classrooms (10 Rombel)
        $classroomsData = [
            ['name' => '1-Abu Bakar Ash-Shiddiq', 'school' => $sdit, 'level' => $lvlSD1, 'teacher' => $employees['199003202026011003']],
            ['name' => '1-Umar bin Khattab', 'school' => $sdit, 'level' => $lvlSD1, 'teacher' => $employees['199102122026012005']],
            ['name' => '2-Utsman bin Affan', 'school' => $sdit, 'level' => $lvlSD2, 'teacher' => $employees['199401152026012008']],
            ['name' => '7-Umar bin Khattab', 'school' => $smpit, 'level' => $lvlSMP7, 'teacher' => $employees['198505122026011001']],
            ['name' => '7-Aisyah binti Abu Bakar', 'school' => $smpit, 'level' => $lvlSMP7, 'teacher' => $employees['198807152026012002']],
            ['name' => '8-Ali bin Abi Thalib', 'school' => $smpit, 'level' => $lvlSMP8, 'teacher' => $employees['199306182026012006']],
            ['name' => '8-Khadijah Al-Kubra', 'school' => $smpit, 'level' => $lvlSMP8, 'teacher' => $employees['199605052026011009']],
            ['name' => '10-MIPA 1 Al-Khawarizmi', 'school' => $smait, 'level' => $lvlSMA10, 'teacher' => $employees['198711042026011004']],
            ['name' => '10-IPS 1 Ibnu Khaldun', 'school' => $smait, 'level' => $lvlSMA10, 'teacher' => $employees['198909092026011007']],
            ['name' => '11-MIPA 1 Ibnu Sina', 'school' => $smait, 'level' => $lvlSMA11, 'teacher' => $employees['198711042026011004']],
        ];

        $classrooms = [];
        foreach ($classroomsData as $cd) {
            $classrooms[] = Classroom::updateOrCreate(
                ['school_id' => $cd['school']->id, 'name' => $cd['name']],
                [
                    'level_id' => $cd['level']->id,
                    'academic_year_id' => $ay->id,
                    'capacity' => 30,
                    'homeroom_teacher_id' => $cd['teacher']->id,
                ]
            );
        }

        // 6. Subjects (12+ Mapel)
        $subjectsData = [
            ['code' => 'PAI-01', 'name' => 'PAI & Aqidah Akhlak', 'category' => 'RELIGION', 'school' => $smpit],
            ['code' => 'TQ-01', 'name' => 'Tahfidz Al-Qur\'an Juz 30-29', 'category' => 'JSIT', 'school' => $smpit],
            ['code' => 'ARB-01', 'name' => 'Bahasa Arab Al-Qur\'an', 'category' => 'JSIT', 'school' => $smpit],
            ['code' => 'MTK-01', 'name' => 'Matematika Merdeka', 'category' => 'UMUM', 'school' => $smpit],
            ['code' => 'IPA-01', 'name' => 'Ilmu Pengetahuan Alam', 'category' => 'UMUM', 'school' => $smpit],
            ['code' => 'IPS-01', 'name' => 'Ilmu Pengetahuan Sosial', 'category' => 'UMUM', 'school' => $smpit],
            ['code' => 'IND-01', 'name' => 'Bahasa Indonesia', 'category' => 'UMUM', 'school' => $smpit],
            ['code' => 'ENG-01', 'name' => 'Bahasa Inggris', 'category' => 'UMUM', 'school' => $smpit],
            ['code' => 'INF-01', 'name' => 'Informatika & Coding', 'category' => 'UMUM', 'school' => $smpit],
            ['code' => 'PJK-01', 'name' => 'PJOK & Memanah', 'category' => 'UMUM', 'school' => $smpit],
            ['code' => 'PKN-01', 'name' => 'Pancasila & Kewarganegaraan', 'category' => 'UMUM', 'school' => $smpit],
            ['code' => 'SBK-01', 'name' => 'Seni Kaligrafi Islam', 'category' => 'JSIT', 'school' => $smpit],
        ];

        foreach ($subjectsData as $sub) {
            Subject::updateOrCreate(
                ['school_id' => $sub['school']->id, 'code' => $sub['code']],
                ['name' => $sub['name'], 'category' => $sub['category']]
            );
        }

        // 7. Guardians (Orang Tua)
        $guardians = [];
        for ($i = 1; $i <= 12; $i++) {
            $guardians[] = Guardian::updateOrCreate(
                ['nik' => '32730101018500' . sprintf('%02d', $i)],
                [
                    'full_name' => 'Wali Murid ' . $i . ' S.T',
                    'phone' => '0812-1111-' . sprintf('%04d', $i),
                    'bpi_pin' => '123456',
                ]
            );
        }

        // 8. Students (12+ Siswa)
        $studentsList = [
            ['nis' => '20267001', 'name' => 'Fatih Abdullah Prasetyo', 'school' => $smpit, 'cls' => $classrooms[3], 'rfid' => 'RFID-STU-7001', 'savings' => 350000],
            ['nis' => '20267002', 'name' => 'Aisyah Humaira', 'school' => $smpit, 'cls' => $classrooms[3], 'rfid' => 'RFID-STU-7002', 'savings' => 200000],
            ['nis' => '20267003', 'name' => 'Muhammad Rayhan', 'school' => $sdit, 'cls' => $classrooms[0], 'rfid' => 'RFID-STU-7003', 'savings' => 150000],
            ['nis' => '20267004', 'name' => 'Zaid bin Tsabit', 'school' => $smpit, 'cls' => $classrooms[3], 'rfid' => 'RFID-STU-7004', 'savings' => 450000],
            ['nis' => '20267005', 'name' => 'Maryam Al-Fatihah', 'school' => $smpit, 'cls' => $classrooms[4], 'rfid' => 'RFID-STU-7005', 'savings' => 500000],
            ['nis' => '20267006', 'name' => 'Bilal bin Rabah', 'school' => $sdit, 'cls' => $classrooms[0], 'rfid' => 'RFID-STU-7006', 'savings' => 120000],
            ['nis' => '20267007', 'name' => 'Salman Al-Farisi', 'school' => $smait, 'cls' => $classrooms[7], 'rfid' => 'RFID-STU-7007', 'savings' => 600000],
            ['nis' => '20267008', 'name' => 'Ruqayyah Azzahra', 'school' => $smait, 'cls' => $classrooms[7], 'rfid' => 'RFID-STU-7008', 'savings' => 280000],
            ['nis' => '20267009', 'name' => 'Hamzah Abdul Malik', 'school' => $smpit, 'cls' => $classrooms[5], 'rfid' => 'RFID-STU-7009', 'savings' => 310000],
            ['nis' => '20267010', 'name' => 'Fatimah Azzahra', 'school' => $smpit, 'cls' => $classrooms[6], 'rfid' => 'RFID-STU-7010', 'savings' => 400000],
            ['nis' => '20267011', 'name' => 'Usamah bin Zaid', 'school' => $sdit, 'cls' => $classrooms[1], 'rfid' => 'RFID-STU-7011', 'savings' => 175000],
            ['nis' => '20267012', 'name' => 'Thariq bin Ziyad', 'school' => $smait, 'cls' => $classrooms[8], 'rfid' => 'RFID-STU-7012', 'savings' => 520000],
        ];

        $students = [];
        foreach ($studentsList as $idx => $s) {
            $students[] = Student::updateOrCreate(
                ['nis' => $s['nis']],
                [
                    'school_id' => $s['school']->id,
                    'classroom_id' => $s['cls']->id,
                    'guardian_id' => $guardians[$idx % count($guardians)]->id,
                    'full_name' => $s['name'],
                    'nickname' => explode(' ', $s['name'])[0],
                    'gender' => ($idx % 2 == 0) ? 'M' : 'F',
                    'pob' => 'Bandung',
                    'dob' => '2013-05-' . sprintf('%02d', $idx + 1),
                    'rfid_tag' => $s['rfid'],
                    'status' => 'ACTIVE',
                    'canteen_daily_limit' => 30000.00,
                    'savings_balance' => $s['savings'],
                ]
            );
        }

        // 9. Attendance Log (12+ Presensi Realtime)
        $statuses = ['HADIR', 'HADIR', 'HADIR', 'TERLAMBAT', 'HADIR', 'IZIN', 'SAKIT', 'HADIR', 'HADIR', 'TERLAMBAT', 'HADIR', 'HADIR'];
        foreach ($students as $idx => $st) {
            Attendance::updateOrCreate(
                ['student_id' => $st->id, 'date' => date('Y-m-d')],
                [
                    'school_id' => $st->school_id,
                    'time_in' => '06:' . rand(45, 59) . ':00',
                    'status' => $statuses[$idx % count($statuses)],
                    'method' => 'RFID_GATE',
                    'notes' => 'Tap RFID Gate Sekolah',
                ]
            );
        }

        // 10. SPP Bills & Payments (12+ Tagihan)
        foreach ($students as $st) {
            $bill = SppBill::updateOrCreate(
                ['student_id' => $st->id, 'month_period' => 'Juli 2026'],
                [
                    'school_id' => $st->school_id,
                    'academic_year_id' => $ay->id,
                    'amount' => 500000.00,
                    'paid_amount' => 500000.00,
                    'status' => 'PAID',
                    'due_date' => '2026-07-10',
                ]
            );

            SppPayment::updateOrCreate(
                ['spp_bill_id' => $bill->id],
                [
                    'receipt_number' => 'KW-SPP-202607-' . sprintf('%04d', $st->id),
                    'amount_paid' => 500000.00,
                    'payment_method' => 'CASH',
                    'paid_at' => date('Y-m-d H:i:s'),
                    'notes' => 'Pembayaran SPP Juli 2026',
                ]
            );
        }

        // 11. Chart of Accounts (COA) & Savings
        $kas = ChartOfAccount::updateOrCreate(
            ['code' => '1001-KAS'],
            ['school_id' => $smpit->id, 'name' => 'Kas Bendahara Sekolah', 'type' => 'ASSET', 'current_balance' => 25500000.00]
        );

        $bank = ChartOfAccount::updateOrCreate(
            ['code' => '1002-BANK'],
            ['school_id' => $smpit->id, 'name' => 'Bank Syariah Indonesia (BSI)', 'type' => 'ASSET', 'current_balance' => 125000000.00]
        );

        ChartOfAccount::updateOrCreate(
            ['code' => '4001-SPP'],
            ['school_id' => $smpit->id, 'name' => 'Pendapatan SPP Siswa', 'type' => 'REVENUE', 'current_balance' => 60000000.00]
        );

        // Savings transactions
        foreach ($students as $st) {
            SavingsTransaction::create([
                'student_id' => $st->id,
                'type' => 'DEPOSIT',
                'amount' => $st->savings_balance,
                'balance_after' => $st->savings_balance,
                'description' => 'Setor Tabungan Siswa Teller',
            ]);
        }

        // 12. Canteen POS Outlets & Transactions
        $outlet1 = CanteenOutlet::updateOrCreate(
            ['name' => 'Kantin Barokah SMPIT'],
            [
                'school_id' => $smpit->id,
                'owner_name' => 'Ibu Halimah',
                'phone' => '0815-7777-8888',
                'commission_rate' => 5.00,
            ]
        );

        $outlet2 = CanteenOutlet::updateOrCreate(
            ['name' => 'Kantin Thayyibah SDIT'],
            [
                'school_id' => $sdit->id,
                'owner_name' => 'Pak Subhan',
                'phone' => '0815-7777-9999',
                'commission_rate' => 5.00,
            ]
        );

        CanteenProduct::updateOrCreate(
            ['canteen_outlet_id' => $outlet1->id, 'name' => 'Nasi Goreng Ayam Suwir'],
            ['category' => 'MAKANAN', 'price' => 12000.00, 'stock' => 50]
        );

        CanteenProduct::updateOrCreate(
            ['canteen_outlet_id' => $outlet1->id, 'name' => 'Es Teh Manis Jasmine'],
            ['category' => 'MINUMAN', 'price' => 4000.00, 'stock' => 100]
        );

        foreach ($students as $idx => $st) {
            CanteenTransaction::updateOrCreate(
                ['invoice_number' => 'POS-20260811-' . sprintf('%03d', $idx + 1)],
                [
                    'canteen_outlet_id' => ($st->school_id == $sdit->id) ? $outlet2->id : $outlet1->id,
                    'student_id' => $st->id,
                    'total_amount' => rand(8, 25) * 1000.00,
                    'rfid_tag_used' => $st->rfid_tag,
                ]
            );
        }
    }
}
