<?php

namespace ddruganov\Yii2ApiEssentials\http\actions;

use ReflectionClass;
use ddruganov\Yii2ApiEssentials\ExecutionResult;
use ddruganov\Yii2ApiEssentials\forms\AbstractForm;

final class FormAction extends ApiAction
{
    public string $formClass;
    private AbstractForm $form;

    protected function beforeRun()
    {
        if (!parent::beforeRun()) {
            return false;
        }

        $reflectionClass = new ReflectionClass($this->formClass);
        $this->form = $reflectionClass->newInstanceArgs();
        $this->form->setAttributes($this->getData());

        return true;
    }

    public function run(): ExecutionResult
    {
        return $this->form->run();
    }
}
