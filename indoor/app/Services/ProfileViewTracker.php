<?php

namespace App\Services;

use App\Models\ProfileView;
use App\Models\ProviderDetail;
use Illuminate\Http\Request;

/**
 * Service for tracking profile views
 *
 * Tracks when a provider profile is viewed and stores view information
 * (IP address, user agent, timestamp)
 */
class ProfileViewTracker
{
    /**
     * Track a profile view
     *
     * Creates a new profile view record if the same IP hasn't viewed
     * this profile today
     */
    public function track(ProviderDetail $provider, Request $request): void
    {
        $ipAddress = $request->ip();
        $userAgent = $request->header('User-Agent');

        if (! $ipAddress || ! $userAgent) {
            return;
        }

        $existingView = ProfileView::query()
            ->where('provider_detail_id', $provider->id)
            ->where('ip_address', $ipAddress)
            ->whereDate('viewed_at', today())
            ->exists();

        if ($existingView) {
            return;
        }

        ProfileView::query()->create([
            'provider_detail_id' => $provider->id,
            'viewed_at' => now(),
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'has_notification_sent' => false,
        ]);
    }
}
