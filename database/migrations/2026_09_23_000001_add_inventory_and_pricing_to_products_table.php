<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            
            $table->integer('stock_quantity')->default(0)->after('is_available')->comment('Number of items available in stock');
            
            
            $table->decimal('base_price', 12, 2)->nullable()->after('price')->comment('Base product price without shipping');
            $table->decimal('shipping_fee', 12, 2)->default(0)->after('base_price')->comment('Shipping/logistics cost');
           
            $table->text('story')->nullable()->after('description')->comment('Optional artisan story or provenance');
            
            
            $table->decimal('platform_commission_rate', 5, 2)->default(10)->after('shipping_fee')->comment('Platform commission percentage (default 10%)');
        });
    }

    
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['stock_quantity', 'base_price', 'shipping_fee', 'platform_commission_rate']);
        });
    }
};
