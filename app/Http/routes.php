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

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::get('me', 'ProfileController@showCurrentUser');
Route::get('profile/{user}', 'ProfileController@showUser');
Route::get('family', 'FamilyController@index');

/*
|--------------------------------------------------------------------------
| Messages Routes
|--------------------------------------------------------------------------
*/
Route::get('messages', 'MessagesController@index');




/*
|--------------------------------------------------------------------------
| Forum Routes
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::controllers([
	'password' => 'Auth\PasswordController',
]);
