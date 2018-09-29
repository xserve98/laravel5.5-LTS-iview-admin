<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-29
 * Time: 下午4:48
 */

namespace guiguoershao\WebSocket\Service;


use guiguoershao\WebSocket\Base\Response;
use swoole_websocket_server;
class MessageService
{
    /**
     * 并不是单例
     * @return MessageService
     * @throws \Exception
     */
    public static function getInstance() : MessageService
    {
        return new MessageService();
    }

    public function push($clientId, Response $response, swoole_websocket_server $server)
    {

    }
}