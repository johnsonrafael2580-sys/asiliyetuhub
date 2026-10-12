<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('whatsapp_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artisan_id')->unique();
            $table->string('whatsapp_number'); 
            $table->boolean('whatsapp_enabled')->default(true);
            $table->boolean('receive_product_alerts')->default(true);
            $table->enum('upload_method', ['whatsapp', 'ussd', 'web', 'manager'])->default('whatsapp');
            $table->string('whatsapp_group_link')->nullable();
            $table->timestamps();

            $table->foreign('artisan_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('whatsapp_enabled');
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_settings');
    }
};
