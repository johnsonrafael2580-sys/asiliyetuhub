<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::table('product_requests', function (Blueprint $table) {
           
            $table->string('delivery_location')->nullable()->after('status'); 
            $table->string('delivery_note')->nullable()->after('delivery_location');
            $table->string('tourist_phone')->nullable()->after('delivery_note');
            $table->string('tourist_email')->nullable()->after('tourist_phone');
           
            $table->text('cancellation_reason')->nullable()->after('status');
        });
    }

   
    public function down(): void
    {
        Schema::table('product_requests', function (Blueprint $table) {
            $table->dropColumn(['delivery_location', 'delivery_note', 'tourist_phone', 'tourist_email', 'cancellation_reason']);
        });
    }
};
