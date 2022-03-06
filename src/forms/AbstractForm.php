<?php

namespace ddruganov\Yii2ApiEssentials\forms;

use ddruganov\Yii2ApiEssentials\ExecutionResult;
use yii\base\Model;

abstract class AbstractForm extends Model
{
    public abstract function run(): ExecutionResult;
}
