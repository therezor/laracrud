<?php

namespace TheRezor\LaraCrud\Repositories\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use TheRezor\LaraCrud\Fields\Collections\FieldCollection;
use TheRezor\LaraCrud\Repositories\Contracts\Criteria;
use TheRezor\LaraCrud\Repositories\Contracts\Repository;

class OrderCriteria implements Criteria
{
    /**
     * @var FieldCollection
     */
    protected $fields;

    protected $request;

    protected $directions = ['asc', 'desc'];

    protected $defaultColumn = 'id';

    protected $defaultDirection = 'desc';

    protected $orderKey;

    protected $dirKey;

    public function __construct(array $fields, Request $request, $orderKey = 'sort', $dirKey = 'direction')
    {
        $fields = new FieldCollection($fields);

        $this->fields = $fields->onlySortable();
        $this->request = $request;
        $this->orderKey = $orderKey;
        $this->dirKey = $dirKey;
    }

    public function apply(Builder $builder, Repository $repository): Builder
    {
        if (!$this->fields->count()) {
            return $builder->orderBy($this->defaultColumn, $this->defaultDirection);
        }

        $column = $this->getColumn();
        $direction = $this->getDirection();

        return $builder->orderBy($column, $direction);
    }

    public function setDefaultOrder($column, $direction = 'desc'): self
    {
        $this->defaultColumn = $column;
        $this->defaultDirection = $direction;

        return $this;
    }

    protected function getColumn()
    {
        $column = $this->request->get($this->orderKey);

        $columns = $this->fields->map(function ($field) {
            return $field->getName();
        });

        if (!in_array($column, $columns->toArray(), true)) {
            return $columns->first();
        }

        return $column;
    }

    protected function getDirection()
    {
        $direction = $this->request->get($this->dirKey);

        if (!in_array($direction, $this->directions, true)) {
            return 'desc';
        }

        return $direction;
    }
}
