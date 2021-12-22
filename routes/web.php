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

    Route::get('/games',[\App\Http\Controllers\gamesController::class,'index']
    )->name('games');


    Route::get('/games/add',[\App\Http\Controllers\gamesController::class,'game_add_page']
    )->name('game_add_page');

    Route::post('/games/add',[\App\Http\Controllers\gamesController::class,'game_add']
    )->name('game_add');

    Route::get('/score',[\App\Http\Controllers\gamesController::class,'score']
    )->name('score');

    Route::get('/edit/{game_id}',[\App\Http\Controllers\gamesController::class,'edit_page']
    )->name('games.edit_page');

    Route::post('/edit/{id}',[\App\Http\Controllers\gamesController::class,'edit']
    )->name('game.edit');

    Route::get('/score/{game_id}',[\App\Http\Controllers\gamesController::class,'score_page']
    )->name('games.score_page');

    Route::get('/adjudicator/{game_id}',[\App\Http\Controllers\gamesController::class,'adjudicator_page']
    )->name('games.adjudicator_page');

    Route::get('/team_page/{game_id}',[\App\Http\Controllers\gamesController::class,'team_page']
    )->name('games.team_page');
});

