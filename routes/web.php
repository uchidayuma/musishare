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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'mypage'], function () {
        Route::get('', 'MypageController@edit')->name('mypage.edit');
        Route::patch('update', 'MypageController@update')->name('mypage.update');
        Route::get('password/change', 'MypageController@password')->name('mypage.password');
        Route::patch('password/change', 'MypageController@passwordChange')->name('mypage.password.change');
    });
});
