<?php

//  登录
Route::post('/login', 'LoginController@login');

Route::get('/getSession', 'LoginController@getSession')->middleware(['auth:web-manage']);
//  登出
Route::get('/logout', 'LoginController@logout')->middleware(['auth:web-manage']);