<?php

namespace ddruganov\Yii2ApiEssentials\models;

use ddruganov\Yii2ApiEssentials\ExecutionResult;
use yii\base\Model;

abstract class AbstractApiModel extends Model
{
    public abstract function run(): ExecutionResult;
}
