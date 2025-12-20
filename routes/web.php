<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// untuk about us
Route::get('/aboutus', function () {
    return view('aboutus');
});

// untuk registration
Route::get('/registration', function () {
    return view('registration');
});