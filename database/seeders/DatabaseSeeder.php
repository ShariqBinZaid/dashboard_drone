<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use App\Models\Briefs;
use App\Models\Clients;
use App\Models\Modules;
use App\Models\Orders;
use App\Models\Packages;
use App\Models\UserRole;
use App\Models\UserType;
use App\Models\Permission;
use App\Models\UserInType;
use App\Models\RolePermission;
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

        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@test.com',
            'phone' => '123456',
            'password' => Hash::make('123456'),
            'display_picture' => 'profileimage/test.png',
            'user_type' => 'admin'
        ]);
        User::create([
            'first_name' => 'User',
            'last_name' => 'User',
            'email' => 'user@test.com',
            'phone' => '123456',
            'password' => Hash::make('123456'),
            'display_picture' => 'profileimage/test.png',
            'user_type' => 'user'
        ]);

        Packages::create([
            'name' => 'Packages 1',
            'desc' => 'Testing',
            'regular_price' => '100',
            'sale_price' => '50',
        ]);
        Packages::create([
            'name' => 'Packages 2',
            'desc' => 'Testing',
            'regular_price' => '80',
            'sale_price' => '40',
        ]);
        Packages::create([
            'name' => 'Packages 3',
            'desc' => 'Testing',
            'regular_price' => '60',
            'sale_price' => '30',
        ]);

        Clients::create([
            'image' => 'profileimage/test.png',
            'first_name' => 'Client 1',
            'last_name' => 'Testing 1',
            'email' => 'client1@test.com',
            'country' => 'California',
            'password' => Hash::make('123456'),
        ]);
        Clients::create([
            'image' => 'profileimage/test.png',
            'first_name' => 'Client 2',
            'last_name' => 'Testing 2',
            'country' => 'California',
            'email' => 'client2@test.com',
            'password' => Hash::make('123456'),
        ]);

        Orders::create([
            'package_id' => '1',
            'client_id' => '1',
            'amount' => '100',
            'payment_status' => 'unpaid',
            'status' => 'unpaid',
        ]);
        Orders::create([
            'package_id' => '2',
            'client_id' => '2',
            'amount' => '80',
            'payment_status' => 'paid',
            'status' => 'paid',
        ]);

        Briefs::create([
            'order_id' => '1',
            'name' => 'Client 1',
            'email' => 'client1@test.com',
            'country' => 'California',
            'file' => 'Testing 1',
            'color_theme' => 'Yellow',
            'business_type' => 'Blog',
        ]);
        Briefs::create([
            'order_id' => '2',
            'name' => 'Client 2',
            'email' => 'client2@test.com',
            'country' => 'California',
            'file' => 'Testing 2',
            'color_theme' => 'Blue',
            'business_type' => 'E-Commerce',
        ]);

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

        // $packages = [[
        //     'name' => 'Packages 1',
        //     'no_of_session' => '1 Session',
        //     'total_time' => '30',
        //     'session_time' => '30 Minute',
        //     'price' => '10',
        // ], [
        //     'name' => 'Packages 2',
        //     'no_of_session' => '2 Session',
        //     'total_time' => '60',
        //     'session_time' => '30 Minute',
        //     'price' => '20',
        // ]];
        // Packages::insert($packages);
    }
}
