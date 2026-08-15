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
        // 1. Sarpras Assets
        Schema::create('sarpras_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
            $table->string('asset_code')->unique();
            $table->string('name');
            $table->string('category')->default('ELEKTRONIK'); // ELEKTRONIK, MEBEL, KENDARAAN, BANGUNAN
            $table->integer('quantity')->default(1);
            $table->string('location')->default('Ruang Lab Komputer');
            $table->enum('condition', ['GOOD', 'MINOR_DAMAGE', 'HEAVY_DAMAGE'])->default('GOOD');
            $table->decimal('purchase_cost', 14, 2)->default(0);
            $table->timestamps();
        });

        // 2. Library Books
        Schema::create('library_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
            $table->string('isbn')->unique();
            $table->string('title');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->integer('stock')->default(10);
            $table->integer('available_stock')->default(10);
            $table->string('category')->default('AGAMA_ISLAM');
            $table->timestamps();
        });

        // 3. LMS Materials
        Schema::create('lms_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
            $table->string('subject_name');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['PDF', 'VIDEO', 'ASSIGNMENT'])->default('PDF');
            $table->string('file_url')->nullable();
            $table->timestamps();
        });

        // 4. BK Records (Bimbingan Konseling & Poin Pelanggaran/Prestasi)
        Schema::create('bk_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->enum('type', ['VIOLATION', 'ACHIEVEMENT'])->default('VIOLATION');
            $table->string('title');
            $table->integer('points')->default(10);
            $table->text('description')->nullable();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bk_records');
        Schema::dropIfExists('lms_materials');
        Schema::dropIfExists('library_books');
        Schema::dropIfExists('sarpras_assets');
    }
};
