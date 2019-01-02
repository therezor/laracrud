<?php

namespace TheRezor\LaraCrud\Forms\Traits;

use TheRezor\LaraCrud\Eloquent\Model\Contracts\HasValidation;

trait DefaultModelRules
{
    protected function getModelRules($name, $model)
    {
        if ($model instanceof HasValidation) {
            return array_get($model->getValidationRules(), $name, []);
        }

        return [];
    }
}
