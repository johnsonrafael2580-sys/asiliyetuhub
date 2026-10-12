<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'story')) {
            Schema::table('products', function (Blueprint $table) {
                $table->text('story')->nullable()->after('description')->comment('Artisan story or provenance');
            });
        }
    }

   
    public function down(): void
    {
        if (Schema::hasColumn('products', 'story')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('story');
            });
        }
    }
};
