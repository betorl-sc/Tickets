<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions
        $this->call(RolePermissionSeeder::class);

        // Create Admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Create Technician user
        $technician = User::factory()->create([
            'name' => 'Technician User',
            'email' => 'technician@example.com',
            'password' => Hash::make('password'),
        ]);
        $technician->assignRole('technician');

        // Create Client user
        $client = User::factory()->create([
            'name' => 'Alberto Ronceros Lévano',
            'email' => 'alberto.ronceros@gmail.com',
            'password' => Hash::make('password'),
        ]);
        $client->assignRole('client');

        // Create additional client users
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('client');
        });
    }
}
