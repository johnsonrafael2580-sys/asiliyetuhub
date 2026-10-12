<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'is_approved')) {
            \Illuminate\Support\Facades\DB::table('users')->update(['is_approved' => true]);
        }

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            if (Schema::hasColumn('orders', 'payment_status')) {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('pending','processing','paid','failed','verification_pending','rejected') NOT NULL DEFAULT 'pending'");
            }
            if (Schema::hasColumn('order_payments', 'status')) {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE order_payments MODIFY status ENUM('pending','verified','rejected','failed') NOT NULL DEFAULT 'pending'");
            }
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'payment_status')) {
                    $table->enum('payment_status', ['pending', 'processing', 'paid', 'failed', 'verification_pending', 'rejected'])
                        ->default('pending')
                        ->after('customer_email');
                }
                if (!Schema::hasColumn('orders', 'customer_note')) {
                    $table->text('customer_note')->nullable()->after('customer_email');
                }
                if (!Schema::hasColumn('orders', 'delivery_location')) {
                    $table->string('delivery_location')->nullable()->after('customer_note');
                }
            });
        }

        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (!Schema::hasColumn('order_items', 'product_description')) {
                    $table->text('product_description')->nullable()->after('product_title');
                }
            });
        }

        if (Schema::hasTable('order_payments')) {
            Schema::table('order_payments', function (Blueprint $table) {
                if (!Schema::hasColumn('order_payments', 'checkout_request_id')) {
                    $table->string('checkout_request_id', 160)->nullable()->after('transaction_id')->index();
                }
                if (!Schema::hasColumn('order_payments', 'provider_transaction_id')) {
                    $table->string('provider_transaction_id', 160)->nullable()->after('checkout_request_id')->index();
                }
                if (!Schema::hasColumn('order_payments', 'provider_status')) {
                    $table->string('provider_status', 80)->nullable()->after('status');
                }
                if (!Schema::hasColumn('order_payments', 'provider_response')) {
                    $table->json('provider_response')->nullable()->after('provider_status');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('order_payments')) {
            Schema::table('order_payments', function (Blueprint $table) {
                foreach (['checkout_request_id', 'provider_transaction_id', 'provider_status', 'provider_response'] as $column) {
                    if (Schema::hasColumn('order_payments', $column)) {
                        if (in_array($column, ['checkout_request_id', 'provider_transaction_id'], true)) {
                            $table->dropIndex([$column]);
                        }
                        $table->dropColumn($column);
                    }
                }
            });
        }

        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (Schema::hasColumn('order_items', 'product_description')) $table->dropColumn('product_description');
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'delivery_location')) $table->dropColumn('delivery_location');
                if (Schema::hasColumn('orders', 'customer_note')) $table->dropColumn('customer_note');
            });
        }
    }
};
