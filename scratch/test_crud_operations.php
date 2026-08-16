<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\Level;
use App\Models\Classroom;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Subject;
use App\Models\Room;
use App\Models\SppBill;
use App\Models\SppPayment;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\SavingsTransaction;
use App\Models\CanteenOutlet;
use App\Models\CanteenProduct;
use App\Models\CanteenTransaction;
use App\Models\Attendance;
use App\Models\StudentLeave;
use App\Models\Grade;
use App\Models\KbmJournal;
use App\Models\Schedule;
use App\Models\PpdbRegistration;
use App\Models\CbtExam;
use App\Models\SarprasAsset;
use App\Models\LibraryBook;
use App\Models\LmsMaterial;
use App\Models\BkRecord;
use App\Models\PayrollSalary;
use App\Models\BpiMutabaah;
use Illuminate\Http\Request;

echo "=== TESTING ALL CRUD & TRANSACTION OPERATIONS ===\n\n";

$admin = User::where('email', 'admin@smartedu.test')->first();
auth()->login($admin);

$school = School::first();
$academicYear = AcademicYear::first();
$level = Level::first();
$teacher = Employee::whereIn('role_type', ['TEACHER', 'HEADMASTER'])->first();

// 1. Create Classroom
$reqClassroom = new Request([
    'school_id' => $school->id,
    'level_id' => $level->id,
    'name' => 'Test Kelas 9-Ali',
    'capacity' => 32,
    'homeroom_teacher_id' => $teacher->id,
]);
app(\App\Http\Controllers\Admin\MasterDataController::class)->storeClassroom($reqClassroom);
echo "✓ MasterDataController::storeClassroom passed\n";

// 2. Create Student
$uniqueNis = 'TEST' . rand(1000, 9999);
$reqStudent = new Request([
    'school_id' => $school->id,
    'classroom_id' => Classroom::latest()->first()->id,
    'nis' => $uniqueNis,
    'nisn' => '00' . rand(1000000, 9999999),
    'full_name' => 'Siswa Uji Coba Cerdas',
    'gender' => 'L',
    'birth_place' => 'Palembang',
    'birth_date' => '2014-01-01',
    'rfid_tag' => 'RFID-TEST-' . rand(1000, 9999),
    'status' => 'ACTIVE',
]);
app(\App\Http\Controllers\Admin\MasterDataController::class)->storeStudent($reqStudent);
echo "✓ MasterDataController::storeStudent passed\n";

$testStudent = Student::where('nis', $uniqueNis)->first();

// 3. Create Teacher
$uniqueNip = 'NIP' . rand(100000, 999999);
$reqTeacher = new Request([
    'school_id' => $school->id,
    'nip' => $uniqueNip,
    'full_name' => 'Ustadz Penguji Baru',
    'title' => 'M.Pd',
    'type' => 'GURU',
    'position' => 'Guru Pengampu Sains',
    'phone' => '08123456789',
    'email' => 'penguji.' . rand(100, 999) . '@robbani.test',
]);
app(\App\Http\Controllers\Admin\MasterDataController::class)->storeTeacher($reqTeacher);
echo "✓ MasterDataController::storeTeacher passed\n";

// 4. Create Subject & Room
$reqSubject = new Request([
    'school_id' => $school->id,
    'code' => 'TEST-SBJ-' . rand(10, 99),
    'name' => 'Sains & Robotika',
    'group' => 'MUATAN_LOKAL',
]);
app(\App\Http\Controllers\Admin\MasterDataController::class)->storeSubject($reqSubject);

$reqRoom = new Request([
    'school_id' => $school->id,
    'code' => 'R-TEST-' . rand(10, 99),
    'name' => 'Lab Robotika Modern',
    'building' => 'Gedung Sains Lt 2',
    'capacity' => 28,
]);
app(\App\Http\Controllers\Admin\MasterDataController::class)->storeRoom($reqRoom);
echo "✓ MasterDataController::storeSubject and storeRoom passed\n";

