<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Official Letters (Surat Masuk & Surat Keluar)
        Schema::create('official_letters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['INCOMING', 'OUTGOING'])->default('OUTGOING'); // INCOMING = Surat Masuk, OUTGOING = Surat Keluar
            $table->string('letter_category', 50)->default('SURAT_EDARAN'); // SURAT_EDARAN, SURAT_TUGAS, NOTA_DINAS, SURAT_KETERANGAN, UNDANGAN, SURAT_KEPUTUSAN, LAINNYA
            $table->string('reference_number', 100)->nullable(); // Nomor Surat Resmi (misal: 045/SDIT-ROBBANI/SE/VIII/2026)
            $table->string('agenda_number', 50)->nullable(); // Nomor Agenda / Buku Registrasi Surat Masuk
            $table->string('title'); // Perihal / Judul Surat
            $table->string('sender')->nullable(); // Pengirim / Instansi Asal
            $table->string('recipient')->nullable(); // Penerima / Tujuan Surat
            $table->date('letter_date'); // Tanggal Surat
            $table->date('received_date')->nullable(); // Tanggal Terima (untuk Surat Masuk)
            $table->text('content')->nullable(); // Narasi / Isi Surat (HTML / Text)
            $table->string('file_url')->nullable(); // Lampiran / Scan Surat (PDF/JPG)
            $table->enum('security_level', ['BIASA', 'SEGERA', 'KILAT', 'RAHASIA'])->default('BIASA');
            $table->enum('status', ['DRAFT', 'VERIFICATION', 'WAITING_SIGNATURE', 'SIGNED', 'DISPATCHED', 'ARCHIVED'])->default('DRAFT');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->json('metadata_json')->nullable(); // Tembusan, tags, catatan dinas tambahan
            $table->timestamps();
        });

        // 2. Letter Templates (Master Format Baku Surat)
        Schema::create('letter_templates', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // e.g. TPL-ST-01, TPL-SE-01
            $table->string('name'); // Surat Tugas Pelatihan, Surat Edaran Libur, dll
            $table->string('category', 50)->default('SURAT_EDARAN');
            $table->string('format_number_pattern')->default('{NO}/SIT-ROBBANI/{CAT}/{ROMAN_MONTH}/{YEAR}');
            $table->longText('content_template'); // Template body with {nama}, {nip}, {kegiatan}, dll
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Digital Signatures (TTE Standar BSrE BSSN / PSrE)
        Schema::create('digital_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_id')->constrained('official_letters')->cascadeOnDelete();
            $table->foreignId('signer_employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('certificate_issuer')->default('BSrE - Badan Siber dan Sandi Negara (BSSN) / SmartEdu CA');
            $table->string('certificate_serial', 100);
            $table->string('signature_hash', 128); // Cryptographic SHA-256 Digest
            $table->string('verify_token', 64)->unique(); // Token Verifikasi QR Code
            $table->timestamp('signed_at');
            $table->string('ip_address', 45)->nullable();
            $table->boolean('passphrase_validated')->default(true);
            $table->enum('status', ['VALID', 'REVOKED'])->default('VALID');
            $table->timestamps();
        });

        // 4. Letter Dispositions (Lembar Disposisi & Instruksi Pimpinan)
        Schema::create('letter_dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_id')->constrained('official_letters')->cascadeOnDelete();
            $table->foreignId('from_employee_id')->constrained('employees')->cascadeOnDelete(); // Pimpinan Pemberi Disposisi
            $table->foreignId('to_employee_id')->constrained('employees')->cascadeOnDelete(); // Bawahan / Staf Penerima
            $table->string('instruction'); // Tindak Lanjuti, Pelajari, Hadiri, Siapkan Laporan, Arsipkan, dll
            $table->text('notes')->nullable(); // Catatan Khusus dari Pimpinan
            $table->date('due_date')->nullable(); // Batas Waktu Pengerjaan
            $table->enum('status', ['PENDING', 'IN_PROGRESS', 'COMPLETED', 'REJECTED'])->default('PENDING');
            $table->text('reply_notes')->nullable(); // Feedback / Laporan Balasan Bawahan
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // 5. Letter Audit Trails (Jejak Rekam & Tracking Alur Surat)
        Schema::create('letter_audit_trails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('letter_id')->constrained('official_letters')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action'); // CREATED, SUBMITTED_FOR_TTE, SIGNED_TTE, DISPOSED, COMPLETED, ARCHIVED
            $table->string('description');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('letter_audit_trails');
        Schema::dropIfExists('letter_dispositions');
        Schema::dropIfExists('digital_signatures');
        Schema::dropIfExists('letter_templates');
        Schema::dropIfExists('official_letters');
    }
};
