<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        
        if (Schema::hasTable('users')) {
            if (!Schema::hasColumn('users', 'is_approved')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->boolean('is_approved')->default(true)->after('role');
                });
            }

            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY role ENUM('admin','artisan','customer','tourist') NOT NULL DEFAULT 'customer'");
            }

            
            DB::table('users')
                ->where('role', 'tourist')
                ->update(['role' => 'customer']);

            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY role ENUM('admin','artisan','customer') NOT NULL DEFAULT 'customer'");
            }
        }

        
        if (Schema::hasTable('product_requests') && !Schema::hasColumn('product_requests', 'order_id')) {
            Schema::table('product_requests', function (Blueprint $table) {
                $table->foreignId('order_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('orders')
                    ->nullOnDelete();
                $table->index('order_id');
            });
        }

       
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'customer_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('customer_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('users')
                    ->nullOnDelete();
                $table->index('customer_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('product_requests') && Schema::hasColumn('product_requests', 'order_id')) {
            Schema::table('product_requests', function (Blueprint $table) {
                $table->dropForeign(['order_id']);
                $table->dropIndex(['order_id']);
                $table->dropColumn('order_id');
            });
        }

        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'customer_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropForeign(['customer_id']);
                $table->dropIndex(['customer_id']);
                $table->dropColumn('customer_id');
            });
        }

        if (Schema::hasTable('users')) {
            if (DB::getDriverName() === 'mysql') {
                DB::statement("ALTER TABLE users MODIFY role ENUM('admin','artisan','customer','tourist') NOT NULL DEFAULT 'customer'");
                DB::table('users')->where('role', 'customer')->update(['role' => 'tourist']);
                DB::statement("ALTER TABLE users MODIFY role ENUM('admin','artisan','tourist') NOT NULL DEFAULT 'tourist'");
            }

            if (Schema::hasColumn('users', 'is_approved')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('is_approved');
                });
            }
        }
    }
};
