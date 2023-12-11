<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\support\Str;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        User::factory()->create([
            'firstName' => 'Test',
            'lastName' => 'Admin',
            'phone' => '09121244888',
            'address' => 'Sagbayan, Bohol',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
            'remember_token' => Str::random(10), // Generating a random token
            'email_verified_at' => now(), // Marking the email as verified
        ]);

        $user = User::factory()->create([
            'firstName' => 'Test',
            'lastName' => 'Manager',
            'phone' => '09121244888',
            'address' => 'Sagbayan, Bohol',
            'email' => 'customer@test.com',
            'password' => bcrypt('password123'),
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ]);

        // Create a customer and associate it with the user
        $user->customer()->create();


        $this->call([
            RolesandPermissionSeeder::class,

        ]);


    }
}
