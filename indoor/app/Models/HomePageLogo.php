<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class HomePageLogo extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'is_active',
        'prio',
    ];

    public function file(): MorphOne
    {
        return $this->morphOne(File::class, 'fileable');
    }
}
