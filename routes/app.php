<?php

use Illuminate\Support\Facades\Route;

//移动端内嵌页面，使用 auth:api 来认证,Web View 需要增加拦截器在 load 时，增加Header

Route::get('/', 'App\MainController@index');
