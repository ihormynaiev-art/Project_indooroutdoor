<?php

use App\Models\ProviderDetail;
use App\Models\User;
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
        Schema::create('provider_messages', function (Blueprint $table) {
            $table->id();
            $table->string('contact');
            $table->text('message');
            $table->boolean('is_read')
                ->default(false);
            $table->text('comment')
                ->nullable();
            $table->string('status')
                ->nullable();
            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
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
        Schema::dropIfExists('provider_messages');
    }
};
