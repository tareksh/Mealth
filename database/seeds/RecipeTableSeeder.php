<?php

use Illuminate\Database\Seeder;
use App\Recipe;

class RecipeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recipe = new Recipe();
         $recipe->recipe_name = "shakriah1";
         $recipe->recipe_description = "this is a healthy recipe";
         $recipe->recipe_kind = "breakfast";
         $recipe->recipe_video="c";
         $recipe->recipe_calories = 40;
         $recipe->preparation_time =5;
         $recipe->cooker_id = 1;
         $recipe->save();


        $recipe = new Recipe();
        $recipe->recipe_name = "shakriah2";
        $recipe->recipe_description = "this is a healthy recipe";
        $recipe->recipe_kind = "breakfast";
        $recipe->recipe_video="c";
        $recipe->recipe_calories = 20;
        $recipe->preparation_time =5;
        $recipe->cooker_id = 1;
        $recipe->save();

        $recipe = new Recipe();
        $recipe->recipe_name = "shakriah3";
        $recipe->recipe_description = "this is a healthy recipe";
        $recipe->recipe_kind = "breakfast";
        $recipe->recipe_video="c";
        $recipe->recipe_calories = 10;
        $recipe->recipe_rating = 50;
        $recipe->preparation_time =10;
        $recipe->cooker_id = 3;
        $recipe->save();

        $recipe = new Recipe();
        $recipe->recipe_name = "shakriah4";
        $recipe->recipe_description = "this is a healthy recipe";
        $recipe->recipe_kind = "breakfast";
        $recipe->recipe_video="c";
        $recipe->recipe_calories = 30;
        $recipe->recipe_rating = 30;
        $recipe->preparation_time =15;
        $recipe->cooker_id = 1;
        $recipe->save();


        $recipe = new Recipe();
        $recipe->recipe_name = "shakriah5";
        $recipe->recipe_description = "this is a healthy recipe";
        $recipe->recipe_kind = "breakfast";
        $recipe->recipe_video="c";
        $recipe->recipe_calories = 30;
        $recipe->recipe_rating = 40;
        $recipe->preparation_time =15;
        $recipe->cooker_id = 1;
        $recipe->save();
    }
}
