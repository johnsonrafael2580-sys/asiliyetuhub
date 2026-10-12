<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('fulfillments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_request_id');
            $table->unsignedBigInteger('artisan_id');
            $table->enum('status', ['pending', 'packaged', 'dispatched', 'in_transit', 'delivered', 'failed'])->default('pending');
            $table->string('tracking_number')->nullable();
            $table->string('courier_partner')->nullable(); 
            $table->text('packaging_notes')->nullable();
            $table->string('pickup_location')->nullable();
            $table->string('delivery_location')->nullable(); 
            $table->text('special_instructions')->nullable();
            $table->timestamp('packaged_at')->nullable();
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->foreign('product_request_id')->references('id')->on('product_requests')->onDelete('cascade');
            $table->foreign('artisan_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('status');
            $table->index('tracking_number');
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('fulfillments');
    }
};
