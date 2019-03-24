<?php

namespace App\Http\Controllers\API;

use App\FoodSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if (!$request->user()) {
        return response()->json([
          'Fail' => 'Food schedule could not be created!',
          'error' => 'Unauthenticated : Missing Token'
        ]);
      }
      $schedule = new FoodSchedule;
      $schedule->user_id = $request->user_id;
      $schedule->title = $request->title;
      $schedule->start_time = $request->start_time;
      $schedule->duration = $request->duration;
      $schedule->calories = $request->calories;
      $schedule->price = $request->price;
      $schedule->privacy = $request->privacy;
      $schedule->kind = $request->kind;
      $schedule->meals = $request->meals;
      $schedule->save();
      $this->build($schedule);
    }

    /**
     * Build the actual food shcedule
     *
     * @param  FoodSchedule $schedule
     * @return \Illuminate\Http\Response
     */
    public function build(FoodSchedule $schedule)
    {
      $daily_intake = ($schedule->calories / $schedule->duration);
      $meals = strtolower($schedule->meals);
      if (strpos($meals, 'breakfast') !== false) {
        $breakfast_intake = $daily_intake * (2/5); // considering breakfast is 40% of daily intake
        if ($breakfast_intake > 950 || $breakfast_intake < 150) {
          // breakfast must not exceed a limit of 950 calories
          // neither subceed a limit of 150 calories
          return response()->json([
            'Fail' => 'Schedule could not be built!',
            'error' => 'Breakfast calorie limit : calorie limit exceeded or subceeded'
          ]);
        }
        $recipes = $this->hit_query($schedule->kind, 'breakfast', $breakfast_intake);
        fill_schedule($recipes, $schedule->id, $schedule->duration);
      }
      if (strpos($meals, 'lunch') !== false) {
        $lunch_intake = $daily_intake * (7/20); // considering lunch is 35% of daily intake
        if ($lunch_intake > 950 || $lunch_intake < 150) {
          // luch must not exceed a limit of 950 calories
          // neither subceed a limit of 150 calories
          return response()->json([
            'Fail' => 'Schedule could not be built!',
            'error' => 'Lunch calorie limit : calorie limit exceeded or subceeded'
          ]);
        }
        $recipes = $this->hit_query($schedule->kind, 'lunch', $lunch_intake);
        fill_schedule($recipes, $schedule->id, $schedule->duration);
      }
      if (strpos($meals, 'dinner') !== false) {
        $dinner_intake = $daily_intake * (1/4); // considering dinner is 25% of daily intake
        if ($dinner_intake > 700 || $dinner_intake < 150) {
          // dinner must not exceed a limit of 700 calories
          // neither subceed a limit of 150 calories
          return response()->json([
            'Fail' => 'Schedule could not be built!',
            'error' => 'Dinner calorie limit : calorie limit exceeded or subceeded'
          ]);
        }
        $recipes = $this->hit_query($schedule->kind, 'dinner', $dinner_intake);
        fill_schedule($recipes, $schedule->id, $schedule->duration);
      }
      if (strpos($meals, 'snack') !== false) {
        $snack_intake = $daily_intake * (1/10); // considering snacks are 10% of daily intake
        if ($snack_intake > 250) {
          // snacks must not exceed a limit of 250 calories
          return response()->json([
            'Fail' => 'Schedule could not be built!',
            'error' => 'Snack calorie limit : calorie limit exceeded or subceeded'
          ]);
        }
        $recipes = $this->hit_query($schedule->kind, 'snack', $snack_intake);
        fill_schedule($recipes, $schedule->id, $schedule->duration);
      }
      // Schedule is built successfully
      return response()->json([
        'Success' => 'Food schedule built successfully!',
        'Data' => $schedule
      ]);
    }

    /**
     * builds the actual query to get the meals regarding conditions
     *
     * @param  string  $kind
     * @param  string  $meal
     * @param  int  $calories
     * @return array App\Recipe
     */
    public function hit_query($kind, $meal, $calories)
    {
        $top_limit = 0;
        $bottom_limit = 0;
        if (!strcmp($kind, 'reducing')) {
          $top_limit = $calories + 25;
          $bottom_limit = $calories - 100;
        } elseif (!strcmp($kind, 'preserving')) {
          $top_limit = $calories + 25;
          $bottom_limit = $calories - 25;
        } elseif (!strcmp($kind, 'incresing')) {
          $top_limit = $calories + 100;
          $bottom_limit = $calories - 25;
        }
        return DB::table('recipe')
        ->where('recipe_kind', $kind)
        ->whereBetween('recipe_calories', array($bottom_limit, $top_limit))
        ->get();
    }

    /**
     * fills the recipes in the table
     *
     * @param  array  $recipes
     * @param  int  $schedule_id
     * @param  int  $schedule_duration
     * @return \Illuminate\Http\Response
     */
    public function fill_schedule($recipes, $schedule_id, $schedule_duration)
    {
      $j = 0;
      for ($i = 0; $i < $schedule_duration; ++$i) {
        if (!($i < sizeof($recipes))) {
          $j = 0;
        }
        $recipe_id = $recipes[$j]->id;
        DB::table('schedules')->insert(
            ['food_schedule_id' => $schedule_id, 'recipe_id' => $recipe_id]
        );
        $j++;
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
