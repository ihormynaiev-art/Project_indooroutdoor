<?php

use App\Models\ProfileView;
use App\Models\ProviderDetail;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Migrate views count from provider_details.views to profile_views table
     */
    public function up(): void
    {
        $providers = ProviderDetail::query()->where('views', '>', 0)->get();

        foreach ($providers as $provider) {
            for ($i = 0; $i < $provider->views; $i++) {
                ProfileView::query()->create([
                    'provider_detail_id' => $provider->id,
                    'viewed_at' => now()->subDays(rand(0, 30)),
                    'ip_address' => fake()->ipv4(),
                    'user_agent' => fake()->userAgent(),
                    'has_notification_sent' => false,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        ProfileView::query()->truncate();
    }
};
