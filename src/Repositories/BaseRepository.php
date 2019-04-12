<?php

namespace TheRezor\LaraCrud\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use TheRezor\LaraCrud\Repositories\Contracts\Criteria as CriteriaContract;
use TheRezor\LaraCrud\Repositories\Contracts\Repository as RepositoryContract;

abstract class BaseRepository implements RepositoryContract
{
    protected $model;

    /**
     * @var Collection
     */
    protected $criteria;

    protected $skipCriteria = false;

    /**
     * new Model instance
     *
     * @return model
     */
    protected function model(): Model
    {
        return $this->model;
    }

    public function __construct()
    {
        $this->resetCriteria();
    }

    public function get($columns = ['*'])
    {
        return $this->newQuery()->get();
    }

    public function first($columns = ['*'])
    {
        return $this->newQuery()->first();
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

    public function newModel(): Model
    {
        return $this->model()->newInstance();
    }

    /**
     * @param CriteriaContract $criteria
     *
     * @return $this
     */
    public function prependCriteria(CriteriaContract $criteria): self
    {
        $this->criteria->prepend($criteria);

        return $this;
    }

    /**
     * @param CriteriaContract $criteria
     *
     * @return $this
     */
    public function pushCriteria(CriteriaContract $criteria): self
    {
        $this->criteria->push($criteria);

        return $this;
    }

    /**
     * @param string|CriteriaContract $criteria
     *
     * @return $this
     */
    public function popCriteria($criteria): self
    {
        $this->criteria = $this->criteria->reject(function ($item) use ($criteria) {
            if (is_object($item) && is_string($criteria)) {
                return get_class($item) === $criteria;
            }
            if (is_string($item) && is_object($criteria)) {
                return $item === get_class($criteria);
            }

            return get_class($item) === get_class($criteria);
        });

        return $this;
    }

    public function getCriteria(): Collection
    {
        return $this->criteria;
    }

    /**
     * @param bool $status
     *
     * @return $this
     */
    public function skipCriteria($status = true): self
    {
        $this->skipCriteria = $status;

        return $this;
    }

    /**
     * @return $this
     */
    public function resetCriteria(): self
    {
        $this->criteria = new Collection();

        return $this;
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
