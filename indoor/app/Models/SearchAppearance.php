<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int provider_detail_id
 * @property Carbon appeared_at
 * @property string|null ip_address
 * @property-read ProviderDetail providerDetail
 */
class SearchAppearance extends Model
{
    protected $fillable = [
        'provider_detail_id',
        'appeared_at',
        'ip_address',
    ];

    protected $casts = [
        'appeared_at' => 'datetime',
    ];

    public function providerDetail(): BelongsTo
    {
        return $this->belongsTo(ProviderDetail::class);
    }

    /**
     * Get appearances for last 7 days
     */
    public function scopeLast7Days(Builder $query): Builder
    {
        return $query->where('appeared_at', '>=', now()->subDays(7));
    }

    /**
     * Get count of appearances for provider in last 7 days
     */
    public static function countAppearancesLast7Days(int $providerDetailId): int
    {
        return static::where('provider_detail_id', $providerDetailId)
            ->last7Days()
            ->count();
    }
}
