<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\adjudicator;


class adjudicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($game_id)
    {
        $adjudicators = auth()->user()->games()->find($game_id)->adjudicators()->get();
        return view('game.adjudicator.adjudicator', ['adjudicators' => $adjudicators ,'id' => $game_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($game_id)
    {
        return view('game.adjudicator.create', ['id' => $game_id]);
    }

    public function find_adjudicator(Request $request,$game_id){
        $adjudicator_info = User::where([
            'email' => $request->email]);
        
        if (adjudicator::where(
            [
                'user_id' => $adjudicator_info->first()->id ,
                'game_id' => $game_id
            ])->count() > 0) {
            return redirect()->route('adjudicator.index',["game_id" => $game_id])->with('notice','此帳號已是當場比賽評審！');
        }
        
        if($adjudicator_info->count() == 1)
        {
            $this->store($adjudicator_info->first()->id,$game_id);
        }
        return redirect()->route('adjudicator.index',["game_id" => $game_id]);
    }

    public function register_adjudicator(Request $request,$game_id)
    {
        $content = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);
        $content['password'] = Hash::make($content['password']);
        $usersOverriding = User::factory()->create($content);

        $this->store($usersOverriding['id'],$game_id);

        return redirect()->route('adjudicator.index',["game_id" => $game_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($user_id,$game_id)
    {
        $content = [
            'user_id' => $user_id
        ];
        auth()->user()->games()->find($game_id)->adjudicators()->create($content);
        return redirect()->route('adjudicator.index',["game_id" => $game_id]);
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
        $game_id = adjudicator::find($id)->game_id;
        auth()->user()->games()->find($game_id)->adjudicators()->find($id)->delete();
        return redirect()->route('adjudicator.index',["game_id" => $game_id]);
    }
}
