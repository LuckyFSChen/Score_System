<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class scoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = auth()->user()->adjudicator()->first()->games()->where('enabled' , '1')->get();

        return view('score.index',['games' => $games ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $game_id)
    {
        $game_name = auth()->user()->adjudicator()->first()->games()->find($game_id)->name;
        $titles = auth()->user()->adjudicator()->first()->games()->find($game_id)->score_titles()->get();
        $teams = auth()->user()->adjudicator()->first()->games()->find($game_id)->teams()->get();
        $str = "";
        foreach($teams as $team_value){
            foreach($titles as $title_value){
                $score = $request->{$team_value->id.'-'.$title_value->id};
                $game_score = [
                    'team_id' => $team_value->id,
                    'score_titles_id' => $title_value->id,
                    'score' => $score,
                ];

                $pass = auth()->user()->adjudicator()->first()->scores()->where([
                    'team_id' => $team_value->id,
                    'score_titles_id' => $title_value->id
                ])->first();
                if (isset($pass->score)) {
                    $pass->score = $score;
                    $pass->save();
                }else{
                    auth()->user()->adjudicator()->first()->scores()->create($game_score);
                }
            }
        }
        return redirect()->route('score');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($game_id)
    {
        $game_name = auth()->user()->adjudicator()->first()->games()->find($game_id)->name;
        $titles = auth()->user()->adjudicator()->first()->games()->find($game_id)->score_titles()->get();
        $teams = auth()->user()->adjudicator()->first()->games()->find($game_id)->teams()->get();
        $scores = [];
        foreach($teams as $team_value){
            foreach($titles as $title_value){
                
                $pass = auth()->user()->adjudicator()->first()->scores()->where([
                    'team_id' => $team_value->id,
                    'score_titles_id' => $title_value->id
                ])->first();
                if (isset($pass->score)) {
                    $scores[$team_value->id . '-'. $title_value->id] = $pass->score;
                }else{
                    $scores[$team_value->id . '-'. $title_value->id] = 0;
                }
                
            }
        }
        return view('score.show',['game_id' => $game_id, 'teams' => $teams , 'game_name' => $game_name , 'titles' => $titles, 'scores' => $scores]);
    }

    public function show_list($game_id)
    {
        $game_name = auth()->user()->adjudicator()->first()->games()->find($game_id)->name;
        $titles = auth()->user()->adjudicator()->first()->games()->find($game_id)->score_titles()->get();
        $teams = auth()->user()->adjudicator()->first()->games()->find($game_id)->teams()->get();
        $scores = [];
        foreach($teams as $team_value){
            foreach($titles as $title_value){
                
                $pass = auth()->user()->adjudicator()->first()->scores()->where([
                    'team_id' => $team_value->id,
                    'score_titles_id' => $title_value->id
                ])->first();
                if (isset($pass->score)) {
                    $scores[$team_value->id . '-'. $title_value->id] = $pass->score;
                }else{
                    $scores[$team_value->id . '-'. $title_value->id] = 0;
                }
                
            }
        }
        return view('score.list',['game_id' => $game_id, 'teams' => $teams , 'game_name' => $game_name , 'titles' => $titles, 'scores' => $scores]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
