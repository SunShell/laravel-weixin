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

//跳转页
Route::get('/verify/{twoId}', 'VotesController@verify');
//正式投票页
Route::get('/vote/{voteId}', 'VotesController@detail');
//查询
Route::post('/vote/{voteId}', 'VotesController@detailQuery');
//报名
Route::get('/vote/apply/{voteId}', 'VotesController@apply');
//报名保存
Route::post('/vote/apply/{voteId}', 'VotesController@applyStore');
//排名
Route::get('/vote/rank/{voteId}', 'VotesController@rank');
//选手详情
Route::get('/vote/one/{theId}', 'VotesController@oneDetail');
//提交投票
Route::post('/vote/voteOp/{voteId}', 'VotesController@voteOp');

//add vote
Route::get('/create', 'VotesController@create');
//save vote
Route::post('/create', 'VotesController@store');

//login
Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');

//logout
Route::get('/logout', 'SessionsController@destroy');

//微信接口
Route::any('/wechat', 'WechatController@serve');
//获取微信图片素材
Route::get('/photos', 'MaterialsController@photos');
//获取微信文章素材
Route::get('/articles', 'MaterialsController@articles');
//创建自定义菜单
Route::get('/menu', 'MenuController@menu');
//获取自定义菜单
Route::get('/menu/get', 'MenuController@getMenu');
//删除自定义菜单
Route::get('/menu/del', 'MenuController@delMenu');