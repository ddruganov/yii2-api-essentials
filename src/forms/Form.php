<?php

namespace ddruganov\Yii2ApiEssentials\forms;

use ddruganov\Yii2ApiEssentials\ExecutionResult;
use yii\base\Model;

abstract class Form extends Model
{
    final public function run(): ExecutionResult
    {
        if (!$this->validate()) {
            return ExecutionResult::failure($this->getFirstErrors());
        }

        return $this->_run();
    }

    protected abstract function _run(): ExecutionResult;
}
