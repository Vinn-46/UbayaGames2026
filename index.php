<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/vendor/autoload.php';

// Simpan hasil require ke dalam variabel $app
$app = (require_once __DIR__.'/bootstrap/app.php')
    ->handleRequest(Request::capture());

// Sekarang variabel $app sudah tersedia untuk di-bind
$app->bind('path.public', function() {
    return __DIR__;
});