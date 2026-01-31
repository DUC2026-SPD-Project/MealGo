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
    Schema::create('stock_transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained();
        $table->foreignId('user_id')->constrained(); // Who changed the stock?
        $table->string('type'); // 'in', 'out', 'broken', 'transfer'
        $table->integer('qty'); // How many?
        $table->text('note')->nullable(); // e.g., "Arrived from Supplier"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
