<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $admin = [
            'name' => 'Admin ICH',
            'email' => 'admin@ich.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '+62812345000',
            'whatsapp' => '+62812345000',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Teachers
        $teachers = [
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@ich.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
                'phone' => '+62812345001',
                'whatsapp' => '+62812345001',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael.chen@ich.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
                'phone' => '+62812345002',
                'whatsapp' => '+62812345002',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Emily Rodriguez',
                'email' => 'emily.rodriguez@ich.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
                'phone' => '+62812345003',
                'whatsapp' => '+62812345003',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'David Williams',
                'email' => 'david.williams@ich.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
                'phone' => '+62812345004',
                'whatsapp' => '+62812345004',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jessica Taylor',
                'email' => 'jessica.taylor@ich.com',
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
                'phone' => '+62812345005',
                'whatsapp' => '+62812345005',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Students
        $students = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad.rizki@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345101',
                'whatsapp' => '+62812345101',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345102',
                'whatsapp' => '+62812345102',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345103',
                'whatsapp' => '+62812345103',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345104',
                'whatsapp' => '+62812345104',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345105',
                'whatsapp' => '+62812345105',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fitri Handayani',
                'email' => 'fitri.handayani@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345106',
                'whatsapp' => '+62812345106',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Gunawan Wijaya',
                'email' => 'gunawan.wijaya@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345107',
                'whatsapp' => '+62812345107',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hani Kusuma',
                'email' => 'hani.kusuma@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345108',
                'whatsapp' => '+62812345108',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Indra Permana',
                'email' => 'indra.permana@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345109',
                'whatsapp' => '+62812345109',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Joko Widodo',
                'email' => 'joko.widodo@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345110',
                'whatsapp' => '+62812345110',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kartika Sari',
                'email' => 'kartika.sari@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345111',
                'whatsapp' => '+62812345111',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Linda Wijayanti',
                'email' => 'linda.wijayanti@student.com',
                'password' => Hash::make('student123'),
                'role' => 'student',
                'phone' => '+62812345112',
                'whatsapp' => '+62812345112',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($admin);
        DB::table('users')->insert($teachers);
        DB::table('users')->insert($students);
    }
}
