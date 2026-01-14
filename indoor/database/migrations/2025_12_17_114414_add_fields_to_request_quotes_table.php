<?php

use App\Enums\RequestQuote\RequestQuoteStatusEnum;
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
        Schema::table('request_quotes', function (Blueprint $table) {
            $table->string('status')
                ->default(RequestQuoteStatusEnum::NEW->value);
            $table->text('internal_note')->nullable();
            $table->boolean('is_read')
                ->default(false);
            $table->timestamp('read_at')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_quotes', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('internal_note');
            $table->dropColumn('is_read');
            $table->dropColumn('read_at');
        });
    }
};
