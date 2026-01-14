<?php

namespace App\Jobs;

use App\Models\RequestQuote;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdminRequestQuote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private RequestQuote $requestQuote) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::role(['admin', 'super admin'])->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new \App\Mail\RequestQuoteMessage(
                $this->requestQuote->id
            ));
        }

        Mail::to('jim@indooroutdoor.com')->send(new \App\Mail\RequestQuoteInformation(
            $this->requestQuote
        ));
    }
}
