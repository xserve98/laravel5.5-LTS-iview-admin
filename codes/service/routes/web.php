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
    $arr = ['hello'=>'world1111111111'];
//    ChromePhp::info($arr);
//    \App\Helpers\SLog::info($arr);

    (new guiguoershao\WebSocket\WebSocketApp())->pushMessage(10086, 'count-data', $arr);
//    return view('welcome');
});

Route::post('/getSign', function () {
   return (new guiguoershao\WebSocket\WebSocketApp())->createConnectUrl(10086);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
