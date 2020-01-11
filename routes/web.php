<?php

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads', 'ThreadController@index')->name('threads');
Route::get('/threads/{thread}', 'ThreadController@show');
Route::post('/threads/{thread}/replies', 'ReplyController@store');
Route::post('/threads', 'ThreadController@store');
