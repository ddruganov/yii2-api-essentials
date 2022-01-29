<?php

namespace ddruganov\Yii2ApiEssentials\common\collectors;

use yii\base\Component;

abstract class AbstractDataCollector extends Component
{
    public abstract function get(): array;
}
