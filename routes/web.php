<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['middleware' => 'auth'], function(){
    Route::get('/', function () {
        return view('dashboard');
    });
    Route::get('/dashboard',function(){
        return view('dashboard');
    })->name('dashboard');

    Route::get('/games/index',[\App\Http\Controllers\gamesController::class,'index']
    )->name('games');

    Route::get('/games/score',[\App\Http\Controllers\gamesController::class,'score']
    )->name('score');

    Route::get('/games/addPage',[\App\Http\Controllers\gamesController::class,'addPage']
    )->name('games.addPage');

    Route::get('/game/edit/{game_id}',[\App\Http\Controllers\gamesController::class,'editPage']
    )->name('games.editPage');

    Route::post('/game/edit/{id}',[\App\Http\Controllers\gamesController::class,'edit']
    )->name('game.edit');

    

    Route::resource('scoreTitles','\App\Http\Controllers\scoreTitlesController')->only(['create','destroy']);

    Route::post('/scoreTitles/store/{game_id}',[\App\Http\Controllers\scoreTitlesController::class,'store']
    )->name('scoreTitles.store');

    Route::get('/scoreTitles/index/{game_id}',[\App\Http\Controllers\scoreTitlesController::class,'index']
    )->name('scoreTitles.index');

    Route::get('/scoreTitles/{game_id}/{id}',[\App\Http\Controllers\scoreTitlesController::class,'edit'])
    ->name('scoreTitles.edit');

    Route::post('/scoreTitles/update/{id}',[\App\Http\Controllers\scoreTitlesController::class,'update'])
    ->name('scoreTitles.update');

    Route::resource('adjudicator','\App\Http\Controllers\adjudicatorController');
    Route::resource('team','\App\Http\Controllers\teamController');
});

