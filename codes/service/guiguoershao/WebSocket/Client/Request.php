<?php

namespace guiguoershao\WebSocket\Client;

/**
 * 请求
 * Class Request
 * @package websocket
 */
class Request
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * Request constructor.
     * @throws \Exception
     */
    public function __construct()
    {
    }

    /**
     * 创建请求
     * @param $clientId
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function http($clientId, array $data)
    {
        return $this->_send(env('HTTP_SERVER'), http_build_query(['client_id'=>$clientId, 'data'=>$data]));
    }

    /**
     * @param $url
     * @param $query
     * @return mixed
     */
    private function _send($url, $query)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);//超时时间
        curl_setopt($ch, CURLOPT_POST, true);
        $query = http_build_query($query);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if (!empty($err)) {
            return $err;
        }
        return $result;
    }
}