<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RbacSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'permissions' => [
                    'manage_users' => true,
                    'manage_roles' => true,
                    'view_all_customers' => true,
                    'view_all_schemes' => true,
                    'manage_coupons' => true,
                    'view_reports' => true,
                    'delete_records' => true,
                    'modify_records' => true,
                ]
            ],
            [
                'name' => 'Manager',
                'permissions' => [
                    'view_all_customers' => true,
                    'view_all_schemes' => true,
                    'approve_coupons' => true,
                    'approve_schemes' => true,
                    'view_reports' => true,
                ]
            ],
            [
                'name' => 'Executive',
                'permissions' => [
                    'add_customers' => true,
                    'view_own_customers' => true,
                    'generate_tokens' => true,
                ]
            ],
            [
                'name' => 'Accounts',
                'permissions' => [
                    'view_schemes' => true,
                    'view_payments' => true,
                    'view_invoices' => true,
                ]
            ],
            [
                'name' => 'Marketing',
                'permissions' => [
                    'send_promotions' => true,
                    'send_lucky_draws' => true,
                ]
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->command->info('Roles seeded successfully!');
    }
}