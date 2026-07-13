<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permission = Permission::firstOrCreate(['name' => 'create player notes']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo($permission);
        Role::firstOrCreate(['name' => 'viewer']);

        User::firstOrCreate(['email' => 'admin@demo.test'], ['name' => 'Admin Demo', 'password' => bcrypt('password')])->assignRole('admin');
        User::firstOrCreate(['email' => 'viewer@demo.test'], ['name' => 'Viewer Demo', 'password' => bcrypt('password')])->assignRole('viewer');
        User::firstOrCreate(['email' => 'agent@demo.test'], ['name' => 'AI Agent', 'password' => bcrypt('password')])->givePermissionTo($permission);
    }
}
