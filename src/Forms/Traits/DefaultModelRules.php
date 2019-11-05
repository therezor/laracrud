<?php

namespace TheRezor\LaraCrud\Forms\Traits;

use TheRezor\LaraCrud\Eloquent\Model\Contracts\HasValidation;
use Illuminate\Support\Arr;

trait DefaultModelRules
{
    protected function getModelRules($name, $model)
    {
        if ($model instanceof HasValidation) {
            return Arr::get($model->getValidationRules(), $name, []);
        }

        return [];
    }
}
