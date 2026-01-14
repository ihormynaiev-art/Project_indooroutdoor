<?php

namespace App\Services\Review;

use App\Models\ProviderDetail;
use App\Services\GooglePlacesApi;
use Exception;

class GoogleReviewsService implements ReviewInterface
{
    public function __construct(
        protected GooglePlacesApi $googleApiService
    ) {}

    /**
     * @throws Exception
     */
    public function updateAll(): void
    {
        $providers = ProviderDetail::query()
            ->whereNotNull('google_place_id')
            ->get();

        foreach ($providers as $provider) {
            $this->updateOne($provider);
        }
    }

    /**
     * @throws Exception
     */
    public function updateOne(ProviderDetail $provider): void
    {
        $placeData = $this->googleApiService->placeDetailsRelevantReviews($provider->google_place_id);

        foreach ($placeData['result']['reviews'] ?? [] as $review) {
            $provider->googleReviews()->firstOrCreate(
                [
                    'author_name' => $review['author_name'],
                    'date' => date('Y-m-d H:i:s', $review['time']),
                ],
                [
                    'rating' => $review['rating'],
                    'text' => $review['text'],
                ]
            );
        }

        $placeData = $this->googleApiService->placeDetailsNewestReviews($provider->google_place_id);

        foreach ($placeData['result']['reviews'] ?? [] as $review) {
            $provider->googleReviews()->firstOrCreate(
                [
                    'author_name' => $review['author_name'],
                    'date' => date('Y-m-d H:i:s', $review['time']),
                ],
                [
                    'rating' => $review['rating'],
                    'text' => $review['text'],
                ]
            );
        }

        ProviderDetail::query()
            ->where('id', $provider->id)
            ->update([
                'google_rating' => $placeData['result']['rating'] ?? null,
                'google_link' => $placeData['result']['url'] ?? null,
                'google_reviews_count' => $placeData['result']['user_ratings_total'] ?? null,
            ]);
    }
}
