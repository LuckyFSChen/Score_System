<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class adjudicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function games(){
        return $this->belongsToMany('App\Models\game');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function scores(){
        return $this->hasMany('App\Models\game_score');
    }
}
