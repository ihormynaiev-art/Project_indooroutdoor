<?php

namespace App\Console\Commands;

use App\Jobs\SendWeeklySearchAppearanceSummary;
use App\Models\ProviderDetail;
use Illuminate\Console\Command;

class SendSearchAppearanceSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:send-summary {provider_id : The ID of the provider to send summary to}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Send weekly search appearance and profile views summary to a specific provider';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $providerId = $this->argument('provider_id');

        $provider = ProviderDetail::query()->find($providerId);

        if (! $provider) {
            $this->error("Provider with ID {$providerId} not found");

            return self::FAILURE;
        }

        if (! $provider->phone) {
            $this->error("Provider {$provider->business_name} does not have a phone number");

            return self::FAILURE;
        }

        $this->info("Sending summary to provider: {$provider->business_name}");

        dispatch(new SendWeeklySearchAppearanceSummary($provider));

        $this->info('✓ Job dispatched to queue');

        return self::SUCCESS;
    }
}
