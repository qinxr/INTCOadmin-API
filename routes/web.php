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




//人员信息接口
//获取人员信息(部分)
Route::get('user/getUserInfos','UserController@getUserInfos');
//获取人员信息（全部）
Route::get('user/getAllUserInfos','UserController@getAllUserInfos');
//增
Route::post('user/addUser','UserController@addUserInfo');
//查指定id
Route::post('user/getUserAsId/{id}','UserController@getUserAsId');
//改
Route::post('user/editUser/{id}','UserController@editUser');
//删
Route::post('user/deleteUser','UserController@deleteUser');

//pad借用信息接口
//获取人员信息(部分)
Route::get('user/getPadUserInfos','PadUserController@getPadUserInfos');
//获取人员信息（全部）
Route::get('padUser/getAllPadUserInfos','PadUserController@getAllPadUserInfos');
//增
Route::post('padUser/addPadUser','PadUserController@addPadUserInfo');
//查指定id
Route::post('padUser/getPadUserAsId/{id}','PadUserController@getPadUserAsId');
//改
Route::post('padUser/editPadUser/{id}','PadUserController@editPadUser');
//删
Route::post('padUser/deletePadUser','PadUserController@deletePadUser');


//电脑信息接口
//获取人员信息
Route::get('pc/getPcInfos','PcController@getPcInfos');
//增
Route::post('pc/addPcInfo','PcController@addPcInfo');
//查指定id
Route::post('pc/getPcAsId/{id}','PcController@getPcAsId');
//查指定序列号
Route::post('pc/getPcAsNum/{num}','PcController@getPcAsNum');
//改
Route::post('pc/editPc/{id}','PcController@editPc');
//删
Route::post('pc/deletePc','PcController@deletePc');
//归还
Route::post('pc/backPc','PcController@backPc');


//Pad信息接口
//获取人员信息
Route::get('pad/getPadInfos','PadController@getPadInfos');
//增
Route::post('pad/addPadInfo','PadController@addPadInfo');
//查指定id
Route::post('pad/getPadAsId/{id}','PadController@getPadAsId');
//查指定序列号
Route::post('pad/getPadAsNum/{num}','PadController@getPadAsNum');
//改
Route::post('pad/editPad/{id}','PadController@editPad');
//删
Route::post('pad/deletePad','PadController@deletePad');
//归还
Route::post('pad/backPad','PadController@backPad');


//配料信息接口
//获取展示列表信息
Route::get('pladmin/getPlInfos','PvcplController@getPlInfos');
//增
Route::post('pladmin/addPlInfo','PvcplController@addPlInfo');
//查指定id
Route::post('pladmin/getPlAsId/{id}','PvcplController@getPlAsId');
//改
Route::post('pladmin/editpl/{id}','PvcplController@editpl');
//删
//Route::post('padUser/deletePadUser','PadUserController@deletePadUser');