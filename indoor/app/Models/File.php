<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'type',
        'status',
        'fileable_id',
        'fileable_type',
        'prio',
    ];

    protected static function booted(): void
    {
        static::deleting(function (File $file) {
            if ($file->path && Storage::disk('public')->exists($file->path)) {
                Storage::disk('public')->delete($file->path);
            }
        });
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        if ($this->path) {
            return url('storage/'.$this->path);
        }

        return url()->asset('/assets/img/profiles/avatar-02.jpg');
    }

    public function getIconSrcAttribute()
    {
        return URL::asset('/assets/img/icons/'.$this->type.'.png');
    }
}
