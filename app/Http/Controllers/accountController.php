<?php

namespace App\Http\Controllers;

use App\Models\adjudicator;
use App\Models\game;
use App\Models\score_title;
use Illuminate\Http\Request;

class accountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('account.account_manage');
    }
}
