<?php
/**
 * 自定义跳转类
 * User: fengyan
 * Date: 17-10-13
 * Time: 上午10:43
 */

namespace App\Helpers;


trait Jump
{
    /**
     * 模板前缀
     * @var string
     */
    private $templatePrefix = '';

    /**
     * 返回数据格式
     * @var string
     */
    private $returnFormat = 'json';

    /**
     * 返回的数据
     * @var array
     */
    protected $data = [];

    /**
     * 返回json数据
     * @var string
     */
    public static $returnFormatJson = 'json';

    /**
     * 返回view页面
     * @var string
     */
    public static $returnFormatView = 'view';

    /**
     * 设置模板前缀
     * @param string $templatePrefix
     * @return $this
     */
    protected function setTemplatePrefix($templatePrefix = '')
    {
        $this->templatePrefix = $templatePrefix;

        return $this;
    }

    /**
     * 设置当前模块
     * @param string $returnFormat
     * @return $this
     */
    protected function setReturnFormat($returnFormat = 'json')
    {
        $this->returnFormat = $returnFormat;

        return $this;
    }

    public function withData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * 模板统一调用方法
     * @param null $view
     * @param array $data
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function fetch($view = null, $data = [])
    {
        if (strpos($view, '/') !== 0) {
            $template = $this->templatePrefix . $view;
        } else {
            $template = substr($view, 1);
        }

        $this->templatePrefix = '';

        return response()->view($template, array_merge($this->data, $data));
    }

    /**
     * 错误输出
     * @param string $msg
     * @param null $url
     * @param string $data
     * @param int $wait
     * @param int $httpStatus
     * @param array $header
     * @param string $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    protected function error($msg = '', $data = '', $url = null, $wait = 2, $httpStatus = 200, array $header = [], $type = 'error')
    {
//        $data = empty($data) ? null : $data;

        $result = [
            'code' => -1,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
            'type' => $type,
        ];

        if ($this->returnFormat == self::$returnFormatJson) {
            return response()->json($result, $httpStatus, $header);
        }

        return $this->fetch('error', array_merge($result, ['httpStatus'=>$httpStatus]));
    }

    /**
     * 成功返回
     * @param string $msg
     * @param null $url
     * @param string $data
     * @param int $wait
     * @param int $httpStatus
     * @param array $header
     * @param string $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    protected function success($msg = '', $data = '', $url = null, $wait = 2, $httpStatus = 200, array $header = [], $type = 'success')
    {
        $httpStatus = empty($httpStatus) ? 200 : $httpStatus;

        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
            'type' => $type,
        ];

        if ($this->returnFormat == self::$returnFormatJson) {
            return response()->json($result, $httpStatus, $header);
        }

        return $this->fetch('error', array_merge($result, ['httpStatus'=>$httpStatus]));
    }
}