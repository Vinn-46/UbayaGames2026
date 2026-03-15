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
                'username' => 'elixir',
                'password' => Hash::make('stark@812'),
                'role' => 'Kontingen',
                'house_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'justicia',
                'password' => Hash::make('snow@459'),
                'role' => 'Kontingen',
                'house_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'mercator',
                'password' => Hash::make('raven@371'),
                'role' => 'Kontingen',
                'house_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'praxis',
                'password' => Hash::make('iron@624'),
                'role' => 'Kontingen',
                'house_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'arcana',
                'password' => Hash::make('wolf@193'),
                'role' => 'Kontingen',
                'house_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'fortis',
                'password' => Hash::make('weareone@404'),
                'role' => 'Kontingen',
                'house_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'vivens',
                'password' => Hash::make('hodor@508'),
                'role' => 'Kontingen',
                'house_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'creatio',
                'password' => Hash::make('wall@742'),
                'role' => 'Kontingen',
                'house_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'vitalis',
                'password' => Hash::make('king@285'),
                'role' => 'Kontingen',
                'house_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //sekret
            [
                'username' => 'debrina',
                'password' => Hash::make('sekret@!1234'),
                'role' => 'Sekretariat',
                'house_id' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'username' => 'edwin',
                'password' => Hash::make('sekret@!1234'),
                'role' => 'Sekretariat',
                'house_id' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'username' => 'celine',
                'password' => Hash::make('sekret@!1234'),
                'role' => 'Sekretariat',
                'house_id' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'username' => 'felicia',
                'password' => Hash::make('sekret@!1234'),
                'role' => 'Sekretariat',
                'house_id' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'username' => 'gisyele',
                'password' => Hash::make('sekret@!1234'),
                'role' => 'Sekretariat',
                'house_id' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            //cablom

            //admin
            [
                'username' => 'sigacor',
                'password' => Hash::make('juanjeL3K@123'),
                'role' => 'Sekretariat',
                'house_id' => NULL,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        DB::table('users')->insert($users);
    }
}