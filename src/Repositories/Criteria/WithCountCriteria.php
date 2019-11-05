<?php

namespace TheRezor\LaraCrud\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use TheRezor\LaraCrud\Fields\Contracts\Field;
use TheRezor\LaraCrud\Repositories\Contracts\Criteria;
use TheRezor\LaraCrud\Repositories\Contracts\Repository;

class WithCountCriteria implements Criteria
{
    protected $field;

    protected $request;

    public function __construct(Field $field)
    {
        $this->field = $field;
    }

    public function apply(Builder $builder, Repository $repository): Builder
    {
        return $builder->withCount(mb_substr($this->field->getName(), 0, -6));
    }
}
