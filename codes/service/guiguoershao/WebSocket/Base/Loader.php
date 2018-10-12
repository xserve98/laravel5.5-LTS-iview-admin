<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-28
 * Time: 上午10:38
 */

namespace guiguoershao\WebSocket\Base;


use guiguoershao\WebSocket\Client\Request;
use guiguoershao\WebSocket\Service\AuthService;
use guiguoershao\WebSocket\Service\MessageService;
use guiguoershao\WebSocket\Service\UserService;

class Loader
{
    /**
     * redis 连接
     * @var
     */
    private static $_redis;


    private static $_sign;

    private static $_request;

    /**
     * 获取redis实例对象
     * @return \Redis
     */
    public static function redis(): \Redis
    {
        if (!(self::$_redis instanceof \Redis)) {
            $config = Config::getInstance()->getRedisConfig();

            $redis = new \Redis();
            $redis->connect($config['host'], $config['port']);
            $config['pass'] && $redis->auth($config['pass']);
            $redis->select($config['db']);

            self::$_redis = $redis;
        }

        return self::$_redis;
    }

    /**
     * 获取签名实例对象
     * @return Sign
     */
    public static function sign(): Sign
    {
        if (!(self::$_sign instanceof Sign)) {
            self::$_sign = new Sign();
        }

        return self::$_sign;
    }

    /**
     * 获取配置实例对象
     * @return Config
     */
    public static function config(): Config
    {
        return Config::getInstance();
    }

    /**
     * 客户端请求对象
     * @return Request
     */
    public static function request(): Request
    {
        if (!(self::$_request instanceof Request)) {
            self::$_request = new Request();
        }

        return self::$_request;
    }

    /**
     *
     * @param array $data
     * @return Response
     */
    public static function response(array $data = []): Response
    {
        return Response::getInstance($data);
    }

    /**
     * 参数鉴权
     * @return AuthService
     */
    public static function auth(): AuthService
    {
        return AuthService::getInstance();
    }

    /**
     *
     * @return UserService
     */
    public static function user(): UserService
    {
        return UserService::getInstance();
    }

    /**
     * @return MessageService
     */
    public static function message(): MessageService
    {
        return MessageService::getInstance();
    }
}