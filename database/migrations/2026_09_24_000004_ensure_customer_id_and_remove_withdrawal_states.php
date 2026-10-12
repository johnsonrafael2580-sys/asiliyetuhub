<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'customer_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('customer_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
                $table->index('customer_id');
            });
        }

        if (Schema::hasTable('order_items') && Schema::hasColumn('order_items', 'payment_status')) {
            DB::statement("ALTER TABLE order_items MODIFY payment_status ENUM('pending','escrowed','settled') NOT NULL DEFAULT 'pending'");
        }

        if (Schema::hasTable('commissions')) {
            if (Schema::hasColumn('commissions', 'withdrawn_at')) {
                Schema::table('commissions', function (Blueprint $table) {
                    $table->dropColumn('withdrawn_at');
                });
            }
            if (Schema::hasColumn('commissions', 'status')) {
                DB::statement("ALTER TABLE commissions MODIFY status ENUM('pending','completed') NOT NULL DEFAULT 'pending'");
            }
        }
    }

    public function down(): void
    {
        
    }
};
