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
        Schema::create('bpi_mutabaahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->date('date');
            $table->boolean('sholat_subuh')->default(true);
            $table->boolean('sholat_zhuhur')->default(true);
            $table->boolean('sholat_ashar')->default(true);
            $table->boolean('sholat_maghrib')->default(true);
            $table->boolean('sholat_isya')->default(true);
            $table->boolean('dhuha')->default(false);
            $table->boolean('tahajud')->default(false);
            $table->string('tilawah_juz')->nullable(); // e.g. "Juz 30 (Surah An-Naba)"
            $table->string('hafalan_surah')->nullable(); // e.g. "Surah Al-Mulk ayat 1-15"
            $table->boolean('al_mathurat')->default(true);
            $table->decimal('infaq_amount', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->boolean('verified_by_parent')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpi_mutabaahs');
    }
};
