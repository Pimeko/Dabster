<?php

use Illuminate\Http\Request;

// NOTE : A PUT Request is a POST Request with _method = PUT in the body

Route::get('/users',                        'UsersController@getUsers');
Route::get('/users/{user}',                 'UsersController@getUser');
Route::post('/users',                       'UsersController@register');

Route::post('/login',                       'UsersController@authenticate');

Route::get('/users/{user}/posts',           'UserPostsController@getPosts');
Route::get('/users/{user}/followings',      'UserUserController@showFollowings'); // Show users followed by "user"
Route::get('/users/{user}/followers',       'UserUserController@showFollowers');

// Must be connected
Route::group(['middleware' => 'validjwt'], function () {
    // Must be a specific user
    Route::group(['middleware' => 'correctuser'], function () {
        Route::post('/users/{user}/posts',                  'UserPostsController@addPost');
        Route::post('/posts/{post}/comments',               'UserCommentsController@addComment');

        Route::post('/posts/{post}/likes',                  'UserLikesController@changeLike');
        Route::put('/posts/{post}/likes',                   'UserLikesController@changeLike');
        Route::delete('/posts/{post}/likes',                'UserLikesController@changeLike');

        Route::post('/users/{user}/followings',             'UserUserController@follow'); // user follows "followed"
    });
});



