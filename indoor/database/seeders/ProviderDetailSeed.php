<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProviderDetailSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::role('provider')->get();
        foreach ($users as $user) {
            $user->providerDetail()->create();
        }
    }
}
