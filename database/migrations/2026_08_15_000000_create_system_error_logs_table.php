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
        Schema::create('system_error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('error_type')->default('PHP Exception'); // PHP Exception, JS Runtime Error, Database Error, RFID Device Error, API Timeout
            $table->enum('severity', ['CRITICAL', 'HIGH', 'WARNING', 'INFO'])->default('HIGH');
            $table->text('message');
            $table->string('file')->nullable();
            $table->integer('line')->nullable();
            $table->longText('stack_trace')->nullable();
            $table->string('url')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('ip_address')->nullable();
            $table->enum('status', ['UNRESOLVED', 'MITIGATING', 'RESOLVED', 'AUTO_MITIGATED'])->default('UNRESOLVED');
            $table->text('mitigation_solution')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_error_logs');
    }
};
