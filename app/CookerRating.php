<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CookerRating extends Model
{
    protected $fillable = [
        'user_id',
        'cooker_id',
        'rating_value',
        'description',

    ];
}
