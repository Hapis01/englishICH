<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Course;
use App\Models\SchoolClass;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Removed manual truncation since we use migrate:fresh

        $password = Hash::make('password');

        // Create Admin
        User::create([
            'name' => 'Admin ICH',
            'email' => 'admin@ich.com',
            'password' => $password,
            'role' => 'admin',
            'whatsapp' => '+628000000000',
            'status' => 'active',
            'student_status' => 'ACTIVE'
        ]);
    }
}
