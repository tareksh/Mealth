<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'recipe_id',
        'description',
        'raw_material_id',
        'amount',
    ];
}
