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
            $table->integer('views')->default(0);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->integer('selections')->default(0);
        });
    }

    public function down()
    {
        Schema::table('provider_details', function (Blueprint $table) {
            $table->dropColumn('views');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('selections');
        });
    }
};
