<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Api\HrisMobileApiController;

echo "=== TESTING SDM SIT ROBBANI MOBILE API & BACKEND INTEGRATION ===\n\n";

$controller = new HrisMobileApiController();

// 1. Test Login & Auto Multi-Tenancy Unit Detection
$reqLogin = Request::create('/api/v1/mobile/auth/login', 'POST', [
    'email' => 'guru@robbani.sch.id',
    'password' => 'Password@123',
]);
$resLogin = $controller->login($reqLogin);
$dataLogin = json_decode($resLogin->getContent(), true);

assert($resLogin->getStatusCode() === 200, "Login should return 200");
assert($dataLogin['status'] === 'success', "Login status should be success");
assert(isset($dataLogin['unit']['code']), "Unit code should be auto-detected");
echo "✓ 1. Multi-Tenancy Auto-Detection: Successfully detected Unit '" . $dataLogin['unit']['name'] . "' (" . $dataLogin['unit']['code'] . ") with theme " . $dataLogin['unit']['theme']['primary'] . "\n";

// 2. Test Dashboard Summary
$reqDash = Request::create('/api/v1/mobile/dashboard', 'GET');
$reqDash->headers->set('X-User-Id', $dataLogin['user']['id']);
$resDash = $controller->dashboard($reqDash);
$dataDash = json_decode($resDash->getContent(), true);

assert($resDash->getStatusCode() === 200, "Dashboard should return 200");
assert($dataDash['status'] === 'success', "Dashboard status should be success");
echo "✓ 2. Dashboard API: Successfully retrieved today's attendance, leave quota (" . $dataDash['data']['leave_summary']['remaining_days'] . " days left), and wallet balance (Rp " . number_format($dataDash['data']['wallet_balance'], 0, ',', '.') . ")\n";

// 3. Test Attendance Check-In Inside Geofence
$schoolLat = $dataLogin['unit']['latitude'];
$schoolLng = $dataLogin['unit']['longitude'];

$reqCheckIn = Request::create('/api/v1/mobile/attendance/check-in', 'POST', [
    'latitude' => $schoolLat,
    'longitude' => $schoolLng,
    'is_mocked' => false,
    'face_image' => 'selfie_test_valid.jpg',
]);
$reqCheckIn->headers->set('X-User-Id', $dataLogin['user']['id']);
$resCheckIn = $controller->attendanceCheckIn($reqCheckIn);
$dataCheckIn = json_decode($resCheckIn->getContent(), true);

assert($resCheckIn->getStatusCode() === 200, "Valid check-in should return 200");
assert($dataCheckIn['status'] === 'success', "Check-in should be successful");
assert($dataCheckIn['data']['distance_meters'] <= $dataLogin['unit']['radius_meters'], "Distance must be inside radius");
echo "✓ 3. Face Recognition Check-In (Inside Radius): Success at distance " . $dataCheckIn['data']['distance_meters'] . " meters (Status: " . $dataCheckIn['data']['status'] . ")\n";

// 4. Test Geofence Rejection Outside Radius
$reqCheckInFar = Request::create('/api/v1/mobile/attendance/check-in', 'POST', [
    'latitude' => -3.30000000, // Jauh dari sekolah (~10 km)
    'longitude' => 104.70000000,
    'is_mocked' => false,
    'face_image' => 'selfie_far.jpg',
]);
$reqCheckInFar->headers->set('X-User-Id', $dataLogin['user']['id']);
$resCheckInFar = $controller->attendanceCheckIn($reqCheckInFar);
$dataCheckInFar = json_decode($resCheckInFar->getContent(), true);

assert($resCheckInFar->getStatusCode() === 422, "Check-in outside radius should return 422");
assert($dataCheckInFar['error_code'] === 'OUT_OF_GEOFENCE', "Error code must be OUT_OF_GEOFENCE");
echo "✓ 4. Geofence Protection: Successfully rejected check-in outside radius (" . $dataCheckInFar['distance_meters'] . " meters away)\n";

// 5. Test Anti-Fake GPS (Mock Location Protection)
$reqCheckInMock = Request::create('/api/v1/mobile/attendance/check-in', 'POST', [
    'latitude' => $schoolLat,
    'longitude' => $schoolLng,
    'is_mocked' => true, // FAKE GPS AKTIF
    'face_image' => 'selfie_fake.jpg',
]);
$reqCheckInMock->headers->set('X-User-Id', $dataLogin['user']['id']);
$resCheckInMock = $controller->attendanceCheckIn($reqCheckInMock);
$dataCheckInMock = json_decode($resCheckInMock->getContent(), true);

assert($resCheckInMock->getStatusCode() === 422, "Mock GPS check-in should return 422");
assert($dataCheckInMock['error_code'] === 'FAKE_GPS_DETECTED', "Error code must be FAKE_GPS_DETECTED");
echo "✓ 5. Anti-Fake GPS Protection: Successfully blocked Fake GPS / Mock Location spoofing attempt!\n";

