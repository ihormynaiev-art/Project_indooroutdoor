<?php

namespace App\Jobs;

use App\Services\Review\GoogleReviewsService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchGoogleReviews implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @throws Exception
     */
    public function handle(GoogleReviewsService $reviewsService): void
    {
        $reviewsService->updateAll();
    }
}
