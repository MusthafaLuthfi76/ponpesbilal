<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        DB::table('user')->updateOrInsert(
            ['email' => 'admin@admin.com'],
            [
                'nama' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        DB::table('user')->updateOrInsert(
            ['email' => 'admin@pesantren.local'],
            [
                'nama' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Musyrif Accounts
        DB::table('user')->updateOrInsert(
            ['email' => 'musyrif1@pesantren.com'],
            [
                'nama' => 'Musyrif1',
                'password' => Hash::make('musyrif123'),
                'role' => 'musyrif',
            ]
        );

        DB::table('user')->updateOrInsert(
            ['email' => 'musyrif2@pesantren.com'],
            [
                'nama' => 'Musyrif2',
                'password' => Hash::make('musyrif123'),
                'role' => 'musyrif',
            ]
        );

        DB::table('user')->updateOrInsert(
            ['email' => 'musyrif3@pesantren.com'],
            [
                'nama' => 'Musyrif3',
                'password' => Hash::make('musyrif123'),
                'role' => 'musyrif',
            ]
        );

        // Pengajar Accounts
        DB::table('user')->updateOrInsert(
            ['email' => 'pengajar1@pesantren.com'],
            [
                'nama' => 'Pengajar1',
                'password' => Hash::make('pengajar123'),
                'role' => 'pengajar',
            ]
        );

        DB::table('user')->updateOrInsert(
            ['email' => 'pengajar2@pesantren.com'],
            [
                'nama' => 'Pengajar2',
                'password' => Hash::make('pengajar123'),
                'role' => 'pengajar',
            ]
        );

        DB::table('user')->updateOrInsert(
            ['email' => 'pengajar3@pesantren.com'],
            [
                'nama' => 'Pengajar3',
                'password' => Hash::make('pengajar123'),
                'role' => 'pengajar',
            ]
        );
    }
}

