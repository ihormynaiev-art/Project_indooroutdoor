<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->delete('general.image_path');
        $this->migrator->add('general.image_paths', []);
    }

    public function down(): void
    {
        $this->migrator->add('general.image_path');
        $this->migrator->delete('general.image_paths');
    }
};
