<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ItemList;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First seed default categories and items
        $this->call(DefaultItemsSeeder::class);

        // Then create test user
        // Create admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);

        // Create regular test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => false,
        ]);
        // The ItemListServiceProvider will automatically create the default list
        // and attach default items for the new user
    }
}
