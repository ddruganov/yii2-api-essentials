<?php

namespace src\common\http\actions;

use ReflectionClass;
use src\common\components\AbstractApiModel;
use src\common\ExecutionResult;

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
