<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artisan_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('message_type'); // product_upload, price_update, order_notification, etc.
            $table->string('phone_number');
            $table->text('message_content');
            $table->enum('status', ['sent', 'delivered', 'read', 'failed'])->default('sent');
            $table->string('whatsapp_message_id')->nullable();
            $table->text('error_details')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();

            $table->foreign('artisan_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index('artisan_id');
            $table->index('status');
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_messages');
    }
};
