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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->index('cart_items_customer_id');
            $table->foreignId('product_id')->constrained()->onUpdate('cascade')->onDelete('cascade')->index('cart_items_product_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('status');
            $table->timestamps();

            $table->unique(['customer_id', 'product_id'], 'cart_items_customer_product_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
