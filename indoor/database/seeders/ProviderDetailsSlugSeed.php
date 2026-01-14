<?php

namespace Database\Seeders;

use App\Models\ProviderDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProviderDetailsSlugSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProviderDetail::whereNull('slug')->whereNotNull('business_name')->each(function ($providerDetail) {
            $providerDetail->slug = Str::slug($providerDetail->business_name);
            $providerDetail->save();
        });
    }
}
