<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-29
 * Time: 下午5:21
 */

namespace guiguoershao\WebSocket\Service;


class UserService
{
    /**
     * 并不是单例
     * @return UserService
     * @throws \Exception
     */
    public static function getInstance(): self
    {
        return new self();
    }
}