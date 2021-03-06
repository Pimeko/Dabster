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
use Illuminate\Http\Request;
use App\Http\Controllers\UsersController;

Route::get('/', 'PagesController@home');
Route::get('posts/{postId}', 'UserPostsController@get');

Route::group(['middleware' => 'notconnected'], function () {
    Route::get('login', 'PagesController@login');
    Route::post('login', 'UsersController@authenticate');

    Route::get('register', 'PagesController@register');
    Route::post('register', 'UsersController@register');
});

Route::get('404', function () {
    return view('404');
});

Route::group(['middleware' => 'validjwt'], function () {
    Route::get('logout',                         'UsersController@logout');
    Route::get('signout',                        'PagesController@signout');
    Route::post('signout',                       'UsersController@signout');

    // users
    Route::get('users/{userId}',                'UsersController@profilePosts');
    Route::get('users/{userId}/posts',          'UsersController@profilePosts');
    Route::get('users/{userId}/likes',          'UsersController@profileLikes');
    Route::get('users/{userId}/followings',     'UsersController@profileFollowings');
    Route::get('users/{userId}/followers',      'UsersController@profileFollowers');

    // posts
    Route::post('/posts/{postId}/likes',        'UserLikesController@changeLike');
    Route::post('/posts/{post}/comments',       'UserCommentsController@add');
    Route::delete('/posts/{postId}',            'UserPostsController@remove');
    Route::delete('/comments/{commentId}',      'UserCommentsController@remove');
    Route::post('/users/{userId}/followings',   'UserUserController@follow'); // user follows "followed"

    // feeds
    Route::get('trending',                      'UserPostsController@trending');
    Route::get('recent',                        'UserPostsController@recent');
    Route::get('random',                        'UserPostsController@random');

    Route::get('upload',                        'UserPostsController@uploadPage');
    Route::post('upload',                       'UserPostsController@upload');

    Route::group(['middleware' => 'correctuser'], function () {
        Route::get('users/{userId}/edit',           'UsersController@profileEdit');
        Route::put('users/{userId}/edit',           'UsersController@updateProfile');
        Route::get('users/{userId}/feed',           'UsersController@feed');
        Route::post('/users/{userId}/posts',        'UserPostsController@addPost');
    });
});
