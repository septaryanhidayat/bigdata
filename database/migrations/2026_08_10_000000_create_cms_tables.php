<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('feature_modules', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_title')->nullable();
            $table->string('category');
            $table->string('category_name');
            $table->string('icon')->default('🏛️');
            $table->string('badge_bg')->default('bg-emerald-100 text-emerald-800');
            $table->text('short_desc');
            $table->text('full_desc');
            $table->json('highlights');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('faq_items', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('answer');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faq_items');
        Schema::dropIfExists('feature_modules');
        Schema::dropIfExists('site_settings');
    }
};
