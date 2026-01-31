<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. The Receipt Header
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained(); // Who sold it? (nullable for guest orders)
            $table->decimal('total_price', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->string('payment_method')->default('cash'); // cash, qr, card
            $table->timestamps();
        });

        // 2. The Items on the Receipt
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->integer('qty');
            $table->decimal('price', 10, 2); // Price at moment of sale
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
    }
};