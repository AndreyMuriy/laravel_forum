<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Threads
Route::resource('/threads', 'ThreadController')->except('show');
Route::get('/threads/{channel}', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::post('/replies/{reply}/favorites', 'FavoriteController@store');
