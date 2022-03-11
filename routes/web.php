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

   

    Route::POST('/games/store',[\App\Http\Controllers\gamesController::class,'store']
    )->name('games.store');

    Route::get('/games/addPage',[\App\Http\Controllers\gamesController::class,'addPage']
    )->name('games.addPage');

    Route::get('/game/edit/{game_id}',[\App\Http\Controllers\gamesController::class,'editPage']
    )->name('games.editPage');

    Route::post('/game/edit/{game_id}',[\App\Http\Controllers\gamesController::class,'edit']
    )->name('game.edit');

    Route::post('/game/destroy/{game_id}',[\App\Http\Controllers\gamesController::class,'destroy']
    )->name('game.destroy');

    Route::get('/game/open/{game_id}',[\App\Http\Controllers\gamesController::class,'open_game']
    )->name('game.open');

    Route::get('/game/close/{game_id}',[\App\Http\Controllers\gamesController::class,'close_game']
    )->name('game.close');
    


    /**
     *  scoreTitles
     */
    Route::resource('scoreTitles','\App\Http\Controllers\scoreTitlesController')->only(['create','destroy']);

    Route::get('/scoreTitles/index/{game_id}',[\App\Http\Controllers\scoreTitlesController::class,'index']
    )->name('scoreTitles.index');

    Route::post('/scoreTitles/store/{game_id}',[\App\Http\Controllers\scoreTitlesController::class,'store']
    )->name('scoreTitles.store');

    Route::get('/scoreTitles/{game_id}/{id}',[\App\Http\Controllers\scoreTitlesController::class,'edit'])
    ->name('scoreTitles.edit');

    Route::post('/scoreTitles/update/{id}',[\App\Http\Controllers\scoreTitlesController::class,'update'])
    ->name('scoreTitles.update');

    /**
     * adjudicator
     */
    Route::delete('/adjudicator/index/{game_id}/{id}',[\App\Http\Controllers\adjudicatorController::class,'destroy']
    )->name('adjudicator.destroy');

    Route::get('/adjudicator/index/{game_id}',[\App\Http\Controllers\adjudicatorController::class,'index']
    )->name('adjudicator.index');

    Route::post('/adjudicator/find/{game_id}',[\App\Http\Controllers\adjudicatorController::class,'find_adjudicator']
    )->name('adjudicator.find');

    Route::get('/adjudicator/create/{game_id}',[\App\Http\Controllers\adjudicatorController::class,'create']
    )->name('adjudicator.create');

    Route::post('/adjudicator/store/{game_id}',[\App\Http\Controllers\adjudicatorController::class,'store']
    )->name('adjudicator.store');

    Route::post('/adjudicator/register/{game_id}',[\App\Http\Controllers\adjudicatorController::class,'register_adjudicator']
    )->name('adjudicator.register');

    /**
     * team
     */

    Route::get('/team/index/{game_id}',[\App\Http\Controllers\teamController::class,'index']
    )->name('team.index');

    Route::post('/team/import/{game_id}',[\App\Http\Controllers\teamController::class,'import']
    )->name('team.import');

    Route::post('/team/clear/{game_id}',[\App\Http\Controllers\teamController::class,'clear_teams']
    )->name('team.clear');

    /**
     * score
     */

    Route::get('/score',[\App\Http\Controllers\scoreController::class,'index']
    )->name('score');

    Route::get('/score/{game_id}/show',[\App\Http\Controllers\scoreController::class,'show']
    )->name('score.score');

    Route::get('/score/{game_id}/adjudicator/list',[\App\Http\Controllers\scoreController::class,'show_adjudicator_score_list']
    )->name('adjudicator_score.list');

    Route::get('/score/{game_id}/admin/list',[\App\Http\Controllers\scoreController::class,'show_admin_score_list']
    )->name('admin_score.list');
    
    Route::post('/score/{game_id}/store',[\App\Http\Controllers\scoreController::class,'store'])
    ->name('score.store');

    /**
     * 帳號管理
     */

    Route::get('/account_manage',[\App\Http\Controllers\accountController::class,'index'])
    ->name('account');
    Route::get('/account/edit/{id}',[\App\Http\Controllers\accountController::class,'edit_page'])
    ->name('account.edit_page');
    Route::post('/account/edit/{id}',[\App\Http\Controllers\accountController::class,'edit'])
    ->name('account.edit');
    Route::post('/account/destroy/{id}',[\App\Http\Controllers\accountController::class,'destroy'])
    ->name('account.destroy');
});

