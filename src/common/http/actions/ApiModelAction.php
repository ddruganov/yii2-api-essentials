<?php

namespace ddruganov\Yii2ApiEssentials\common\http\actions;

use ReflectionClass;
use ddruganov\Yii2ApiEssentials\common\components\AbstractApiModel;
use ddruganov\Yii2ApiEssentials\common\ExecutionResult;

final class ApiModelAction extends ApiAction
{
    public string $modelClass;
    private AbstractApiModel $model;

    protected function  beforeRun()
    {
        $reflectionClass = new ReflectionClass($this->modelClass);
        $this->model = $reflectionClass->newInstanceArgs([$this->getData()]);
    }

    public function run(): ExecutionResult
    {
        return $this->model->run();
    }
}
