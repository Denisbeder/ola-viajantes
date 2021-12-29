<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class AdvertFilter extends ModelFilter
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
        $str = filter_var($str);

        return $this->where(function ($query) use ($str) {
            return $query->where('title', 'LIKE', "%$str%")
                ->orwhere('body', 'LIKE', "%$str%");
        });
    }

    public function category($str)
    {
        $str = filter_var($str);
        
        return $this->whereHas('category', function ($query) use ($str) {
            $query->where('slug', $str);
        });
    }

    public function order($str)
    {
        $str = filter_var($str);

        return $this->orderby('published_at', $str)->orderby('created_at', $str);
    }

    public function amount($str)
    {
        $str = filter_var($str);

        return $this->orderby('amount', $str);
    }
    
    public function place($str)
    {
        $str = filter_var($str);
        
        return $this->whereHas('city', function ($query) use ($str) {
            $query->where('name', 'LIKE', "%$str%");
        });
    }
}
