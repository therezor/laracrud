<?php

namespace TheRezor\LaraCrud\Http\Crud;

use TheRezor\LaraCrud\Http\Crud\Traits\Hookable;
use TheRezor\LaraCrud\Repositories\Contracts\Criteria;
use TheRezor\LaraCrud\Repositories\Contracts\Repository;
use TheRezor\LaraCrud\Repositories\Criteria\OrderCriteria;

abstract class BaseCrud
{
    use Hookable;

    protected $repository;

    /**
     * Items per page on list view
     *
     * @var int
     */
    public $perPage = 20;

    /**
     * Default column for sorting
     *
     * @var string
     */
    public $defaultColumn = 'id';

    /**
     * Default direction for sorting
     *
     * @var string
     */
    public $defaultDirection = 'desc';

    /**
     * Available route methods
     *
     * @var array
     */
    public $methods = [
        'index',
        'create',
        'show',
        'store',
        'edit',
        'update',
        'destroy',
    ];

    /**
     * Plural name for page title etc...
     *
     * @return string
     */
    abstract public function getCrudName(): string;

    /**
     * Crud route name prefix
     *
     * @return string
     */
    abstract public function getRouteName(): string;

    public function getRepository(): Repository
    {
        return $this->repository;
    }

    public function getListFields(): array
    {
        return [];
    }

    public function getShowFields(): array
    {
        return $this->getListFields();
    }

    public function getCreateFormClass(): ?string
    {
        return null;
    }

    public function getEditFormClass(): ?string
    {
        return $this->getCreateFormClass();
    }

    public function getFilterFormClass(): ?string
    {
        return null;
    }

    public function getViewByMethod(string $method): string
    {
        return str_finish($this->getViewPrefix(), '.') . $method;
    }

    public function getEntityActions(): array
    {
        return [
            $this->getViewPrefix() . '.actions.show',
            $this->getViewPrefix() . '.actions.edit',
            $this->getViewPrefix() . '.actions.destroy',
        ];
    }

    protected function getViewPrefix(): string
    {
        return 'laracrud::crud';
    }

    public function getRouteByMethod($method)
    {
        if (!in_array($method, $this->methods)) {
            return null;
        }

        return str_finish($this->getRouteName(), '.') . $method;
    }

    public function getOrderCriteria(): Criteria
    {
        return new OrderCriteria($this->getListFields(), request());
    }
}
