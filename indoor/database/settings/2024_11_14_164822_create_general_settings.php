<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.edition_name', 'E-dition');
        $this->migrator->add('general.edition_code', '');
    }
};
