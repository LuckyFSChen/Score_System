<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adjudicator_game extends Model
{
    use HasFactory;

    protected $table = 'adjudicator_game';

    public function game(){
        return $this->belongsTo('App\Models\game');
    }
    public function adjudicator(){
        return $this->belongsToMany('App\Models\adjudicator');
    }
}
