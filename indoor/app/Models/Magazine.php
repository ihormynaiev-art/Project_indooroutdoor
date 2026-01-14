<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Magazine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'prio',
        'is_active',
        'file_path',
    ];

    public function magazineImages(): HasMany
    {
        return $this->hasMany(MagazineImage::class);
    }
}
