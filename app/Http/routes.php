<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('forum', 'ForumController@index');
Route::get('forum/start-discussion', 'ForumController@create');
Route::post('forum/start-discussion', 'ForumController@store');
Route::get('forum/{category}', 'ForumController@category');
Route::get('forum/{category}/{thread}', 'ForumController@thread');
Route::get('forum/{category}/{thread}/edit', 'ForumController@edit');



Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
