<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            ['name' => 'View Users', 'slug' => 'view_users', 'group_name' => 'Users'],
            ['name' => 'Create Users', 'slug' => 'create_users', 'group_name' => 'Users'],
            ['name' => 'Delete Users', 'slug' => 'delete_users', 'group_name' => 'Users'],

            ['name' => 'Manage Companies', 'slug' => 'manage_companies', 'group_name' => 'Companies'],
            ['name' => 'Approve Companies', 'slug' => 'approve_companies', 'group_name' => 'Companies'],

            ['name' => 'View Logs', 'slug' => 'view_logs', 'group_name' => 'System'],
            ['name' => 'Manage Backups', 'slug' => 'manage_backups', 'group_name' => 'System'],

            ['name' => 'Manage Tickets', 'slug' => 'manage_tickets', 'group_name' => 'Support'],
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['slug' => $perm['slug']], $perm);
        }

        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Administrator', 'description' => 'Full System Access']
        );

        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions);
    }
}