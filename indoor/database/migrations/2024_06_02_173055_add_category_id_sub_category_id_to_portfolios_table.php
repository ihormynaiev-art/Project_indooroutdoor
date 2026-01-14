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
//        \App\Models\Portfolio::truncate();
        Schema::table('portfolios', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('cascade');
            $table->foreignId('sub_category_id')
                ->constrained('categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolios', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['sub_category_id']);
            $table->dropColumn(['category_id', 'sub_category_id']);
        });
    }
};
