<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add homeroom_signature_path to classrooms
        if (Schema::hasTable('classrooms') && !Schema::hasColumn('classrooms', 'homeroom_signature_path')) {
            Schema::table('classrooms', function (Blueprint $table) {
                $table->string('homeroom_signature_path')->nullable()->after('homeroom_teacher_id');
            });
        }

        // 2. Extracurriculars table
        if (!Schema::hasTable('extracurriculars')) {
            Schema::create('extracurriculars', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
                $table->string('name');
                $table->string('coach_name')->nullable();
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // 3. P5 Projects table
        if (!Schema::hasTable('p5_projects')) {
            Schema::create('p5_projects', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
                $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->nullOnDelete();
                $table->foreignId('academic_year_id')->nullable()->constrained('academic_years')->nullOnDelete();
                $table->string('theme'); // Gaya Hidup Berkelanjutan, Kearifan Lokal, Kewirausahaan, dll
                $table->string('title'); // Nama kegiatan projek
                $table->text('description')->nullable();
                $table->string('coordinator_name')->nullable();
                $table->json('target_dimensions')->nullable(); // Beriman, Mandiri, Gotong Royong, dll
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('classrooms') && Schema::hasColumn('classrooms', 'homeroom_signature_path')) {
            Schema::table('classrooms', function (Blueprint $table) {
                $table->dropColumn('homeroom_signature_path');
            });
        }
        Schema::dropIfExists('p5_projects');
        Schema::dropIfExists('extracurriculars');
    }
};
