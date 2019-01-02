<?php

namespace TheRezor\LaraCrud\Fields;

class ArrayList extends BaseField
{
    protected $template = 'laracrud::fields.array';

    public function translateValue($prefix)
    {
        $prefix = str_finish($prefix, '.');

        $this->valueCallback = function ($value, $entity, BaseField $field) use ($prefix) {
            $translated = [];

            foreach ($value as $k => $v) {
                $translated[$k] = trans($prefix . $v);
            }

            return $translated;
        };

        return $this;
    }
}
