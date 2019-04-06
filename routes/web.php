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

#App
Route::get('/', 'AppCtrl@login')->name('login');
Route::get('logout','AppCtrl@logout');
Route::post('logout', function(){ return \App::abort(404); });
#Login
Route::post('login', 'AppCtrl@doLogin');
Route::get('login', function(){ return \App::abort(404); });
#Signup
Route::post('signup', 'AppCtrl@doSignup');
Route::get('signup', function(){ return \App::abort(404); });
#Verify
Route::post('verify', 'AppCtrl@doVerify');
Route::get('verify', function(){ return \App::abort(404); });
Route::post('userVerify', 'AppCtrl@userVerify');
Route::get('userVerify', function(){ return \App::abort(404); });


