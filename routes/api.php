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


Route::get('/users',                    'UsersController@getUsers');
Route::get('/users/{user}',             'UsersController@getUser');
Route::post('/users',                   'UsersController@register');
Route::post('/login',                   'UsersController@authenticate');

Route::get('/users/{user}/posts',       'UserPostsController@getPosts');
Route::post('/users/{user}/posts',      'UserPostsController@addPost');
