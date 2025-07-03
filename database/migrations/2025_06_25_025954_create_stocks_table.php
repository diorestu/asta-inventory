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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prod_id')->references('id')->on('products')->constrained();
            $table->integer('quantity');
            // $table->enum('type', ['in', 'out', 'adjustment', 'transfer']);
            $table->string('reference')->nullable(); // No PO, DO, dll
            $table->integer('qty_stock_in')->unsigned()->default(0);
            $table->integer('qty_stock_out')->unsigned()->default(0);
            $table->integer('qty_stock_adj')->unsigned()->default(0);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
