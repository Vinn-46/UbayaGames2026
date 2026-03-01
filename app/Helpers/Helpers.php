<?php

if (!function_exists('getMajorsByHouse')) {
    function getMajorsByHouse(string $houseName): array
    {
        $major = [
            //farmasi
            'House of Elixir' => [''], 

            //hukum
            'House of Justicia' => [''], 

            //bisnis dan ekonomika
            'House of Mercator' => [
                'Akuntasi', 
                'Manajemen'
                ], 

            //politeknik
            'House of Praxis' => [''],

            //psikologi
            'House of Arcana' => [''],

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
            'House of Vivens' => [''],

            //industri kreatif
            'House of Creatio' => [''],

            //kedokteran
            'House of Vitalis' => ['']
            
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