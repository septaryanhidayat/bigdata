<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Quran Criteria (Kriteria Penilaian Dinamis - Metode Wafa)
        if (!Schema::hasTable('quran_criteria')) {
            Schema::create('quran_criteria', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->nullable()->constrained('schools')->cascadeOnDelete();
                $table->enum('category', ['tahsin', 'tahfidz'])->default('tahsin');
                $table->string('code', 30);
                $table->string('name');
                $table->text('description')->nullable();
                $table->unsignedSmallInteger('order_number')->default(0);
                $table->timestamps();
            });
        }

        // 2. Quran Grades (Rapor Al-Qur'an: Tahsin Wafa & Tahfidz)
        if (!Schema::hasTable('quran_grades')) {
            Schema::create('quran_grades', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
                $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
                
                // Tahsin Wafa Data
                $table->string('tahsin_method')->default('Wafa');
                $table->string('tahsin_level')->nullable();
                $table->json('tahsin_scores')->nullable();
                $table->decimal('tahsin_final_score', 5, 2)->nullable();
                $table->string('tahsin_predicate', 30)->nullable();
                $table->text('tahsin_notes')->nullable();
                
                // Tahfidz Data
                $table->string('tahfidz_target')->nullable();
                $table->string('tahfidz_achievement')->nullable();
                $table->decimal('tahfidz_score', 5, 2)->nullable();
                $table->string('tahfidz_predicate', 30)->nullable();
                $table->string('tasmi_exam_result')->nullable();
                $table->text('tahfidz_notes')->nullable();
                
                $table->foreignId('examiner_teacher_id')->nullable()->constrained('employees')->nullOnDelete();
                $table->timestamps();
            });
        }

        // 3. Character Indicators (7 Standar Mutu Karakter JSIT)
        if (!Schema::hasTable('character_indicators')) {
            Schema::create('character_indicators', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->nullable()->constrained('schools')->cascadeOnDelete();
                $table->string('standard_code', 20);
                $table->string('standard_name');
                $table->text('indicator_name');
                $table->unsignedSmallInteger('order_number')->default(0);
                $table->timestamps();
            });
        }

        // 4. Character Grades (Rapor BPI & Karakter JSIT)
        if (!Schema::hasTable('character_grades')) {
            Schema::create('character_grades', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
                $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
                
                $table->json('indicator_scores')->nullable();
                $table->string('mutabaah_sholat_fardhu')->nullable()->default('Selalu Berjamaah');
                $table->string('mutabaah_sholat_dhuha')->nullable()->default('Rutin Setiap Hari');
                $table->string('mutabaah_tilawah')->nullable()->default('Rutin 1/2 Juz per Hari');
                $table->string('mutabaah_infaq')->nullable()->default('Rutin Infaq Jumat');
                $table->text('bpi_mentor_notes')->nullable();
                $table->timestamps();
            });
        }

        // 5. Homeroom Notes (Catatan Wali Kelas, Presensi, Fisik & Ekskul)
        if (!Schema::hasTable('homeroom_notes')) {
            Schema::create('homeroom_notes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
                $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
                $table->integer('sick_count')->default(0);
                $table->integer('permission_count')->default(0);
                $table->integer('absent_count')->default(0);
                $table->decimal('height_cm', 5, 1)->nullable();
                $table->decimal('weight_kg', 5, 1)->nullable();
                $table->string('hearing_health')->nullable()->default('Baik');
                $table->string('vision_health')->nullable()->default('Baik');
                $table->string('dental_health')->nullable()->default('Baik');
                $table->json('extracurriculars')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // 6. Report Settings (Kop Surat, Logo, Tanda Tangan, Pejabat)
        if (!Schema::hasTable('report_settings')) {
            Schema::create('report_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
                $table->text('kop_header_text')->nullable();
                $table->string('kop_image_url')->nullable();
                $table->string('school_logo_url')->nullable();
                $table->string('jsit_logo_url')->nullable();
                $table->string('foundation_logo_url')->nullable();
                $table->string('stamp_image_url')->nullable();
                $table->string('principal_signature_url')->nullable();
                $table->string('principal_name')->nullable();
                $table->string('principal_nip')->nullable();
                $table->string('report_date')->nullable();
                $table->string('report_city')->nullable()->default('Bandung');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('report_settings');
        Schema::dropIfExists('homeroom_notes');
        Schema::dropIfExists('character_grades');
        Schema::dropIfExists('character_indicators');
        Schema::dropIfExists('quran_grades');
        Schema::dropIfExists('quran_criteria');
    }
};
