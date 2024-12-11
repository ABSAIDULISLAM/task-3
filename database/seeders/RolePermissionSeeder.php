<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define permission groups and associated permissions
        $permissionGroups = [
            'dashboard' => ['dashboard','normal-view'],
            'Sales Management' => ['sales-list', 'sales-create', 'sales-edit', 'sales-view', 'sales-delete','sales-status', 'payment-view', 'add-payment'],
            'Customer Management' => ['customer-list', 'customer-create', 'customer-edit', 'customer-view', 'customer-delete','customer-status','add-customer-document','delete-customer-document'],
            'Advocate Management' => ['advocate-list', 'advocate-create', 'advocate-edit', 'advocate-view', 'advocate-delete','advocate-status'],
            'Agent Management' => ['agent-list', 'agent-create', 'agent-edit', 'agent-view', 'agent-delete','agent-status'],
            'Service Category Management' => ['service-category-list', 'service-category-create', 'service-category-edit', 'service-category-delete','service-category-status'],
            'Service Management' => ['service-list', 'service-create', 'service-edit', 'service-delete','service-status'],
            'Expense Category Management' => ['expense-category-list', 'expense-category-create', 'expense-category-edit', 'expense-category-delete','expense-category-status'],
            'Expense Management' => ['expense-list', 'expense-create', 'expense-edit', 'expense-view', 'expense-delete','expense-status','all-expense'],
            'Appointment Management' => ['appointment-list', 'appointment-create', 'appointment-edit', 'appointment-view', 'appointment-delete','appointment-status'],
            'Report' => ['indivisual-report', 'profit-loss'],
            'User Management' => ['user-list', 'user-create', 'user-edit', 'user-view', 'user-delete','user-status'],
            'Notice Management' => ['notice-list', 'notice-create', 'notice-edit', 'notice-view', 'notice-delete','notice-status'],
            'Company Management' => ['company-list', 'company-create', 'company-edit', 'company-delete','company-status'],
            'Role Management' => ['role-list', 'role-create', 'role-edit', 'role-delete','role-status'],
            'Permission Management' => ['permission-list', 'permission-create', 'permission-edit','permission-delete','permission-status'],
        ];

        // Create or update permissions
        foreach ($permissionGroups as $groupName => $permissions) {
            foreach ($permissions as $permission) {
                Permission::firstOrCreate(
                    ['name' => $permission],
                    ['group_name' => $groupName]
                );
            }
        }

        // Create or update the Admin role and assign all permissions to it
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->syncPermissions(Permission::all());

        // Create a default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Ensure no duplicate email
            [
                'name' => 'Admin',
                'mobile' => '01700000001',
                'password' => Hash::make('password'),
                'status' => 1, // 1 == active
                'Role' => 'Admin', // 1 == active
            ]
        );

        // Assign the Admin role to the newly created user
        $admin->assignRole($adminRole);

        // Directly assign all permissions to the admin user
        $admin->syncPermissions(Permission::all());
    }



}
