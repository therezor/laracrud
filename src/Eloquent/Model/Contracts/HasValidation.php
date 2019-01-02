<?php

namespace TheRezor\LaraCrud\Eloquent\Model\Contracts;

interface HasValidation
{
    /**
     * Get array of validation rules
     *
     * @return array
     */
    public function getValidationRules(): array;
}
