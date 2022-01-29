<?php

namespace ddruganov\Yii2ApiEssentials\common\http\actions;

use Closure;
use ddruganov\Yii2ApiEssentials\common\ExecutionResult;

final class ClosureAction extends ApiAction
{
    public Closure $closure;

    public function run(): ExecutionResult
    {
        return ($this->closure)();
    }
}
