<?php

namespace App\Filters;

use \EloquentFilter\ModelFilter;

class CommentFilter extends ModelFilter
{
    /**
     * Related Models that have ModelFilters as well as the method on the ModelFilter
     * As [relationMethod => [input_key1, input_key2]].
     *
     * @var array
     */
    public $relations = [];

    public function ctype($str)
    {
        return $this->where(function ($query) use ($str) {
            return $query->where('commentable_type', 'App\\' . $str);
        });
    }

    public function cid($str)
    {
        return $this->where(function ($query) use ($str) {
            return $query->where('commentable_id', $str);
        });
    }
}
