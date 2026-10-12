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

            DB::statement("ALTER TABLE users MODIFY role ENUM('admin','artisan','customer','tourist') NOT NULL DEFAULT 'customer'");
        }

        
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'payment_status')) {
                    $table->enum('payment_status', ['pending', 'verification_pending', 'paid', 'rejected'])->default('pending')->after('payment_method');
                }
                if (!Schema::hasColumn('orders', 'payment_verified_at')) {
                    $table->timestamp('payment_verified_at')->nullable()->after('payment_received_at');
                }
                if (!Schema::hasColumn('orders', 'payment_verified_by')) {
                    $table->foreignId('payment_verified_by')->nullable()->after('payment_verified_at')->constrained('users')->nullOnDelete();
                }
            });
        }

        
        if (Schema::hasTable('order_items') && !Schema::hasColumn('order_items', 'fulfillment_status')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->string('fulfillment_status')->default('pending')->after('payment_settled_at');
                $table->index('fulfillment_status');
            });
        }

       
        if (Schema::hasTable('product_requests')) {
            Schema::table('product_requests', function (Blueprint $table) {
                if (!Schema::hasColumn('product_requests', 'order_id')) {
                    $table->foreignId('order_id')->nullable()->after('id')->constrained('orders')->nullOnDelete();
                }
                if (!Schema::hasColumn('product_requests', 'order_item_id')) {
                    $table->foreignId('order_item_id')->nullable()->after('order_id')->constrained('order_items')->nullOnDelete();
                }
                $table->index(['order_id', 'order_item_id']);
            });
        }

        
        if (!Schema::hasTable('order_payments')) {
            Schema::create('order_payments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
                $table->string('agent_key');
                $table->string('agent_name');
                $table->string('payment_method')->default('mobile_money');
                $table->decimal('amount', 12, 2);
                $table->string('sender_phone', 50);
                $table->string('transaction_id', 120);
                $table->string('proof_path')->nullable();
                $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
                $table->text('rejection_reason')->nullable();
                $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamp('submitted_at')->nullable();
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();
                $table->index(['status', 'order_id']);
                $table->unique('transaction_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_payments');

        if (Schema::hasTable('product_requests')) {
            Schema::table('product_requests', function (Blueprint $table) {
                if (Schema::hasColumn('product_requests', 'order_item_id')) {
                    $table->dropForeign(['order_item_id']);
                    $table->dropColumn('order_item_id');
                }
                if (Schema::hasColumn('product_requests', 'order_id')) {
                    $table->dropForeign(['order_id']);
                    $table->dropColumn('order_id');
                }
            });
        }

        if (Schema::hasTable('order_items') && Schema::hasColumn('order_items', 'fulfillment_status')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropIndex(['fulfillment_status']);
                $table->dropColumn('fulfillment_status');
            });
        }

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'payment_verified_by')) {
                    $table->dropForeign(['payment_verified_by']);
                    $table->dropColumn('payment_verified_by');
                }
                if (Schema::hasColumn('orders', 'payment_verified_at')) {
                    $table->dropColumn('payment_verified_at');
                }
                if (Schema::hasColumn('orders', 'payment_status')) {
                    $table->dropColumn('payment_status');
                }
            });
        }
    }
};
