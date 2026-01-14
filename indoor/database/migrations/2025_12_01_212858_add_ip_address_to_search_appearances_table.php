<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('search_appearances', function (Blueprint $table) {
            $table->string('ip_address')->nullable()->after('appeared_at');
            $table->index(['provider_detail_id', 'ip_address']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('search_appearances', function (Blueprint $table) {
            $table->dropIndex(['provider_detail_id', 'ip_address']);
            $table->dropColumn('ip_address');
        });
    }
};
