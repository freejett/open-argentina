<?php

namespace App\Filters\Frontend;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\QueryFilter;
use Illuminate\Http\Request;

class ApartsFilter extends QueryFilter
{
    /**
     * @param $number_of_rooms
     * @return object
     */
    public function number_of_rooms($number_of_rooms = null)
    {
        if ($number_of_rooms) {
            return $this->builder->where('number_of_rooms', (int) $number_of_rooms);
        }

        return $this->builder;
    }

    /**
     * @param $price
     * @return object
     */
    public function price($price = null)
    {
        if ($price) {
            list($min, $max) = explode(',', $price);
            return $this->builder->where('price', '>=', $min)
                ->where('price', '<=', $max);
        }

        return $this->builder;
    }

    /**
     * @param $kids_allowed
     * @return object
     */
    public function kids_allowed($kids_allowed = null)
    {
        if ($kids_allowed) {
            return $this->builder->where('kids_allowed', 1);
        }

        return $this->builder;
    }

    /**
     * @param $pets_allowed
     * @return object
     */
    public function pets_allowed($pets_allowed = null)
    {
        if ($pets_allowed) {
            return $this->builder->where('kids_allowed', 1);
        }

        return $this->builder;
    }

    /**
     * @param $order
     * @return object
     */
    public function order($order = null)
    {
        if ($order) {
            list($field, $direction) = explode('_', $order);
            return $this->builder->orderBy($field, $direction);
        }

        return $this->builder;
    }
}
