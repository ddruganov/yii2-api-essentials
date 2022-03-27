<?php

namespace ddruganov\Yii2ApiEssentials\forms;

use ddruganov\Yii2ApiEssentials\ExecutionResult;
use yii\base\Model;

abstract class Form extends Model
{
    public function run(): ExecutionResult
    {
        if (!$this->validate()) {
            return ExecutionResult::failure($this->getFirstErrors());
        }

        $result = $this->_run();

        $this->addErrors($result->getErrors());

        return $result;
    }

    protected abstract function _run(): ExecutionResult;
}
