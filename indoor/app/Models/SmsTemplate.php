<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string key
 * @property string keys
 * @property string label
 * @property string message
 * @property string|null description
 * @property bool is_enabled
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class SmsTemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'keys',
        'label',
        'message',
        'description',
        'is_enabled',
    ];
}
