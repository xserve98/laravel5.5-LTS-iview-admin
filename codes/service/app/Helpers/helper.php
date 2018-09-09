<?php

/**
 * 获取随机字符串
 * @param int $len 字符串长度
 * @param int $mode 类型
 * @param int $letterNum  字母个数
 * @return bool|string
 */
function get_rand_string($len = 32, $mode=0, $letterNum=0)
{
    $chars = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H',
        'I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9'];
    $str = '';
    switch ($mode) {
        //数字字母混排
        case 0:
            while ($len -- > 0) {
                $str .= $chars[mt_rand(0, 61)];
            }
            break;
        case 1:
            //纯数字
            while ($len -- > 0) {
                $str .= $chars[mt_rand(52, 61)];
            }
            break;
        case 2:
            //纯字母
            while ($len -- > 0) {
                $str .= $chars[mt_rand(0, 51)];
            }
            break;
        case 3:
            //  只包含指定个数的字母
            for ($i=1; $i<=$len; $i++) {
                if ($i <= $letterNum) {
                    $str .= $chars[mt_rand(0, 51)];
                } else {
                    $str .= $chars[mt_rand(52, 61)];
                }
            }
            $str = str_shuffle($str);
            break;
        default:
            return false;
            break;
    }

    return $str;
}


/**
 * 将下划线命名转换为驼峰式命名
 * @param $str
 * @param bool $ucfirst
 * @return mixed|string
 */
function get_convert_underline( $str , $ucfirst = true)
{
    $str = ucwords(str_replace('_', ' ', $str));
    $str = str_replace(' ','',lcfirst($str));
    return $ucfirst ? ucfirst($str) : $str;
}

if (!function_exists('get_value')){
    /**
     * 判断数组或对象中是否存在某个属性
     * @param $item
     * @param $key
     * @param null $default
     * @return bool|mixed|null
     */
    function get_value($item, $key, $default = null) {

        if (is_object($item)) {
            if (property_exists($item, $key)) {
                return $item->$key;
            }
            if ($item instanceof \Illuminate\Database\Eloquent\Model) {
                return $item->$key === null || $item->$key === '' ? $default : $item->$key;
            }
        }
        if (is_array($item)) {
            if (isset($item[$key])) {
                return $item[$key];
            }
        }
        if ($default !== null) {
            return $default;
        }
        return false;
    }
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @return array
 * @author 鬼国二少 <guiguoershao@163.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author 鬼国二少 <guiguoershao@163.com>
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}

/**
 * 对查询结果集进行排序
 * @access public
 * @param array $list 查询结果
 * @param string $field 排序的字段名
 * @param array $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 * @author 鬼国二少 <guiguoershao@163.com>
 */
function list_sort_by($list, $field, $sortby='asc') {
    if(is_array($list)){
        $refer = $resultSet = array();
        foreach ($list as $i => $data)
            $refer[$i] = &$data[$field];
        switch ($sortby) {
            case 'asc': // 正向排序
                asort($refer);
                break;
            case 'desc':// 逆向排序
                arsort($refer);
                break;
            case 'nat': // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ( $refer as $key=> $val)
            $resultSet[] = &$list[$key];
        return $resultSet;
    }
    return false;
}



if (!function_exists('date_formats')) {
    /**
     * 时间戳格式化
     * @param $time
     * @param string $format
     * @return false|null|string
     */
    function date_formats($time, $format = 'Y-m-d H:i:s')
    {
        if (is_numeric($time)) {
            return empty($time) ? null : date($format, $time);
        }

        return $time;
    }
}

/**
 * 根据身份证号获取省份
 * @param $id
 * @return mixed
 */
function get_province_by_id($id){
    if (empty($id)) {
        return '其他';
    }
    //截取前两位数
    $index = substr($id,0,2);
    $area = array(
        11 => "北京",
        12 => "天津",
        13 => "河北",
        14 => "山西",
        15 => "内蒙古",
        21 => "辽宁",
        22 => "吉林",
        23 => "黑龙江",
        31 => "上海",
        32 => "江苏",
        33 => "浙江",
        34 => "安徽",
        35 => "福建",
        36 => "江西",
        37 => "山东",
        41 => "河南",
        42 => "湖北",
        43 => "湖南",
        44 => "广东",
        45 => "广西",
        46 => "海南",
        50 => "重庆",
        51 => "四川",
        52 => "贵州",
        53 => "云南",
        54 => "西藏",
        61 => "陕西",
        62 => "甘肃",
        63 => "青海",
        64 => "宁夏",
        65 => "新疆",
        71 => "台湾",
        81 => "香港",
        82 => "澳门",
        91 => "国外"
    );
    return isset($area[$index]) ? $area[$index] : '其他';
}

/**
 * 根据身份证号获取年龄
 * @param $id
 * @return float|string
 */
function get_age_by_id($id)
{
    //过了这年的生日才算多了1周岁
    if(empty($id)) {
        return 0;
    }

    if (strlen($id) != 18 || strlen($id) != 15) {
        return 0;
    }

    $date = strtotime(substr($id,6,8));

    //获得出生年月日的时间戳
    $today=strtotime('today');

    //获得今日的时间戳
    $diff = floor(($today-$date)/86400/365);
    //得到两个日期相差的大体年数

    //strtotime加上这个年数后得到那日的时间戳后与今日的时间戳相比
    $age = strtotime(substr($id,6,8).' +'.$diff.'years')>$today?($diff+1):$diff;

    return (int)$age;
}

/**
 * 分析枚举类型配置值 格式 a:名称1,b:名称2
 * @param $string
 * @return array
 */
function parse_config_attr($string) {
    $array = preg_split('/[,;\r\n]+/', trim($string, ",;\r\n"));
    if(strpos($string,':')){
        $value  =   array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
        }
    }else{
        $value  =   $array;
    }
    return $value;
}

