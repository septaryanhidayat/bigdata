<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('employees')) {
            Schema::table('employees', function (Blueprint $table) {
                if (!Schema::hasColumn('employees', 'kk_number')) {
                    $table->string('kk_number', 30)->nullable()->after('nik');
                }
                if (!Schema::hasColumn('employees', 'pob')) {
                    $table->string('pob', 100)->nullable()->after('gender'); // Tempat Lahir
                }
                if (!Schema::hasColumn('employees', 'dob')) {
                    $table->date('dob')->nullable()->after('pob'); // Tanggal Lahir
                }
                if (!Schema::hasColumn('employees', 'religion')) {
                    $table->string('religion', 30)->default('ISLAM')->after('dob');
                }
                if (!Schema::hasColumn('employees', 'blood_type')) {
                    $table->string('blood_type', 5)->nullable()->after('religion');
                }
                if (!Schema::hasColumn('employees', 'marital_status')) {
                    $table->string('marital_status', 30)->default('MARRIED')->after('blood_type'); // SINGLE, MARRIED, WIDOWED
                }
                if (!Schema::hasColumn('employees', 'children_count')) {
                    $table->integer('children_count')->default(0)->after('marital_status');
                }
                if (!Schema::hasColumn('employees', 'last_education')) {
                    $table->string('last_education', 50)->nullable()->after('children_count'); // S1, S2, S3, D3, SMA
                }
                if (!Schema::hasColumn('employees', 'major')) {
                    $table->string('major', 150)->nullable()->after('last_education'); // Jurusan
                }
                if (!Schema::hasColumn('employees', 'university')) {
                    $table->string('university', 150)->nullable()->after('major'); // Kampus / Almamater
                }
                if (!Schema::hasColumn('employees', 'graduation_year')) {
                    $table->string('graduation_year', 10)->nullable()->after('university');
                }
                if (!Schema::hasColumn('employees', 'join_date')) {
                    $table->date('join_date')->nullable()->after('graduation_year'); // TMT Bergabung
                }

                // Dokumen Arsip E-Berkas Digital SDM Yayasan
                if (!Schema::hasColumn('employees', 'file_ktp')) {
                    $table->string('file_ktp')->nullable()->after('join_date');
                }
                if (!Schema::hasColumn('employees', 'file_kk')) {
                    $table->string('file_kk')->nullable()->after('file_ktp');
                }
                if (!Schema::hasColumn('employees', 'file_ijazah')) {
                    $table->string('file_ijazah')->nullable()->after('file_kk');
                }
                if (!Schema::hasColumn('employees', 'file_surat_lamaran')) {
                    $table->string('file_surat_lamaran')->nullable()->after('file_ijazah');
                }
                if (!Schema::hasColumn('employees', 'file_kontrak_kerja')) {
                    $table->string('file_kontrak_kerja')->nullable()->after('file_surat_lamaran');
                }
                if (!Schema::hasColumn('employees', 'file_sertifikat')) {
                    $table->string('file_sertifikat')->nullable()->after('file_kontrak_kerja');
                }
                if (!Schema::hasColumn('employees', 'file_prestasi')) {
                    $table->string('file_prestasi')->nullable()->after('file_sertifikat');
                }
                if (!Schema::hasColumn('employees', 'file_npwp')) {
                    $table->string('file_npwp')->nullable()->after('file_prestasi');
                }
                if (!Schema::hasColumn('employees', 'file_bpjs')) {
                    $table->string('file_bpjs')->nullable()->after('file_npwp');
                }
                if (!Schema::hasColumn('employees', 'notes')) {
                    $table->text('notes')->nullable()->after('file_bpjs');
                }
            });
        }
    }

    public function down(): void
    {
        // No-op rollback for safety
    }
};
