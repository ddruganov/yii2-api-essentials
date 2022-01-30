<?php

namespace ddruganov\Yii2ApiEssentials\http\actions;

use Closure;
use ddruganov\Yii2ApiEssentials\ExecutionResult;

final class ClosureAction extends ApiAction
{
    public Closure $closure;

    public function run(): ExecutionResult
    {
        return ($this->closure)();
    }
}
