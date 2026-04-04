<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// 1. Simpan aplikasi ke variabel $app TERLEBIH DAHULU
$app = require_once __DIR__.'/bootstrap/app.php';

// 2. Lakukan binding folder public SEBELUM menangani request
$app->bind('path.public', function() {
    return __DIR__;
});

// 3. Baru jalankan aplikasinya
$app->handleRequest(Request::capture());