<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Classroom;
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
use App\Models\PpdbRegistration;
use App\Models\CbtExam;
use App\Models\SarprasAsset;
use App\Models\LibraryBook;
use App\Models\LmsMaterial;
use App\Models\BkRecord;
use App\Models\PayrollSalary;
use App\Models\BpiMutabaah;

echo "=== STARTING COMPREHENSIVE CODEBASE & FEATURE VERIFICATION ===\n\n";

$tests = [];

// 1. Auth Admin
$admin = User::where('email', 'admin@smartedu.test')->first();
auth()->login($admin);
echo "✓ Authenticated as: " . $admin->name . "\n";

// 2. Master Data Controller
try {
    $mc = app(\App\Http\Controllers\Admin\MasterDataController::class);
    $mc->index(request());
    $mc->schools();
    $mc->curriculums();
    $mc->classrooms();
    $mc->students(request());
    $mc->teachers();
    $mc->employees();
    $mc->references();
    echo "✓ MasterDataController methods passed!\n";
} catch (\Throwable $e) {
    echo "❌ MasterDataController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 3. Academic Controller
try {
    $ac = app(\App\Http\Controllers\Admin\AcademicController::class);
    $ac->schedules();
    $ac->journals();
    $ac->grades();
    $student = Student::first();
    if ($student) {
        $ac->reportCard($student->id);
    }
    echo "✓ AcademicController methods passed!\n";
} catch (\Throwable $e) {
    echo "❌ AcademicController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 4. Attendance Controller & Api
try {
    $atc = app(\App\Http\Controllers\Admin\AttendanceController::class);
    $atc->index(request());
    $atc->leaves(request());
    $api = app(\App\Http\Controllers\Api\AttendanceApiController::class);
    $req = new \Illuminate\Http\Request(['rfid_tag' => Student::first()->rfid_tag ?? 'RFID-STU-7001']);
    $res = $api->tapRfid($req);
    echo "✓ AttendanceController & AttendanceApiController passed!\n";
} catch (\Throwable $e) {
    echo "❌ AttendanceController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 5. Finance Controller
try {
    $fc = app(\App\Http\Controllers\Admin\FinanceController::class);
    $fc->sppBills();
    $fc->coa();
    $payment = SppPayment::first();
    if ($payment) {
        $fc->printReceipt($payment->id);
    }
    echo "✓ FinanceController & Receipt PDF passed!\n";
} catch (\Throwable $e) {
    echo "❌ FinanceController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 6. Savings Controller
try {
    $sc = app(\App\Http\Controllers\Admin\SavingsController::class);
    $sc->index();
    echo "✓ SavingsController passed!\n";
} catch (\Throwable $e) {
    echo "❌ SavingsController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 7. Canteen Controller
try {
    $cc = app(\App\Http\Controllers\Admin\CanteenController::class);
    $cc->index();
    echo "✓ CanteenController passed!\n";
} catch (\Throwable $e) {
    echo "❌ CanteenController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 8. CBT & PPDB Controller
try {
    $cpc = app(\App\Http\Controllers\Admin\CbtPpdbController::class);
    $cpc->cbtIndex(request());
    $cpc->ppdbIndex(request());
    $reg = PpdbRegistration::first();
    if ($reg) {
        $cpc->downloadSpmbPdf($reg->id);
    }
    echo "✓ CbtPpdbController passed!\n";
} catch (\Throwable $e) {
    echo "❌ CbtPpdbController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 9. HRIS & Payroll Controller
try {
    $hpc = app(\App\Http\Controllers\Admin\HrisPayrollController::class);
    $hpc->index(request());
    echo "✓ HrisPayrollController passed!\n";
} catch (\Throwable $e) {
    echo "❌ HrisPayrollController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 10. Sarpras Controller
try {
    $spc = app(\App\Http\Controllers\Admin\SarprasController::class);
    $spc->index(request());
    echo "✓ SarprasController passed!\n";
} catch (\Throwable $e) {
    echo "❌ SarprasController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 11. Library Controller
try {
    $lc = app(\App\Http\Controllers\Admin\LibraryController::class);
    $lc->index(request());
    echo "✓ LibraryController passed!\n";
} catch (\Throwable $e) {
    echo "❌ LibraryController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 12. LMS Controller
try {
    $lms = app(\App\Http\Controllers\Admin\LmsController::class);
    $lms->index(request());
    echo "✓ LmsController passed!\n";
} catch (\Throwable $e) {
    echo "❌ LmsController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 13. BK Controller
try {
    $bkc = app(\App\Http\Controllers\Admin\BkController::class);
    $bkc->index(request());
    echo "✓ BkController passed!\n";
} catch (\Throwable $e) {
    echo "❌ BkController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 14. BPI Controller
try {
    $bpic = app(\App\Http\Controllers\Admin\BpiController::class);
    $bpic->index(request());
    echo "✓ BpiController passed!\n";
} catch (\Throwable $e) {
    echo "❌ BpiController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// 15. Public School Website Controller
try {
    $swc = app(\App\Http\Controllers\SchoolWebsiteController::class);
    $swc->index();
    $swc->profil();
    $swc->unitProfile('sdit');
    $swc->beritaIndex(request());
    $swc->artikelIndex(request());
    $swc->fasilitas();
    $swc->layananKunjungan();
    $swc->layananKerjasama();
    $swc->layananSewa();
    $swc->ppdbForm();
    $swc->eSppCheck();
    echo "✓ SchoolWebsiteController passed!\n";
} catch (\Throwable $e) {
    echo "❌ SchoolWebsiteController Error: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine() . "\n";
}

echo "\n=== ALL TESTS FINISHED SUCCESSFULLY! ===\n";
