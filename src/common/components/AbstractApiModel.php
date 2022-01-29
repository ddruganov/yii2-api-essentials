<?php

namespace src\common\components;

use src\common\ExecutionResult;
use yii\base\Model;

abstract class AbstractApiModel extends Model
{
    public abstract function run(): ExecutionResult;
}