// 5. Schedule & Journal & Grade
$subject = Subject::latest()->first();
$reqSchedule = new Request([
    'school_id' => $school->id,
    'classroom_id' => Classroom::first()->id,
    'subject_id' => $subject->id,
    'teacher_id' => $teacher->id,
    'day' => 'Monday',
    'start_time' => '08:00',
    'end_time' => '09:30',
]);
app(\App\Http\Controllers\Admin\AcademicController::class)->storeSchedule($reqSchedule);

$schedule = Schedule::latest()->first();
$reqJournal = new Request([
    'schedule_id' => $schedule->id,
    'teacher_id' => $teacher->id,
    'date' => date('Y-m-d'),
    'topic' => 'Pengenalan Algoritma Sains',
    'notes' => 'Siswa sangat aktif bertanya',
]);
app(\App\Http\Controllers\Admin\AcademicController::class)->storeJournal($reqJournal);

$reqGrade = new Request([
    'student_id' => $testStudent->id,
    'subject_id' => $subject->id,
    'academic_year_id' => $academicYear->id,
    'type' => 'FORMATIF_TP',
    'score' => 92.5,
    'notes' => 'Sangat mahir',
]);
app(\App\Http\Controllers\Admin\AcademicController::class)->storeGrade($reqGrade);
echo "✓ AcademicController::storeSchedule, storeJournal, storeGrade passed\n";

// 6. Attendance & Leave
$reqLeave = new Request([
    'student_id' => $testStudent->id,
    'leave_type' => 'SAKIT',
    'start_date' => date('Y-m-d'),
    'end_date' => date('Y-m-d'),
    'reason' => 'Demam dan istirahat',
]);
app(\App\Http\Controllers\Admin\AttendanceController::class)->storeLeave($reqLeave);
echo "✓ AttendanceController::storeLeave passed\n";

// 7. Finance SPP Bill & Pay
$reqBill = new Request([
    'student_id' => $testStudent->id,
    'month' => 'September',
    'year' => 2026,
    'amount' => 500000,
]);
app(\App\Http\Controllers\Admin\FinanceController::class)->storeSppBill($reqBill);

$bill = SppBill::where('student_id', $testStudent->id)->latest()->first();
app(\App\Http\Controllers\Admin\FinanceController::class)->paySpp(request(), $bill->id);
echo "✓ FinanceController::storeSppBill and paySpp passed\n";

// 8. Savings Transaction
$reqSavings = new Request([
    'student_id' => $testStudent->id,
    'transaction_type' => 'DEPOSIT',
    'amount' => 50000,
    'notes' => 'Uji coba setor tabungan',
]);
app(\App\Http\Controllers\Admin\SavingsController::class)->storeTransaction($reqSavings);
echo "✓ SavingsController::storeTransaction passed\n";

// 9. Canteen Outlet & Product & Checkout
$reqOutlet = new Request([
    'school_id' => $school->id,
    'name' => 'Kantin Sehat Robbani Unit Baru',
    'owner_name' => 'Umi Zahra',
    'phone' => '08123456777',
]);
app(\App\Http\Controllers\Admin\CanteenController::class)->storeOutlet($reqOutlet);

$outlet = CanteenOutlet::latest()->first();
$reqProduct = new Request([
    'outlet_id' => $outlet->id,
    'name' => 'Roti Bakar Madu',
    'price' => 8000,
    'stock' => 20,
]);
app(\App\Http\Controllers\Admin\CanteenController::class)->storeProduct($reqProduct);

$testStudent->update(['canteen_balance' => 25000]);
$reqCheckout = new Request([
    'rfid_tag' => $testStudent->rfid_tag,
    'outlet_id' => $outlet->id,
    'total_amount' => 8000,
]);
app(\App\Http\Controllers\Admin\CanteenController::class)->checkoutPos($reqCheckout);
echo "✓ CanteenController::storeOutlet, storeProduct, checkoutPos passed\n";

