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
        Schema::create('request_quotes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('cascade');
            $table->foreignId('sub_category_id')
                ->constrained('categories')
                ->onDelete('cascade');
            $table->string('full_name');
            $table->string('email');
            $table->string('contact_number')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zipcode');
            $table->text('details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_quotes');
    }
};
