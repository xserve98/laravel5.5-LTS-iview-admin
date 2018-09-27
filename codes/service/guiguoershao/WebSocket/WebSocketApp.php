<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2018/9/26
 * Time: 下午11:06
 */

namespace guiguoershao\WebSocket;


use guiguoershao\WebSocket\client\Request;
use guiguoershao\WebSocket\Server\SwooleServer;

class WebSocketApp
{

    public function __construct()
    {

    }

    public function start()
    {
        try {
            SwooleServer::getInstance('0.0.0.0', '9501')->start();
            echo 'Hello';
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function createConnectUrl($clientId=10086)
    {
        return 'ws://www.laravel5.me:9501?a=1&b=2&c=3&client_id='.$clientId;
    }

    public function push($clientId=10086)
    {
        $request = (new Request());

        return $request->http($clientId, ['a'=>1,'b'=>2,'c'=>3,'d'=>4]);
    }

}