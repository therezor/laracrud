<?php

namespace TheRezor\LaraCrud\Fields\Helpers;

use TheRezor\LaraCrud\Fields\Contracts\Field;

interface LabelCallback
{
    public function __invoke($name, Field $field);
}
