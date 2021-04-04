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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::group(['prefix' => 'music'], function () {
    Route::get('list', 'MusicController@index')->name('music.index');
    Route::get('{id}', 'MusicController@show')->name('music.show');
});
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'music'], function () {
        Route::get('create', 'MusicController@create')->name('music.create');
        Route::post('store', 'MusicController@store')->name('music.store');
        Route::get('edit/{id}', 'MusicController@edit')->name('music.edit');
        Route::post('update/{id}', 'MusicController@update')->name('music.update');
        Route::get('download/{id}', 'MusicController@download')->name('music.download');
        Route::post('ajax/like', 'MusicController@ajaxLike')->name('music.ajaxlike');
        Route::delete('destroy/{id}', 'MusicController@destroy')->name('music.destroy');
    });
    Route::group(['prefix' => 'mypage'], function () {
        Route::get('', 'MypageController@edit')->name('mypage.edit');
        Route::patch('update', 'MypageController@update')->name('mypage.update');
        Route::get('password/change', 'MypageController@password')->name('mypage.password');
        Route::patch('password/change', 'MypageController@passwordChange')->name('mypage.password.change');
        Route::get('{id}', 'MypageController@show')->name('mypage.show');
    });
});