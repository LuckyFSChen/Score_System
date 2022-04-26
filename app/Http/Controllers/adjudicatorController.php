<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\game;
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
        $user = User::where('name',$request->name);
        
        if (isset($user->first()->id)){
            if($user->first()->identity_id != 3){
                return redirect()->route('adjudicator.index',["game_id" => $game_id])->with('notice','此帳號非評審帳號！');
            }
            $adjudicator = adjudicator::where('user_id',$user->first()->id);
            if ($adjudicator->count() == 0){
                $user->first()->adjudicator()->create();
            }
            $adjudicator = adjudicator::where('user_id',$user->first()->id)->first();

            if (empty($adjudicator->games()->find($game_id))){
                $this->store($adjudicator,$game_id);
                return redirect()->route('adjudicator.index',["game_id" => $game_id]);
            }else{
                return redirect()->route('adjudicator.index',["game_id" => $game_id])->with('notice','此帳號已是當場比賽評審！');
            }
        }
        return redirect()->route('adjudicator.index',["game_id" => $game_id])->with('notice','查無此帳號');
    }

    public function register_adjudicator(Request $request,$game_id)
    {
        if (User::where('name',$request->name)->get()->count() > 0) {
            return redirect()->route('adjudicator.index',["game_id" => $game_id])->with('notice','此名稱已存在！');
        }
        $content = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ]);
        $content['password'] = Hash::make($content['password']);

        $user = User::factory()->create($content);
        $adjudicator = $user->adjudicator()->create();
        $this->store($adjudicator,$game_id);

        return redirect()->route('adjudicator.index',["game_id" => $game_id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($adjudicator,$game_id)
    {
        
        auth()->user()->games()->find($game_id)->adjudicators()->save($adjudicator);
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
    public function destroy($game_id,$id)
    {
        $adjudicator = adjudicator::find($id);
        
        auth()->user()->games()->find($game_id)->adjudicators()->find($adjudicator)->delete();
        return redirect()->route('adjudicator.index',["game_id" => $game_id]);
    }
}
