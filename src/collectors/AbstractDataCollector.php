<?php

namespace ddruganov\Yii2ApiEssentials\collectors;

use yii\base\Component;

abstract class AbstractDataCollector extends Component
{
    public abstract function get(): array;
}
