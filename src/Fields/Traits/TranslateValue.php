<?php

namespace TheRezor\LaraCrud\Fields\Traits;

use TheRezor\LaraCrud\Fields\BaseField;
use Illuminate\Support\Str;

trait TranslateValue
{
    public function translateValue($prefix)
    {
        $prefix = Str::finish($prefix, '.');

        $this->valueCallback = function ($value, $entity, BaseField $field) use ($prefix) {
            if (null === $value) {
                return $value;
            }

            if (is_iterable($value)) {
                $translated = [];

                foreach ($value as $k => $v) {
                    $translated[$k] = trans($prefix . $v);
                }

                return $translated;
            }

            return trans($prefix . $value);
        };

        return $this;
    }
}
