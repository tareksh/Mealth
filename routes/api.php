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
Route::get('country','API\CountryController@GetAllCountry');
Route::get('country/{id}','API\CountryController@GetCountry');
Route::post('country','API\CountryController@InsertCountry');
Route::post('country/{id}','API\CountryController@UpdateCountry');
Route::delete('country/{id}','API\CountryController@DeleteCountry');
Route::post('country-filter','API\CountryController@Country_Filter');


/* slider Api */

Route::get('slider-image','API\SliderController@GetAllImage');
Route::get('slider-image/{id}','API\SliderController@GetImage');
Route::post('slider-image','API\SliderController@InsertImage');
Route::post('slider-image/{id}','API\SliderController@EditImage');
Route::delete('slider-image/{id}','API\SliderController@DeleteImage');


/* user Api */

Route::post('user-filter','API\UserController@UserFilter');






//Route::post('shit', 'API\UserController@authenticate');




