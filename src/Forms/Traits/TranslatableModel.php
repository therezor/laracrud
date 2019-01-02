<?php

namespace TheRezor\LaraCrud\Forms\Traits;
use TheRezor\LaraCrud\Eloquent\Model\Contracts\HasTranslation;

trait TranslatableModel
{
    protected function setModelTranslations($model)
    {
        if ($model instanceof HasTranslation) {
            $this->setLanguageName($model->getTranslationPrefix());
        }
    }
}
