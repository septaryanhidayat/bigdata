<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_knowledge_bases', function (Blueprint $table) {
            $table->string('file_type')->nullable()->after('file_name'); // pdf, docx, xlsx, txt, manual, website_data
            $table->unsignedBigInteger('file_size')->nullable()->after('file_type'); // bytes
            $table->unsignedInteger('word_count')->nullable()->after('file_size');
            $table->unsignedInteger('chunk_count')->default(1)->after('word_count');
            $table->timestamp('processed_at')->nullable()->after('chunk_count');
            $table->string('uploaded_by')->nullable()->after('processed_at'); // user name/email who uploaded
        });
    }

    public function down(): void
    {
        Schema::table('ai_knowledge_bases', function (Blueprint $table) {
            $table->dropColumn(['file_type', 'file_size', 'word_count', 'chunk_count', 'processed_at', 'uploaded_by']);
        });
    }
};
