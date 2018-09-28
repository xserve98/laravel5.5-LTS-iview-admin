<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-28
 * Time: 下午5:20
 */

namespace guiguoershao\WebSocket\Base;


class Response
{
    private $responseData = [];

    public function setCode($val) : self
    {
        $this->responseData['code'] = $val;

        return $this;
    }

    public function setMessage($val) : self
    {
        $this->responseData['msg'] = $val;

        return $this;
    }

    public function setType($val) : self
    {
        $this->responseData['msgType'] = $val;

        return $this;
    }

    public function setData(array $val) : self
    {
        $this->responseData['data'] = $val;

        return $this;
    }
}