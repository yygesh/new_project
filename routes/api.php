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
Route::group(['namespace' => 'Api'], function() {
	Route::POST('/login', array('as' => 'user.login', 'uses' => 'LoginController@login'));
	Route::POST('/register', array('as' => 'user.register', 'uses' => 'RegisterController@register'));
	Route::PUT('/reset', array('as' => 'user.reset', 'uses' => 'ResetPasswordController@reset'));
});