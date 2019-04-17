<?php

namespace TheRezor\LaraCrud\Http\Controllers\Traits;

use Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Generator;
use Illuminate\Support\Str;
use Route;

trait Routable
{
    public static function routes()
    {
        return resolve(static::class)->buildRoutes();
    }

    public static function breadcrumbs($parent = null)
    {
        return resolve(static::class)->buildBreadcrumbs($parent);
    }

    public function buildRoutes()
    {
        $parameter = last(explode('.', $this->crud->getRouteName()));

        return Route::resource(str_replace('.', '/', $this->crud->getRouteName()), Str::start(static::class, '\\'))
            ->only($this->crud->methods)
            ->parameter($parameter, 'id')
            ->names($this->crud->getRouteName());
    }

    public function buildBreadcrumbs($root = null)
    {
        $index = $this->crud->getRouteByMethod('index');
        $create = $this->crud->getRouteByMethod('create');
        $edit = $this->crud->getRouteByMethod('edit');
        $show = $this->crud->getRouteByMethod('show');

        if ($index) {
            Breadcrumbs::register($index, function (Generator $breadcrumbs) use ($root, $index) {
                if ($root) {
                    $breadcrumbs->parent($root);
                }

                $breadcrumbs->push($this->crud->getCrudName(), route($index));
            });
        }

        if ($create) {
            Breadcrumbs::register($create, function (Generator $breadcrumbs) use ($root, $index, $create) {
                $parent = $index ?: $root;
                if ($parent) {
                    $breadcrumbs->parent($parent);
                }
                $breadcrumbs->push(trans('laracrud::crud.create'), route($create));
            });
        }

        if ($edit) {
            Breadcrumbs::register($edit, function (Generator $breadcrumbs, $id) use ($root, $index, $edit, $show) {
                $parent = $index ?: $root;

                if ($show) {
                    $breadcrumbs->parent($show, $id);
                } elseif ($parent) {
                    $breadcrumbs->parent($parent);
                }

                $breadcrumbs->push(trans('laracrud::crud.update'), route($edit, $id));
            });
        }

        if ($show) {
            Breadcrumbs::register($show, function (Generator $breadcrumbs, $id) use ($root, $show, $index) {
                $parent = $index ?: $root;
                if ($parent) {
                    $breadcrumbs->parent($parent);
                }
                $breadcrumbs->push('#' . $id, route($show, $id));
            });
        }
    }
}
