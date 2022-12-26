<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adjudicator_team extends Model
{
    use HasFactory;

    protected $table = 'adjudicator_team';

    protected $fillable = ['game_id','adjudicator_id','team_id'];

    public function game(){
        return $this->belongsTo('App\Models\team');
    }
    public function adjudicator(){
        return $this->belongsToMany('App\Models\adjudicator');
    }
    public function team(){
        return $this->belongsToMany('App\Models\team');
    }
}
