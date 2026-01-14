<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->slug = $model->generateUniqueSlug($model->business_name);
        });

        static::updating(function ($model) {
            if ($model->isDirty('business_name')) {
                $model->slug = $model->generateUniqueSlug($model->business_name);
            }
        });
    }

    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->where('id', '!=', $this->id)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
