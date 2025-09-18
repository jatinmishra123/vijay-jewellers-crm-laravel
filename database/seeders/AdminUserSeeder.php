<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Find the Admin role
        $adminRole = Role::where('name', 'Admin')->first();

        if (!$adminRole) {
            $this->command->error('Admin role not found! Please run RbacSeeder first.');
            return;
        }

        // Check if admin user already exists
        $adminUser = User::where('email', 'admin@jewellery.com')->first();

        if ($adminUser) {
            // Update existing admin user
            $adminUser->update([
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]);
            $this->command->info('Existing admin user updated successfully!');
        } else {
            // Create new admin user
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@jewellery.com',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]);
            $this->command->info('New admin user created successfully!');
        }

        $this->command->info('Email: admin@jewellery.com');
        $this->command->info('Password: password');
    }
}