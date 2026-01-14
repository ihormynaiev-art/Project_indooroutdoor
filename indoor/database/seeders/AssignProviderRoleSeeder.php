<?php

namespace Database\Seeders;

use App\Models\ProviderDetail;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignProviderRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure 'provider' role exists
        Role::findOrCreate('provider');

        // Get all ProviderDetails with their users
        $providerDetails = ProviderDetail::with('user')->get();

        $assignedCount = 0;

        foreach ($providerDetails as $providerDetail) {
            if ($providerDetail->user && !$providerDetail->user->hasRole('provider')) {
                $providerDetail->user->assignRole('provider');
                $assignedCount++;
            }
        }

        $this->command->info("Assigned 'provider' role to {$assignedCount} users.");
    }
}
