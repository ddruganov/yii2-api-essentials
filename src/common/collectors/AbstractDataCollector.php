<?php

namespace src\common\collectors;

use yii\base\Component;

abstract class AbstractDataCollector extends Component
{
    public abstract function get(): array;
}
