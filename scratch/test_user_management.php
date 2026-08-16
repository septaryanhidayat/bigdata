<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\School;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

echo "=== TESTING USER & ACCOUNT MANAGEMENT MODULE ===\n\n";

$superAdmin = User::where('email', 'admin@smartedu.test')->first();
auth()->login($superAdmin);

$userCtrl = new UserController();

// 1. Test Index / Listing
$reqIndex = Request::create('/admin/users', 'GET');
$resIndex = $userCtrl->index($reqIndex);
assert($resIndex instanceof \Illuminate\View\View, "Index must return a Blade view");
$viewData = $resIndex->getData();
assert($viewData['totalUsers'] >= 15, "Total users should be at least 15");
echo "✓ 1. User listing & metrics summary OK! (Total Users: {$viewData['totalUsers']})\n";

// 2. Test Store New User
$testEmail = 'test.guru.' . time() . '@robbani.sch.id';
$sdit = School::where('code', 'SDIT')->first();

$reqStore = Request::create('/admin/users', 'POST', [
    'name' => 'Ustadz Test Unit Guru',
    'email' => $testEmail,
    'password' => 'Password@123',
    'role' => User::ROLE_TEACHER,
    'school_id' => $sdit->id,
    'phone' => '081299998888',
    'is_active' => '1',
]);

$resStore = $userCtrl->store($reqStore);
$createdUser = User::where('email', $testEmail)->first();
assert($createdUser !== null, "Created user must exist in database");
assert($createdUser->role === User::ROLE_TEACHER, "Role must match");
assert($createdUser->school_id === $sdit->id, "School ID must match");
assert(Hash::check('Password@123', $createdUser->password), "Password must match");
echo "✓ 2. User creation OK! (ID: {$createdUser->id}, Name: {$createdUser->name})\n";

// 3. Test Update User
$reqUpdate = Request::create("/admin/users/{$createdUser->id}", 'PUT', [
    'name' => 'Ustadz Test Guru Updated',
    'email' => $testEmail,
    'role' => User::ROLE_GURU_BK,
    'school_id' => $sdit->id,
    'phone' => '081277776666',
    'is_active' => '1',
]);

$resUpdate = $userCtrl->update($reqUpdate, $createdUser->id);
$createdUser->refresh();
assert($createdUser->name === 'Ustadz Test Guru Updated', "Name must be updated");
assert($createdUser->role === User::ROLE_GURU_BK, "Role must be updated to GURU_BK");
assert($createdUser->phone === '081277776666', "Phone must be updated");
echo "✓ 3. User update OK! (Name updated to: {$createdUser->name}, Role: {$createdUser->role})\n";

// 4. Test Quick Password Reset
$reqReset = Request::create("/admin/users/{$createdUser->id}/reset-password", 'POST', [
    'new_password' => 'Robbani@2026',
]);
$resReset = $userCtrl->resetPassword($reqReset, $createdUser->id);
$createdUser->refresh();
assert(Hash::check('Robbani@2026', $createdUser->password), "Password must be reset to Robbani@2026");
echo "✓ 4. Quick password reset OK!\n";

// 5. Test Toggle Status (Deactivate & Activate)
$userCtrl->toggleStatus($createdUser->id);
$createdUser->refresh();
assert($createdUser->is_active === false, "User should be deactivated");

$userCtrl->toggleStatus($createdUser->id);
$createdUser->refresh();
assert($createdUser->is_active === true, "User should be activated again");
echo "✓ 5. Status toggle (Active/Inactive) OK!\n";

// 6. Test Export Users CSV
$resExport = $userCtrl->export();
assert($resExport instanceof \Symfony\Component\HttpFoundation\StreamedResponse, "Export must return a StreamedResponse");
echo "✓ 6. User CSV export OK!\n";

// 7. Test Self Deletion & Super Admin Protection
$resSelfDelete = $userCtrl->destroy($superAdmin->id);
assert(session('error') !== null, "Must block self-deletion");
echo "✓ 7a. Self-deletion protection OK!\n";

// 8. Test Delete Created Test User
$resDelete = $userCtrl->destroy($createdUser->id);
$deletedUser = User::find($createdUser->id);
assert($deletedUser === null, "Test user must be deleted from database");
echo "✓ 7b. User deletion OK!\n";

echo "\n=== ALL USER MANAGEMENT TESTS PASSED 100%! ===\n";
