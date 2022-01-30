<?php

namespace ddruganov\Yii2ApiEssentials\common\models;

use ddruganov\Yii2ApiEssentials\common\ExecutionResult;
use yii\base\Model;

abstract class AbstractApiModel extends Model
{
    public abstract function run(): ExecutionResult;
}
