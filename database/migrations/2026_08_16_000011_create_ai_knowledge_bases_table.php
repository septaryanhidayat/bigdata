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
        Schema::create('ai_knowledge_bases', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('umum'); // spmb, akademik, keuangan, sop, kurikulum, fasilitas, umum
            $table->string('source_type')->default('text'); // pdf, text, faq, system_data
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->longText('raw_content');
            $table->text('summary')->nullable();
            $table->json('keywords')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_knowledge_bases');
    }
};
