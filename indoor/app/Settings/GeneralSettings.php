<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $edition_name;

    public string $edition_code;

    public array $image_paths;

    public static function group(): string
    {
        return 'general';
    }

    public function addImage(string $path): self
    {
        if (! in_array($path, $this->image_paths)) {
            $this->image_paths[] = $path;
        }

        return $this;
    }

    public function removeImage(string $path): self
    {
        $this->image_paths = array_filter($this->image_paths, function ($existing) use ($path) {
            return $existing !== $path;
        });

        return $this;
    }
}
