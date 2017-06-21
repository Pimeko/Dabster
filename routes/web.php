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

Route::get('/', function () {
    $usersController = new UsersController();

    return view('example', ['users' => $usersController->getUsers()]);
});

Route::get('example', 'PagesController@example');

Route::get('login', 'PagesController@login');
Route::post('login', 'UsersController@authenticate');

Route::get('logout', 'UsersController@logout');

Route::get('profile', 'UsersController@profile');

Route::get('register', function () {
    return view('register');
});
Route::post('register', 'UsersController@register');