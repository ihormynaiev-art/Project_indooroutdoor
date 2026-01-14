<?php

namespace App\Jobs;

use App\Enums\Sms\SmsTemplateEnum;
use App\Models\ProfileView;
use App\Models\ProviderDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Check for providers with high profile views in last 7 days
 * and send SMS notifications if threshold is exceeded
 */
class CheckAndNotifyHighProfileViews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const VIEWS_THRESHOLD = 5;

    public function handle(): void
    {
        $providers = ProviderDetail::query()
            ->where('is_sms_enabled', true)
            ->whereNotNull('phone')
            ->whereHas('profileViews', function ($query) {
                $query->last7Days()
                    ->where('has_notification_sent', false);
            })
            ->withCount(['profileViews' => function ($query) {
                $query->last7Days();
            }])
            ->get();

        foreach ($providers as $provider) {
            if ($provider->profile_views_count >= self::VIEWS_THRESHOLD) {
                $this->notifyProvider($provider, $provider->profile_views_count);
            }
        }
    }

    private function notifyProvider(ProviderDetail $provider, int $viewsCount): void
    {
        dispatch(new SendSmsJob(
            $provider->phone,
            SmsTemplateEnum::PROFILE_VIEWS_THRESHOLD->value,
            ['views_count' => $viewsCount],
            source: 'system',
            providerId: $provider->id,
        ));

        ProfileView::query()
            ->where('provider_detail_id', $provider->id)
            ->last7Days()
            ->update(['has_notification_sent' => true]);

        Log::channel('sms')->info('SMS notification sent for high profile views', [
            'provider_id' => $provider->id,
            'views_count' => $viewsCount,
        ]);
    }
}
