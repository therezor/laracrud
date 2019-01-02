<?php

namespace TheRezor\LaraCrud\Http\Controllers\Traits;

use Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Generator;
use Route;

trait Routable
{
    public static function routes($parent)
    {
        return resolve(static::class)->buildRoutes($parent);
    }

    public function buildRoutes($parent)
    {
        if ($parent) {
            $this->breadcrumbs($parent);
        }

        $parameter = last(explode('.', $this->crud->getRouteName()));

        return Route::resource(str_replace('.', '/', $this->crud->getRouteName()), str_start(static::class, '\\'))
            ->only($this->crud->methods)
            ->parameter($parameter, 'id')
            ->names($this->crud->getRouteName());
    }

    protected function breadcrumbs($parent)
    {
        $index = $this->crud->getRouteByMethod('index');
        $create = $this->crud->getRouteByMethod('create');
        $edit = $this->crud->getRouteByMethod('edit');
        $show = $this->crud->getRouteByMethod('show');

        if ($index) {
            Breadcrumbs::register($index, function (Generator $breadcrumbs) use ($parent, $index) {
                $breadcrumbs->parent($parent);
                $breadcrumbs->push($this->crud->getCrudName(), route($index));
            });
        }

        if ($create) {
            Breadcrumbs::register($create, function (Generator $breadcrumbs) use ($parent, $index, $create) {
                $breadcrumbs->parent($index ?: $parent);
                $breadcrumbs->push(trans('laracrud::crud.create'), route($create));
            });
        }

        if ($edit) {
            Breadcrumbs::register($edit, function ($breadcrumbs, $id) use ($parent, $index, $edit, $show) {
                if ($show) {
                    $breadcrumbs->parent($show, $id);
                } else {
                    $breadcrumbs->parent($index ?: $parent);
                }

                $breadcrumbs->push(trans('laracrud::crud.update'), route($edit, $id));
            });
        }

        if ($show) {
            Breadcrumbs::register($show, function ($breadcrumbs, $id) use ($parent, $show, $index) {
                $breadcrumbs->parent($index ?: $parent);
                $breadcrumbs->push('#' . $id, route($show, $id));
            });
        }
    }
}
