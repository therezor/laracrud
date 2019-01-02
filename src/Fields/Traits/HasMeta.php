<?php

namespace TheRezor\LaraCrud\Fields\Traits;

trait HasMeta
{
    protected $meta = [];

    public function meta($value, $key = null): self
    {
        if (null !== $key) {
            array_set($this->meta, $key, $value);

            return $this;
        }

        $this->meta = $value;

        return $this;
    }

    public function getMeta($key = null)
    {
        if (null !== $key) {
            return array_get($this->meta, $key);
        }

        return $this->meta;
    }
}
