<?php

namespace App\Services;

use App\Models\SearchAppearance;
use Illuminate\Http\Request;

class SearchTrackingService
{
    /**
     * Track multiple search appearances at once
     *
     * Records each provider's appearance in search results with IP address.
     * Only tracks one appearance per IP per provider per day to avoid duplicates.
     */
    public function trackMultipleAppearances(array $providerDetailIds, ?Request $request = null): void
    {
        $ipAddress = $request?->ip();

        if (! $ipAddress || empty($providerDetailIds)) {
            return;
        }

        $now = now();
        $today = $now->startOfDay();

        // Check which providers have NOT been recorded for this IP today
        $existingAppearances = SearchAppearance::query()
            ->whereIn('provider_detail_id', $providerDetailIds)
            ->where('ip_address', $ipAddress)
            ->where('appeared_at', '>=', $today)
            ->pluck('provider_detail_id')
            ->toArray();

        // Filter out providers that already have an appearance today from this IP
        $newProviderIds = array_diff($providerDetailIds, $existingAppearances);

        if (empty($newProviderIds)) {
            return;
        }

        // Insert only new appearances
        $data = array_map(fn ($id) => [
            'provider_detail_id' => $id,
            'appeared_at' => $now,
            'ip_address' => $ipAddress,
        ], $newProviderIds);

        SearchAppearance::query()->insert($data);
    }
}
