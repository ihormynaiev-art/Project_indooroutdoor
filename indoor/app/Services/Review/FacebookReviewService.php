<?php

namespace App\Services\Review;

use App\Models\FacebookReview;
use App\Models\ProviderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class FacebookReviewService implements ReviewInterface
{
    public function updateAll(): void
    {
        $providers = ProviderDetail::query()
            ->whereNotNull('facebook_page_id')
            ->whereNotNull('facebook_token')
            ->get();

        foreach ($providers as $provider) {
            $this->updateOne($provider);
        }
    }

    public function updateOne(ProviderDetail $provider): void
    {
        $response = Http::get("https://graph.facebook.com/{$provider->facebook_page_id}/ratings", [
            'fields' => 'review_text,recommendation_type,created_time,reviewer{name,picture},rating',
            'access_token' => $provider->facebook_page_token,
        ]);

        $reviews = $response->json('data', []);

        foreach ($reviews as $review) {
            FacebookReview::query()
                ->updateOrCreate(
                    ['review_id' => $review['id'] ?? null],
                    [
                        // TODO set review id from $review['id'] when app will published
                        'review_id' => $review['id'] ?? random_int(111, 999),
                        'provider_detail_id' => $provider->id,
                        'reviewer_name' => $review['reviewer']['name'] ?? null,
                        'review_text' => $review['review_text'] ?? null,
                        'rating' => $review['rating'] ?? null,
                        'recommendation_type' => $review['recommendation_type'] ?? null,
                        'reviewed_at' => Carbon::create($review['created_time'] ?? now()),
                    ]
                );
        }
    }
}
