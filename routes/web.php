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

//pc端详情
Route::get('/votes/{voteId}', 'VotesController@pcDetail');
//pc端查询和审核
Route::post('/votes/{voteId}', 'VotesController@pcDetailQuery');
//pc端报名页
Route::get('/votes/apply/{voteId}', 'VotesController@pcApply');
//pc端报名保存
Route::post('/votes/apply/{voteId}', 'VotesController@pcApplyStore');
//pc端排名
Route::get('/votes/rank/{voteId}', 'VotesController@pcRank');
//pc端选手详情
Route::get('/votes/one/{theId}', 'VotesController@pcOneDetail');

//add vote
Route::get('/create', 'VotesController@create');
//save vote
Route::post('/create', 'VotesController@store');

//login
Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');

//logout
Route::get('/logout', 'SessionsController@destroy');