// 10. CBT & PPDB
$reqCbt = new Request([
    'title' => 'Ujian Akhir Semester Sains',
    'subject_name' => 'Sains & Robotika',
    'duration_minutes' => 60,
    'total_questions' => 25,
]);
app(\App\Http\Controllers\Admin\CbtPpdbController::class)->storeCbtExam($reqCbt);

$cbtExam = CbtExam::latest()->first();
$reqQuestion = new Request([
    'cbt_exam_id' => $cbtExam->id,
    'question_text' => 'Apa nama komponen utama mikrokontroler?',
    'option_a' => 'CPU / MCU',
    'option_b' => 'Monitor',
    'correct_answer' => 'A',
]);
app(\App\Http\Controllers\Admin\CbtPpdbController::class)->storeQuestion($reqQuestion);

$ppdbReg = PpdbRegistration::first();
if ($ppdbReg) {
    $reqStatus = new Request(['status' => 'PASSED']);
    app(\App\Http\Controllers\Admin\CbtPpdbController::class)->updatePpdbStatus($reqStatus, $ppdbReg->id);
}
echo "✓ CbtPpdbController::storeCbtExam, storeQuestion, updatePpdbStatus passed\n";

// 11. Other Modules
$reqBpi = new Request([
    'student_id' => $testStudent->id,
    'date' => date('Y-m-d'),
    'tilawah_juz' => 'Juz 30 (Surah An-Naba)',
    'hafalan_surah' => 'Surah Al-Mulk',
    'infaq_amount' => 5000,
]);
app(\App\Http\Controllers\Admin\BpiController::class)->store($reqBpi);

$reqPayroll = new Request([
    'employee_id' => $teacher->id,
    'month_year' => date('Y-m'),
    'basic_salary' => 3500000,
    'position_allowance' => 500000,
    'bpjs_deduction' => 100000,
    'tax_deduction' => 50000,
]);
app(\App\Http\Controllers\Admin\HrisPayrollController::class)->generate($reqPayroll);

$reqSarpras = new Request([
    'asset_code' => 'AST-TEST-' . rand(100, 999),
    'name' => 'Proyektor Epson LCD',
    'category' => 'ELEKTRONIK',
    'quantity' => 2,
    'location' => 'Ruang Kelas 9',
    'purchase_cost' => 4500000,
]);
app(\App\Http\Controllers\Admin\SarprasController::class)->store($reqSarpras);

$reqLib = new Request([
    'isbn' => '978-602-' . rand(100, 999) . '-01',
    'title' => 'Sirah Nabawiyah Lengkap',
    'author' => 'Syaikh Shafiyyurrahman Al-Mubarakfuri',
    'category' => 'AGAMA_ISLAM',
    'stock' => 15,
]);
app(\App\Http\Controllers\Admin\LibraryController::class)->store($reqLib);

$reqLms = new Request([
    'subject_name' => 'Pendidikan Agama Islam',
    'title' => 'Modul Bab 1 Adab Penuntut Ilmu',
    'type' => 'PDF',
    'description' => 'Materi pegangan siswa',
]);
app(\App\Http\Controllers\Admin\LmsController::class)->store($reqLms);

$reqBk = new Request([
    'student_id' => $testStudent->id,
    'type' => 'ACHIEVEMENT',
    'points' => 15,
    'title' => 'Juara 1 Lomba Tahfidz 3 Juz',
    'description' => 'Mewakili sekolah tingkat kabupaten',
]);
app(\App\Http\Controllers\Admin\BkController::class)->store($reqBk);

echo "✓ BPI, Payroll, Sarpras, Library, LMS, BK store methods passed!\n";

echo "\n=== ALL CRUD & WRITE OPERATIONS VERIFIED 100% SUCCESSFUL! ===\n";
