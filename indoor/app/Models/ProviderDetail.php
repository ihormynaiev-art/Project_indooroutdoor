<?php

namespace App\Models;

use App\Traits\HasSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

/**
 * @property int id
 * @property string slug
 * @property string phone
 * @property string business_name
 * @property bool is_sms_enabled
 * @property int|null plan_id
 * @property string facebook_id
 * @property string facebook_token
 * @property string facebook_page_id
 * @property string facebook_page_token
 * @property string facebook_page_name
 * @property int google_reviews_count
 * @property string google_rating
 * @property Carbon|null google_last_request_at
 * @property Carbon|null facebook_last_request_at
 * @property-read User user
 * @property-read Plan|null plan
 * @property-read Collection<Testimonial> testimonials
 * @property-read Collection<Category> categories
 * @property-read Collection<File> certificates
 * @property-read Collection<GoogleReview> googleReviews
 * @property-read Collection<FacebookReview> facebookReviews
 * @property-read Collection<ProfileView> profileViews
 * @property-read Collection<SearchAppearance> searchAppearances
 * @property-read Landing|null landing
 */
class ProviderDetail extends Model
{
    use HasSlug;

    protected $fillable = [
        'business_name',
        'phone',
        'description',
        'user_id',
        'plan_id',
        'facebook_url',
        'x_url',
        'instagram_url',
        'youtube_url',
        'website_url',
        'slug',
        'google_place_id',
        'google_formatted_address',
        'google_last_request_at',
        'google_link',
        'google_reviews_count',
        'facebook_id',
        'facebook_token',
        'facebook_page_token',
        'facebook_page_name',
        'facebook_page_id',
        'facebook_token_expires_at',
        'facebook_last_request_at',
    ];

    protected $casts = [
        'google_last_request_at' => 'datetime',
        'facebook_last_request_at' => 'datetime',
    ];

    public function logo(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('type', 'logo');
    }

    public function background(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable')
            ->where('type', 'background');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function subCategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'provider_detail_sub_category')
            ->withPivot(['id', 'license_verified_at', 'license_expires_on']);
    }

    public function certificates(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')
            ->whereIn('type', ['certificate', 'insurance']);
    }

    public function certificatesSimple(): HasMany
    {
        return $this->hasMany(File::class)
            ->whereIn('type', ['certificate', 'insurance']);
    }

    public function portfolioImages(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')
            ->where('type', 'portfolio')
            ->orderBy('prio');
    }

    public function adImages(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')
            ->where('type', 'ad')
            ->orderBy('prio');
    }

    public function getLogoPathAttribute()
    {
        if ($this->logo) {
            return url('storage/'.$this->logo->path);
        }

        return asset('/assets/img/profiles/avatar-02.jpg');
    }

    public function getBackgroundPathAttribute()
    {
        if ($this->background) {
            return url('storage/'.$this->background->path);
        }

        return asset('/assets/img/bg/b.png');
    }

    public function googleReviews(): HasMany
    {
        return $this->hasMany(GoogleReview::class, 'place_id', 'google_place_id');
    }

    public function countAvgRating(): float
    {
        $googleCount = $this->google_reviews_count ?? 0;
        $googleRating = (float) $this->google_rating ?? 0;

        $testimonialsCount = $this->testimonials->count();
        $testimonialsSum = $this->testimonials->sum('rating');

        $facebookCount = $this->facebookReviews->count();
        $facebookSum = $this->facebookReviews->sum('rating');

        $totalRatings = ($googleRating * $googleCount) + $testimonialsSum + $facebookSum;
        $totalCount = $googleCount + $testimonialsCount + $facebookCount;

        return $totalCount > 0 ? round($totalRatings / $totalCount, 2) : 0;
    }

    /**
     * Get the user's first name.
     */
    protected function getShortWebsiteUrlAttribute()
    {
        return Str::of($this->website_url)->limit(30);
    }

    public function requestQuotes(): HasMany
    {
        return $this->hasMany(RequestQuote::class, 'provider_id');
    }

    public function facebookReviews(): HasMany
    {
        return $this->hasMany(FacebookReview::class);
    }

    public function profileViews(): HasMany
    {
        return $this->hasMany(ProfileView::class);
    }

    public function searchAppearances(): HasMany
    {
        return $this->hasMany(SearchAppearance::class);
    }

    public function landing(): HasOne
    {
        return $this->hasOne(Landing::class);
    }

    public function canFetchGoogleReviews(): bool
    {
        if (is_null($this->google_place_id)) {
            return false;
        }

        if (
            ! is_null($this->google_last_request_at) &&
            $this->google_last_request_at->gt(now()->subHour())
        ) {
            return false;
        }

        return true;
    }

    public function canFetchFacebookReviews(): bool
    {
        if (is_null($this->facebook_token)) {
            return false;
        }

        if (
            ! is_null($this->facebook_last_request_at) &&
            $this->facebook_last_request_at->gt(now()->subHour())
        ) {
            return false;
        }

        return true;
    }

    public function isSmsEnabled(): bool
    {
        return $this->is_sms_enabled && $this->phone;
    }

    public function isPremium(): bool
    {
        return $this->plan?->isPremium() ?? false;
    }

    public function isLite(): bool
    {
        return $this->plan?->isLite() ?? true;
    }

    public function getMaxPhotos(): int
    {
        return $this->plan?->getFeature('max_portfolio_photos', 3) ?? 3;
    }

    public function canShowMap(): bool
    {
        return $this->plan?->getFeature('show_map', false) ?? false;
    }

    public function canShowGoogleReviews(): bool
    {
        return $this->plan?->getReviewSetting('google', false) ?? false;
    }

    public function canShowFacebookReviews(): bool
    {
        return $this->plan?->getReviewSetting('facebook', false) ?? false;
    }

    public function canShowIndoorOutdoorReviews(): bool
    {
        return $this->plan?->getReviewSetting('indooroutdoor', false) ?? true;
    }

    public function hasContactButton(string $button): bool
    {
        return $this->plan?->getContactButton($button, false) ?? false;
    }

    public function hasAdButton(string $button): bool
    {
        return $this->plan?->getAdButton($button, false) ?? false;
    }

    public function getLeadDelayHours(): int
    {
        return $this->plan?->getLimit('lead_delay_hours', 0) ?? 0;
    }
}
