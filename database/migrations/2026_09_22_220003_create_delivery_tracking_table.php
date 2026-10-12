<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('delivery_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fulfillment_id');
            $table->enum('event_type', ['pending', 'packaged', 'dispatched', 'in_transit', 'delivered', 'failed'])->default('pending');
            $table->text('description');
            $table->string('location')->nullable();
            $table->string('updated_by')->nullable(); 
            $table->timestamps();

            $table->foreign('fulfillment_id')->references('id')->on('fulfillments')->onDelete('cascade');
            $table->index('fulfillment_id');
            $table->index('event_type');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('delivery_tracking');
    }
};
