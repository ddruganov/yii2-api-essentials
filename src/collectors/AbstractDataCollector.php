<?php

namespace ddruganov\Yii2ApiEssentials\collectors;

use yii\base\Model;

abstract class AbstractDataCollector extends Model
{
    public function run(): array
    {
        if (!$this->canRunEmpty() && $this->emptyAttributes()) {
            return [];
        }

        if (!$this->validate()) {
            return [];
        }

        return $this->internalRun();
    }

    protected abstract function internalRun(): array;

    protected function canRunEmpty(): bool
    {
        return true;
    }

    protected function emptyAttributes(): bool
    {
        return !count(array_filter($this->getAttributes()));
    }
}
