<?php

namespace src\common\http\actions;

use ReflectionClass;
use src\common\collectors\AbstractDataCollector;
use src\common\ExecutionResult;

final class CollectorAction extends ApiAction
{
    public string $collectorClass;
    private AbstractDataCollector $collector;

    protected function beforeRun()
    {
        $reflectionClass = new ReflectionClass($this->collectorClass);
        $this->collector = $reflectionClass->newInstanceArgs([$this->getData()]);
    }

    public function run(): ExecutionResult
    {
        return ExecutionResult::success($this->collector->get());
    }
}
