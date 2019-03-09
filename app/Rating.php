<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
         'rating_value',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
