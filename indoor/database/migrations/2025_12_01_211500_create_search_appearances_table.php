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
        Schema::create('search_appearances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ProviderDetail::class)
                ->constrained()->cascadeOnDelete();
            $table->timestamp('appeared_at');

            $table->index(['provider_detail_id', 'appeared_at']);
            $table->index('appeared_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_appearances');
    }
};
