<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah Kolom Geofencing Sekolah jika belum ada
        Schema::table('schools', function (Blueprint $table) {
            if (!Schema::hasColumn('schools', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->default(-3.22080000);
            }
            if (!Schema::hasColumn('schools', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->default(104.65040000);
            }
            if (!Schema::hasColumn('schools', 'radius_meters')) {
                $table->integer('radius_meters')->default(150);
            }
        });

        // 2. Tabel Presensi Face Recognition + Anti-Fake GPS Log
        if (!Schema::hasTable('employee_attendance_logs')) {
            Schema::create('employee_attendance_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
                $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
                $table->date('date');
                $table->time('check_in_time')->nullable();
                $table->time('check_out_time')->nullable();
                $table->decimal('check_in_lat', 10, 8)->nullable();
                $table->decimal('check_in_lng', 11, 8)->nullable();
                $table->decimal('check_out_lat', 10, 8)->nullable();
                $table->decimal('check_out_lng', 11, 8)->nullable();
                $table->integer('check_in_distance_meters')->nullable();
                $table->integer('check_out_distance_meters')->nullable();
                $table->string('check_in_face_image')->nullable();
                $table->string('check_out_face_image')->nullable();
                $table->boolean('is_mock_detected')->default(false);
                $table->enum('status', ['PRESENT', 'LATE', 'PERMIT', 'SICK', 'LEAVE'])->default('PRESENT');
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->unique(['employee_id', 'date']);
            });
        }

        // 3. Tabel Pengajuan Cuti & Izin Pegawai
        if (!Schema::hasTable('employee_leaves')) {
            Schema::create('employee_leaves', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
                $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
                $table->enum('leave_type', ['SAKIT', 'TAHUNAN', 'MELAHIRKAN', 'UMROH_HAJI', 'PENTING'])->default('TAHUNAN');
                $table->date('start_date');
                $table->date('end_date');
                $table->integer('total_days')->default(1);
                $table->text('reason');
                $table->string('attachment_url')->nullable();
                $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
                $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
                $table->text('rejection_reason')->nullable();
                $table->timestamps();
            });
        }

        // 4. Tabel Penilaian Kinerja & KPI Pegawai
        if (!Schema::hasTable('employee_kpis')) {
            Schema::create('employee_kpis', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
                $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
                $table->string('period_month_year', 10); // e.g. "2026-08"
                $table->decimal('pedagogic_score', 5, 2)->default(85.00);
                $table->decimal('personality_score', 5, 2)->default(90.00);
                $table->decimal('social_score', 5, 2)->default(88.00);
                $table->decimal('islamic_score', 5, 2)->default(95.00);
                $table->decimal('discipline_attendance_score', 5, 2)->default(92.00);
                $table->decimal('final_score', 5, 2)->default(90.00);
                $table->enum('grade', ['A', 'B', 'C', 'D'])->default('A');
                $table->text('evaluator_notes')->nullable();
                $table->foreignId('evaluated_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_kpis');
        Schema::dropIfExists('employee_leaves');
        Schema::dropIfExists('employee_attendance_logs');
        
        Schema::table('schools', function (Blueprint $table) {
            if (Schema::hasColumn('schools', 'latitude')) {
                $table->dropColumn(['latitude', 'longitude', 'radius_meters']);
            }
        });
    }
};
