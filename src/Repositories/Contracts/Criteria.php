<?php

namespace TheRezor\LaraCrud\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface Criteria
{
    /**
     * Apply criteria to query in repository
     *
     * @param Builder $builder
     * @param Repository $repository
     * @return Builder
     */
    public function apply(Builder $builder, Repository $repository): Builder;
}
