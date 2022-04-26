<?php

namespace App\Http\Controllers;

use App\Models\team;
use Illuminate\Http\Request;
use App\Imports\TeamsImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebstie\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\HeadingRowImport;

class teamController extends Controller
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
        $teams = auth()->user()->games()->find($game_id)->teams()->get();
        $game_name = auth()->user()->games()->find($game_id)->name;
        return view('game.team.team', ['teams' => $teams,'game_id' => $game_id,'game_name' => $game_name]);
    }

    public function example_file()
    {
        return response()->download(public_path('/file/example_file.xlsx'));
    }

    public function import(Request $request,$game_id){
        auth()->user()->games()->find($game_id)->teams()->delete();
        $teams = auth()->user()->games()->find($game_id)->teams()->get();
        
        $teamsImportClass = new TeamsImport($game_id);
        Excel::import($teamsImportClass, $request->file);
        return redirect()->route('team.index', ['teams' => $teams,'game_id' => $game_id]);
    }

    public function clear_teams($game_id){
        auth()->user()->games()->find($game_id)->teams()->delete();
        $teams = auth()->user()->games()->find($game_id)->teams()->get();
        return redirect()->route('team.index', ['teams' => $teams,'game_id' => $game_id]);
    }

    public function team_details($id){
        $team = team::find($id);
        return view('game.team.team_details',['team_name' => $team->name , 'details' => $team->team_details_datas()->get() ]);
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
    public function store(Request $request)
    {
        //
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
