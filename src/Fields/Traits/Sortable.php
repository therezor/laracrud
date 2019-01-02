<?php

namespace TheRezor\LaraCrud\Fields\Traits;

trait Sortable
{
    protected $sortable = false;

    public function sortable(bool $sortable = true): self
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function sortableDirection()
    {
        if (request()->get('sort') !== $this->name) {
            return null;
        }

        $direction = request()->get('direction');

        return in_array($direction, ['asc', 'desc'], true) ? $direction : null;
    }

    public function sortableUrl()
    {
        if (!$this->sortable) {
            return null;
        }

        $direction = $this->sortableDirection();

        $direction = ('desc' === $direction ? 'asc' : 'desc');

        return $this->buildSortableUrl($this->name, $direction);
    }

    protected function buildSortableUrl($sort, $direction)
    {
        $requestParams = request()->except('sort', 'direction', 'page');

        $queryString = http_build_query(array_merge($requestParams, [
            'sort'      => $sort,
            'direction' => $direction,
        ]));

        return url(request()->path() . '?' . $queryString);
    }
}
