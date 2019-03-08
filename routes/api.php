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

    Route::get('test','API\UserController@test');
});







//Route::post('shit', 'API\UserController@authenticate');




