<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GenerateAdminUser extends Seeder
{
    const EMAIL = 'rayan7899@hotmail.com';
    const PASSWORD = 'asdfasdf';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'ريان العرفج',
            'email' => $this::EMAIL,
            'is_admin' => true,
            'password'  => Hash::make($this::PASSWORD),
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ]);
    }
}
