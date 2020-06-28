<?php

Auth::routes(['verify' => true]);

Route::get('/me', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

// Threads
Route::resource('/threads', 'ThreadController')->only('index', 'create', 'destroy');
Route::post('/threads', 'ThreadController@store')->name('threads.store')->middleware('verified');
Route::get('/threads/{channel}', 'ThreadController@index');
Route::patch('/threads/{channel}/{thread}', 'ThreadController@update')->name('threads.update');
Route::post('locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::delete('/threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy')->middleware('auth');

// Best Reply
Route::post('/replies/{reply}/best', 'BestReplyController@store')->name('best-replies.store');

// Reply
Route::post('/replies/{reply}/favorites', 'FavoriteController@store');
Route::delete('/replies/{reply}/favorites', 'FavoriteController@destroy');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy');

// Profile
Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');
Route::get('/profiles/{user}/notifications', 'UserNotificationController@index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy');

// API
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');
