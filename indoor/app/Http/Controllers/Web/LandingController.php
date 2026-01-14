<?php

namespace App\Http\Controllers\Web;

use App\Contracts\HasReviewDate;
use App\Http\Controllers\Controller;
use App\Models\Landing;
use App\Models\ProviderDetail;
use Illuminate\View\View;

class LandingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(ProviderDetail $providerDetail, string $landingSlug): View
    {
        $landing = Landing::query()
            ->where('slug', $landingSlug)
            ->where('provider_detail_id', $providerDetail->id)
            ->firstOrFail();

        // Только админы могут видеть неопубликованные лендинги
        $isAdmin = auth()->check() && auth()->user()->hasRole(['admin', 'super admin']);
        if (! $landing->is_published && ! $isAdmin) {
            abort(404);
        }

        $landing->load([
            'heroImage',
            'offerImage',
            'portfolioImages',
            'providerDetail.logo',
            'providerDetail.background',
            'providerDetail.portfolioImages',
        ]);

        // Load reviews based on plan features
        if ($providerDetail->plan->canShowIndoorOutdoorReviews()) {
            $providerDetail->load(['testimonials' => fn ($q) => $q->orderByDesc('created_at')]);
        }

        if ($providerDetail->plan->canShowGoogleReviews()) {
            $providerDetail->load(['googleReviews' => fn ($q) => $q
                ->where('is_hide', false)
                ->orderByDesc('date')]);
        }

        if ($providerDetail->plan->canShowFacebookReviews()) {
            $providerDetail->load(['facebookReviews' => fn ($q) => $q
                ->where('is_hide', false)
                ->orderByDesc('reviewed_at')]);
        }

        // Merge and sort all reviews
        $reviews = collect()
            ->when($providerDetail->plan->canShowIndoorOutdoorReviews(), fn ($c) => $c->merge($providerDetail->testimonials))
            ->when($providerDetail->plan->canShowGoogleReviews(), fn ($c) => $c->merge($providerDetail->googleReviews))
            ->when($providerDetail->plan->canShowFacebookReviews(), fn ($c) => $c->merge($providerDetail->facebookReviews))
            ->sortByDesc(fn (HasReviewDate $review) => $review->getReviewDate())
            ->values();

        $averageRating = $providerDetail->countAvgRating();

        // Determine which portfolio images to use
        $portfolioImages = $landing->use_custom_portfolio
            ? $landing->portfolioImages
            : $providerDetail->portfolioImages;

        // Determine which description to use
        $description = $landing->use_custom_description && $landing->custom_description
            ? $landing->custom_description
            : $providerDetail->description;

        return view('landings.show', [
            'landing' => $landing,
            'providerDetail' => $providerDetail,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'portfolioImages' => $portfolioImages,
            'description' => $description,
        ]);
    }
}
