<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class game extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','adjudciator_games_id'
    ];

    public static function find($game_id)
    {
    }

    public function teams() {
        return $this->hasMany('App\Models\team');
    }

    public function adjudicators()
    {
        return $this->belongsToMany('App\Models\adjudicator');
    }

    public function team_details_titles(){
        return $this->hasMany('App\Models\team_details_title');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function score_titles(){
        return $this->hasMany('App\Models\score_title');
    }

}
