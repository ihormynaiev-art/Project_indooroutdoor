<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    private $roles = [
        'admin',
        'super admin',
        'provider',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->roles as $role) {
            Role::findOrCreate($role);
        }

        foreach (User::all() as $user) {
            $user->assignRole('super admin');
        }
    }
}
