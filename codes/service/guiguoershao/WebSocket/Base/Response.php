<?php
/**
 * 统一格式返回消息内容
 * User: fengyan
 * Date: 18-9-28
 * Time: 下午5:20
 */

namespace guiguoershao\WebSocket\Base;


use PhpParser\Node\Scalar\String_;

class Response
{
    private $responseData = [];

    private function __construct(array $data = [])
    {
        $this->setResponseData($data);
    }

    /**
     * 批量赋值
     * @param array $data
     */
    public function setResponseData(array $data = [])
    {
        isset($data['code']) && $this->setCode($data['code']);
        isset($data['code']) && $this->setCode($data['code']);
        isset($data['msg']) && $this->setMessage($data['msg']);
        isset($data['msgType']) && $this->setMsgType($data['msgType']);
        isset($data['data']) && $this->setData($data['data']);
    }


    /**
     *
     * @param array $data
     * @return Response
     */
    public function getInstance(array $data = [])
    {
        return new self($data);
    }

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

    public function setMsgType($val) : self
    {
        $this->responseData['msgType'] = $val;

        return $this;
    }

    public function setData(array $val) : self
    {
        $this->responseData['data'] = $val;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return $this->responseData;
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->responseData, 'JSON_UNESCAPED_UNICODE');
    }
}