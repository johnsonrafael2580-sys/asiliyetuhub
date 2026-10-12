<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('whatsapp_messages')) {
            return;
        }

       
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE whatsapp_messages MODIFY status VARCHAR(20) NOT NULL DEFAULT 'sent'");
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('whatsapp_messages')) {
            return;
        }

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::table('whatsapp_messages')->where('status', 'received')->update(['status' => 'sent']);
            DB::statement("ALTER TABLE whatsapp_messages MODIFY status ENUM('sent','delivered','read','failed') NOT NULL DEFAULT 'sent'");
        }
    }
};
