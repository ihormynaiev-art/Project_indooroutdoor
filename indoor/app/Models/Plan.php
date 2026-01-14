<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int id
 * @property string name
 * @property string display_name
 * @property array config
 * @property bool is_active
 * @property int sort_order
 */
class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'config',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    public function providerDetails(): HasMany
    {
        return $this->hasMany(ProviderDetail::class);
    }

    public function getFeature(string $key, mixed $default = null): mixed
    {
        return data_get($this->config, "features.{$key}", $default);
    }

    public function getReviewSetting(string $key, mixed $default = null): mixed
    {
        return data_get($this->config, "reviews.{$key}", $default);
    }

    public function getContactButton(string $key, mixed $default = null): mixed
    {
        return data_get($this->config, "contact_buttons.{$key}", $default);
    }

    public function getAdButton(string $key, mixed $default = null): mixed
    {
        return data_get($this->config, "ad_buttons.{$key}", $default);
    }

    public function getLimit(string $key, mixed $default = null): mixed
    {
        return data_get($this->config, "limits.{$key}", $default);
    }

    public function getAdminSetting(string $key, mixed $default = null): mixed
    {
        return data_get($this->config, "admin.{$key}", $default);
    }

    public function canShowIndoorOutdoorReviews(): bool
    {
        return $this->getReviewSetting('indooroutdoor', false);
    }

    public function canShowGoogleReviews(): bool
    {
        return $this->getReviewSetting('google', false);
    }

    public function canShowFacebookReviews(): bool
    {
        return $this->getReviewSetting('facebook', false);
    }

    public function canShowReviews(): bool
    {
        return $this->canShowFacebookReviews() || $this->canShowIndoorOutdoorReviews() || $this->canShowGoogleReviews();
    }

    public function hasContactButton(string $button): bool
    {
        return $this->getContactButton($button, false);
    }

    public function isLite(): bool
    {
        return $this->name === 'lite';
    }

    public function isPremium(): bool
    {
        return $this->name === 'premium';
    }

    public function canUploadBackground(): bool
    {
        return $this->getFeature('can_upload_background', false);
    }

    public function hasLanding(): bool
    {
        return $this->getFeature('landing', false);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
