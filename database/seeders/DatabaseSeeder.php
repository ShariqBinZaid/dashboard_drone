<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use App\Models\Briefs;
use App\Models\Orders;
use App\Models\Clients;
use App\Models\Modules;
use App\Models\Packages;
use App\Models\UserRole;
use App\Models\UserType;
use App\Models\Categories;
use App\Models\Permission;
use App\Models\UserInType;
use App\Models\RolePermission;
use App\Models\Subscriptions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Categories::create([
            'name' => 'Cinemetography',
        ]);
        Categories::create([
            'name' => 'Tricks',
        ]);

        Subscriptions::create([
            'image' => 'profileimage/test.png',
            'name' => '1 Year',
            'price' => '100',
            'desc' => 'Test 1',
        ]);
        Subscriptions::create([
            'image' => 'profileimage/test.png',
            'name' => '2 Year',
            'price' => '100',
            'desc' => 'Test 2',
        ]);

        User::create([
            'display_picture' => 'profileimage/test.png',
            'category_id' => '1',
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'gender' => 'male',
            'phone' => '1234567890',
            'file' => 'profileimage/test.png',
            'dob' => '2023-08-23',
            'email' => 'admin@test.com',
            // 'country' => 'Dubai',
            // 'address' => 'Emirates',
            // 'desc' => 'Admin',
            'is_active' => '1',
            'password' => Hash::make('123456'),
            'user_type' => 'admin'
        ]);
        User::create([
            'display_picture' => 'profileimage/test.png',
            'category_id' => '2',
            'first_name' => 'User',
            'last_name' => 'User',
            'gender' => 'male',
            'phone' => '123456789',
            'file' => 'profileimage/test.png',
            'dob' => '2023-08-23',
            'email' => 'user@test.com',
            // 'country' => 'United State',
            // 'address' => 'California',
            // 'desc' => 'Admin',
            'is_active' => '1',
            'password' => Hash::make('123456'),
            'user_type' => 'user'
        ]);

        // Clients::create([
        //     'image' => 'profileimage/test.png',
        //     'first_name' => 'Client 2',
        //     'last_name' => 'Testing 2',
        //     'country' => 'California',
        //     'email' => 'client2@test.com',
        //     'password' => Hash::make('123456'),
        // ]);


        $modules = ['Users', 'Roles', 'Clients', 'Modules'];
        foreach ($modules as  $module) {
            Modules::create([
                'name' => $module,
            ]);
        }

        Role::create([
            'role_name' => 'Super Admin',
        ]);
        Role::create([
            'role_name' => 'Admin',
        ]);
        Permission::create([
            'permission_name' => 'Modules.view',
            'module_id' => 4,
        ]);
        Permission::create([
            'permission_name' => 'Modules.create',
            'module_id' => 4,
        ]);
        Permission::create([
            'permission_name' => 'Modules.update',
            'module_id' => 4,
        ]);
        Permission::create([
            'permission_name' => 'Users.view',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Users.create',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Users.update',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Users.delete',
            'module_id' => 1,
        ]);
        Permission::create([
            'permission_name' => 'Roles.view',
            'module_id' => 2,
        ]);
        Permission::create([
            'permission_name' => 'Roles.create',
            'module_id' => 2,
        ]);
        Permission::create([
            'permission_name' => 'Roles.update',
            'module_id' => 2,
        ]);
        Permission::create([
            'permission_name' => 'Clients.view',
            'module_id' => 3,
        ]);

        $rolePermissions = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
        foreach ($rolePermissions as  $rolePermission) {
            RolePermission::create([
                'role_id' => 1,
                'permission_id' => $rolePermission,
            ]);
        }

        UserRole::create([
            'user_id' => 1,
            'role_id' => 1,
        ]);

        $UserTypes = ['Super Admin', 'System User', 'User', 'Moderator'];
        foreach ($UserTypes as  $UserType) {
            UserType::create([
                'name' => $UserType,
            ]);
        }

        UserInType::create([
            'user_id' => 1,
            'user_type' => 1,
        ]);

        UserInType::create([
            'user_id' => 1,
            'user_type' => 2,
        ]);
    }
}
