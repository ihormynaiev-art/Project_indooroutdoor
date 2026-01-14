<?php

use App\Models\Plan;
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
        Schema::create('invite_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')
                ->unique();
            $table->foreignIdFor(Plan::class)
                ->constrained()
                ->onDelete('cascade');
            $table->boolean('is_used')
                ->default(false);
            $table->foreignIdFor(ProviderDetail::class, 'used_by')
                ->nullable()
                ->constrained('provider_details')
                ->onDelete('set null');
            $table->timestamp('used_at')
                ->nullable();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            $table->timestamp('expires_at')
                ->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invite_codes');
    }
};
