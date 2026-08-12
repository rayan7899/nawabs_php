<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ItemList;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Then create test user
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'is_admin' => true,
        ]);

        // The ListServiceProvider will automatically create the default list
        // and attach default items for the new user

        Auth::onceUsingId($admin->id);
        // First seed default categories and items
        $this->call(DefaultItemsSeeder::class);

        // Create regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'is_admin' => false,
        ]);
        // Create regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test2@test.com',
            'is_admin' => false,
        ]);
        // Create regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test3@test.com',
            'is_admin' => false,
        ]);
        // Create regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test4@test.com',
            'is_admin' => false,
        ]);
        // Create regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test5@test.com',
            'is_admin' => false,
        ]);
    }
}
