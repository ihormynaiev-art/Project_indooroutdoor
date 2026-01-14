<?php

namespace App\Jobs;

use App\Enums\Sms\SmsTemplateEnum;
use App\Mail\RequestQuoteInformation;
use App\Models\RequestQuote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendQuoteNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public RequestQuote $requestQuote
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->requestQuote->load('provider.user');

        if (! $this->requestQuote->provider || ! $this->requestQuote->provider->user) {
            return;
        }

        // Send email to provider
        Mail::to($this->requestQuote->provider->user->email)
            ->send(new RequestQuoteInformation($this->requestQuote));

        // Send SMS if enabled
        if ($this->requestQuote->provider->isSmsEnabled()) {
            dispatch(new SendSmsJob(
                phone: $this->requestQuote->provider->phone,
                templateKey: SmsTemplateEnum::NEW_QUOTE->value,
                providerId: $this->requestQuote->provider_id
            ));
        }
    }
}
