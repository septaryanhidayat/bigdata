<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Kelompok BPI SDM
        if (!Schema::hasTable('employee_bpi_groups')) {
            Schema::create('employee_bpi_groups', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('cascade');
                $table->string('name', 100); // e.g. "Halaqah BPI SDM 1 - Utsman Bin Affan"
                $table->foreignId('mentor_id')->constrained('employees')->onDelete('cascade');
                $table->string('schedule_day', 20)->default('Jumat');
                $table->string('schedule_time', 20)->default('16:00 WIB');
                $table->string('location', 100)->default('Masjid Kampus SIT Robbani');
                $table->timestamps();
            });
        }

        // 2. Tabel Anggota Kelompok BPI SDM
        if (!Schema::hasTable('employee_bpi_members')) {
            Schema::create('employee_bpi_members', function (Blueprint $table) {
                $table->id();
                $table->foreignId('group_id')->constrained('employee_bpi_groups')->onDelete('cascade');
                $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
                $table->date('joined_date')->nullable();
                $table->timestamps();

                $table->unique(['group_id', 'employee_id']);
            });
        }

        // 3. Tabel Laporan Amal Ibadah Harian (Mutabaah Yaumiyah SDM)
        if (!Schema::hasTable('employee_mutabaahs')) {
            Schema::create('employee_mutabaahs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
                $table->date('date');
                $table->tinyInteger('sholat_fardhu_jamaah')->default(5); // 0-5 waktu
                $table->boolean('sholat_rawatib')->default(false);
                $table->boolean('sholat_tahajjud')->default(false);
                $table->boolean('sholat_dhuha')->default(false);
                $table->integer('tilawah_pages')->default(0); // Halaman tilawah
                $table->enum('al_matsurat', ['none', 'pagi', 'petang', 'lengkap'])->default('lengkap');
                $table->boolean('puasa_sunnah')->default(false);
                $table->boolean('infaq')->default(false);
                $table->boolean('baca_buku')->default(false);
                $table->text('notes')->nullable();
                $table->boolean('verified_by_mentor')->default(false);
                $table->timestamps();

                $table->unique(['employee_id', 'date']);
            });
        }

        // 4. Tabel Pertemuan Mingguan BPI SDM
        if (!Schema::hasTable('employee_bpi_meetings')) {
            Schema::create('employee_bpi_meetings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('group_id')->constrained('employee_bpi_groups')->onDelete('cascade');
                $table->foreignId('mentor_id')->constrained('employees')->onDelete('cascade');
                $table->date('date');
                $table->string('topic_title', 150); // Judul Materi / Taujih
                $table->text('summary_notes')->nullable();
                $table->json('attendees_json')->nullable(); // List ID pegawai yang hadir
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_bpi_meetings');
        Schema::dropIfExists('employee_mutabaahs');
        Schema::dropIfExists('employee_bpi_members');
        Schema::dropIfExists('employee_bpi_groups');
    }
};
