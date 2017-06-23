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

Route::get('login', function () {
    return view('login');
});
Route::post('login', 'UsersController@authenticate');

Route::get('logout', 'UsersController@logout');

Route::group(['middleware' => 'validjwt'], function () {
    Route::get('users/{userId}/{page}', 'UsersController@profile');
    Route::post('users/{userId}/edit', 'UsersController@edit');
});

Route::get('register', function () {
    return view('register');
});
Route::post('register', 'UsersController@register');