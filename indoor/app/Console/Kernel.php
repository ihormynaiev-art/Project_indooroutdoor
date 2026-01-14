<?php

namespace App\Console;

use App\Jobs\CheckAndNotifyHighProfileViews;
use App\Jobs\FetchFacebookReviews;
use App\Jobs\FetchGoogleReviews;
use App\Jobs\SendWeeklySearchAppearanceSummary;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->job(new FetchGoogleReviews)->daily();
        $schedule->job(new FetchFacebookReviews)->daily();
        $schedule->job(new CheckAndNotifyHighProfileViews)->daily();
        $schedule->job(new SendWeeklySearchAppearanceSummary)->weekly();
        $schedule->command('sitemap:generate')->daily();
        $schedule->command('contractors:send-verification-reminders')->weeklyOn([2, 5], '12:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
