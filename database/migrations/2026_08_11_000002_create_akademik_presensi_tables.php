<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Schedules (Jadwal Pelajaran Mingguan)
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('employees')->cascadeOnDelete();
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->time('start_time');
            $table->time('end_time');
            $table->string('room_name')->nullable();
            $table->timestamps();
        });

        // 2. KBM Journals (Jurnal Mengajar Guru)
        Schema::create('kbm_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('employees')->cascadeOnDelete();
            $table->date('date');
            $table->string('topic');
            $table->text('notes')->nullable();
            $table->integer('student_present_count')->default(0);
            $table->integer('student_absent_count')->default(0);
            $table->timestamps();
        });

        // 3. Grades (Penilaian K13 & Merdeka P5)
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->string('assessment_type', 30); // FORMATIF, SUMATIF, P5_PROYEK, UTS, UAS
            $table->string('competency_code', 50)->nullable(); // e.g. 'TP-1', 'KI-3'
            $table->decimal('score', 5, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 4. Attendances (Presensi Realtime RFID & QR Code)
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('employee_id')->nullable()->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('time_in')->nullable();
            $table->time('time_out')->nullable();
            $table->enum('status', ['HADIR', 'IZIN', 'SAKIT', 'ALPHA', 'TERLAMBAT'])->default('HADIR');
            $table->enum('method', ['RFID_GATE', 'QR_CLASS', 'MANUAL_TEACHER', 'SELF_CHECKIN'])->default('RFID_GATE');
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        // 5. Student Leaves (Pengajuan Izin Siswa)
        Schema::create('student_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guardian_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('type', ['SAKIT', 'IZIN', 'LAINNYA'])->default('IZIN');
            $table->text('reason');
            $table->string('attachment_url')->nullable();
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_leaves');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('kbm_journals');
        Schema::dropIfExists('schedules');
    }
};
