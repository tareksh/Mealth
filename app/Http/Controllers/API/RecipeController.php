<?php

namespace App\Http\Controllers\API;

use App\Ingredients;
use App\Recipe;
use App\RecipeImage;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RecipeController extends Controller
{

    public function index()
    {
        $recipe =  Recipe::All();
        return response()->json(['Recipe' => $recipe]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
      $recipe = new Recipe;

      $recipe->recipe_name = $request->recipe_name;
      $recipe->recipe_description = $request->recipe_description;
      $recipe->recipe_image = $request->recipe_image;
      $recipe->cooker_id = $request->cooker_id;

      $recipe->save();
      return response()->json(['Success' => 'Recipe created successfully!']);
    }

    public function show($id)
    {
        $recipe =  Recipe::where('id',$id)->get();
        return response()->json(['Recipe' => $recipe]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);

        $recipe->recipe_name = $request->recipe_name ? $request->recipe_name : $recipe->recipe_name;
        $recipe->recipe_description = $request->recipe_description ? $request->recipe_description : $recipe->recipe_description;
        $recipe->recipe_image = $request->recipe_image ? $request->recipe_image : $recipe->recipe_image;
        $recipe->cooker_id = $request->cooker_id ? $request->cooker_id : $recipe->cooker_id;

        $recipe->save();
        return response()->json(['Success' => 'Recipe updated successfully!']);
    }

    public function destroy($id)
    {
        //
    }

    public function RecipeFilter(Request $request)
    {
        $where = [];

        $newCompete =   ['recipe.active','=',1];
        array_push($where, $newCompete);
        if(isset($request['recipe_name']) )
        {
            $newCompete =   ['recipe_name', 'like','%'.$request['recipe_name'].'%'];
            array_push($where, $newCompete);
        }

        if(isset($request['recipe_kind']))
        {
            $newCompete =   ['recipe_kind','=',$request['recipe_kind']];
            array_push($where, $newCompete);
        }

        if(isset($request['user_count']) )
        {
            $newCompete =   ['user_count','=',$request['user_count']];
            array_push($where, $newCompete);
        }

        if(isset($request['recipe_calories']) )
        {
            $newCompete =  ['recipe_calories','<=',$request['recipe_calories']];
            array_push($where, $newCompete);
        }

        if(isset($request['preparation_time']) )
        {
            print($request['preparation_time']);
            $newCompete =   ['preparation_time','<=',$request['preparation_time']];
            array_push($where, $newCompete);
        }

        if(isset($request['season']) )
        {
            $newCompete =   ['season','=',$request['season']];
            array_push($where, $newCompete);
        }

        if(isset($request['views']) )
        {

            $newCompete =   ['views','>=',$request['views']];
            array_push($where, $newCompete);
        }

        if(isset($request['users_name']) )
        {
            $newCompete =   ['users.name','like','%'.$request['users_name'].'%'];
            array_push($where, $newCompete);
        }

        if(isset($request['from']) )
        {
            $newCompete =   ['recipe.created_at','>=',$request['from']];
            array_push($where, $newCompete);
        }

        if(isset($request['to']) )
        {

            $newCompete =   ['recipe.created_at','<=',$request['to']];
            array_push($where, $newCompete);
        }

        $select =[
            'recipe_name',
            'recipe_description',
            'recipe_video',
            'recipe_kind',
            'recipe_calories',
            'preparation_time',
            'season',
            'views',
            'user_count',
            'recipe.created_at',
            'users.name'
        ];


        $recipe =  Recipe::join('users', 'recipe.cooker_id', '=', 'users.id')->select($select)->where($where)->get();
        return response()->json(['Recipe' => $recipe]);
    }

    public function RecipeActivate (Request $request)
    {
        $user =  Recipe::where('id',$request['id'])->update
        ([
            'active' => $request['active'],

        ]);
    }

    public function BestRecipe (Request $request)
    {
        $recipe =  Recipe::orderBy('recipe_rating','DESC')->get();
        return response()->json(['Recipe' => $recipe]);
    }

    public function RecipeWithAllInfo($id)
    {
        $Recipe = Recipe::where('id','=',$id)->first();
        $ingredients =  Ingredients::where('recipe_id','=',$id)->get();
        $recipe_image = RecipeImage::where('recipe_id','=',$id)->get();
        $user = User::where('id','=',$Recipe['cooker_id'])->get();

        $array =[];
        array_push($array, $Recipe);
        array_push($array, $ingredients);
        array_push($array, $recipe_image);
        array_push($array, $user);

        return response()->json(['Recipe' => $array]);


    }

    public function RecipeComments($id)
    {
        $comment = Comment::join('users', 'user_id', '=', 'users.id')->where('recipe_id','=',$id)->get();
        return response()->json(['Comment' => $comment]);
    }

    public function push_favorites(Request $request, $id)
    {
      DB::table('recipe_box')->insert(
          ['recipe_id' => $id, 'user_id' => $request->user()->id]
      );
      return response()->json(['Success' => 'Recipe added to favorites successfully!']);
    }

    public function get_favorites($request)
    {
      $ids = DB::table('recipe_box')->select('recipe_id')->where('user_id', '=', $request->user()->id)->get();
      $recipes = DB::table('recipes')->whereIn('id', $ids)->get();
      return response()->json([
        'Success' => 'Favorites retrieved successfully!',
        'Data' => $recipes
      ]);
    }


}
