<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 'recipe';
    protected $fillable = [
<<<<<<< HEAD
        'recipe_name', 'recipe_description', 'recipe_image','recipe_kind',
        'recipe_video','recipe_calories','preparation_time','cooker_id'
=======
        'recipe_name', 'recipe_description', 'recipe_image', 'cooker_id',
>>>>>>> 9fb421c394f0531f044cd3224c3863fc5ade29c7
    ];


    public function cooker()
    {
        return $this->belongsTo('App\User','cooker_id');
    }

}
