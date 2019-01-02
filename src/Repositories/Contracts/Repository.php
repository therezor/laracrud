<?php

namespace TheRezor\LaraCrud\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface Repository extends RepositoryCriteria
{
    public function get($columns = ['*']);

    public function first($columns = ['*']);

    public function paginate($perPage = 10, $columns = ['*'], $pageName = 'page', $page = null);

    public function create(array $data);

    public function update($id, array $attributes);

    public function delete($id);

    public function find($id, $columns = ['*']);

    public function findOrFail($id, $columns = ['*']);

    public function findBy($field, $value, $columns = ['*']);

    public function findByOrFail($field, $value, $columns = ['*']);

    public function newModel(): Model;
}
