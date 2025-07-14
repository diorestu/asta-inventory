<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('prf_number')->unique(); // Nomor PRF yang unik, misal: PRF/2025/07/001
            $table->foreignId('user_id')->constrained('users'); // Foreign key ke user yang meminta
            $table->date('request_date'); // Tanggal permintaan dibuat
            $table->text('purpose'); // Alasan atau tujuan pembelian
            $table->enum('status', ['pending', 'partially_ordered', 'fully_ordered', 'rejected'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users'); // Siapa yang menyetujui
            $table->timestamp('approved_at')->nullable(); // Kapan disetujui
            $table->decimal('total_price', 15, 2)->nullable(); // Estimasi total harga
            $table->timestamps(); // created_at dan updated_at
        });
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            // Jika PRF dihapus, itemnya juga ikut terhapus
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->nullable();
            $table->string('item_id')->nullable();
            $table->string('name');
            $table->unsignedInteger('qty');
            $table->string('satuan'); // Misal: pcs, kg, liter, box
            $table->decimal('est_price', 15, 2)->nullable(); // Estimasi harga satuan
            $table->decimal('subtotal', 15, 2)->nullable(); // Estimasi total harga
            $table->enum('status', ['pending', 'ordered'])->default('pending');
            $table->timestamps();
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique(); // Nomor PO yang unik, misal: PO/VENDOR/2025/001
            $table->foreignId('vendor_id')->constrained('suppliers'); // Foreign key ke tabel vendor
            $table->foreignId('user_id')->constrained('users'); // User dari dept. purchasing yang membuat PO
            $table->date('order_date'); // Tanggal PO dibuat
            $table->date('expected_delivery_date')->nullable(); // Perkiraan tanggal barang tiba
            $table->decimal('total_amount', 15, 2); // Total harga final dari vendor
            $table->text('terms_and_conditions')->nullable();
            $table->string('pay_method')->nullable();
            $table->integer('pay_termin')->nullable();
            $table->enum('status', ['pengajuan', 'diterima', 'dikirim', 'batal'])->default('pengajuan');
            $table->timestamps();
        });
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            // Jika PO dihapus, itemnya juga ikut terhapus
            $table->foreignId('purchase_order_id')->constrained('purchase_orders');
            $table->foreignId('purchase_request_item_id')->constrained();
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->unsignedInteger('qty');
            $table->string('satuan');
            $table->decimal('price', 15, 2); // Harga satuan final dari vendor
            $table->decimal('subtotal', 15, 2); // Harga satuan final dari vendor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
