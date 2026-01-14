<?php

namespace App\Jobs;

use App\Enums\Sms\SmsTemplateEnum;
use App\Models\ProviderDetail;
use App\Services\SearchAppearanceSummaryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWeeklySearchAppearanceSummary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ?ProviderDetail $provider;

    public function __construct(?ProviderDetail $provider = null)
    {
        $this->provider = $provider;
    }

    public function handle(SearchAppearanceSummaryService $summaryService): void
    {
        if ($this->provider) {
            // Send summary for a specific provider
            $this->sendSummaryForProvider($this->provider, $summaryService);
        } else {
            // Send summary for all providers (scheduler)
            $providers = ProviderDetail::query()
                ->where('is_sms_enabled', true)
                ->whereNotNull('phone')
                ->get();

            foreach ($providers as $provider) {
                $this->sendSummaryForProvider($provider, $summaryService);
            }
        }
    }

    private function sendSummaryForProvider(ProviderDetail $provider, SearchAppearanceSummaryService $summaryService): void
    {
        $summary = $summaryService->getWeeklySummary($provider);

        if ($summary['search_appearances'] > 0 || $summary['profile_views'] > 0) {
            SendSmsJob::dispatch(
                $provider->phone,
                SmsTemplateEnum::WEEKLY_SUMMARY->value,
                $summary,
                'weekly_summary',
                $provider->id
            );

            Log::channel('sms')->info('Queued weekly summary SMS', [
                'provider_id' => $provider->id,
                'phone' => $provider->phone,
            ]);
        }
    }
}
