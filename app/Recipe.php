<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';
    protected $fillable = [
        'recipe_name', 'recipe_description', 'recipe_image','recipe_kind',
        'recipe_video','recipe_calories','preparation_time','cooker_id'

    ];


    public function cooker()
    {
        return $this->belongsTo('App\User','cooker_id');
    }

}
