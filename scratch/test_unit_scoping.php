<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\School;
use App\Models\Student;
use App\Models\Employee;
use App\Models\OfficialLetter;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\CmsController;
use App\Http\Controllers\Admin\LetterController;
use Illuminate\Http\Request;

echo "=== TESTING UNIT ISOLATION (MULTI-TENANCY) & TU CMS ACCESS ===\n\n";

$smpit = School::where('code', 'SMPIT')->first();
$sdit = School::where('code', 'SDIT')->first();

if (!$smpit || !$sdit) {
    throw new Exception("School SMPIT or SDIT not found in database!");
}

// 1. Test TU SMPIT Account
$tuSmpit = User::where('email', 'tu@robbani.sch.id')->first();
$tuSmpit->school_id = $smpit->id;
$tuSmpit->save();

auth()->login($tuSmpit);

echo "1. Logged in as: {$tuSmpit->name} (TU SMPIT, School ID: {$tuSmpit->school_id})\n";
assert($tuSmpit->getEffectiveSchoolId() === $smpit->id, "Effective school ID must be SMPIT");
assert($tuSmpit->canManageUnit($smpit->id) === true, "Must be able to manage SMPIT");
assert($tuSmpit->canManageUnit($sdit->id) === false, "Must NOT be able to manage SDIT");
echo "✓ TU SMPIT canManageUnit validation OK!\n";

// 2. Test Switch School Rejection for Unit User
$masterCtrl = new MasterDataController();
$reqSwitch = Request::create('/admin/master/switch-school', 'POST', ['school_id' => $sdit->id]);
$resSwitch = $masterCtrl->switchSchool($reqSwitch);
assert(session('error') !== null, "Switching school must be blocked for unit user");
echo "✓ MasterDataController::switchSchool() properly blocked unit user from switching unit!\n";

// 3. Test Student Listing Scoping
$reqStudents = Request::create('/admin/master/students', 'GET');
$resStudents = $masterCtrl->students($reqStudents);
$viewData = $resStudents->getData();
$students = $viewData['students'];
foreach ($students as $st) {
    assert($st->school_id === $smpit->id, "All returned students must belong to SMPIT");
}
echo "✓ MasterDataController::students() returned " . count($students) . " students strictly scoped to SMPIT!\n";

// 4. Test TU Unit CMS Profile Access
$cmsCtrl = new CmsController();

// A. Accessing own unit (SMPIT) -> Allowed (View returned)
$resEditOwn = $cmsCtrl->editUnitProfile('smpit');
assert($resEditOwn instanceof \Illuminate\View\View, "TU SMPIT must be able to view SMPIT profile edit form");
echo "✓ CmsController::editUnitProfile('smpit') allowed for TU SMPIT!\n";

// B. Accessing other unit (SDIT) -> Denied (Redirected with error)
$resEditOther = $cmsCtrl->editUnitProfile('sdit');
assert($resEditOther->isRedirect(), "TU SMPIT must be blocked from accessing SDIT profile");
assert(session('error') !== null, "Session must contain error message");
echo "✓ CmsController::editUnitProfile('sdit') properly denied for TU SMPIT!\n";

// 5. Test Outgoing Letter Scoping
$letterCtrl = new LetterController();
$reqOutgoing = Request::create('/admin/letters/outgoing', 'GET');
$resOutgoing = $letterCtrl->outgoing($reqOutgoing);
$outgoingLetters = $resOutgoing->getData()['letters'];
foreach ($outgoingLetters as $ol) {
    if ($ol->school_id !== null) {
        assert($ol->school_id === $smpit->id, "Letter school_id must match SMPIT");
    }
}
echo "✓ LetterController::outgoing() returned letters strictly scoped to SMPIT!\n";

// 6. Test Super Admin Global Oversight
$superAdmin = User::where('email', 'admin@smartedu.test')->first();
auth()->login($superAdmin);
echo "\n2. Logged in as: {$superAdmin->name} (Super Admin, Global Oversight)\n";
assert($superAdmin->canManageUnit($smpit->id) === true);
assert($superAdmin->canManageUnit($sdit->id) === true);

$resEditAdminSmpit = $cmsCtrl->editUnitProfile('smpit');
assert($resEditAdminSmpit instanceof \Illuminate\View\View);
$resEditAdminSdit = $cmsCtrl->editUnitProfile('sdit');
assert($resEditAdminSdit instanceof \Illuminate\View\View);
echo "✓ Super Admin can manage all units (SMPIT & SDIT) without restriction!\n";

echo "\n=== ALL UNIT DATA SCOPING & TU CMS PERMISSION TESTS PASSED 100%! ===\n";
