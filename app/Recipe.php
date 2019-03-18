<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';
    protected $fillable = [
        'recipe_name', 'recipe_description', 'recipe_image',
    ];

    public function cooker()
    {
        return $this->belongsTo('App\User','cooker_id');
    }

}
