<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property int id
 * @property string slug
 * @property string title
 * @property string|null custom_description
 * @property bool is_published
 * @property bool use_custom_description
 * @property bool use_custom_portfolio
 * @property int provider_detail_id
 * @property-read ProviderDetail providerDetail
 */
class Landing extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'custom_description',
        'is_published',
        'use_custom_description',
        'use_custom_portfolio',
        'provider_detail_id',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'use_custom_description' => 'boolean',
        'use_custom_portfolio' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::deleting(function (Landing $landing) {
            // Delete all related images (hero, offer, portfolio)
            $landing->heroImage?->delete();
            $landing->offerImage?->delete();
            $landing->portfolioImages()->delete();
        });
    }

    /**
     * Get the provider detail that owns the landing.
     */
    public function providerDetail(): BelongsTo
    {
        return $this->belongsTo(ProviderDetail::class);
    }

    /**
     * Get the hero image for the landing.
     */
    public function heroImage(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('type', 'hero_image');
    }

    /**
     * Get the offer image for the landing.
     */
    public function offerImage(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('type', 'offer_image');
    }

    /**
     * Get the portfolio images for the landing.
     */
    public function portfolioImages(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')
            ->where('type', 'portfolio')
            ->orderBy('prio');
    }
}
