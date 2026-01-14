<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class MailSetting extends Settings
{
    public array $emails_for_new_registered;

    public static function group(): string
    {
        return 'mail';
    }
}
