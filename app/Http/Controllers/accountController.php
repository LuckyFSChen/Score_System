<?php

namespace App\Http\Controllers;

use App\Models\adjudicator;
use App\Models\game;
use App\Models\score_title;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\adjudicator_game;

class accountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $users = User::where('identity_id' ,'!=',1)->get();

        return view('account.account_manage',['users' => $users]);
    }
    public function edit_page($id)
    {
        $user = User::find($id);

        return view('account.edit',['id' => $id,'user'=>$user]);
    }
    public function edit(Request $request,$id)
    {
        $user = User::find($id);
        if($user->identity_id != 1){
            $content = $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255'],
             ]);
            $user->update($content);
        }
        

        return redirect()->route("account");
    }

    public function destroy($id){
        $user = User::find($id);
        if($user->identity_id != 1){
            if($user->identity_id === 3){
                adjudicator_game::where([
                    ['adjudicator_id',$user->adjudicator()->first()->id],
                ])->delete();
            }
            $user->Delete();
        }
        
        return redirect()->route('account');
    }
}
