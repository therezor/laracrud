<?php

namespace TheRezor\LaraCrud\Forms;

use Kris\LaravelFormBuilder\Form as BaseForm;
use TheRezor\LaraCrud\Forms\Traits\TranslatableModel;
use TheRezor\LaraCrud\Repositories\Contracts\Criteria;
use TheRezor\LaraCrud\Repositories\Criteria\FilterCriteria;

class FilterForm extends BaseForm
{
    use TranslatableModel;

    protected $errorBag = 'filter_form';

    public function getFilterCriteria(): Criteria
    {
        return new FilterCriteria($this->getFieldValues(false));
    }

    public function setFormOptions(array $formOptions, $unsetModel = false)
    {
        $this->setModelTranslations($formOptions['model'] ?? null);

        unset($formOptions['model']);

        return parent::setFormOptions($formOptions);
    }

    protected function setupFieldOptions($name, &$options)
    {
        if (empty($options['wrapper']['class'])) {
            $options['wrapper']['class'] = config('laravel-form-builder.defaults.wrapper_class') . ' col';
        }

        if ($this->request->has($name)) {
            $options['default_value'] = $this->request->get($name);
        }

        parent::setupFieldOptions($name, $options);
    }

    protected function addSpacer($name, $class = 'w-100')
    {
        return $this->add($name, 'static', ['wrapper' => ['class' => $class], 'label' => false]);
    }
}
