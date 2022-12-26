<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\adjudicator;
use App\Models\game;
use App\Models\score_title;
use App\Models\team;
use App\Models\adjudicator_team;

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

        return view('game.score.index',['games' => $games ]);
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
                if (adjudicator_team::where([
                    ['adjudicator_id',auth()->user()->adjudicator()->first()->id],
                    ['team_id',$team_value->id]    
                ])->count() == 0) {
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
        }
        return redirect()->route('score.score',$game_id);
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
        $adjudicator_team = adjudicator_team::where([
            ['game_id',$game_id]
        ]);
        $scores = [];
        $percentage = [];
        foreach($titles as $title){
            $percentage[$title->id] = $title->percentage;
        }
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
        return view('game.score.show',['game_id' => $game_id, 'teams' => $teams, 'adjudicator_team' => $adjudicator_team , 'game_name' => $game_name , 'titles' => $titles, 'scores' => $scores ,'percentage' => $percentage]);
    }

    public function show_adjudicator_score_list($game_id)
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
        return view('game.score.adjudicator_list',['game_id' => $game_id, 'teams' => $teams , 'game_name' => $game_name , 'titles' => $titles, 'scores' => $scores]);
    }

    public function show_admin_score_list($game_id)
    {
        $game = auth()->user()->games()->find($game_id);
        $game_name = $game->name;
        $titles = $game->score_titles()->get();
        $teams = $game->teams()->get();
        $adjudicators = $game->adjudicators()->get();
        $scores = [];
        //隊伍總成績
        foreach ($teams as $team) {
            $sum = 0;
            foreach($titles as $title){
                $title_sum = 0;
                $score_num = $adjudicators->count();
                foreach($adjudicators as $adjudicator){
                    if(adjudicator_team::where([
                        'team_id' => $team->id,
                        'game_id' => $game_id,
                        'adjudicator_id' => $adjudicator->id
                    ])->count() > 0){
                        $score_num-=1;
                        $scores[$adjudicator->id.'-'.$team->id.'-'.$title->id] = "不評分";
                    }else{
                        if($adjudicator->scores()->where([
                            'team_id' => $team->id,
                            'score_titles_id' => $title->id
                        ])->count() == 0){
                            $score_num-=1;
                            $scores[$adjudicator->id.'-'.$team->id.'-'.$title->id] = "未評分";

                        }else{
                            $pass = $adjudicator->scores()->where([
                                'team_id' => $team->id,
                                'score_titles_id' => $title->id
                            ])->first();
                            $scores[$adjudicator->id.'-'.$team->id.'-'.$title->id] = $pass->score;
                            $sum += $pass->score * $title->percentage / 100;
                            $title_sum += $pass->score * $title->percentage / 100;
                        }
                    }
                    
                }
                $scores[$team->id.'-'.$title->id.'-sum'] = round($title_sum / $score_num,4);
                    print_r($scores);
                    echo "<br><br>";
            }
            $score_num = $adjudicators->count() - adjudicator_team::where([
                'team_id' => $team->id,
                'game_id' => $game_id,
            ])->count();
            $scores[$team->id.'-team_sum'] = round($sum / $score_num,4);
        }

        foreach($adjudicators as $adjudicator){
            foreach($teams as $team){
                $sum = 0;
                foreach($titles as $title){
                    if(adjudicator_team::where([
                        'team_id' => $team->id,
                        'game_id' => $game_id,
                        'adjudicator_id' => $adjudicator->id
                    ])->count() != 0){
                        
                    }
                    else{
                        if($adjudicator->scores()->where([
                            'team_id' => $team->id,
                            'score_titles_id' => $title->id
                        ])->count() == 0){
                            $sum += 0;
                        }else{
                            $pass = $adjudicator->scores()->where([
                                'team_id' => $team->id,
                                'score_titles_id' => $title->id
                            ])->first();
                            $sum += $pass->score * $title->percentage / 100;
                        }
                        
                    }
                }
                $scores['sub-'.$adjudicator->id.'-'.$team->id.'-sum'] = $sum;
            }
        }

        
        // foreach($adjudicators as $adjudicator){
        //     foreach($teams as $team_value){
        //         $sum = 0;
        //         foreach($titles as $title_value){

        //             $pass = $adjudicator->scores()->where([
        //                 'team_id' => $team_value->id,
        //                 'score_titles_id' => $title_value->id
        //             ])->first();
        //             $sum += $pass->score * $title_value->percentage / 100;
                    

        //         }
        //         $scores[$adjudicator->id.'-'.$team_value->id.'-sum'] = $sum;
        //     }
        // }

        // foreach($teams as $team_value){
        //     $sum = 0; //隊伍總成績
        //     foreach($titles as $title_value){
        //         $title_sum = 0; 
        //         foreach ($adjudicators as $adjudicator) {
        //             $pass = $adjudicator->scores()->where([
        //                 'team_id' => $team_value->id,
        //                 'score_titles_id' => $title_value->id
        //             ])->first();
        //             if (isset($pass->score)) {
        //                 $sum += $pass->score * $title_value->percentage / 100;
        //                 $title_sum += $pass->score;
        //                 $scores[$adjudicator->id.'-'.$team_value->id . '-'. $title_value->id] = $pass->score;
        //             }else if(adjudicator_team::where([
        //                 ['adjudicator_id',$adjudicator->id],
        //                 ['team_id',$team_value->id]    
        //             ])->count() > 0){
        //                 $adjudicator_count -= 1;
        //                 $scores[$adjudicator->id.'-'.$team_value->id . '-'. $title_value->id] = "不評分";
        //             }
        //             else{
        //                 $scores[$adjudicator->id.'-'.$team_value->id . '-'. $title_value->id] = 0;
        //             }
        //         } 
                
        //         $scores[$team_value->id.'-'.$title_value->id.'-sum'] = round($title_sum / $adjudicators->count(),4);
        //     }
        //     $scores[$team_value->id.'-team_sum'] = round($sum / $adjudicators->count(),4);
        // }

        

        return view('game.score.admin_list',['game_id' => $game_id, 'teams' => $teams , 'game_name' => $game_name , 'titles' => $titles, 'adjudicators' => $adjudicators, 'scores' => $scores]);
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
