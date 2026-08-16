<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('employees') && !Schema::hasColumn('employees', 'employment_status')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('employment_status', 30)->default('TETAP')->nullable()->after('role_type');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('employees') && Schema::hasColumn('employees', 'employment_status')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('employment_status');
            });
        }
    }
};
