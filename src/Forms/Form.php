<?php

namespace TheRezor\LaraCrud\Forms;

use Kris\LaravelFormBuilder\Form as BaseForm;
use TheRezor\LaraCrud\Forms\Traits\DefaultModelRules;
use TheRezor\LaraCrud\Forms\Traits\TranslatableModel;

class Form extends BaseForm
{
    use TranslatableModel, DefaultModelRules;

    protected $errorBag = 'form';

    public function setFormOptions(array $formOptions)
    {
        $this->setModelTranslations($formOptions['model'] ?? null);

        return parent::setFormOptions($formOptions);
    }

    protected function setupFieldOptions($name, &$options)
    {
        if (empty($options['rules'])) {
            $options['rules'] = $this->getModelRules($name, $this->getModel());
        }

        parent::setupFieldOptions($name, $options);
    }
}
