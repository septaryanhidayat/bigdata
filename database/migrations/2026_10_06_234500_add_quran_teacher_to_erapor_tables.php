<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. quran_grades
        if (Schema::hasTable('quran_grades')) {
            Schema::table('quran_grades', function (Blueprint $table) {
                if (!Schema::hasColumn('quran_grades', 'quran_teacher_name')) {
                    $table->string('quran_teacher_name', 255)->nullable()->after('examiner_teacher_id');
                }
                if (!Schema::hasColumn('quran_grades', 'quran_teacher_title')) {
                    $table->string('quran_teacher_title', 255)->nullable()->after('quran_teacher_name');
                }
            });
        }

        // 2. report_settings
        if (Schema::hasTable('report_settings')) {
            Schema::table('report_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('report_settings', 'quran_teacher_name')) {
                    $table->string('quran_teacher_name', 255)->nullable()->after('principal_nip');
                }
                if (!Schema::hasColumn('report_settings', 'quran_teacher_title')) {
                    $table->string('quran_teacher_title', 255)->nullable()->after('quran_teacher_name');
                }
            });
        }

        // 3. classrooms
        if (Schema::hasTable('classrooms')) {
            Schema::table('classrooms', function (Blueprint $table) {
                if (!Schema::hasColumn('classrooms', 'quran_teacher_name')) {
                    $table->string('quran_teacher_name', 255)->nullable()->after('homeroom_signature_path');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('quran_grades')) {
            Schema::table('quran_grades', function (Blueprint $table) {
                if (Schema::hasColumn('quran_grades', 'quran_teacher_title')) {
                    $table->dropColumn('quran_teacher_title');
                }
                if (Schema::hasColumn('quran_grades', 'quran_teacher_name')) {
                    $table->dropColumn('quran_teacher_name');
                }
            });
        }

        if (Schema::hasTable('report_settings')) {
            Schema::table('report_settings', function (Blueprint $table) {
                if (Schema::hasColumn('report_settings', 'quran_teacher_title')) {
                    $table->dropColumn('quran_teacher_title');
                }
                if (Schema::hasColumn('report_settings', 'quran_teacher_name')) {
                    $table->dropColumn('quran_teacher_name');
                }
            });
        }

        if (Schema::hasTable('classrooms')) {
            Schema::table('classrooms', function (Blueprint $table) {
                if (Schema::hasColumn('classrooms', 'quran_teacher_name')) {
                    $table->dropColumn('quran_teacher_name');
                }
            });
        }
    }
};
