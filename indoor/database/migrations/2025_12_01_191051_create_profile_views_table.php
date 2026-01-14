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
        Schema::create('profile_views', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ProviderDetail::class)->constrained()->cascadeOnDelete();
            $table->timestamp('viewed_at');
            $table->string('ip_address');
            $table->text('user_agent')->nullable();
            $table->boolean('has_notification_sent')->default(false);
            $table->timestamps();

            $table->index(['provider_detail_id', 'viewed_at']);
            $table->index(['ip_address', 'provider_detail_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_views');
    }
};
