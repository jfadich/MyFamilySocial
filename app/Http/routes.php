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
Event::listen("illuminate.query", function($query, $bindings, $time, $name){
    \Log::info($query." | ".json_encode($bindings));
    //\Log::info(json_encode($bindings)."\n");
});

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
| Tag Routes
|--------------------------------------------------------------------------
*/
Route::get('tags/search/', 'TagsController@search');

/*
|--------------------------------------------------------------------------
| Forum Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'forum'], function()
{
	//Create Threads
	Route::get('topic/create', 'ForumController@create');
	Route::post('topic', 'ForumController@store');

	// List threads
	Route::get('/', 'ForumController@index');
	Route::get('category/{category}', 'ForumController@threadsInCategory');
	Route::get('topic/{thread}', 'ForumController@showThread');

	//Edit threads
	Route::get('topic/{thread}/edit', 'ForumController@edit');
	Route::patch('topic/{thread}', 'ForumController@update');
	Route::post('topic/{thread}', 'ForumController@addReply');

	Route::get('categories', 'CategoryController@index');
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
