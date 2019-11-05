<?php

namespace TheRezor\LaraCrud\Console;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use TheRezor\LaraCrud\Console\Traits\ParseClass;

class CrudFormMakeCommand extends GeneratorCommand
{
    use ParseClass;

    protected $name = 'make:laracrud:form';

    protected $description = 'Create a new crud form';

    protected $type = 'Form';

    protected function getStub()
    {
        if ($this->option('filter')) {
            return  __DIR__ . '/stubs/filterform.stub';
        }

        return  __DIR__ . '/stubs/form.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Forms';
    }

    protected function buildClass($name)
    {
        $replace = [];

        if ($this->option('model')) {
            $replace = $this->buildFieldsReplacements($replace);
        }

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
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
            $fields .= '        $this->add' . "('{$f}', 'text');\n";
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
            ['model', 'm', InputOption::VALUE_REQUIRED, 'Model class used by repository.'],
            ['filter', 'f', InputOption::VALUE_OPTIONAL, 'Is filter form?.'],
        ];
    }
}
