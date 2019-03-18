<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeRating extends Model
{
    protected $fillable = ['recipe_id','user_id','rank_value'];
}
