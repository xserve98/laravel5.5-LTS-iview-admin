<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-8-17
 * Time: 下午3:33
 */

namespace App\Traits;


namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasCompositePrimaryKey
{
    /**
     * Get the value indicating whether the IDs are incrementing.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Set the keys for a save update query.
     * @param Builder $query
     * @return Builder
     * @throws \Exception
     */
    protected function setKeysForSaveQuery(Builder $query)
    {
        foreach ($this->getKeyName() as $key) {
            if ($this->$key)
                $query->where($key, '=', $this->$key);
            else
                throw new \Exception(__METHOD__ . 'Missing part of the primary key: ' . $key);
        }

        return $query;
    }
}