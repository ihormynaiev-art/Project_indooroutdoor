<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int provider_detail_id
 * @property Carbon viewed_at
 * @property string ip_address
 * @property string|null user_agent
 * @property bool has_notification_sent
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property-read ProviderDetail providerDetail
 */
class ProfileView extends Model
{
    protected $fillable = [
        'provider_detail_id',
        'viewed_at',
        'ip_address',
        'user_agent',
        'has_notification_sent',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
        'has_notification_sent' => 'boolean',
    ];

    public function providerDetail(): BelongsTo
    {
        return $this->belongsTo(ProviderDetail::class);
    }

    /**
     * Get views for current week
     */
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('viewed_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ]);
    }

    /**
     * Get views for last N days
     */
    public function scopeLastDays(Builder $query, int $days): Builder
    {
        return $query->where('viewed_at', '>=', now()->subDays($days));
    }

    /**
     * Get views for last 7 days (one week)
     */
    public function scopeLast7Days(Builder $query): Builder
    {
        return $query->lastDays(7);
    }

    /**
     * Get count of views for provider in last 7 days
     */
    public static function countViewsLast7Days(int $providerDetailId): int
    {
        return static::where('provider_detail_id', $providerDetailId)
            ->last7Days()
            ->count();
    }

    /**
     * Check if provider has enough views in last 7 days
     */
    public static function hasEnoughViewsLast7Days(int $providerDetailId, int $threshold = 5): bool
    {
        return static::countViewsLast7Days($providerDetailId) >= $threshold;
    }
}
