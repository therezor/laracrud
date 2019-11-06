<?php

namespace TheRezor\LaraCrud\Fields;

use Illuminate\Support\HtmlString;

class Text extends BaseField
{
    public function __construct(string $name)
    {
        $this->valueCallback = function ($value, $entity, $field) {
            if ($value) {
                return new HtmlString(nl2br(e($value)));
            }

            return $value;
        };

        parent::__construct($name);
    }
}
