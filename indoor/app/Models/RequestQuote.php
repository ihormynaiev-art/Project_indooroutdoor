<?php

namespace App\Models;

use App\Enums\RequestQuote\RequestQuoteStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int id
 * @property int category_id
 * @property int sub_category_id
 * @property string full_name
 * @property string email
 * @property string city
 * @property string state
 * @property string zipcode
 * @property string details
 * @property string|null contact_number
 * @property int|null provider_id
 * @property bool processed
 * @property Carbon|null available_at
 * @property bool is_read
 * @property Carbon|null read_at
 * @property RequestQuoteStatusEnum|null status
 * @property string|null internal_note
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property-read Collection<File> documents
 * @property-read Category category
 * @property-read Category subCategory
 * @property-read ProviderDetail|null provider
 */
class RequestQuote extends Model
{
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'full_name',
        'email',
        'city',
        'state',
        'zipcode',
        'details',
        'contact_number',
        'provider_id',
        'processed',
        'available_at',
        'is_read',
        'read_at',
        'status',
        'internal_note',
    ];

    protected $casts = [
        'available_at' => 'datetime',
        'read_at' => 'datetime',
        'status' => RequestQuoteStatusEnum::class,
    ];

    public function documents(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(ProviderDetail::class);
    }

    /**
     * Scope to filter quotes that are available to the provider.
     */
    public function scopeAvailableToProvider($query)
    {
        return $query->where(function ($query) {
            $query->whereNull('available_at')
                ->orWhere('available_at', '<=', now());
        });
    }
}
