<?php

namespace App\Services;

use App\Models\ProfileView;
use App\Models\ProviderDetail;
use App\Models\SearchAppearance;

class SearchAppearanceSummaryService
{
    /**
     * Get weekly summary for a provider
     */
    public function getWeeklySummary(ProviderDetail $provider): array
    {
        $searchAppearances = SearchAppearance::query()
            ->where('provider_detail_id', $provider->id)
            ->last7Days()
            ->count();

        $profileViews = ProfileView::query()
            ->where('provider_detail_id', $provider->id)
            ->last7Days()
            ->count();

        return [
            'business_name' => $provider->business_name,
            'search_appearances' => $searchAppearances,
            'profile_views' => $profileViews,
            'week_date' => now()->subWeek()->format('M d').' - '.now()->format('M d, Y'),
        ];
    }
}
