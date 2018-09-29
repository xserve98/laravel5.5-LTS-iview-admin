<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-29
 * Time: 下午4:30
 */

namespace guiguoershao\WebSocket\Base;


class RespEnum
{
    //  成功
    const SUCCESS = 0;

    //参数级2开头
    const PARAM_ERROR = 2000;

    //签名错误
    const SIGN_ERROR = 2001;

    //请求过期
    const REQUEST_EXPIRE = 2002;

    //未知方法
    const UNKNOW_SERVICE = 2003;

    //权限级4开头
    const AUTH_FAIL = 4000;
}