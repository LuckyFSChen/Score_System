<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class team_details_data extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id','content','team_details_title_id'
    ];

    public function team_details_title(){
        return $this->belongsTo('\App\Models\team_details_title');
    }

    public function team(){
        return $this->belongsTo('App\Models\team');
    }
}
