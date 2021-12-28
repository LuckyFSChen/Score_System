<?php

namespace App\Http\Controllers;

use App\Models\score_title;
use Illuminate\Http\Request;

class scoreTitlesController extends Controller
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
    public function index($game_id)
    {
        $scores = auth()->user()->games()->find($game_id)->score_titles()->get();
        return view('game.scoreTitles.score', ['scores' => $scores , 'id' => $game_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,$id)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request , int $id
     * @return \Illuminate\Http\Response
     */
    public function store($game_id,Request $request)
    {
        $content = $request->validate([
            'name' => 'required',
            'percentage' => 'required'
        ]);

        auth()->user()->games()->find($game_id)->score_titles()->create($content);
        return redirect()->route('scoreTitles.index',['game_id' => $game_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($game_id,$id)
    {
        $scoreTitle = auth()->user()->games()->find($game_id)->score_titles()->find($id);
        return view("game.scoreTitles.edit",['scoreTitle' => $scoreTitle]);
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
        $game_id = $request->game_id;
        $scoreTitle = auth()->user()->games()->find($game_id)->score_titles()->find($id);

        $content = $request->validate([
            'name' => 'required',
            'percentage' => 'required|min:0|max:100',
        ]);

        $scoreTitle->update($content);
        return redirect()->route('scoreTitles.index',['game_id' => $game_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game_id = score_title::find($id)->game_id;
        auth()->user()->games()->find($game_id)->score_titles()->find($id)->delete();
        return redirect()->route('scoreTitles.index',['game_id' => $game_id]);
    }
}
