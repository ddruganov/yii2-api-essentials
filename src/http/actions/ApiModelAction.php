<?php

namespace ddruganov\Yii2ApiEssentials\http\actions;

use ReflectionClass;
use ddruganov\Yii2ApiEssentials\models\AbstractApiModel;
use ddruganov\Yii2ApiEssentials\ExecutionResult;

final class ApiModelAction extends ApiAction
{
    public string $modelClass;
    private AbstractApiModel $model;

    protected function beforeRun()
    {
        $reflectionClass = new ReflectionClass($this->modelClass);
        $this->model = $reflectionClass->newInstanceArgs([$this->getData()]);

        return parent::beforeRun();
    }

    public function run(): ExecutionResult
    {
        return $this->model->run();
    }
}
