<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\UserController;
use GuzzleHttp\Middleware;

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

Route::group(['prefix'=>'admin'],function(){

    //后台登录页面路由
    Route::get('login',[LoginController::class,'login']);
    //登录页面验证路由
    Route::post('doLogin',[LoginController::class,'doLogin']);

});

//验证码生成路由
Route::get('code/captcha/{tmp?}',[LoginController::class,'captcha']);

//需要验证是否登录的路由组
Route::group(['prefix'=>'admin','middleware'=>'isLogin'],function(){

    //后台主页路由
    Route::get('index',[LoginController::class,'index']);

    //后台欢迎页路由
    Route::get('welcome',[LoginController::class,'welcome']);

    //后台退出路由
    Route::get('logout',[LoginController::class,'logout']);

    //用户模块相关路由
    Route::resource('user',UserController::class);

});

