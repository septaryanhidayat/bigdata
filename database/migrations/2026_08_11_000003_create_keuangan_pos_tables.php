<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. SPP Bills (Tagihan SPP Bulanan)
        Schema::create('spp_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_year_id')->constrained()->cascadeOnDelete();
            $table->string('month_period', 20); // e.g. 'Juli 2026'
            $table->decimal('amount', 12, 2);
            $table->decimal('discount_amount', 12, 2)->default(0.00);
            $table->decimal('paid_amount', 12, 2)->default(0.00);
            $table->enum('status', ['UNPAID', 'PARTIAL', 'PAID', 'WAIVED'])->default('UNPAID');
            $table->date('due_date');
            $table->timestamps();
        });

        // 2. SPP Payments (Kasir Pembayaran & Kwitansi)
        Schema::create('spp_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spp_bill_id')->constrained()->cascadeOnDelete();
            $table->string('receipt_number', 50)->unique(); // e.g. 'KW-202608-001'
            $table->decimal('amount_paid', 12, 2);
            $table->enum('payment_method', ['CASH', 'TRANSFER_BANK', 'PAYMENT_GATEWAY', 'TABUNGAN'])->default('CASH');
            $table->foreignId('cashier_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamp('paid_at');
            $table->string('notes')->nullable();
            $table->timestamps();
        });

        // 3. Chart of Accounts (COA Akuntansi)
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('code', 30)->unique(); // e.g. '1001-KAS', '4001-SPP'
            $table->string('name');
            $table->enum('type', ['ASSET', 'LIABILITY', 'EQUITY', 'REVENUE', 'EXPENSE']);
            $table->decimal('current_balance', 15, 2)->default(0.00);
            $table->timestamps();
        });

        // 4. Journal Entries (Jurnal Otomatis Akuntansi)
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('account_id')->constrained('chart_of_accounts')->cascadeOnDelete();
            $table->string('reference_number', 50)->nullable();
            $table->string('description');
            $table->decimal('debit', 15, 2)->default(0.00);
            $table->decimal('credit', 15, 2)->default(0.00);
            $table->date('date');
            $table->timestamps();
        });

        // 5. Savings Transactions (Mutasi Tabungan Siswa)
        Schema::create('savings_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['DEPOSIT', 'WITHDRAWAL', 'TRANSFER_SPP'])->default('DEPOSIT');
            $table->decimal('amount', 12, 2);
            $table->decimal('balance_after', 12, 2);
            $table->string('description');
            $table->foreignId('teller_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->timestamps();
        });

        // 6. Canteen Outlets (Tenant Kantin Multi-Outlet)
        Schema::create('canteen_outlets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // e.g. 'Kantin Barokah Unit SD', 'Dapur Robbani'
            $table->string('owner_name');
            $table->string('phone')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(5.00); // 5% komisi
            $table->timestamps();
        });

        // 7. Canteen Products (Menu & Stok Kantin)
        Schema::create('canteen_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canteen_outlet_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('category', 30)->default('MAKANAN'); // MAKANAN, MINUMAN, SNACK
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(50);
            $table->string('image_url')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });

        // 8. Canteen Transactions (Checkout POS Cashless Tap RFID)
        Schema::create('canteen_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canteen_outlet_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number', 50)->unique();
            $table->decimal('total_amount', 10, 2);
            $table->string('rfid_tag_used', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canteen_transactions');
        Schema::dropIfExists('canteen_products');
        Schema::dropIfExists('canteen_outlets');
        Schema::dropIfExists('savings_transactions');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('chart_of_accounts');
        Schema::dropIfExists('spp_payments');
        Schema::dropIfExists('spp_bills');
    }
};
