<?php

use App\Http\Controllers\CrewController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ParticipantController;

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

Route::post('/login', [LoginController::class, 'authenticate'])->name('login.action');

// Route untuk Logout
Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

//Route untuk allplayer
Route::get('/allplayer',[ParticipantController::class,'allplayer'])
    ->middleware('auth')
    ->name('allplayer');

//teamlist
Route::get('/teamlist',[TeamController::class,'index'])
    ->middleware('auth')
    ->name('teamlist');

Route::post('/teams', [TeamController::class, 'store'])
    ->middleware('auth')
    ->name('teams.store');
    
//teamdetail
Route::get('/teamdetail', [TeamController::class, 'show'])
    ->middleware('auth')
    ->name('teamdetail');

//change team name
Route::put('/teams/{team}', [TeamController::class, 'changeName'])
    ->name('teams.changeName');     

//add player
Route::post('/teams/{team}/attach-player', 
    [ParticipantController::class, 'attachExistingPlayer']
)->name('participant.attachPlayer');

Route::post('/teams/{team}/add-player', 
    [ParticipantController::class, 'addPlayer'])
    ->name('participant.addPlayer');

//hapus player
Route::delete('/teams/{team}/participant/{participant}',
    [TeamController::class, 'destroyPlayer']
)->name('teams.destroyPlayer');

//edit player
Route::put('/teams/{team}/participant/{participant}', 
    [ParticipantController::class, 'update']
)->name('participant.update');

//edit player (general)
Route::put('/participant/{participant}', 
    [ParticipantController::class, 'updateGeneral']
)->name('participant.updateGeneral');

Route::delete('/teams/{team}/crew/{crew}', 
    [CrewController::class, 'destroyCrew'])
->name('crew.destroyCrew');

//delete team
Route::delete('/teams/{id}', [TeamController::class, 'deleteTeam'])
    ->name('teams.destroy');

Route::get('/teamlist-sekre', [TeamController::class, 'indexSekre'])
    ->middleware('auth')
    ->name('teamlist.sekre');

Route::put('/teams/{id}/status', [TeamController::class, 'updateStatus'])
    ->middleware('auth')
    ->name('teams.updateStatus');

Route::get('/teamdetail-sekre', [TeamController::class, 'showSekre'])
    ->middleware('auth')
    ->name('teamdetail.sekre');

Route::post('/teams/revision', [TeamController::class, 'updateRevision'])
    ->middleware('auth')
    ->name('teams.updateRevision');

Route::put('/participants/{participant}/teams/{team}/status', 
    [ParticipantController::class, 'updateStatus'])
    ->name('participants.updateStatus');

Route::post('/participants/{participant}/teams/{team}/status',
    [ParticipantController::class, 'updateRevision'])
    ->name('participants.updateRevision');

Route::put('/crew/{crew}/teams/{team}/status',
    [CrewController::class,'updateStatus'])
    ->name('crew.updateStatus');

Route::post('/crew/{crew}/teams/{team}/status',
    [CrewController::class,'updateRevision'])
    ->name('crew.updateRevision');

Route::post('/teams/{team}/crew/add', 
    [CrewController::class, 'addCrew'])
    ->name('crew.addCrew');

Route::post('/crew/attach/{team}', 
    [CrewController::class, 'attachCrew'])
    ->name('crew.attachCrew');

Route::put('/teams/{team}/crew/{crew}', 
    [CrewController::class, 'updateCrew'])
    ->name('crew.updateCrew');

Route::put('/crew/{crew}', 
    [CrewController::class, 'updateGeneralCrew'])
    ->name('crew.updateGeneralCrew');    

//delete player dari all player
Route::delete('/allplayer/{id}', 
    [\App\Http\Controllers\ParticipantController::class, 'destroy'])
    ->name('participant.destroy');

Route::get('/allcrews', 
    [\App\Http\Controllers\CrewController::class, 'allCrews'])
    ->name('allcrews');

Route::delete('/allcrews/{id}', 
    [\App\Http\Controllers\CrewController::class, 'destroy'])
    ->name('crew.destroy');