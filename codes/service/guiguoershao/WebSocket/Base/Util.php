<?php

namespace guiguoershao\WebSocket\Base;
/**
 * Class Util
 * @package websocket\Base
 */
class Util
{
    /**
     * @param $tag
     * @param $msg
     */
    public static function ps($tag, $msg)
    {
        $date = date('Y-m-d H:i:s');
        echo "date:{$date},tag:$tag,msg:$msg\r\n";
    }
}