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
        // CHANGE THIS LINE: It must say 'products', not 'categories'
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Foreign Keys
            // Note: We use nullable() for supplier in case you delete a supplier later
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');

            // Product Details
            $table->string('name_en');            // English Name
            $table->string('name_kh')->nullable(); // Khmer Name
            $table->string('barcode')->unique();
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->default(0);
            $table->integer('qty')->default(0);
            $table->integer('alert_qty')->default(5);
            $table->string('image')->nullable();
            $table->string('status')->default('active');
            $table->text('description')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};