/**
 * 生成分类 select树形结构
 * @param array $list
 * @param int $selectId 需要选中的分类 id
 * @param int $currentCid 需要隐藏的分类 id
 * @return string|array
 */
function get_select_tree(array $list, $selectId = 0, $currentCid = 0, $returnType = 'list')
{
    $tree       = new App\Helpers\Tree();
//    $tree->icon = ['&nbsp;&nbsp;│', '&nbsp;&nbsp;├─', '&nbsp;&nbsp;└─'];
//    $tree->nbsp = '&nbsp;&nbsp;';
    $tree->icon = [' │', ' ├─', ' └─'];
    $tree->nbsp = ' ';

    $newCategories = [];
    foreach ($list as $item) {
        $item = (array) $item;
        if (!isset($item['parent_id']) && array_key_exists('pid', $item)) {
            $item['parent_id'] = $item['pid'];
        }

        if (!isset($item['name']) && array_key_exists('title', $item)) {
            $item['name'] = $item['title'];
        }

        $item['disabled'] = "";
        if (is_array($currentCid)) {
            $item['disabled'] = in_array($item['id'], $currentCid) ? "disabled" : "";
        } else {
            if ($currentCid > 0 && $currentCid == $item['id']) {
                continue;
            }
        }
        $item['selected'] = $selectId == $item['id'] ? "selected" : "";

        array_push($newCategories, $item);
    }

    if ($returnType != 'list') {
        $tree->init($newCategories);
        $str     = '<option value=\"{$id}\" {$selected} {$disabled}>{$spacer}{$name}</option>';
        $treeStr = $tree->getTree(0, $str);
        return $treeStr;
    }

    $str = '{$id}, {$selected}, {$spacer}{$name}.';
    $tree->init($newCategories);
    $treeStr = $tree->getTree(0, $str);
    $arr = explode('.', rtrim($treeStr, '.'));
    $list = [];
    foreach ($arr as $key=>$value) {
        $val = explode(',', $value);
        $list[$key] = ['id'=>(int)$val[0], 'title'=>$val[2]];
    }
    return $list;
}

/**
 * ********************************************************************************************************
 */

/**
 * 获取图片信息
 * @param $imageUrl
 * @return mixed
 */
function getImageInfo($imageUrl)
{
    $key = md5($imageUrl);

    $list = \Illuminate\Support\Facades\Cache::get('image_wh_list');

    $list = empty($list) ? [] : $list;

    if (array_key_exists($key, $list)) {
        return $list[$key];
    }

    $imageSize = getimagesize($imageUrl);

    $list[$key] = [
        'w' => $imageSize[0],
        'h' => $imageSize[1],
    ];

    \Illuminate\Support\Facades\Cache::forever('image_wh_list', $list);

    return $list[$key];
}

/**
 * 替换掉emoji表情
 * @param $text
 * @param string $replaceTo
 * @return mixed|string
 */
function filter_emoji($text, $replaceTo = '?')
{
    $clean_text = "";
    // Match Emoticons
    $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
    $clean_text = preg_replace($regexEmoticons, $replaceTo, $text);
    // Match Miscellaneous Symbols and Pictographs
    $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
    $clean_text = preg_replace($regexSymbols, $replaceTo, $clean_text);
    // Match Transport And Map Symbols
    $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
    $clean_text = preg_replace($regexTransport, $replaceTo, $clean_text);
    // Match Miscellaneous Symbols
    $regexMisc = '/[\x{2600}-\x{26FF}]/u';
    $clean_text = preg_replace($regexMisc, $replaceTo, $clean_text);
    // Match Dingbats
    $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
    $clean_text = preg_replace($regexDingbats, $replaceTo, $clean_text);
    return $clean_text;
}

/**
 * 修改env文件的配置
 * @param array $data
 */
function modify_env(array $data)
{
    $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';

    $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));

    $contentArray->transform(function ($item) use ($data){
        if (empty($item)) {
            return $item;
        }

        $arr = explode('=', $item);

        $k = $arr[0];

        foreach ($data as $key => $value){
            if ($key != $k) {
                continue;
            }
//            print_r($k.' '.$v. ' '.PHP_EOL);

            $item = $key . '=' . $value;
        }

        return $item;
    });

    $content = implode($contentArray->toArray(), "\n");

    \File::put($envPath, $content);
}

/**
 * 对象转为数组
 * @param $array
 * @return array
 */
function object_array($array) {
    if(is_object($array)) {
        $array = (array)$array;
    } if(is_array($array)) {
        foreach($array as $key=>$value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}

/**
 * 将二维数组转为一维数组 把指定值作为键
 * @param $array
 * @param $keyField
 * @param $valueField
 * @return array
 */
function arrayToList($array, $keyField, $valueField)
{
    $data = [];
    foreach ($array as $key=>$value) {
        $data[$value[$keyField]] = $value[$valueField];
    }

    return $data;
}