<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('mail.emails_for_new_registered', []);
    }

    public function down(): void
    {
        $this->migrator->delete('mail.emails_for_new_registered');
    }
};
