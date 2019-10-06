<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class CountsWithTravel implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->with(['user', 'offers', 'hotel', 'travel_category'])->withCount(['offers', 'bookings']);
    }
}
