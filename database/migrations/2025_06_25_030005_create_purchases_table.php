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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wh_id')->references('id')->on('warehouses')->constrained();
            $table->foreignId('prod_id')->references('id')->on('products')->constrained();
            $table->decimal('price', 10, 2);
            $table->integer('qty')->default(0);
            $table->date('purchase_date');
            $table->timestamps();
        });
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('prf_number')->unique(); // Nomor PRF yang unik, misal: PRF/2025/07/001
            $table->foreignId('user_id')->constrained('users'); // Foreign key ke user yang meminta
            $table->date('request_date'); // Tanggal permintaan dibuat
            $table->text('purpose'); // Alasan atau tujuan pembelian
            $table->enum('status', ['pending', 'diterima', 'ditolak', 'diproses'])->default('pending'); // Status PRF
            $table->foreignId('approved_by')->nullable()->constrained('users'); // Siapa yang menyetujui
            $table->timestamp('approved_at')->nullable(); // Kapan disetujui
            $table->decimal('total_price', 15, 2)->nullable(); // Estimasi total harga
            $table->timestamps(); // created_at dan updated_at
        });
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            // Jika PRF dihapus, itemnya juga ikut terhapus
            $table->foreignId('purchase_request_id')->constrained('purchase_requests')->onDelete('cascade');
            $table->string('item_name');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity');
            $table->string('unit_of_measurement'); // Misal: pcs, kg, liter, box
            $table->decimal('estimated_price', 15, 2)->nullable(); // Estimasi harga satuan
            $table->timestamps();
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            // PO dibuat berdasarkan PRF yang sudah ada
            $table->foreignId('purchase_request_id')->constrained('purchase_requests');
            $table->string('po_number')->unique(); // Nomor PO yang unik, misal: PO/VENDOR/2025/001
            $table->foreignId('vendor_id')->constrained('suppliers'); // Foreign key ke tabel vendor
            $table->foreignId('user_id')->constrained('users'); // User dari dept. purchasing yang membuat PO
            $table->date('order_date'); // Tanggal PO dibuat
            $table->date('expected_delivery_date')->nullable(); // Perkiraan tanggal barang tiba
            $table->decimal('total_amount', 15, 2); // Total harga final dari vendor
            $table->text('terms_and_conditions')->nullable();
            $table->enum('status', ['pengajuan', 'diterima', 'dikirim', 'batal'])->default('pengajuan');
            $table->timestamps();
        });
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            // Jika PO dihapus, itemnya juga ikut terhapus
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->onDelete('cascade');
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
