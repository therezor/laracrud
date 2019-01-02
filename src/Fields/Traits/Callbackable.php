<?php

namespace TheRezor\LaraCrud\Fields\Traits;


trait Callbackable
{
    public function valueCallback(?callable $callback): self
    {
        $this->valueCallback = $callback;

        return $this;
    }

    public function labelCallback(?callable $callback): self
    {
        $this->labelCallback = $callback;

        return $this;
    }

    public function renderCallback(?callable $callback): self
    {
        $this->renderCallback = $callback;

        return $this;
    }
}
