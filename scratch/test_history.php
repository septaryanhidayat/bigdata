<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$controller = new App\Http\Controllers\Api\HrisMobileApiController();

$req = Illuminate\Http\Request::create('/api/v1/mobile/attendance/history', 'GET', [
    'month' => '08',
    'year' => '2026',
]);
$req->headers->set('X-User-Id', '1');

$res = $controller->attendanceHistory($req);
$data = json_decode($res->getContent(), true);

echo "Status: " . $res->getStatusCode() . "\n";
echo "Total logs returned: " . count($data['data']) . "\n";
echo "Summary: " . json_encode($data['summary']) . "\n";
foreach ($data['data'] as $l) {
    echo "Date: {$l['date']} | In: {$l['check_in_time']} | Out: {$l['check_out_time']} | Status: {$l['status']}\n";
}
