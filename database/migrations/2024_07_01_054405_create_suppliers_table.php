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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama perusahaan supplier
            $table->string('contact_person')->nullable(); // Nama narahubung
            $table->string('email')->unique()->nullable(); // Alamat email supplier
            $table->string('phone_number')->nullable(); // Nomor telepon
            $table->text('address'); // Alamat lengkap supplier
            $table->string('city')->nullable(); // Kota
            $table->string('country')->nullable();
            $table->string('tax_id')->unique()->nullable(); // NPWP supplier, jika ada
            $table->string('payment_method')->nullable(); // Syarat pembayaran, misal: "Net 30", "COD"
            $table->integer('payment_terms')->nullable(); // Jumlah hari
            $table->string('account_number')->nullable(); // Nomor rekening
            $table->string('account_name')->nullable(); // Nama akun rekening
            $table->string('bank_name')->nullable(); // Nama bank   
            $table->boolean('is_active')->default(true); // Status untuk menonaktifkan supplier tanpa menghapus
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
