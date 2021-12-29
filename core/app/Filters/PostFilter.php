<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class PostFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function filter($str)
    {
        return $this->where(function ($query) use ($str) {
            return $query->where('title', 'LIKE', "%$str%")
                ->orwhere('description', 'LIKE', "%$str%")
                ->orwhere('hat', 'LIKE', "%$str%")
                ->orwhere('author', 'LIKE', "%$str%");
        });
    }
}
