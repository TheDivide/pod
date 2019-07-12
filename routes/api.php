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

// sign up,registration etc request routes...

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

    });
});

// Password reset link request routes...

Route::group(['namespace' => 'Auth', 'middleware' => 'api', 'prefix' => 'password'], function () {
    Route::post('create', ['as'=>'password.reset.create','uses'=>'ResetPasswordController@create']);
    Route::get('find/{token}', ['as'=>'password.reset.find','uses'=>'ResetPasswordController@find']);
    Route::post('reset', ['as'=>'password.reset','uses'=>'ResetPasswordController@rest']);

});

// API CRUD request routes...

Route::group(['prefix' => 'v1','middleware' => 'auth:api'], function () {

    Route::apiResource('users', 'UserController');
    Route::apiResource('properties', 'PropertiesController');
   
   
});
