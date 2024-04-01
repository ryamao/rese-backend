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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole = $this->createAdminRole();
        $this->createOwnerRole();
        $this->createCustomerRole();

        $admin = User::create([
            'name' => 'Administrator',
            'email' => env('ADMIN_EMAIL', 'admin@example.com'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
        ]);
        $admin->markEmailAsVerified();

        $admin->assignRole($adminRole);

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    private function createAdminRole(): Role
    {
        $role = Role::create(['name' => 'admin']);

        $names = [
            'create owners',
            'send notification email',
        ];

        foreach ($names as $name) {
            $permission = Permission::findOrCreate($name);
            $role->givePermissionTo($permission);
        }

        return $role;
    }

    private function createOwnerRole(): Role
    {
        $role = Role::create(['name' => 'owner']);

        $names = [
            'view shops for owners',
            'create shops',
            'edit shops',
            'view reservations for owners',
            'edit reservations',
            'create reservations',
            'delete reservations',
            'create billings',
        ];

        foreach ($names as $name) {
            $permission = Permission::findOrCreate($name);
            $role->givePermissionTo($permission);
        }

        return $role;
    }

    private function createCustomerRole(): Role
    {
        $role = Role::create(['name' => 'customer']);

        $names = [
            'view customer infomation',
            'view favorites for customers',
            'add to favorites',
            'remove from favorites',
            'view reservations for customers',
            'edit reservations',
            'create reservations',
            'delete reservations',
            'create payments',
        ];

        foreach ($names as $name) {
            $permission = Permission::findOrCreate($name);
            $role->givePermissionTo($permission);
        }

        return $role;
    }
}
