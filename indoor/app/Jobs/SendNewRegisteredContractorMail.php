<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewRegisteredContractorMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $user) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $toEmails = app(\App\Settings\MailSetting::class)->emails_for_new_registered;
        Mail::to($toEmails)->send(new \App\Mail\NewContractorRegistered(
            $this->user
        ));
    }
}
