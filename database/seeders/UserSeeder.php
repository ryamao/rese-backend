<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createOwnersPermission = Permission::create(['name' => 'create owners']);
        $createShopsPermission = Permission::create(['name' => 'create shops']);

        $adminRole = Role::create(['name' => 'admin']);
        $ownerRole = Role::create(['name' => 'owner']);

        $admin = User::create([
            'name' => 'Administrator',
            'email' => env('ADMIN_EMAIL', 'test@example.com'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
        ]);
        $admin->markEmailAsVerified();

        $adminRole->givePermissionTo($createOwnersPermission);
        $ownerRole->givePermissionTo($createShopsPermission);

        $admin->assignRole($adminRole);
    }
}
