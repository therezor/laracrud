<?php

namespace TheRezor\LaraCrud\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use TheRezor\LaraCrud\Repositories\Contracts\Criteria;
use TheRezor\LaraCrud\Repositories\Contracts\Repository;

class EmptyCriteria implements Criteria
{
    public function apply(Builder $builder, Repository $repository): Builder
    {
        return $builder;
    }
}
