<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $houses = [
            ['name' => 'House of Elixir', 'faculty' => 'Farmasi'],
            ['name' => 'House of Justicia', 'faculty' => 'Hukum'],
            ['name' => 'House of Mercator', 'faculty' => 'Bisnis dan Ekonomika'],
            ['name' => 'House of Praxis', 'faculty' => 'Politeknik'],
            ['name' => 'House of Arcana', 'faculty' => 'Psikologi'],
            ['name' => 'House of Fortis', 'faculty' => 'Teknik'],
            ['name' => 'House of Vivens', 'faculty' => 'Teknobiologi'],
            ['name' => 'House of Creatio', 'faculty' => 'Industri Kreatif'],
            ['name' => 'House of Vitalis', 'faculty' => 'Kedokteran'],
        ];

        // Masukkan data ke tabel houses
        DB::table('houses')->insert($houses);
    }
}