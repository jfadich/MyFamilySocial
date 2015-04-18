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

Route::get( 'home', 'ActivitiesController@index' );


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'users'], function() {
    Route::get( '/', 'UsersController@index' );
    Route::get( 'me', 'UsersController@showCurrentUser' );
    Route::get( '{user}', 'UsersController@showUser' );
    Route::get( '{user}/edit', 'UsersController@edit' );
    Route::put( '{user}', 'UsersController@update' );
});

/*
|--------------------------------------------------------------------------
| Messages Routes
|--------------------------------------------------------------------------
*/
Route::get('messages', 'MessagesController@index');

/*
|--------------------------------------------------------------------------
| Photos Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'photos'], function() {
    Route::get( '/', 'AlbumsController@index' );
    Route::post( '/', 'PhotosController@store' );
    Route::patch( '{photo}', 'PhotosController@update' );
    Route::get( '{photo}/edit', 'PhotosController@edit' );
    Route::get( '{photo}', 'PhotosController@show' );
    Route::put( '{photo}', 'PhotosController@addReply' );
});

Route::get( 'album/create', 'AlbumsController@create' );
Route::post( 'album', 'AlbumsController@store' );
Route::get( 'album/{album}/edit', 'AlbumsController@edit' );
Route::patch( 'album/{album}', 'AlbumsController@update' );
Route::get( 'album/{album}', 'AlbumsController@show' );


// Route to get raw images
Route::get( 'images/{size}/{file}', 'PhotosController@showPhoto' );

/*
|--------------------------------------------------------------------------
| Tag Routes
|--------------------------------------------------------------------------
*/
Route::get('tags/search/', 'TagsController@search');
Route::get( 'tags/{show}', 'TagsController@show' );

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
    Route::get('tags/{tag}', 'ForumController@threadsByTag');

	//Edit threads
	Route::get('topic/{thread}/edit', 'ForumController@edit');
	Route::patch('topic/{thread}', 'ForumController@update');
	Route::post('topic/{thread}', 'ForumController@addReply');

    //Route::get('categories', 'CategoryController@index');
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
