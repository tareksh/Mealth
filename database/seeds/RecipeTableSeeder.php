<?php

use Illuminate\Database\Seeder;

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
         $recipe->recipe_name = "shakriah";
         $recipe->recipe_description = "this is a healthy recipe";
         $recipe->save();
    }
}
