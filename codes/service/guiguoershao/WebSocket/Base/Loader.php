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

    public static function response(): Response
    {

    }

    /**
     * 参数鉴权
     * @return AuthService
     */
    public static function auth(): AuthService
    {
        return AuthService::getInstance();
    }
}