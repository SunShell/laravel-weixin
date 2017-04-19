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

//index
Route::get('/', 'VotesController@index')->name('home');
//search
Route::post('/', 'VotesController@search');
//delete
Route::post('/delete', 'VotesController@destroy');

//add vote
Route::get('/create', 'VotesController@create');
//save vote
Route::post('/create', 'VotesController@store');

//login
Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');

//logout
Route::get('/logout', 'SessionsController@destroy');