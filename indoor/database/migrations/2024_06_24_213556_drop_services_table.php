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
        Schema::dropIfExists('services');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_active')->default(true);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('cascade');
            $table->foreignId('sub_category_id')
                ->constrained('categories')
                ->onDelete('cascade');
        });
    }
};
