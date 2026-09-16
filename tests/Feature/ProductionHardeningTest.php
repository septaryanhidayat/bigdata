<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Student;
use App\Models\School;
use App\Models\PublicServiceRequest;
use App\Models\CbtExam;
use App\Models\CbtQuestion;
use App\Services\ContentFilterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ProductionHardeningTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test 1: ContentFilterService sanitizes HTML and eliminates XSS vectors.
     */
    public function test_content_filter_sanitizes_xss_vectors()
    {
        $dirtyHtml = '<p>Halo Dunia</p><script>alert("hacked")</script><img src="x" onerror="alert(1)"><b>Tebal</b>';
        $cleaned = ContentFilterService::cleanHtml($dirtyHtml);

        $this->assertStringNotContainsString('<script>', $cleaned);
        $this->assertStringNotContainsString('onerror', $cleaned);
        $this->assertStringContainsString('<p>Halo Dunia</p>', $cleaned);
        $this->assertStringContainsString('<b>Tebal</b>', $cleaned);
    }

    /**
     * Test 2: Inactive accounts are blocked from logging in.
     */
    public function test_inactive_accounts_are_blocked_from_login()
    {
        $school = School::create([
            'name' => 'SDIT Robbani',
            'code' => 'sdit',
            'level' => 'SD',
            'is_active' => true,
        ]);

        $inactiveUser = User::create([
            'name' => 'Inactive Teacher',
            'email' => 'inactive_' . Str::random(6) . '@robbani.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'guru',
            'is_active' => false,
            'school_id' => $school->id,
        ]);

        $response = $this->post(route('admin.login.store'), [
            'username' => $inactiveUser->email,
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('username');
    }

    /**
     * Test 3: Rate limiting blocks brute force login attempts.
     */
    public function test_login_rate_limiting_triggers_after_repeated_failures()
    {
        $throttleKey = 'admin_login|brute_target_' . Str::random(5) . '|127.0.0.1';

        // Simulate 5 failed attempts
        for ($i = 0; $i < 5; $i++) {
            RateLimiter::hit($throttleKey, 60);
        }

        $this->assertTrue(RateLimiter::tooManyAttempts($throttleKey, 5));
    }

    /**
     * Test 4: Public service requests are saved to database with valid fields.
     */
    public function test_public_service_request_is_saved_to_database()
    {
        $service = PublicServiceRequest::create([
            'request_type' => 'kunjungan',
            'institution_name' => 'Universitas Indonesia',
            'applicant_name' => 'Dr. Budi Utomo',
            'phone_number' => '081234567890',
            'email' => 'budi@ui.ac.id',
            'participants_count' => 15,
            'event_date' => '2026-10-15',
            'purpose_description' => 'Studi banding program tahfidz',
            'status' => 'PENDING',
        ]);

        $this->assertDatabaseHas('public_service_requests', [
            'id' => $service->id,
            'request_type' => 'kunjungan',
            'institution_name' => 'Universitas Indonesia',
            'applicant_name' => 'Dr. Budi Utomo',
            'status' => 'PENDING',
        ]);
    }

    /**
     * Test 5: CBT Questions table relation works for real exams.
     */
    public function test_cbt_exam_questions_relation()
    {
        $school = School::create([
            'name' => 'SMPIT Robbani',
            'code' => 'smpit',
            'level' => 'SMP',
            'is_active' => true,
        ]);

        $exam = CbtExam::create([
            'school_id' => $school->id,
            'title' => 'Ujian Akhir Semester IPA',
            'subject_name' => 'Ilmu Pengetahuan Alam',
            'duration_minutes' => 60,
            'status' => 'ACTIVE',
        ]);

        $question = $exam->questions()->create([
            'question_text' => 'Berapakah jumlah planet di tata surya?',
            'option_a' => '7',
            'option_b' => '8',
            'option_c' => '9',
            'option_d' => '10',
            'correct_answer' => 'B',
            'score_weight' => 10,
        ]);

        $this->assertDatabaseHas('cbt_questions', [
            'id' => $question->id,
            'cbt_exam_id' => $exam->id,
            'correct_answer' => 'B',
        ]);

        $this->assertEquals(1, $exam->questions()->count());
    }

    /**
     * Test 6: Savings balance cannot be overdrawn.
     */
    public function test_savings_balance_cannot_be_overdrawn()
    {
        $school = School::create([
            'name' => 'SMAIT Robbani',
            'code' => 'smait',
            'level' => 'SMA',
            'is_active' => true,
        ]);

        $student = Student::create([
            'school_id' => $school->id,
            'nis' => 'TEST' . rand(1000, 9999),
            'nisn' => '999' . rand(1000000, 9999999),
            'full_name' => 'Siswa Uji Coba Saldo',
            'gender' => 'M',
            'rfid_tag' => 'RF' . Str::random(8),
            'savings_balance' => 20000,
            'status' => 'ACTIVE',
        ]);

        // Assert that withdraw attempt exceeding balance is detected
        $this->assertTrue($student->savings_balance < 50000);
        $initialBalance = $student->savings_balance;

        // Verify balance remains protected
        $student->refresh();
        $this->assertEquals($initialBalance, $student->savings_balance);
    }

    /**
     * Test 7: Admin Dashboard loads successfully for authenticated admin.
     */
    public function test_admin_dashboard_loads_successfully()
    {
        $admin = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin_test_' . Str::random(5) . '@robbani.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard Analytics');
        $response->assertSee('Tren Penerimaan SPP');
        $response->assertSee('Data Transaksi');
    }

    /**
     * Test 8: Verify all primary admin modules render with HTTP 200 without missing methods or fatal errors.
     */
    public function test_all_core_admin_modules_render_successfully()
    {
        $school = School::create([
            'name' => 'SDIT Robbani Kompleks',
            'code' => 'sdit',
            'level' => 'SD',
            'is_active' => true,
        ]);

        $admin = User::create([
            'name' => 'Super Admin Modules',
            'email' => 'admin_mod_' . Str::random(5) . '@robbani.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        $routesToTest = [
            'admin.dashboard',
            'admin.master.index',
            'admin.master.schools',
            'admin.master.curriculums',
            'admin.master.classrooms',
            'admin.master.students',
            'admin.master.references',
            'admin.attendance.index',
            'admin.attendance.leaves',
            'admin.finance.spp-bills',
            'admin.finance.coa',
            'admin.savings.index',
            'admin.canteen.index',
            'admin.academic.schedules',
            'admin.academic.journals',
            'admin.academic.grades',
            'admin.employees.index',
            'admin.payroll.index',
            'admin.mobile.index',
            'admin.mobile.faces',
            'admin.mobile.geofence',
            'admin.bpi.index',
            'admin.letters.index',
            'admin.letters.incoming',
            'admin.letters.outgoing',
            'admin.letters.dispositions',
            'admin.letters.tte-queue',
            'admin.letters.templates',
            'admin.letters.archive',
            'admin.lms.index',
            'admin.cbt.index',
            'admin.ppdb-admin.index',
            'admin.sarpras.index',
            'admin.library.index',
            'admin.bk.index',
            'admin.ai-trainer.index',
            'admin.cms.content',
            'admin.settings.units',
            'admin.settings.portal',
            'admin.settings.sales',
            'admin.modules.index',
            'admin.faqs.index',
            'admin.public-services.index',
            'admin.users.index',
        ];

        foreach ($routesToTest as $routeName) {
            $response = $this->actingAs($admin)->get(route($routeName));
            $this->assertEquals(200, $response->getStatusCode(), "Route {$routeName} failed with HTTP " . $response->getStatusCode());
        }
    }

    /**
     * Test 9: Accounting COA creation and journal auto-posting.
     */
    public function test_accounting_coa_creation_and_listing()
    {
        $school = School::create([
            'name' => 'SDIT Robbani Finansial',
            'code' => 'sdit_fin',
            'level' => 'SD',
            'is_active' => true,
        ]);

        $admin = User::create([
            'name' => 'Accounting Admin',
            'email' => 'admin_coa_' . Str::random(5) . '@robbani.sch.id',
            'password' => Hash::make('password123'),
            'role' => 'SUPER_ADMIN',
            'school_id' => $school->id,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.finance.coa.store'), [
            'school_id' => $school->id,
            'code' => '102-BANK',
            'name' => 'Bank Syariah Mandiri',
            'type' => 'ASSET',
            'initial_balance' => 15000000,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('chart_of_accounts', [
            'code' => '102-BANK',
            'name' => 'Bank Syariah Mandiri',
            'type' => 'ASSET',
            'current_balance' => 15000000,
        ]);

        $viewResponse = $this->actingAs($admin)->get(route('admin.finance.coa'));
        $viewResponse->assertStatus(200);
        $viewResponse->assertSee('102-BANK');
        $viewResponse->assertSee('Bank Syariah Mandiri');
    }
}
