<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages.login');
})->name('home');

Route::group([
    'as' => 'register.',
    'prefix' => '/register'
], function() {
    Route::get('', 'RegisterController@create')->name('index');
    Route::post('', 'RegisterController@store')->name('store');
});

Route::group([
    'as' => 'login.',
    'prefix' => '/login'
], function() {
    Route::get('', 'SessionsController@create')->name('index');
    Route::post('', 'SessionsController@store')->name('store');
});

Route::get('/logout', 'SessionsController@destroy')->name('logout');
