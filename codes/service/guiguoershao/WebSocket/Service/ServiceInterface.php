<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2018/10/12
 * Time: 下午11:13
 */

namespace guiguoershao\WebSocket\Service;


interface ServiceInterface
{

    public function handle(callable $func);
}