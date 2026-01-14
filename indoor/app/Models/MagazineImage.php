<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MagazineImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'magazine_id',
        'path',
        'is_active',
        'url',
    ];

    public function magazine(): BelongsTo
    {
        return $this->belongsTo(Magazine::class);
    }
}
