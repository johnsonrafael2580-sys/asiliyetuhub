<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('customer_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('customer_name');
                $table->string('customer_phone');
                $table->decimal('total_amount', 12, 2);
                $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
                
               
                $table->enum('payment_method', ['mobile_money', 'bank_transfer', 'card', 'other'])->default('mobile_money')->comment('Payment method used');
                $table->enum('escrow_status', ['awaiting_payment', 'escrowed', 'held_pending_delivery', 'released_to_fulfillment', 'released_to_artisan'])->default('awaiting_payment')->comment('Escrow account status');
                $table->decimal('platform_reserved_commission', 12, 2)->default(0)->comment('Total platform commission reserved from this order');
                $table->decimal('logistics_pool_amount', 12, 2)->default(0)->comment('Total logistics/shipping amount for this order');
                $table->timestamp('payment_received_at')->nullable()->comment('When payment was received in escrow');
                
                $table->timestamps();
                $table->index('status');
                $table->index('escrow_status');
            });
        }

       
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->foreignId('artisan_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->string('product_title');
                $table->decimal('price', 12, 2)->comment('Total price per item (base + shipping)');
                $table->integer('quantity')->default(1);
                $table->decimal('subtotal', 12, 2)->comment('price * quantity');
                
               
                $table->decimal('base_product_price', 12, 2)->default(0)->comment('Base product price per unit');
                $table->decimal('shipping_fee_per_item', 12, 2)->default(0)->comment('Shipping fee allocated to this item');
                $table->decimal('platform_commission', 12, 2)->default(0)->comment('10% platform commission from base price');
                $table->decimal('artisan_earnings', 12, 2)->default(0)->comment('90% of base product price (artisan net earnings)');
                
                
                $table->enum('payment_status', ['pending', 'escrowed', 'settled'])->default('pending')->comment('Payment settlement status');
                $table->timestamp('payment_settled_at')->nullable()->comment('When payment was settled to artisan');
                
                $table->timestamps();
                $table->index('order_id');
                $table->index('artisan_id');
                $table->index('payment_status');
            });
        }
    }

   
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
