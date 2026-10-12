<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artisan_id'); 
            $table->unsignedBigInteger('order_id')->nullable(); 
            $table->unsignedBigInteger('product_id');
            $table->decimal('order_amount', 12, 2); 
            $table->decimal('commission_rate', 5, 2)->default(10); 
            $table->decimal('commission_amount', 12, 2); 
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->timestamp('completed_at')->nullable(); 
            $table->timestamps();

            $table->foreign('artisan_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index('artisan_id');
            $table->index('status');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('commissions');
    }
};
