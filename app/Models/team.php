<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    use HasFactory;

    public function game(){
        return $this->belongsTo('App\Models\game');
    }



    public function team_details_datas(){
        return $this->hasMany('App\Models\team_details_data');
    }
}
