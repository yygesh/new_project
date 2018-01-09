<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', 'AuthController@loginForm')->name('login');
Route::POST('/login', 'AuthController@login')->name('login');
Route::GET('/register', 'AuthController@registerForm')->name('register');
Route::POST('/register', 'AuthController@register')->name('register');
Route::GET('/passwordChange', 'AuthController@showResetForm');
Route::POST('/resetPassword', array('as' => 'user.reset', 'uses' => 'AuthController@reset'));
Route::POST('/logout', 'AuthController@logout')->name('logout');

