<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property string code
 * @property int plan_id
 * @property bool is_used
 * @property int|null used_by
 * @property Carbon|null used_at
 * @property int|null created_by
 * @property Carbon|null expires_at
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property-read Plan plan
 * @property-read ProviderDetail|null usedByProvider
 * @property-read User|null createdByUser
 */
class InviteCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'plan_id',
        'is_used',
        'used_by',
        'used_at',
        'created_by',
        'expires_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function usedByProvider(): BelongsTo
    {
        return $this->belongsTo(ProviderDetail::class, 'used_by');
    }

    public function createdByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isValid(): bool
    {
        if ($this->is_used) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function markAsUsed(ProviderDetail $providerDetail): void
    {
        $this->update([
            'is_used' => true,
            'used_by' => $providerDetail->id,
            'used_at' => now(),
        ]);
    }

    public function scopeValid($query)
    {
        return $query->where('is_used', false)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeUsed($query)
    {
        return $query->where('is_used', true);
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now())
            ->where('is_used', false);
    }
}
