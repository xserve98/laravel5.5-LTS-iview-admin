<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-28
 * Time: 上午11:14
 */

namespace guiguoershao\WebSocket\Base;


class Sign
{

    /**
     * 创建socket连接url
     * @param $clientId
     * @return string
     * @throws \Exception
     */
    public function createConnectUrl($clientId)
    {
        $appName = Loader::config()->getAppName();

        if (empty(Loader::config()->getAppKeyByName($appName))) {
            throw new \Exception("签名秘钥不能为空");
        }

        $query = $this->createQueryData($clientId, 'auth');

        return Loader::config()->getServerLinks()['ws'] . '?' . http_build_query($query);
    }

    /**
     * 创建请求参数
     * @param $appName      应用名称
     * @param $clientId     客户端编号
     * @param $serviceName  服务名称
     * @param string $pushMsgType   消息推送类型
     * @param array $data   推送数据
     * @return array|null
     * @throws \Exception
     */
    public function createQueryData($clientId, $serviceName, $pushMsgType = '', array $data = [])
    {
        $appName = Loader::config()->getAppName();

        $signSecretKey = Loader::config()->getAppKeyByName($appName);

        if (empty($signSecretKey)) {
            throw new \Exception("创建签名缺少必要的签名秘钥");
        }

        $query = [
            'app_name' => $appName,
            'client_id' => $clientId,
            'service' => $serviceName,
            'msg_type' => $pushMsgType,
            'once' => Util::getRandString(16, 3, 8),
            'timestamp' => time(),
            'expire_in' => Loader::config()->getSignConfig()['expireIn'],
            'data' => $data
        ];

        $query['sign'] = $this->createSign($signSecretKey, $query);

        if (!$this->checkParams($query)) {
            return null;
        }

        return $query;
    }

    /**
     * 验证参数
     * @param $query
     * @return bool
     */
    private function checkParams($query)
    {
        if (empty($query['app_name']) ||
            empty($query['client_id']) ||
            empty($query['service']) ||
            !isset($query['msg_type']) ||
            empty($query['once']) ||
            empty($query['timestamp']) ||
            empty($query['expire_in']) ||
            !isset($query['data']) ||
            empty($query['sign'])
        ) {
            return false;
        }
        return true;
    }

    /**
     * 创建签名
     * @param $signSecretKey
     * @param array $params
     * @return string
     * @throws \Exception
     */
    private function createSign($signSecretKey, array $params = [])
    {

        if (!isset($params['app_name']) || empty($params['app_name'])) {
            throw new \Exception("创建签名缺少必要的应用名称");
        }

        unset($params['sign']);

        ksort($params);

        return md5(http_build_query($params) . "&secret_key={$signSecretKey}");
    }
}