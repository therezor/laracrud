<?php

namespace TheRezor\LaraCrud\Fields;

class Actions extends BaseField
{
    protected $template = 'laracrud::fields.actions';

    protected $routePrefix;

    protected $actions = [
        'show',
        'edit',
        'destroy',
    ];

    public function __construct(string $name, string $routePrefix)
    {
        $this->routePrefix = $routePrefix;

        $this->meta('text-right', 'list.class');

        $this->label = trans('laracrud::crud.actions');

        parent::__construct($name);
    }

    public function getRoutePrefix()
    {
        return $this->routePrefix;
    }

    public function hasAction($name): bool
    {
        return in_array($name, $this->actions);
    }
}
