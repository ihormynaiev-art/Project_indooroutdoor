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
        Schema::create('magazine_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('magazine_id');
            $table->string('path');
            $table->boolean('is_active')->default(true);
            $table->foreign('magazine_id')
                ->references('id')
                ->on('magazines')
                ->onDelete('cascade');
            $table->string('url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magazine_images');
    }
};
