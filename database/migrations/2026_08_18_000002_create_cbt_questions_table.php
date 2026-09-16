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
        Schema::create('cbt_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cbt_exam_id')->constrained('cbt_exams')->onDelete('cascade');
            $table->text('question_text');
            $table->string('question_image')->nullable();
            $table->text('option_a');
            $table->text('option_b');
            $table->text('option_c')->nullable();
            $table->text('option_d')->nullable();
            $table->text('option_e')->nullable();
            $table->string('correct_answer', 10)->default('A');
            $table->decimal('score_weight', 5, 2)->default(1.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cbt_questions');
    }
};
