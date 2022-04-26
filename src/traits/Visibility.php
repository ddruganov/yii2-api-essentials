<?php

namespace ddruganov\Yii2ApiEssentials\traits;

use ReflectionClass;

trait Visibility
{
    /**
     * @return $this
     */
    public function visible()
    {
        return $this
            ->andWhere($this->getVisibilityCondition());
    }

    private function getVisibilityCondition()
    {
        $reflection = new ReflectionClass(static::class);
        return $reflection->getStaticPropertyValue('visibilityCondition', ['visible' => true]);
    }
}
