<?php

namespace src\common\http\actions;

use Closure;
use src\common\ExecutionResult;

final class ClosureAction extends ApiAction
{
    public Closure $closure;

    public function run(): ExecutionResult
    {
        return ($this->closure)();
    }
}
