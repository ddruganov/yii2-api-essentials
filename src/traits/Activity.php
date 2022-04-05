<?php

namespace ddruganov\Yii2ApiEssentials\traits;

use ReflectionClass;

trait Activity
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this
            ->andWhere($this->getActivityCondition());
    }

    private function getActivityCondition()
    {
        $reflection = new ReflectionClass(static::class);
        return $reflection->getStaticPropertyValue('activityCondition', ['is', 'deleted_at', null]);
    }
}
