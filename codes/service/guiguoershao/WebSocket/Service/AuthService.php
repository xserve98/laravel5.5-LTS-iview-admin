<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-29
 * Time: 下午4:03
 */

namespace guiguoershao\WebSocket\Service;


use guiguoershao\WebSocket\Base\Loader;
use guiguoershao\WebSocket\Base\RespEnum;

class AuthService
{

    /**
     * @return AuthService
     * @throws \Exception
     */
    public static function getInstance()
    {
        return new AuthService();
    }

    /**
     * 参数鉴权
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public function verify(array $data)
    {
        if (! Loader::sign()->checkParams($data)) {
            throw new \Exception("参数格式错误", RespEnum::PARAM_ERROR);
        }

        if (! Loader::sign()->verifyRequestIsExpire($data['timestamp'], $data['expire_in'])) {
            throw new \Exception("请求过期", RespEnum::REQUEST_EXPIRE);
        }

        if (! Loader::sign()->verifySign($data, $data['sign'])) {
            throw new \Exception("签名验证失败", RespEnum::SIGN_ERROR);
        }

        return true;
    }
}