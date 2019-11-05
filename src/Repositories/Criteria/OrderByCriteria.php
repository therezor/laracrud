<?php

namespace TheRezor\LaraCrud\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use TheRezor\LaraCrud\Repositories\Contracts\Repository;
use TheRezor\LaraCrud\Repositories\Contracts\SortableCriteria;

class OrderByCriteria implements SortableCriteria
{
    protected $column;

    protected $direction;

    public function __construct($column, $direction = 'desc')
    {
        $this->column = $column;
        $this->direction = $direction;
    }

    public function setDirection(string $direction)
    {
        $this->direction = $direction;

        return $this;
    }

    public function apply(Builder $builder, Repository $repository): Builder
    {
        return $builder->orderBy($this->column, $this->direction);
    }
}
