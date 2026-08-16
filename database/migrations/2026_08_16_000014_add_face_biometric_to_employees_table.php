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
        Schema::table('employees', function (Blueprint $table) {
            if (!Schema::hasColumn('employees', 'face_photo_url')) {
                $table->string('face_photo_url')->nullable()->after('employment_status');
            }
            if (!Schema::hasColumn('employees', 'face_registered_at')) {
                $table->timestamp('face_registered_at')->nullable()->after('face_photo_url');
            }
            if (!Schema::hasColumn('employees', 'face_descriptor')) {
                $table->text('face_descriptor')->nullable()->after('face_registered_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['face_photo_url', 'face_registered_at', 'face_descriptor']);
        });
    }
};
