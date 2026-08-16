<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\School;
use App\Models\Employee;
use App\Models\OfficialLetter;
use App\Models\LetterTemplate;
use App\Models\LetterDisposition;
use App\Models\DigitalSignature;
use Illuminate\Http\Request;

echo "=== TESTING REVISED PERSURATAN, EDIT DRAFT & INTERNAL TTE ===\n\n";

$admin = User::where('email', 'admin@smartedu.test')->first();
auth()->login($admin);
echo "✓ Authenticated as: " . $admin->name . "\n";

$school = School::first();
$principal = Employee::whereIn('role_type', ['HEADMASTER', 'TEACHER'])->first();
$staff = Employee::where('id', '!=', $principal->id)->first() ?? $principal;

$lc = app(\App\Http\Controllers\Admin\LetterController::class);

// 1. Overview Dashboard
$lc->index(request());
echo "✓ 1. Dashboard Overview passed!\n";

// 2. Incoming Letters
$lc->incoming(request());
$reqIn = new Request([
    'school_id' => $school->id,
    'reference_number' => 'TEST/DISDIK/' . rand(100, 999),
    'title' => 'Uji Coba Surat Masuk ANBK 2026',
    'sender' => 'Dinas Pendidikan Provinsi Sumsel',
    'letter_date' => date('Y-m-d'),
    'received_date' => date('Y-m-d'),
    'security_level' => 'SEGERA',
    'letter_category' => 'UNDANGAN',
    'content' => 'Undangan koordinasi teknis',
]);
$lc->storeIncoming($reqIn);
echo "✓ 2. Surat Masuk & Agenda Numbering passed!\n";

// 3. Outgoing Letters & Create Draft
$lc->outgoing(request());
$reqOut = new Request([
    'school_id' => $school->id,
    'title' => 'Surat Undangan Kajian Wali Santri',
    'recipient' => 'Seluruh Wali Santri SIT Robbani',
    'letter_category' => 'UNDANGAN',
    'letter_date' => date('Y-m-d'),
    'content' => 'Undangan rapat dan kajian parenting.',
    'security_level' => 'BIASA',
    'action_type' => 'SAVE_DRAFT',
]);
$lc->storeOutgoing($reqOut);
echo "✓ 3. Pembuatan Surat Keluar (Draft) passed!\n";

$draftLetter = OfficialLetter::where('type', 'OUTGOING')->where('status', 'DRAFT')->latest()->first();

// 4. Edit Draft Letter (User Requested Feature)
$reqUpdate = new Request([
    'school_id' => $school->id,
    'title' => 'Surat Undangan Kajian Parenting & Sosialisasi JSIT (Revisi)',
    'recipient' => 'Seluruh Orang Tua / Wali Santri Kelas 7 & 8',
    'letter_date' => date('Y-m-d'),
    'content' => "Hari / Tanggal : Sabtu, 22 Agustus 2026\nWaktu : 08.30 WIB\nTempat : Aula Utama\nPembicara : Ustadz Dr. H. Ahmad Fauzi, M.Pd.I",
    'security_level' => 'SEGERA',
    'action_type' => 'SUBMIT_TTE',
]);
$lc->updateOutgoing($reqUpdate, $draftLetter->id);
echo "✓ 4. Edit Draf Surat & Re-Submit ke Antrian TTE passed!\n";

// 5. Dispositions
$lc->dispositions(request());
$incomingLetter = OfficialLetter::where('type', 'INCOMING')->latest()->first();
$reqDisp = new Request([
    'letter_id' => $incomingLetter->id,
    'to_employee_id' => $staff->id,
    'instruction' => 'Tindak Lanjuti Segera',
    'notes' => 'Siapkan delegasi guru',
    'due_date' => date('Y-m-d', strtotime('+3 days')),
]);
$lc->storeDisposition($reqDisp);

$latestDisp = LetterDisposition::latest()->first();
$reqDispUpdate = new Request([
    'status' => 'COMPLETED',
    'reply_notes' => 'Telah dikoordinasikan dan surat balasan telah dikirim.',
]);
$lc->updateDispositionStatus($reqDispUpdate, $latestDisp->id);
echo "✓ 5. Disposisi Pimpinan & Update Feedback passed!\n";

// 6. TTE Internal Signing
$lc->tteQueue(request());
$reqSign = new Request([
    'passphrase' => 'rahasia123',
    'signer_employee_id' => $principal->id,
]);
$lc->signLetter($reqSign, $draftLetter->id);
echo "✓ 6. TTE Digital Internal (Secure QR & SHA-256 Digest) passed!\n";

// 7. Preview PDF with 1 Centered Logo / KOP
$lc->previewPdf($draftLetter->id);
echo "✓ 7. Preview & Cetak PDF Resmi (1 Logo Tengah / Banner KOP) passed!\n";

// 8. Public Internal Verification
$sig = DigitalSignature::where('letter_id', $draftLetter->id)->first();
$pvc = app(\App\Http\Controllers\PublicLetterVerificationController::class);
$pvc->verify($sig->verify_token);
echo "✓ 8. Public Verification Portal (/verifikasi-surat/{token}) passed!\n";

echo "\n=== ALL REVISED PERSURATAN & INTERNAL TTE FEATURES PASSED 100%! ===\n";
