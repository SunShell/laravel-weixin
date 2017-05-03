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

//首页
Route::get('/', 'VotesController@index')->name('home');
//搜索
Route::post('/', 'VotesController@search');
//删除
Route::post('/delete', 'VotesController@destroy');
//php info
Route::get('/info', 'VotesController@info');

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

//验证跳转页
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

//添加投票
Route::get('/create', 'VotesController@create');
//保存投票
Route::post('/create', 'VotesController@store');

//登录
Route::get('/login', 'SessionsController@create')->name('login');
Route::post('/login', 'SessionsController@store');

//登出
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

//微信自动回复视图
Route::get('/autoReply', 'WxController@autoReply');
//获取页面信息
Route::post('/autoReply/getPageInfo', 'WxController@getPageInfo');
//翻页
Route::post('/autoReply/getPaging', 'WxController@getPaging');
//删除
Route::post('/autoReply/del', 'WxController@del');
//获取素材
Route::get('/autoReply/sel/{mType}', 'WxController@sel');
//保存
Route::post('/autoReply/store', 'WxController@store');
//获取默认回复数据
Route::post('/autoReply/getDr', 'WxController@getDr');
//保存自动回复
Route::post('/autoReply/storeDr', 'WxController@storeDr');