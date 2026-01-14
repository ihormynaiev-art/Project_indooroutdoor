<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string phone
 * @property string message
 * @property int|null sms_template_id
 * @property string status
 * @property string error_message
 * @property Carbon|null sent_at
 * @property Carbon|null created_at
 * @property Carbon|null updated_at
 * @property-read SmsTemplate|null smsTemplate
 * @property-read ProviderDetail|null providerDetail
 */
class SmsMessage extends Model
{
    protected $fillable = [
        'phone',
        'message',
        'sms_template_id',
        'provider_detail_id',
        'status',
        'error_message',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function smsTemplate(): BelongsTo
    {
        return $this->belongsTo(SmsTemplate::class);
    }

    public function providerDetail(): BelongsTo
    {
        return $this->belongsTo(ProviderDetail::class);
    }
}
