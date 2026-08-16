<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\School;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;

echo "=== TESTING ROLE-BASED ACCESS CONTROL (RBAC) & MULTI-USER ACCOUNTS ===\n\n";

// 1. Test All 15 Seeded Accounts
$expectedRoles = [
    'admin@smartedu.test' => User::ROLE_SUPER_ADMIN,
    'ketua.yayasan@robbani.sch.id' => User::ROLE_YAYASAN_CHAIRMAN,
    'kepala.tkit@robbani.sch.id' => User::ROLE_HEADMASTER,
    'kepala.sdit@robbani.sch.id' => User::ROLE_HEADMASTER,
    'kepala.smpit@robbani.sch.id' => User::ROLE_HEADMASTER,
    'kepala.smait@robbani.sch.id' => User::ROLE_HEADMASTER,
    'tu@robbani.sch.id' => User::ROLE_STAFF_TU,
    'keuangan@robbani.sch.id' => User::ROLE_STAFF_KEUANGAN,
    'guru@robbani.sch.id' => User::ROLE_TEACHER,
    'bk@robbani.sch.id' => User::ROLE_GURU_BK,
    'musyrif@robbani.sch.id' => User::ROLE_MUSYRIF_ASRAMA,
    'perpus@robbani.sch.id' => User::ROLE_PETUGAS_PERPUS,
    'kantin@robbani.sch.id' => User::ROLE_PETUGAS_KANTIN,
    'ppdb@robbani.sch.id' => User::ROLE_PANITIA_PPDB,
    'sarpras@robbani.sch.id' => User::ROLE_PETUGAS_SARPRAS,
];

foreach ($expectedRoles as $email => $expectedRole) {
    $u = User::where('email', $email)->first();
    if (!$u) {
        throw new Exception("User not found: {$email}");
    }
    if ($u->role !== $expectedRole) {
        throw new Exception("Role mismatch for {$email}: expected {$expectedRole}, got {$u->role}");
    }
    echo "✓ Akun OK: {$u->name} ({$u->email}) -> Role: {$u->role_name_label}\n";
}

echo "\n--- 2. Testing canAccessModule() Permissions Matrix ---\n";

// A. Super Admin has access to everything
$superAdmin = User::where('email', 'admin@smartedu.test')->first();
assert($superAdmin->canAccessModule('master') === true);
assert($superAdmin->canAccessModule('finance') === true);
assert($superAdmin->canAccessModule('lms') === true);
assert($superAdmin->canAccessModule('settings') === true);
echo "✓ Super Admin can access all modules (Master, Finance, LMS, Settings, etc.)\n";

// B. Bendahara (STAFF_KEUANGAN)
$keuangan = User::where('email', 'keuangan@robbani.sch.id')->first();
assert($keuangan->canAccessModule('finance') === true);
assert($keuangan->canAccessModule('savings') === true);
assert($keuangan->canAccessModule('hris') === true);
assert($keuangan->canAccessModule('bk') === false);
assert($keuangan->canAccessModule('settings') === false);
assert($keuangan->canAccessModule('lms') === false);
echo "✓ Bendahara can access Finance/Savings/HRIS, blocked from BK, Settings, LMS\n";

// C. Guru (TEACHER)
$guru = User::where('email', 'guru@robbani.sch.id')->first();
assert($guru->canAccessModule('lms') === true);
assert($guru->canAccessModule('academic') === true);
assert($guru->canAccessModule('bpi') === true);
assert($guru->canAccessModule('finance') === false);
assert($guru->canAccessModule('settings') === false);
assert($guru->canAccessModule('master') === false);
echo "✓ Guru can access LMS/Academic/BPI, blocked from Finance, Settings, Master\n";

// D. Kasir Kantin (PETUGAS_KANTIN)
$kantin = User::where('email', 'kantin@robbani.sch.id')->first();
assert($kantin->canAccessModule('canteen') === true);
assert($kantin->canAccessModule('finance') === false);
assert($kantin->canAccessModule('master') === false);
assert($kantin->canAccessModule('academic') === false);
echo "✓ Kasir Kantin can access Canteen POS only, blocked from other modules\n";

// E. Guru BK (GURU_BK)
$bk = User::where('email', 'bk@robbani.sch.id')->first();
assert($bk->canAccessModule('bk') === true);
assert($bk->canAccessModule('attendance') === true);
assert($bk->canAccessModule('finance') === false);
assert($bk->canAccessModule('canteen') === false);
echo "✓ Guru BK can access BK & Attendance, blocked from Finance & Canteen\n";

// F. Ketua Yayasan (YAYASAN_CHAIRMAN)
$ketua = User::where('email', 'ketua.yayasan@robbani.sch.id')->first();
assert($ketua->canAccessModule('letters') === true);
assert($ketua->canAccessModule('finance') === true);
assert($ketua->canAccessModule('hris') === true);
assert($ketua->canAccessModule('sarpras') === true);
assert($ketua->canAccessModule('settings') === true);
echo "✓ Ketua Yayasan can access Letters, Finance, HRIS, Sarpras, Settings\n";

echo "\n--- 3. Testing CheckRole Middleware Invocations ---\n";
$middleware = new CheckRole();

// Test 1: Guru accessing route guarded by TEACHER role (Allow)
$req1 = Request::create('/admin/academic/grades', 'GET');
$req1->setUserResolver(fn() => $guru);
$res1 = $middleware->handle($req1, fn($r) => response('OK', 200), 'TEACHER', 'HEADMASTER');
assert($res1->getContent() === 'OK');
echo "✓ Middleware allowed Guru on Academic route\n";

// Test 2: Guru accessing route guarded by STAFF_KEUANGAN role (Deny / Redirect with error)
$req2 = Request::create('/admin/finance/spp-bills', 'GET');
$req2->setUserResolver(fn() => $guru);
$res2 = $middleware->handle($req2, fn($r) => response('OK', 200), 'STAFF_KEUANGAN', 'YAYASAN_CHAIRMAN');
assert($res2->isRedirect());
assert(session('error') !== null);
echo "✓ Middleware blocked Guru from Finance route and redirected safely\n";

// Test 3: API JSON request by Unauthorized user returns 403 JSON
$req3 = Request::create('/api/finance/export', 'GET');
$req3->headers->set('Accept', 'application/json');
$req3->setUserResolver(fn() => $kantin);
$res3 = $middleware->handle($req3, fn($r) => response()->json(['data' => 'secret']), 'STAFF_KEUANGAN');
assert($res3->getStatusCode() === 403);
echo "✓ Middleware returned 403 JSON response for unauthorized API call\n";

echo "\n=== ALL 15 ROLES & ACCESS RESTRICTION TESTS PASSED 100%! ===\n";
