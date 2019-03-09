<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'comment'
    ];
    public function user()
    {
        return $this->belongsToMany('App\User');
    }

    public function recipe()
    {
        return $this->belongsToMany('App\Recipe');
    }
}
