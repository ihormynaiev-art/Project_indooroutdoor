<?php

namespace App\Models;

use App\Contracts\HasReviewDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int provider_detail_id
 * @property null|Carbon reviewed_at
 */
class FacebookReview extends Model implements HasReviewDate
{
    protected $fillable = [
        'provider_detail_id',
        'review_id',
        'reviewer_name',
        'review_text',
        'rating',
        'recommendation_type',
        'reviewed_at',
        'is_hide',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function getReviewDate(): Carbon
    {
        return $this->reviewed_at;
    }
}
