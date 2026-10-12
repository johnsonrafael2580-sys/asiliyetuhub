<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('product_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('product_requests', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('product_requests', 'customer_phone')) {
                $table->string('customer_phone')->nullable()->after('customer_name');
            }

            if (!Schema::hasColumn('product_requests', 'customer_email')) {
                $table->string('customer_email')->nullable()->after('customer_phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('product_requests', function (Blueprint $table) {
            if (Schema::hasColumn('product_requests', 'customer_email')) {
                $table->dropColumn('customer_email');
            }

            if (Schema::hasColumn('product_requests', 'customer_phone')) {
                $table->dropColumn('customer_phone');
            }

            if (Schema::hasColumn('product_requests', 'customer_name')) {
                $table->dropColumn('customer_name');
            }
        });
    }
};
