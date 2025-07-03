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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fromwh_id')->references('id')->on('warehouses')->constrained();
            $table->foreignId('towh_id')->references('id')->on('warehouses')->constrained();
            $table->foreignId('prod_id')->references('id')->on('products')->constrained();
            $table->integer('quantity');
            // $table->enum('type', ['in', 'out', 'adjustment', 'transfer']);
            $table->string('reference')->nullable(); // No PO, DO, dll
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
