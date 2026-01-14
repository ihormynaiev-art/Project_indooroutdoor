<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_detail_id',
        'token',
        'expires_at',
    ];
}
