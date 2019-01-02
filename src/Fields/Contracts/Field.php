<?php

namespace TheRezor\LaraCrud\Fields\Contracts;

interface Field
{
    /**
     * Field name
     *
     * @return string
     */
    public function getName(): string;
}
