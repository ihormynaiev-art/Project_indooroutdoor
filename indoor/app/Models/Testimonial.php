<?php

namespace App\Models;

use App\Contracts\HasReviewDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Testimonial extends Model implements HasReviewDate
{
    use HasFactory;

    protected $fillable = [
        'provider_detail_id',
        'nickname',
        'title',
        'review',
        'is_active',
        'rating',
        'would_recommend',
        'email',
    ];

    protected $appends = ['image_path'];

    public function images(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable')->where('type', 'image');
    }

    public function videos(): MorphMany
    {
        return $this->MorphMany(File::class, 'fileable')->where('type', 'video');
    }

    public function providerDetail(): BelongsTo
    {
        return $this->belongsTo(ProviderDetail::class);
    }

    public function getImagePathAttribute()
    {
        if ($this->image) {
            return url('storage/'.$this->image->path);
        }

        return asset('/assets/img/profiles/avatar-02.jpg');
    }

    public function getReviewDate(): Carbon
    {
        return $this->created_at;
    }
}
