<?php

namespace App\Console\Commands;

use App\Mail\ConfirmContractorPageReminder;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendContractorVerificationReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contractors:send-verification-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email verification reminders to contractors who have not verified their email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all providers (contractors) who haven't verified their email
        $unverifiedContractors = User::role('provider')
            ->where('is_verified', false)
            ->get();

        $count = 0;
        foreach ($unverifiedContractors as $contractor) {
            Mail::to($contractor->email)->send(new ConfirmContractorPageReminder($contractor));
            $count++;
        }

        $this->info("Sent {$count} verification reminder emails to unverified contractors.");

        return Command::SUCCESS;
    }
}
