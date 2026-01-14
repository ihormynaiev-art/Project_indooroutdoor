<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property int id
 * @property string|null contact
 * @property string|null message
 * @property bool is_read
 * @property string|null comment
 * @property int|null user_id
 * @property string|null status
 * @property int|null provider_detail_id
 * @property-read null|User user
 * @property-read Collection|File[] images
 * @property-read ProviderDetail providerDetail
 **/
class ProviderMessage extends Model
{
    protected $fillable = [
        'contact',
        'message',
        'is_read',
        'comment',
        'user_id',
        'status',
        'provider_detail_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')
            ->where('type', 'image');
    }

    public function providerDetail(): BelongsTo
    {
        return $this->belongsTo(ProviderDetail::class);
    }
}
