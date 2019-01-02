<?php

namespace TheRezor\LaraCrud\Fields\Contracts;

interface ValueCallback
{
    public function __invoke($value, $entity, Field $field);
}
