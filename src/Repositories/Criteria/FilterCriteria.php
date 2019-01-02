<?php

namespace TheRezor\LaraCrud\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use TheRezor\LaraCrud\Repositories\Contracts\Criteria;
use TheRezor\LaraCrud\Repositories\Contracts\Repository;

class FilterCriteria implements Criteria
{
    protected $callbacks = [];

    protected $filters = [];

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function apply(Builder $builder, Repository $repository): Builder
    {
        if (!$this->filters) {
            return $builder;
        }

        return $builder->where(function (Builder $query) {
            foreach ($this->filters as $column => $value) {
                if ($this->hasCallback($column)) {
                    $query = call_user_func(
                        $this->callbacks[$column], $query, $value, $this
                    );

                    continue;
                }

                $query = $this->addLike($column, $value, $query);
            }
        });
    }

    public function addCallback($column, callable $callback): self
    {
        $this->callbacks[$column] = $callback;

        return $this;
    }

    protected function addLike(string $column, $value, Builder $builder): Builder
    {
        return $builder->where($column, 'like', '%' . $this->escapeLike($value) . '%');
    }

    protected function escapeLike(string $column)
    {
        return addcslashes($column, '%_');
    }

    protected function hasCallback($column): bool
    {
        return isset($this->callbacks[$column]) && is_callable($this->callbacks[$column]);
    }
}
