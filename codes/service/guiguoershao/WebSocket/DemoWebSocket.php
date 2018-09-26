<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2018/9/26
 * Time: 下午11:06
 */

namespace guiguoershao\WebSocket;


class DemoWebSocket
{
    private $server;

    private function __construct($ip, $port)
    {
        $this->server = new \swoole_websocket_server($ip, $port);
    }

    public static function getInstance($ip, $port)
    {
        return new self($ip, $port);
    }

    public function start()
    {
        $this->server->on('open', function (\swoole_websocket_server $ws, \swoole_http_request $request) {
            echo "server: handshake success with fd{$request->fd}\n";
        });

        $this->server->on('message', function (\swoole_websocket_server $ws, \swoole_websocket_frame $frame) {
            echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
            $ws->push($frame->fd, "this is server");
        });

        $this->server->on('close', function ($ser, $fd) {
            echo "client {$fd} closed\n";
        });

        $this->server->start();
    }
}