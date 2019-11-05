<?php

namespace TheRezor\LaraCrud\Repositories;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use TheRezor\LaraCrud\Repositories\Contracts\Repository as RepositoryContract;
use TheRezor\LaraCrud\Repositories\Traits\HasCriteria;

abstract class BaseRepository implements RepositoryContract
{
    use HasCriteria;

    /**
     * @var Container
     */
    protected $container;

    /** @var Model */
    protected $model;

    /**
     * Specify Model class name
     *
     * @return string
     */
    abstract public function modelClass(): string;

    /**
     * new Model instance
     *
     * @return model
     */
    protected function model(): Model
    {
        return $this->model;
    }

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->resetCriteria();
        $this->buildModel();
    }

    public function get($columns = ['*'])
    {
        return $this->newQuery()->get($columns);
    }

    public function first($columns = ['*'])
    {
        return $this->newQuery()->first($columns);
    }

    public function paginate($perPage = 10, $columns = ['*'], $pageName = 'page', $page = null)
    {
        return $this->newQuery()->paginate($perPage, $columns, $pageName, $page);
    }

    public function create(array $attributes)
    {
        $model = $this->model()->newInstance($attributes);
        $model->save();

        return $model;
    }

    public function update($id, array $attributes)
    {
        $model = $this->findOrFail($id);
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->newQuery()->updateOrCreate($attributes, $values);
    }

    public function delete($id)
    {
        $model = $this->findOrFail($id);

        return $model->delete();
    }

    public function find($id, $columns = ['*'])
    {
        return $this->newQuery()->find($id, $columns);
    }

    public function findOrFail($id, $columns = ['*'])
    {
        return $this->newQuery()->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = ['*'])
    {
        return $this->newQuery()->where($field, '=', $value)->first($columns);
    }

    public function findByOrFail($field, $value, $columns = ['*'])
    {
        return $this->newQuery()->where($field, '=', $value)->firstOrFail($columns);
    }

    public function sum($column)
    {
        return $this->newQuery()->sum($column);
    }

    public function count($columns = '*')
    {
        return $this->newQuery()->count($columns);
    }

    public function cursor()
    {
        return $this->newQuery()->cursor();
    }

    public function newModel(): Model
    {
        return $this->model()->newInstance();
    }

    public function buildModel($rebuild = false)
    {
        if ($rebuild || !$this->model) {
            $this->model = $this->container->make($this->modelClass());
        }

        return $this->model;
    }

    protected function newQuery(): Builder
    {
        $query = $this->model()->newQuery();

        if (true === $this->skipCriteria) {
            return $query;
        }

        $criteria = $this->getCriteria();
        foreach ($criteria as $c) {
            $query = $c->apply($query, $this);
        }

        return $query;
    }
}
