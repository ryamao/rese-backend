<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $createOwnersPermission = \Spatie\Permission\Models\Permission::create(['name' => 'create owners']);
        $adminRole = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo($createOwnersPermission);

        $admin = User::create([
            'name' => 'Administrator',
            'email' => env('ADMIN_EMAIL', 'test@example.com'),
            'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
        ]);
        $admin->markEmailAsVerified();
        $admin->assignRole($adminRole);
    }
}
