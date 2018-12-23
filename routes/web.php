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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/loginUser', 'LoginController@showIndex');//登录
Route::post('/login_sub',"LoginController@login_sub");//登录提交

Route::get('/registered', 'LoginController@showRegistered');//注册
Route::any('/registered/sub', 'LoginController@registered_sub');//注册提交


Route::get('/default/img','UserController@defaultImg');

/*
登录后的路有组
*/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/userInfo', "UserController@userInfo");
    Route::post('/upload/img',"UserController@uploadImg");
    Route::post('/change/info','UserController@changeInfo');
    Route::get('/userImg','UserController@userImg');//获取用户头像地址
    Route::post('/save/cardset','CardControlle@saveSet');//存套牌
    Route::post('/delete/set','CardControlle@deleteSet');//删除套牌
    Route::get('/get/user/cardset','UserController@getCardSet');//获取用户套牌
    Route::post('/updata/set','UserController@updataCardSet');//更新套牌
    Route::post('/delete/set','UserController@deleteCardSet');//删除套牌
});

Route::get('/card','CardControlle@getCardPage');
Route::get('/card/pageinfo','CardControlle@cardPageInfo');
Route::get("/class",'CardControlle@getClass');
Route::any('/serach','CardControlle@serach');
Route::post('/get/class/card','CardControlle@serachClassCard');//获得某一职业+中立卡牌
Route::post('/get/card/arrid','CardControlle@serachId');//通过ID搜索