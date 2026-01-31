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
        Schema::table('sales', function (Blueprint $table) {
            $table->string('order_number')->unique()->nullable()->after('id');
            $table->string('customer_name')->nullable()->after('user_id');
            $table->string('customer_email')->nullable()->after('customer_name');
            $table->string('customer_phone', 20)->nullable()->after('customer_email');
            $table->text('shipping_address')->nullable()->after('customer_phone');
            $table->string('city', 100)->nullable()->after('shipping_address');
            $table->string('postal_code', 20)->nullable()->after('city');
            $table->text('notes')->nullable()->after('postal_code');
            $table->decimal('subtotal', 10, 2)->default(0)->after('notes');
            $table->decimal('shipping', 10, 2)->default(0)->after('tax');
            $table->decimal('total', 10, 2)->default(0)->after('shipping');
            $table->string('status', 50)->default('pending')->after('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn([
                'order_number',
                'customer_name',
                'customer_email',
                'customer_phone',
                'shipping_address',
                'city',
                'postal_code',
                'notes',
                'subtotal',
                'shipping',
                'total',
                'status'
            ]);
        });
    }
};
