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
        Schema::table('testimonials', function (Blueprint $table) {
            $table->renameColumn('name', 'nickname');
            $table->renameColumn('job_title', 'title');
            $table->renameColumn('content', 'review');
            $table->integer('rating');
            $table->boolean('would_recommend')->nullable();
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('review')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->renameColumn('nickname', 'name');
            $table->renameColumn('title', 'job_title');
            $table->renameColumn('review', 'content');
            $table->dropColumn(['rating', 'would_recommend']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('content')->nullable(false)->change();
        });
    }
};
