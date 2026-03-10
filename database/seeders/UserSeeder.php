<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $users = [
            //kontingen
            [
                'username' => 'Farmasi',
                'password' => Hash::make('admin123'),
                'role' => 'Kontingen',
                'house_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Hukum',
                'password' => Hash::make('admin123'),
                'role' => 'Kontingen',
                'house_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Fbe',
                'password' => Hash::make('admin123'),
                'role' => 'Kontingen',
                'house_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Politeknik',
                'password' => Hash::make('admin123'),
                'role' => 'Kontingen',
                'house_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Psikologi',
                'password' => Hash::make('admin123'),
                'role' => 'Kontingen',
                'house_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Teknik',
                'password' => Hash::make('admin123'),
                'role' => 'Kontingen',
                'house_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Teknobiologi',
                'password' => Hash::make('admin123'),
                'role' => 'Kontingen',
                'house_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Fik',
                'password' => Hash::make('admin123'),
                'role' => 'Kontingen',
                'house_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Kedokteran',
                'password' => Hash::make('admin123'),
                'role' => 'Kontingen',
                'house_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //sekret
            [
                'username' => 'Sekre',
                'password' => Hash::make('sekre123'),
                'role' => 'Sekretariat',
                'house_id' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //cablom

            //admin
        ];
        DB::table('users')->insert($users);
    }
}