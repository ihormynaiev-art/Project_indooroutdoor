<?php

namespace App\Jobs;

use App\Models\ProviderDetail;
use App\Services\Review\FacebookReviewService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchFacebookReviewsByProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected ProviderDetail $providerDetail
    ) {}

    /**
     * @throws Exception
     */
    public function handle(FacebookReviewService $reviewsService): void
    {
        $reviewsService->updateOne($this->providerDetail);
    }
}
