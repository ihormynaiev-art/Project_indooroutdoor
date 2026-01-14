<?php

namespace App\Listeners;

use App\Mail\ContractorPageLive;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendContractorPageLiveNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Verified $event): void
    {
        $user = $event->user;

        // Only send the email if the user is a provider (contractor)
        if ($user->hasRole('provider') && $user->providerDetail) {
            Mail::to($user->email)->send(new ContractorPageLive($user));
        }
    }
}
