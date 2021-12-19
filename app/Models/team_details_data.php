<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class team_details_data extends Model
{
    use HasFactory;

    public function team(){
        return $this->belongsTo('App\Models\team');
    }
}
