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
      if (!$request->user()) {
        return response()->json([
          'Fail' => 'Favorites could not be retrieved!',
          'error' => 'Unauthenticated : Missing Token'
        ]);
      }
      $recipe = new Recipe;

      $recipe->recipe_name = $request->recipe_name;
      $recipe->recipe_description = $request->recipe_description;
      $recipe->recipe_image = $request->recipe_image;
      $recipe->cooker_id = $request->user()->id;

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
        if (!$request->user()) {
          return response()->json([
            'Fail' => 'Favorites could not be retrieved!',
            'error' => 'Unauthenticated : Missing Token'
          ]);
        }
        $recipe = Recipe::find($id);

        $recipe->recipe_name = $request->recipe_name ? $request->recipe_name : $recipe->recipe_name;
        $recipe->recipe_description = $request->recipe_description ? $request->recipe_description : $recipe->recipe_description;
        $recipe->recipe_image = $request->recipe_image ? $request->recipe_image : $recipe->recipe_image;
        $recipe->cooker_id = $request->user()->id;

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

    public function PushImage(Request $request, $id)
    {

      $this->validate($request, [
          'input_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      ]);

      if ($request->hasFile('input_img')) {
          $image = $request->file('input_img');
          $name = $image->getClientOriginalName();
          $destinationPath = public_path('/images');
          $image->move($destinationPath, $name);
          DB::table('recipe_images')->insert(
              ['recipe_id' => $id, 'image' => $name]
          );
          return response()->json(['Success' => 'Image added to recipe successfully!']);
      }
      return response()->json(['Fail' => 'No image was provided']);
    }

    public function PushVideo($id)
    {

      $this->validate($request, [
          'input_video' => 'required|mimes:flv,mp4,m3u8,ts,3gp,mov,avi,wmv|max:102400',
      ]);

      if ($request->hasFile('input_video')) {
          $video = $request->file('input_video');
          $name = $video->getClientOriginalName();
          $destinationPath = public_path('/videos');
          $video->move($destinationPath, $name);

          $recipe = Recipe::find($id);
          $recipe->recipe_video = $name;
          $recipe->save();

          return response()->json(['Success' => 'Video added to recipe successfully!']);
      }
      return response()->json(['Fail' => 'No video was provided']);
    }

    public function RemoveImage($id)
    {
      DB::table('recipe_images')->where([['recipe_id', '=', $id], ['image', '=', $request->$image]])->delete();
      $destinationPath = public_path('/images').'/'.$request->$name;
      if (file_exists($destinationPath)) {
        unlink($destinationPath);
        return response()->json(['Success' => 'Image removed from recipe images successfully!']);
      }
      return response()->json(['Fail' => 'Image does not exist!']);
    }

    public function RemoveVideo($id)
    {
      $recipe = Recipe::find($id);
      $destinationPath = public_path('/videos').'/'.$recipe->recipe_video;
      if (file_exists($destinationPath)) {
        unlink($destinationPath);
        $recipe->recipe_video = "";
        $recipe->save();
        return response()->json(['Success' => 'Video removed from recipe successfully!']);
      }
      return response()->json(['Fail' => 'Video does not exist!']);
    }

}
