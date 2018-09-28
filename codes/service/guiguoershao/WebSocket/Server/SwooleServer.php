<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-27
 * Time: 下午4:21
 */

namespace guiguoershao\WebSocket\Server;

use function foo\func;
use guiguoershao\WebSocket\Base\Loader;
use guiguoershao\WebSocket\Base\Util;
use swoole_http_request;
use swoole_websocket_frame;
use swoole_websocket_server;
use swoole_http_response;
class SwooleServer
{
    /**
     * 单例
     * @var
     */
    private static $instance;

    /**
     * swoole server object
     * @var
     */
    private $server;

    /**
     * 启动开始时间
     * @var
     */
    private $startTime;

    /**
     * SwooleServer constructor.
     * @param $ip
     * @param $port
     */
    private function __construct($ip, $port)
    {
        $this->server = new swoole_websocket_server($ip, $port);
    }

    /**
     * 获取单例
     * @return mixed
     */
    public static function getInstance() : self
    {
        $ip = Loader::config()->getServerConnectInfo()['ip'];
        $port = Loader::config()->getServerConnectInfo()['port'];
        $keys = md5("{$ip},{$port}");
        if (empty(self::$instance[$keys])) {
            self::$instance[$keys] = new self($ip, $port);
            self::$instance[$keys]->startTime = date('YmdHis');
        }

        return self::$instance[$keys];
    }

    /**
     * 启动服务
     */
    public function start()
    {
        $server = $this->server;

        /**
         * 用户接入
         */
        $server->on('open', function (swoole_websocket_server $ws, swoole_http_request $request) {
            Util::ps('open', "用户接入fd:{$request->fd}");
        });

        /**
         * 收到socket消息
         */
        $server->on('message', function (swoole_websocket_server $ws, swoole_websocket_frame $frame) {
            Util::ps('message', "用户socket消息fd:{$frame->fd}");
        });

        $server->on('request', function (swoole_http_request $request, swoole_http_response $response) use ($server) {
            $params = property_exists($request, 'post') ? $request->post : (property_exists($request, 'get') ? $request->get : []);
            Util::ps('request', "http请求:".json_encode([$params]));
            $server->push('1', json_encode(['code'=>'1', 'message'=>'测试消息内容', 'data'=>$params], JSON_UNESCAPED_UNICODE));
            $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
        });

        /**
         * 关闭链接
         */
        $server->on('close', function ($ws, $fd) {
            Util::ps('close', "关闭链接,fd:{$fd}");
        });

        /**
         * 启动服务
         */
        $server->on('start', function ($ws) {
            Util::ps('start', '启动服务');
        });

        $server->start();
    }
}