<?php

namespace TheRezor\LaraCrud\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TheRezor\LaraCrud\Console\Traits\ParseClass;

class CrudControllerMakeCommand extends GeneratorCommand
{
    use ParseClass;

    protected $name = 'make:laracrud:controller';

    protected $description = 'Create a new crud controller';

    protected $type = 'Controller';

    protected function getStub()
    {
        return __DIR__ . '/stubs/controller.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }

    protected function getPath($name)
    {
        $name = str_finish($name, 'Controller');

        return parent::getPath($name);
    }

    protected function buildClass($name)
    {
        $name = str_finish($name, 'Controller');

        $replace = [];

        $replace = $this->buildCrudReplacements($replace);

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function buildCrudReplacements(array $replace)
    {
        $rootNamespace = $this->laravel->getNamespace() . 'Http\\Crud\\';

        $crud = $this->option('crud');

        if (!$crud) {
            $crud = $this->argument('name');

            $this->call('make:crud', [
                'name'    => $crud,
                '--model' => $this->option('model'),
            ]);

            $crud = str_finish($crud, 'Crud');
        }

        $class = $this->parseClass($crud, $rootNamespace);

        return array_merge($replace, [
            'DummyFullCrudClass' => $class,
            'DummyCrudClass'     => class_basename($class),
        ]);
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the contract.'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['crud', 'c', InputOption::VALUE_OPTIONAL, 'Crud class.'],
            ['model', 'm', InputOption::VALUE_REQUIRED, 'Model class.'],
        ];
    }
}
