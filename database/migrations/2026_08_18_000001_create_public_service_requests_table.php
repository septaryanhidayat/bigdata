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
        Schema::create('public_service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_type'); // 'kunjungan', 'kerjasama', 'sewa'
            $table->string('institution_name')->nullable();
            $table->string('applicant_name');
            $table->string('email')->nullable();
            $table->string('phone_number');
            $table->date('event_date')->nullable();
            $table->integer('participants_count')->nullable();
            $table->string('facility_or_type')->nullable(); // e.g., 'Aula', 'Lapangan', 'Sponsorship'
            $table->text('purpose_description');
            $table->string('document_path')->nullable();
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'COMPLETED'])->default('PENDING');
            $table->text('admin_note')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_service_requests');
    }
};
