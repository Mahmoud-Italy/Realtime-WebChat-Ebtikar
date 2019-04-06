<?php

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Here is where you can register user routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "user" middleware group. Now create something great!
|
*/


#Chat Area
Route::get('chat-window', 'ChatCtrl@index');
Route::post('chat-window', function() { return \App::abort(404); });

#Chat
Route::post('json/load/chats', 'ChatCtrl@loadChat');
Route::get('json/load/chats', function() { return \App::abort(404); });

