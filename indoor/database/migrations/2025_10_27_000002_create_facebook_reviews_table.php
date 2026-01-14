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
        Schema::create('facebook_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProviderDetail::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('review_id')->unique();
            $table->string('reviewer_name')->nullable();
            $table->text('review_text')->nullable();
            $table->integer('rating')->nullable();
            $table->string('recommendation_type')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->boolean('is_hide')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_reviews');
    }
};
