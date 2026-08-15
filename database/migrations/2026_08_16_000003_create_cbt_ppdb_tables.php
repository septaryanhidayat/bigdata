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
        Schema::create('cbt_exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
            $table->string('title');
            $table->string('subject_name');
            $table->integer('duration_minutes')->default(90);
            $table->integer('total_questions')->default(25);
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->enum('status', ['DRAFT', 'ACTIVE', 'COMPLETED'])->default('ACTIVE');
            $table->timestamps();
        });

        Schema::create('ppdb_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
            $table->string('registration_number')->unique();
            $table->string('full_name');
            $table->string('parent_name');
            $table->string('phone_number');
            $table->string('target_level'); // TK, SDIT, SMPIT, SMAIT
            $table->string('previous_school')->nullable();
            $table->enum('status', ['PENDING', 'DOCUMENT_VERIFIED', 'PASSED', 'REJECTED'])->default('PENDING');
            $table->decimal('registration_fee', 12, 2)->default(250000);
            $table->boolean('fee_paid')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppdb_registrations');
        Schema::dropIfExists('cbt_exams');
    }
};
