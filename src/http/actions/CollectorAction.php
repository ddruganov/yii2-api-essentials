<?php

namespace ddruganov\Yii2ApiEssentials\http\actions;

use ReflectionClass;
use ddruganov\Yii2ApiEssentials\collectors\AbstractDataCollector;
use ddruganov\Yii2ApiEssentials\ExecutionResult;

final class CollectorAction extends ApiAction
{
    public string $collectorClass;
    private AbstractDataCollector $collector;

    protected function beforeRun()
    {
        $reflectionClass = new ReflectionClass($this->collectorClass);
        $this->collector = $reflectionClass->newInstanceArgs([$this->getData()]);

        return parent::beforeRun();
    }

    public function run(): ExecutionResult
    {
        return ExecutionResult::success($this->collector->get());
    }
}
