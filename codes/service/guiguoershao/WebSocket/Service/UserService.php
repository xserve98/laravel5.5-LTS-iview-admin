<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-29
 * Time: 下午5:21
 */

namespace guiguoershao\WebSocket\Service;


use guiguoershao\WebSocket\Base\Loader;

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

    /**
     * 绑定 fid 和 client_id
     * @param $fd
     * @param $clientId
     * @return bool
     */
    public function bind($fd, $clientId)
    {
        Loader::redis()->sAdd(
            $this->getUserKey($clientId),
            $fd
        );

        Loader::redis()->set(
            $this->getFdKey($fd),
            $clientId
        );

        return true;
    }

    /**
     * 取消绑定
     * @param $fd
     * @return bool
     */
    public function unbind($fd)
    {
        if ($clientId = Loader::redis()->get($this->getFdKey($fd))) {
            Loader::redis()->sRemove($this->getUserKey($clientId), $fd);
        }

        Loader::redis()->del($this->getFdKey($fd));

        return true;
    }

    /**
     *
     * @param $clientId
     * @return string
     */
    private function getUserKey($clientId)
    {
        return Loader::config()::ONLINE_USER_SET . $clientId;
    }

    /**
     *
     * @param $fd
     * @return string
     */
    private function getFdKey($fd)
    {
        return Loader::config()::ONLINE_FD_STRING . $fd;
    }
}