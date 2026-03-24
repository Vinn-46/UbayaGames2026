<?php

if (!function_exists('getMajorsByHouse')) {
    function getMajorsByHouse(string $houseName): array
    {
        $major = [
            //farmasi
            'House of Elixir' => [
                'Farmasi'
            ], 

            //hukum
            'House of Justicia' => [
                'Hukum'
            ], 

            //bisnis dan ekonomika
            'House of Mercator' => [
                'Ilmu Ekonomi',
                'Manajemen',
                'Akuntansi',
                'Professional Accounting',
                'IBN'
            ], 

            //politeknik
            'House of Praxis' => [
                'Digital Business Accounting',
                'Digital Business & Marketing',
                'Digital Office Administration',
                'English for Business & PR',
                'Digital Taxation',
                'Computerized Accounting',
                'Business Administration',
                'Digital Professional Taxation'
            ],

            //psikologi
            'House of Arcana' => [
                'Psikologi'
            ],

            //teknik
            'House of Fortis' => [
                'Teknik Elektro', 
                'Teknik Kimia', 
                'Teknik Industri', 
                'Teknik Informatika',
                'Teknik Mesin dan Manufaktur',
                'Sistem Informasi'
            ],

            //teknobiologi
            'House of Vivens' => [
                'Biologi (Bioteknologi)',
                'Bionutrisi dan Inovasi Pangan'
            ],

            //industri kreatif
            'House of Creatio' => [
                'Desain Produk',
                'Desain Komunikasi Visual'
            ],

            //kedokteran
            'House of Vitalis' => [
                'Kedokteran'
            ]
            
        ];

        return $major[$houseName] ?? [];
    }
}

if (!function_exists('getPlayersByTeam')) {
    function getPlayersByTeam(\App\Models\Team $team) {
        return $team->participantTeams()->with('participant')->get();
    }
}

if (!function_exists('getCrewsByTeam')) {
    function getCrewsByTeam(\App\Models\Team $team) {
        return $team->crewTeams()->with('crew')->get();
    }
}