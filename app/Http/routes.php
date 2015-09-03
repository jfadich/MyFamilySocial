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

Route::get( 'activities', 'ActivitiesController@index' );

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'users'], function() {
    Route::get( '/', 'UsersController@index' );
    Route::get( '~', 'UsersController@showCurrentUser' );
    Route::get( '{user}', 'UsersController@showUser' );
    Route::get( '{user}/edit', 'UsersController@edit' );
    Route::patch( '{user}', 'UsersController@update' );
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
    Route::get( '/', 'PhotosController@index' );
    Route::post( '/', 'PhotosController@store' );
    Route::patch( '{photo}', 'PhotosController@update' );
    Route::get( '{type}/{id}', 'PhotosController@showBy' );
    Route::get( '{photo}', 'PhotosController@show' );
    Route::post( '{photo}', 'PhotosController@addReply' );
});

Route::group(['prefix' => 'albums'], function() {
    Route::get( '/', 'AlbumsController@index' );
    Route::post( '/', 'AlbumsController@store' );
    Route::patch( '{album}', 'AlbumsController@update' );
    Route::get( '{album}', 'AlbumsController@show' );
    Route::get( '{album}/download', 'AlbumsController@download' );
});

// Route to get raw images
Route::get( 'images/{size}/{file}', 'PhotosController@showPhoto' );

/*
|--------------------------------------------------------------------------
| Tag Routes
|--------------------------------------------------------------------------
*/
Route::get('tags/search/', 'TagsController@search');
Route::get( 'tags/{tag}', 'TagsController@show' );
Route::get( 'tags/{tag}/threads', 'TagsController@listThreads' );
/*
|--------------------------------------------------------------------------
| Forum Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'forum'], function()
{
	//Create Resources
	Route::post('topic', 'ForumController@store');
    Route::post('topic/{thread}', 'ForumController@addReply');

    // List threads
    Route::get('/', 'ForumController@index');
    Route::get('topic/{thread}', 'ForumController@showThread');
    Route::get('categories/{category}', 'CategoriesController@show');

    //Edit threads
    Route::patch('topic/{thread}', 'ForumController@update');

    Route::get('categories', 'CategoriesController@index');
});

Route::get( 'comments/{type}/{id}', 'CommentsController@showBy' );
Route::post( 'comments/{type}/{id}', 'CommentsController@showBy' );
Route::get('comments/{comment}', 'CommentsController@show');
Route::post( 'comments/', 'CommentsController@store' );
Route::delete('comments/{comment}', 'CommentsController@destroy');
Route::patch('comments/{comment}', 'CommentsController@update');
/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::post('auth/register', 'Auth\AuthController@register');
Route::post('auth/login', 'Auth\AuthController@authenticate');
Route::post('auth/refresh', 'Auth\AuthController@refresh');

Route::get( 'roles', 'RolesController@index' );

Route::controllers([
	'password' => 'Auth\PasswordController',
]);

/*
|--------------------------------------------------------------------------
| Debug Routes
|--------------------------------------------------------------------------
*/
Route::group( [ 'prefix' => 'debug' ], function () {
    Route::controller( 'db', '\MyFamily\DBLogger\Http\DatabaseLogController' );
} );