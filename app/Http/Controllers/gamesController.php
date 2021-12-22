<?php

namespace App\Http\Controllers;

use App\Models\game;
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

    public function import($game_id){
        $reader = Excel::Load(request()->file('file'));
        $header_Row = $reader->first()->keys()->toArray();
        foreach($header_Row as $header){
            if($header != "隊伍編號" || $header != "隊伍名稱"){
                $content = [
                    'name' => $header
                ];
                auth()->user()->games()->find($game_id)->team_details_titles()->create($content);
            }
        }
        $isFirst = true;
        foreach($reader as $row){

            if ($isFirst){
                $isFirst = false;
                continue;
            }

            $content = [
                'serial_num' => $row['隊伍編號'],
                'name' => $row['隊伍名稱']
            ];

            auth()->user()->games()->find($game_id)->team()->create($content);

            foreach($row as $row_data){
                auth()->user()->games()->find($game_id)->team()->team_details_datas()->where('name', $row_data->keys())->create($row_data);
            }
        }

        return redirect()->route('games');
    }

    public function add_page()
    {
        return view('game.game_add');
    }

    public function add(Request $request)
    {
        $content = $request->validate([
            'name' => 'required',

        ]);

        auth()->user()->games()->create($content);

        return redirect()->route('games');
    }

    public function edit_page($game_id){
        return view('game.edit', ['id' => $game_id]);
    }

    public function edit(Request $request, $id){
        $game = auth()->user()->games()->find($id);

        $content = $request->validate([
           'name' => 'required',
        ]);
        $game->update($content);

        return redirect()->route('games');
    }

    public function score_page($game_id){
        return view('game.score');
    }

    public function adjudicator_page($game_id){
        return view('game.adjudicator');
    }

    public function team_page($game_id){
        return view('game.team');
    }

    public function score()
    {
        return view('game.score');
    }

}
