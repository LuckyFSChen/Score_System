<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class score_title extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name','percentage','user_id'
    ];

    public function game(){
        return $this->belongsTo('App\Models\game');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
