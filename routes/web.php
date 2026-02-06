<?php

use Illuminate\Support\Facades\Route;

// untuk aboutus (jadi tampilan utama saat web dibuka)
Route::get('/', function () {
    return view('aboutus');
})->name('aboutus');

// untuk schedule
Route::get('/schedule', function () {
    return view('schedule');
})->name('schedule');

// untuk house
Route::get('/house', function () {
    return view('house');
})->name('house');

// untuk registration
Route::get('/registration', function () {
    return view('registration');
});