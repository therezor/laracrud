<?php

namespace TheRezor\LaraCrud\Fields\Contracts;

interface RenderCallback
{
    public function __invoke($value, $entity, Field $field);
}
