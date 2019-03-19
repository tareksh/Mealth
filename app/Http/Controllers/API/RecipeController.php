<?php

namespace App\Http\Controllers\API;

use App\Recipe;
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

    public function RecipeBest (Request $request)
    {
        $recipe =  Recipe::orderBy('recipe_rating','DESC')->get();
        return response()->json(['Recipe' => $recipe]);
    }

    public function PushFavorites(Request $request, $id)
    {
      if (!$request->user()) {
        return response()->json([
          'Fail' => 'Favorites could not be retrieved!',
          'error' => 'Unauthenticated : Missing Token'
        ]);
      }
      DB::table('recipe_box')->insert(
          ['recipe_id' => $id, 'user_id' => $request->user()->id]
      );
      return response()->json(['Success' => 'Recipe added to favorites successfully!']);
    }

    public function GetFavorites(Request $request)
    {
      if (!$request->user()) {
        return response()->json([
          'Fail' => 'Favorites could not be retrieved!',
          'error' => 'Unauthenticated : Missing Token'
        ]);
      }
      $ids = DB::table('recipe_box')->select('recipe_id')->where('user_id', '=', $request->user()->id)->get();
      $recipes = DB::table('recipes')->whereIn('id', $ids)->get();
      return response()->json([
        'Success' => 'Favorites retrieved successfully!',
        'Data' => $recipes
      ]);
    }


    public function RemoveFavorites(Request $request, $id)
    {
      if (!$request->user()) {
        return response()->json([
          'Fail' => 'Favorites could not be retrieved!',
          'error' => 'Unauthenticated : Missing Token'
        ]);
      }
      DB::table('recipe_box')->where([['recipe_id', '=', $id], ['user_id', '=', $request->user()->id]])->delete();
      return response()->json(['Success' => 'Recipe removed from favorites successfully!']);
    }
}
