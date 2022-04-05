<?php

namespace ddruganov\Yii2ApiEssentials\traits;

use ReflectionClass;

trait Sorting
{
    /**
     * @return $this
     */
    public function newestFirst()
    {
        return $this->sort(SORT_DESC);
    }

    /**
     * @return $this
     */
    public function oldestFirst()
    {
        return $this->sort(SORT_ASC);
    }

    private function sort(int $direction)
    {
        return $this
            ->orderBy([
                $this->getSortField() => $direction
            ]);
    }

    private function getSortField()
    {
        $reflection = new ReflectionClass(static::class);
        return $reflection->getStaticPropertyValue('sortField', 'created_at');
    }
}
