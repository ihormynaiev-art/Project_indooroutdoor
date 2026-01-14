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
            $table->string('google_rating')->nullable();
            $table->timestamp('google_last_request_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_details', function (Blueprint $table) {
            $table->dropColumn('google_rating');
            $table->dropColumn('google_last_request_at');
        });
    }
};
