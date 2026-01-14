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
        Schema::table('provider_details', function (Blueprint $table) {
            $table->string('facebook_id')->nullable();
            $table->string('facebook_token', 500)->nullable();
            $table->string('facebook_page_token', 500)->nullable();
            $table->string('facebook_page_name')->nullable();
            $table->string('facebook_page_id')->nullable();
            $table->timestamp('facebook_token_expires_at')->nullable();
            $table->timestamp('facebook_last_request_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_details', function (Blueprint $table) {
            $table->dropColumn('facebook_id');
            $table->dropColumn('facebook_token');
            $table->dropColumn('facebook_page_token');
            $table->dropColumn('facebook_page_name');
            $table->dropColumn('facebook_page_id');
            $table->dropColumn('facebook_token_expires_at');
            $table->dropColumn('facebook_last_request_at');
        });
    }
};
