<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OwnerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'owner@ich.com'],
            [
                'name' => 'Owner',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'owner',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
    }
}
