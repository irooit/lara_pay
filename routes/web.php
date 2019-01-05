<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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

Route::get('/', 'MainController@index');

//认证
Auth::routes(['verify' => true]);
Route::get('auth/qrcode', 'Auth\LoginController@qrcode');
Route::get('logout', 'Auth\LoginController@logout');

//社交账户登录
Route::get('auth/social/{provider}', 'Auth\SocialLoginController@redirectToProvider');
Route::get('auth/social/{provider}/callback', 'Auth\SocialLoginController@handleProviderCallback');
Route::get('auth/social/{provider}/binding', 'Auth\SocialLoginController@handleProviderBinding');

/**
 * 用户中心入口
 */
Route::get('/home', 'HomeController@index')->name('home');
