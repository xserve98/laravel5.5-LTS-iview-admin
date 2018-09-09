<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 17-10-13
 * Time: 上午11:02
 */

namespace App\Exceptions;


interface InterException
{
    /**
     * 获取数据
     * @return array
     */
    public function getData(): array ;

    /**
     * 获取跳转url
     * @return string
     */
    public function getJumpUrl(): string ;

    /**
     * 获取等待时间
     * @return int
     */
    public function getWaitTime(): int ;

    /**
     * 获取信息类型
     * @return string
     */
    public function getInfoType(): string ;

    /**
     * 获取http状态
     * @return int
     */
    public function getHttpStatus(): int ;

    /**
     * 获取http header头信息
     * @return array
     */
    public function getHttpHeaders(): array ;
}