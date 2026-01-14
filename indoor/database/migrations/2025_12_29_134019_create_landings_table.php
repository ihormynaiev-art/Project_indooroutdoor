<?php

use App\Models\ProviderDetail;
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
        Schema::create('landings', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->text('custom_description')
                ->nullable();
            $table->boolean('is_published')
                ->default(false);
            $table->boolean('use_custom_description')
                ->default(false);
            $table->boolean('use_custom_portfolio')
                ->default(false);
            $table->foreignIdFor(ProviderDetail::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landings');
    }
};
