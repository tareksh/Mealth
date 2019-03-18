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
Route::put('user-edit-myprofile','API\UserController@EditMyProfile')->middleware('auth:api');
Route::put('user-edit-myprofile-image','API\UserController@EditMyProfileImage')->middleware('auth:api');

Route::get('user-get-myprofile','API\UserController@GetMyProfile')->middleware('auth:api');






/* Cooker Api */
Route::resource('cooker', 'API\CookerController', array('only' => array('index')));
Route::get('cooker-best','API\CookerController@BestCooker');
Route::get('cooker-filter','API\CookerController@CookerFiler');


/* Recipe Api */
Route::Post('recipe-filter','API\RecipeController@RecipeFilter');
Route::post('recipe-activate','API\RecipeController@RecipeActivate');
Route::get('recipe-best','API\RecipeController@BestRecipe');
Route::get('recipe-all-info/{id}','API\RecipeController@RecipeWithAllInfo');
Route::resource('recipe', 'API\RecipeController');


/*Ingredients Api */
Route::resource('ingredients', 'API\IngredientsController');


/*Raw Material Api */
Route::resource('raw-material', 'API\RawMaterialController');

/*Raw Material Price Api */
Route::resource('raw-material-price', 'API\RawMaterialPriceController');











