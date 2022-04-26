<?php

namespace App\Http\Controllers;

use App\Models\adjudicator;
use App\Models\game;
use App\Models\score_title;
use Illuminate\Http\Request;

class gamesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $games = auth()->user()->games()->orderBy('created_at', 'desc')->paginate(5);

        return view('game.games', ['games' => $games]);
    }


    public function addPage()
    {
        return view('game.game_add');
    }

    public function store(Request $request)
    {
        $content = $request->validate([
            'name' => 'required',

        ]);
        $game = auth()->user()->games()->create($content);

        return redirect()->route('games');
    }


    public function editPage($game_id){
        $game_name = auth()->user()->games()->find($game_id)->name;
        return view("game.edit", ["id" => $game_id, "game_name" => $game_name]);
//        return view('game.edit', ['id' => $game_id]);
    }

    public function edit(Request $request, $id){
        $game = auth()->user()->games()->find($id);

        $content = $request->validate([
           'name' => 'required',
        ]);
        $game->update($content);

        return redirect()->route('games');
    }


    public function close_game($id){
        $game = auth()->user()->games()->find($id);
        $game->enabled = 0;
        $game->update();
        return redirect()->route('games');
    }
    public function open_game($id){
        $game = auth()->user()->games()->find($id);
        $game->enabled = 1;
        $game->update();
        return redirect()->route('games');
    }

    public function destroy($id){
        auth()->user()->games()->find($id)->delete();
        return redirect()->route('games');
    }

}
