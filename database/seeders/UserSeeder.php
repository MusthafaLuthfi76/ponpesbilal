<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user')->updateOrInsert(
            ['email' => 'admin@pesantren.local'],
            [
                'nama' => 'admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
