<?php

namespace TheRezor\LaraCrud\Fields\Collections;

use Illuminate\Support\Collection;
use TheRezor\LaraCrud\Fields\Contracts\Field;

class FieldCollection extends Collection
{
    public function onlySortable(): self
    {
        return $this->filter(function (Field $field) {
            return true === $field->isSortable() && null !== $field->getName();
        });
    }

    public function pluckNames()
    {
        $attributes = [];

        foreach ($this->all() as $field) {
            $attributes[] = $field->getName();
        }

        return $attributes;
    }
}
