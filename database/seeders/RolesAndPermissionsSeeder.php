<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions for posts module
        Permission::create(['name' => 'posts.list']);
        Permission::create(['name' => 'posts.add']);
        Permission::create(['name' => 'posts.edit']);
        Permission::create(['name' => 'posts.delete']);

        // Create roles
        $editorRole = Role::create(['name' => 'editor']);
        $viewerRole = Role::create(['name' => 'viewer']);

        // Assign permissions to roles
        $editorRole->givePermissionTo(['posts.edit', 'posts.delete']);
        $viewerRole->givePermissionTo(['posts.list', 'posts.add']);

        // Create users
        $editor = User::create([
            'name' => 'Editor User',
            'email' => 'editor@example.com',
            'password' => bcrypt('password'),
        ]);

        $viewer = User::create([
            'name' => 'Viewer User',
            'email' => 'viewer@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign roles to users
        $editor->assignRole('editor');
        $viewer->assignRole('viewer');
    }
} 