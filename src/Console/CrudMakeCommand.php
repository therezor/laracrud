<?php

namespace TheRezor\LaraCrud\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TheRezor\LaraCrud\Console\Traits\ParseClass;
use Illuminate\Support\Str;

class CrudMakeCommand extends GeneratorCommand
{
    use ParseClass;

    protected $name = 'make:laracrud:crud';

    protected $description = 'Create a crud resources';

    protected $type = 'Crud';

    protected function getStub()
    {
        return __DIR__ . '/stubs/crud.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Crud';
    }

    protected function getPath($name)
    {
        $name = str_finish($name, 'Crud');

        return parent::getPath($name);
    }

    protected function buildClass($name)
    {
        $name = str_finish($name, 'Crud');

        $replace = [];

        $replace = $this->buildValueReplacements($replace);
        $replace = $this->buildRepositoryReplacements($replace);
        $replace = $this->buildFieldsReplacements($replace);
        $replace = $this->buildFormReplacements($replace);
        $replace = $this->buildFilterFormReplacements($replace);

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    protected function buildValueReplacements(array $replace)
    {
        $name = $this->argument('name');

        return array_merge($replace, [
            'DummyCrudName'  => Str::title($name),
            'DummyCrudRoute' => Str::snake($name),
        ]);
    }

    protected function buildRepositoryReplacements(array $replace)
    {
        $repository = $this->option('repository');

        if (!$repository) {
            $repository = $this->argument('name') . 'Repository';

            $this->call('make:crud:repository', [
                'name'    => $repository,
                '--model' => $this->option('model'),
            ]);
        }

        $rootNamespace = $this->laravel->getNamespace() . 'Repositories\\';

        $class = $this->parseClass($repository, $rootNamespace);

        return array_merge($replace, [
            'DummyFullRepositoryClass' => $class,
            'DummyRepositoryClass'     => class_basename($class),
        ]);
    }

    protected function buildFormReplacements(array $replace)
    {
        $rootNamespace = $this->laravel->getNamespace() . 'Forms\\';

        $form = $this->option('form');

        if (!$form) {
            $form = $this->argument('name') . 'Form';

            $this->call('make:crud:form', [
                'name'    => $form,
                '--model' => $this->option('model'),
            ]);
        }

        $class = $this->parseClass($form, $rootNamespace);

        return array_merge($replace, [
            'DummyFullFormClass' => $class,
            'DummyFormClass'     => class_basename($class),
        ]);
    }

    protected function buildFilterFormReplacements(array $replace)
    {
        $rootNamespace = $this->laravel->getNamespace() . 'Forms\\';

        $form = $this->option('filter_form');

        if (!$form) {
            $form = $this->argument('name') . 'FilterForm';

            $this->call('make:crud:form', [
                'name'     => $form,
                '--model'  => $this->option('model'),
                '--filter' => true,
            ]);
        }

        $class = $this->parseClass($form, $rootNamespace);

        return array_merge($replace, [
            'DummyFullFilterFormClass' => $class,
            'DummyFilterFormClass'     => class_basename($class),
        ]);
    }

    protected function buildFieldsReplacements(array $replace)
    {
        $modelClass = $this->parseClass($this->option('model'));

        $model = resolve($modelClass);

        if (!class_exists($modelClass) || !$model instanceof Model) {
            return '';
        }

        $fillable = $model->getFillable();

        $fields = '';

        foreach ($fillable as $f) {
            $fields .= "            Field::make('{$f}'),\n";
        }

        return array_merge($replace, [
            'DummyFields' => $fields,
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
            ['model', 'm', InputOption::VALUE_REQUIRED, 'Model class.'],
            ['repository', 'r', InputOption::VALUE_OPTIONAL, 'Repository class.'],
            ['form', 'f', InputOption::VALUE_OPTIONAL, 'Form class.'],
            ['filter_form', 'ff', InputOption::VALUE_OPTIONAL, 'Filter form class.'],
        ];
    }
}
