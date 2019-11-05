<?php

namespace TheRezor\LaraCrud\Eloquent\Model\Contracts;

interface HasTranslation
{
    /**
     * Get prefix for attribute name translations
     *
     * @return string
     */
    public function getTranslationPrefix(): string;
}
