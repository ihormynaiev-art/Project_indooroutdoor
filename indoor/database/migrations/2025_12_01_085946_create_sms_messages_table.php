<?php

use App\Models\ProviderDetail;
use App\Models\SmsTemplate;
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
        Schema::create('sms_messages', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->text('message');
            $table->foreignIdFor(SmsTemplate::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->foreignIdFor(ProviderDetail::class)
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('status');
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_messages');
    }
};
