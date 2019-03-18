<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@login');


Route::group(['middleware' => ['auth:api']], function() {


    Route::get('details',
        [
            'uses' => 'API\UserController@details',
            'middleware' => 'roles',
            'roles' => ['Admin']
        ]);


});

Route::get('test','API\UserController@test');

/* country Api */

Route::resource('countries','API\CountryController'/*, array('only' => array('show','index','destroy','update','create'))*/);
Route::get('country/{id}','API\CountryController@GetCountry');
Route::get('country','API\CountryController@GetAllCountry');
Route::post('country-filter','API\CountryController@Country_Filter');


/* slider Api */

Route::get('slider-image','API\SliderController@GetAllImage');
Route::get('slider-image/{id}','API\SliderController@GetImage');
Route::post('slider-image','API\SliderController@InsertImage');
Route::post('slider-image/{id}','API\SliderController@EditImage');
Route::delete('slider-image/{id}','API\SliderController@DeleteImage');


/* user Api */

Route::post('user-filter','API\UserController@UserFilter');
Route::post('user-activate','API\UserController@UserActivate');





/* Cooker Api */
Route::resource('cooker', 'API\CookerController', array('only' => array('index')));



/* Recipe Api */
Route::Post('recipe-filter','API\RecipeController@RecipeFilter');
Route::post('recipe-activate','API\RecipeController@RecipeActivate');
Route::get('recipe-best','API\RecipeController@RecipeBest');
Route::resource('recipe', 'API\RecipeController');
Route::post('recipe/favorites/{id}', 'API\RecipeController@push_favorites');
Route::delete('recipe/favorites/{id}', 'API\RecipeController@remove_favorites');
Route::get('recipe/favorites', 'API\RecipeController@get_favorites');
/*Ingredients Api */
Route::resource('ingredients', 'API\IngredientsController');


/*Raw Material Api */
Route::resource('raw-material', 'API\RawMaterialController');

/*Raw Material Price Api */
Route::resource('raw-material-price', 'API\RawMaterialPriceController');
