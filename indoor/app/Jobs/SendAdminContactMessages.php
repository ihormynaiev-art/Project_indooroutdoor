<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdminContactMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $message, private $name, private $email) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = User::role(['admin', 'super admin'])->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new \App\Mail\ContactMessage(
                $this->message,
                $this->name,
                $this->email
            ));
        }
    }
}
