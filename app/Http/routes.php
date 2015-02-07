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

Route::get('me', 'ProfileController@showCurrentUser');
Route::get('profile/{user}', 'ProfileController@showUser');

Route::get('messages', 'MessagesController@index');

Route::get('family', 'FamilyController@index');

Route::group(['prefix' => 'forum'], function()
{
	Route::get('/', 'ForumController@index');
	Route::get('start-discussion', 'ForumController@create');
	Route::post('start-discussion', 'ForumController@store');
	Route::get('{category}', 'ForumController@category');
	Route::get('{category}/{thread}', 'ForumController@thread');
	Route::post('{category}/{thread}', 'ForumController@addReply');
	Route::get('{category}/{thread}/edit', 'ForumController@edit');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
