<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\TeamController;

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

// untuk leaderboard
Route::get('/leaderboard', function () {
    return view('leaderboard');
})->name('leaderboard');

// untuk login
Route::get('/login', function () {
    return view('login');
})->name('login');
use App\Http\Controllers\LoginController;
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.action');

// Route untuk Logout
Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

//teamlist
Route::get('/teamlist',[TeamController::class,'index'])
    ->middleware('auth')
    ->name('teamlist');

Route::post('/teams', [TeamController::class, 'store'])
    ->middleware('auth')
    ->name('teams.store'); 
    
Route::get('/teamdetail', [TeamController::class, 'show'])
    ->middleware('auth')
    ->name('teamdetail');