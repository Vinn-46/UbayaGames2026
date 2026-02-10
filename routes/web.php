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

// untuk teamdetail
Route::get('/teamdetail', function () {
    return view('teamdetail');
})->name('teamdetail');

// untuk teamlist
Route::get('/teamlist', function () {
    return view('teamlist');
})->name('teamlist');

// untuk leaderboard
Route::get('/leaderboard', function () {
    return view('leaderboard');
})->name('leaderboard');

// untuk login
Route::get('/login', function () {
    return view('login');
})->name('login');

