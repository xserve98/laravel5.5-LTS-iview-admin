<?php
/**
 * 错误异常基类
 * User: fengyan
 * Date: 18-3-30
 * Time: 上午9:38
 */

namespace App\Exceptions;


abstract class BaseException extends \Exception implements InterException
{
    /**
     * 传输数据
     * @var
     */
    protected $data = [];

    /**
     * 跳转链接
     * @var
     */
    protected $url = '';

    /**
     * 等待时间 单位秒
     * @var
     */
    protected $waitTime = 2;

    /**
     * @var
     */
    protected $httpStatus = 200;

    /**
     * @var
     */
    protected $httpHeaders = [];

    /**
     * @var string
     */
    protected $infoType = 'error';

    /**
     * 未登录类型
     */
    const NO_LOGIN = 'not-login';

    const SUCCESS = 'success';

    const ERROR = 'error';

    /**
     * BaseException constructor.
     * @param string $msg
     * @param int $code
     * @param string $type success|error|noLogin
     * @param \Throwable|null $previous
     */
    public function __construct($msg = '', $code = -1, $type = 'error', \Throwable $previous = null)
    {
        parent::__construct($msg, $code);

        $this->infoType = $type;
    }

    /**
     * 设置传输数据
     * @param array $data
     * @return $this
     */
    public function setData(array $data = [])
    {
        $this->data = $data;

        return $this;
    }

    /**
     * 设置跳转url
     * @param string $url
     * @return $this
     */
    public function setJumpUrl($url = '')
    {
        $this->url = $url;

        return $this;
    }

    /**
     * 设置等待时间
     * @param int $wait
     * @return $this
     */
    public function setWaitTime($wait = 2)
    {
        $this->waitTime = $wait;

        return $this;
    }

    /**
     * 设置信息类型
     * @return $this
     */
    public function setInfoType()
    {
        return $this;
    }

    /**
     * 设置http状态
     * @param int $status
     * @return $this
     */
    public function setHttpStatus($status = 200)
    {
        $this->httpStatus = $status;

        return $this;
    }

    /**
     * 设置http header头信息
     * @param array $headers
     * @return $this
     */
    public function setHttpHeaders(array $headers = [])
    {
        $this->httpHeaders = $headers;

        return $this;
    }

    /**
     * 获取数据
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * 获取跳转url
     * @return string
     */
    public function getJumpUrl(): string
    {
        return $this->url;
    }

    /**
     * 获取等待时间
     * @return int
     */
    public function getWaitTime(): int
    {
        return $this->waitTime;
    }

    /**
     * 获取信息类型
     * @return string
     */
    public function getInfoType(): string
    {
        if (empty($this->infoType)) {
            return $this->getCode() == 0 ? 'success' : 'error';
        }

        return $this->infoType;
    }

    /**
     * 获取http状态
     * @return int
     */
    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    /**
     * 获取http header头信息
     * @return array
     */
    public function getHttpHeaders(): array
    {
        return $this->httpHeaders;
    }
}