// 6. Test Check-Out
$reqCheckOut = Request::create('/api/v1/mobile/attendance/check-out', 'POST', [
    'latitude' => $schoolLat,
    'longitude' => $schoolLng,
    'is_mocked' => false,
    'face_image' => 'selfie_checkout.jpg',
]);
$reqCheckOut->headers->set('X-User-Id', $dataLogin['user']['id']);
$resCheckOut = $controller->attendanceCheckOut($reqCheckOut);
$dataCheckOut = json_decode($resCheckOut->getContent(), true);

assert($resCheckOut->getStatusCode() === 200, "Check-out should return 200");
echo "✓ 6. Check-Out API: Successfully logged employee check-out at " . $dataCheckOut['data']['check_out_time'] . "\n";

// 7. Test Attendance History
$reqHist = Request::create('/api/v1/mobile/attendance/history', 'GET');
$reqHist->headers->set('X-User-Id', $dataLogin['user']['id']);
$resHist = $controller->attendanceHistory($reqHist);
$dataHist = json_decode($resHist->getContent(), true);

assert($resHist->getStatusCode() === 200, "History should return 200");
echo "✓ 7. Attendance History: Retrieved " . count($dataHist['data']) . " log records with monthly summary\n";

// 8. Test Leave Application
$reqLeave = Request::create('/api/v1/mobile/leaves/apply', 'POST', [
    'leave_type' => 'TAHUNAN',
    'start_date' => date('Y-m-d', strtotime('+3 days')),
    'end_date' => date('Y-m-d', strtotime('+4 days')),
    'reason' => 'Keperluan keluarga di luar kota.',
]);
$reqLeave->headers->set('X-User-Id', $dataLogin['user']['id']);
$resLeave = $controller->applyLeave($reqLeave);
$dataLeave = json_decode($resLeave->getContent(), true);

assert($resLeave->getStatusCode() === 200, "Leave apply should return 200");
assert($dataLeave['status'] === 'success', "Leave apply should be successful");
echo "✓ 8. Online Leave Application: Successfully submitted " . $dataLeave['data']['total_days'] . " days leave request\n";

// 9. Test Payroll & Payslip Breakdown
$reqPay = Request::create('/api/v1/mobile/payroll', 'GET');
$reqPay->headers->set('X-User-Id', $dataLogin['user']['id']);
$resPay = $controller->payroll($reqPay);
$dataPay = json_decode($resPay->getContent(), true);

$firstSalaryId = $dataPay['data'][0]['id'];
$reqSlip = Request::create('/api/v1/mobile/payroll/' . $firstSalaryId . '/slip', 'GET');
$resSlip = $controller->payrollSlip($reqSlip, $firstSalaryId);
$dataSlip = json_decode($resSlip->getContent(), true);

assert($resSlip->getStatusCode() === 200, "Payslip should return 200");
assert(count($dataSlip['data']['earnings']) > 0, "Earnings must be detailed");
assert(count($dataSlip['data']['deductions']) > 0, "Deductions must be detailed");
echo "✓ 9. Digital Payslip API: Breakdown Take Home Pay Rp " . number_format($dataSlip['data']['net_salary'], 0, ',', '.') . " with " . count($dataSlip['data']['earnings']) . " earnings & " . count($dataSlip['data']['deductions']) . " deductions\n";

// 10. Test KPI Evaluation
$reqKpi = Request::create('/api/v1/mobile/kpi', 'GET');
$reqKpi->headers->set('X-User-Id', $dataLogin['user']['id']);
$resKpi = $controller->kpi($reqKpi);
$dataKpi = json_decode($resKpi->getContent(), true);

assert($resKpi->getStatusCode() === 200, "KPI should return 200");
echo "✓ 10. KPI Evaluation: Grade " . $dataKpi['data'][0]['grade'] . " (Final Score: " . $dataKpi['data'][0]['final_score'] . " pts)\n";

// 11. Test Canteen & Koperasi Purchase
$reqBuy = Request::create('/api/v1/mobile/canteen/pay', 'POST', [
    'product_id' => 1,
    'amount' => 15000,
]);
$resBuy = $controller->canteenPay($reqBuy);
$dataBuy = json_decode($resBuy->getContent(), true);

assert($resBuy->getStatusCode() === 200, "Canteen pay should return 200");
assert($dataBuy['status'] === 'success', "Canteen pay should be success");
echo "✓ 11. Non-Cash Canteen Store Pay: Processed transaction (Receipt: " . $dataBuy['receipt_number'] . ")\n";

// 12. Test Internal Announcements
$reqAnn = Request::create('/api/v1/mobile/announcements', 'GET');
$resAnn = $controller->announcements($reqAnn);
$dataAnn = json_decode($resAnn->getContent(), true);

assert($resAnn->getStatusCode() === 200, "Announcements should return 200");
assert(count($dataAnn['data']) === 3, "Should return 3 announcements");
echo "✓ 12. Broadcast Memos: Retrieved " . count($dataAnn['data']) . " official school & foundation announcements\n";

echo "\n=== ALL 12 MOBILE HRIS API ENDPOINTS PASSED WITH 100% SUCCESS! ===\n";
