<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 2018/3/30
 * Time: 下午11:37
 */

namespace App\Traits;


trait PaginateTrait
{
    /**
     * 格式化分页数据
     * @return array
     */
    public function paginateFormat(\Illuminate\Contracts\Pagination\LengthAwarePaginator $data)
    {
        $list = [];
        foreach ($data as $key=>$value) {
            $list[$key] = $value;
        }

        //  判断是否需要格式化列表输出
        if (method_exists($this, 'formatFieldValue')) {
            $list = $this->formatFieldValue($list);
        }

        return ['list' => $list, 'currentPage' => $data->currentPage(), 'lastPage' => $data->lastPage(), 'totalCount' => $data->total()];
    }
}