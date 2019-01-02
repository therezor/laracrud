<?php

namespace TheRezor\LaraCrud\Console\Traits;

use Illuminate\Support\Str;

trait ParseClass
{
    protected function parseClass($class, $rootNamespace = null)
    {
        $rootNamespace = $rootNamespace ?: $this->laravel->getNamespace();

        $class = trim(str_replace('/', '\\', $class), '\\');

        if (!Str::startsWith($class, $rootNamespace)) {
            $class = $rootNamespace . $class;
        }

        return $class;
    }
}
