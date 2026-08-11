<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Schools (Multi-Unit Yayasan Context)
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name');
            $table->string('npsn', 20)->nullable();
            $table->string('principal_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('theme_color', 10)->default('#059669');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Academic Years & Semesters
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20); // e.g. '2026/2027'
            $table->enum('semester', ['Ganjil', 'Genap'])->default('Ganjil');
            $table->string('curriculum_code', 30)->default('MERDEKA'); // MERDEKA, K13, JSIT
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        // 3. Levels (Tingkat Per Unit Sekolah)
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('code', 20); // e.g. 'SD-1', 'SMP-7'
            $table->string('name'); // e.g. 'Kelas 7 (VII)'
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 4. Employees / Teachers & Staff
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('nip', 30)->nullable();
            $table->string('nik', 20)->nullable();
            $table->string('full_name');
            $table->string('title_prefix', 20)->nullable(); // e.g. 'Ustdz.'
            $table->string('title_suffix', 30)->nullable(); // e.g. 'S.Pd.'
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('role_type', 30)->default('TEACHER'); // TEACHER, STAFF, HEADMASTER, COUNSELOR, TREASURER
            $table->string('employment_status', 30)->default('PERMANENT'); // PERMANENT, CONTRACT, HONORARY
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 5. Classrooms / Rombel
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('level_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('homeroom_teacher_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('name'); // e.g. '7-Umar bin Khattab'
            $table->string('room_number', 30)->nullable();
            $table->integer('capacity')->default(30);
            $table->timestamps();
        });

        // 6. Rooms & Facilities
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('code', 30);
            $table->string('name');
            $table->string('category', 30)->default('KELAS'); // KELAS, LAB, PERPUS, LAPANGAN, AULA
            $table->integer('capacity')->default(30);
            $table->string('location_building')->nullable();
            $table->timestamps();
        });

        // 7. Subjects (Mata Pelajaran)
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('code', 30);
            $table->string('name');
            $table->string('category', 30)->default('UMUM'); // UMUM, RELIGION, JSIT, MULOK
            $table->decimal('passing_grade', 5, 2)->default(75.00);
            $table->timestamps();
        });

        // 8. Guardians (Orang Tua / Wali)
        Schema::create('guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('full_name');
            $table->string('nik', 20)->nullable();
            $table->string('relationship', 20)->default('FATHER'); // FATHER, MOTHER, GUARDIAN
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('occupation')->nullable();
            $table->string('bpi_pin', 6)->default('123456');
            $table->timestamps();
        });

        // 9. Students (Siswa)
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('guardian_id')->nullable()->constrained()->nullOnDelete();
            $table->string('nis', 30)->unique();
            $table->string('nisn', 30)->nullable();
            $table->string('rfid_tag', 50)->nullable()->unique();
            $table->string('full_name');
            $table->string('nickname', 50)->nullable();
            $table->enum('gender', ['M', 'F'])->default('M');
            $table->string('pob', 50)->nullable();
            $table->date('dob')->nullable();
            $table->string('status', 20)->default('ACTIVE'); // ACTIVE, GRADUATED, MUTATED, SUSPENDED
            $table->decimal('canteen_daily_limit', 12, 2)->default(50000.00);
            $table->decimal('canteen_balance', 12, 2)->default(0.00);
            $table->decimal('savings_balance', 12, 2)->default(0.00);
            $table->timestamps();
        });

        // 10. Audit Logs
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action'); // e.g. 'UPDATE_NILAI', 'VOID_SPP', 'MUTATE_STUDENT'
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('students');
        Schema::dropIfExists('guardians');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('rooms');
        Schema::dropIfExists('classrooms');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('academic_years');
        Schema::dropIfExists('schools');
    }
};
