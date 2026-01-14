<?php

namespace App\Models;

use App\Contracts\HasReviewDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GoogleReview extends Model implements HasReviewDate
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime',
    ];

    protected $fillable = [
        'author_name',
        'rating',
        'date',
        'text',
        'place_id',
        'is_hide',
    ];

    public function providerDetail(): BelongsTo
    {
        return $this->belongsTo(ProviderDetail::class, 'place_id', 'google_place_id');
    }

    public function getReviewDate(): Carbon
    {
        return $this->date;
    }
}
